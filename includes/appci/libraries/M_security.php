<?php
/**
 * Minang Igniter
 *
 * Engine code untuk pengembangan aplikasi berbasis codeigniter
 * @link	http://ilmuprogrammer.com
 *
 * M_security
 *
 * Description:
 * Librari ini digunakan untuk kemanan aplikasi
 *
 * Copy file ini pada application/libraries/M_security.php
 *
 * @copyright	Copyright (c) 2015 Heru Rahmat Akhnuari
 * @version 	1.0
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 **/
defined('BASEPATH') OR exit('No direct script access allowed');

class M_security{

	protected $CI;
	/**
	 * [$hash description]
	 * @var string pilih salah satu hash password pada folder hash
	 */
	protected $hash='pbkdf2';

	function __construct(){
		$this->CI=& get_instance();
	}


/**
 * [filterPost ASDASDAS]
 * @param  string $field    [Nama html input]
 * @param  string $filter [Rule of Form Validation Lihat User guide]
 * @return [type]         [description]
 */
	function filterPost($field,$filter)
	{
		$this->CI->load->helper(array('form', 'url'));
		$this->CI->load->library('form_validation');
		return $this->CI->form_validation->set_rules($field, ucfirst($field), $filter);
	}

/**
 * [startPost eksekusi post]
 * @return [type] [description]
 */
	function startPost()
	{
		$this->CI->load->helper(array('form', 'url'));
		$this->CI->load->library('form_validation');
		if ($this->CI->form_validation->run() == FALSE)
		{
			return false;
		}else{
			return true;
		}
	}

/**
 * [filterSegment Memfilter segment url]
 * @param  string $segmenId [Segment dari URL. Misal segment ketiga dari http://domain.com/a/s/d adalah d]
 * @return [type]           [description]
 */
	function filterSegment($segmenId)
	{
		$this->CI->load->helper('security');
		$is_kode=$this->CI->security->xss_clean($this->CI->uri->segment($segmenId));
		if($is_kode)
		{
			return $is_kode;
		}else{
			return false;
		}
	}

/**
 * [filterXSS Memfilter data anti XSS]
 * @param  string $data [Data yg akan difilter]
 * @return [type]       [description]
 */
	function filterXSS($data)
	{

		$this->CI->load->helper('security');
		if ($this->CI->security->xss_clean($data, TRUE) === FALSE)
		{
			return false;
		}else{
			return true;
		}
	}

/**
 * [strEncrypt Ekripsi string dari codeigniter]
 * @param  string $str [string yg akan dienkripsi]
 * @return string      [description]
 */
	function strEncrypt($str)
    {
    	$this->CI->load->library('encrypt');
    	return $this->CI->encrypt->encode($str);
    }

/**
 * [strDecrypt Decrypt string dari hash codeigniter]
 * @param  string $str [Hash string]
 * @return string      [description]
 */
    function strDecrypt($str)
    {
    	$this->CI->load->library('encrypt');
    	return $this->CI->encrypt->decode($str);
    }

/**
 * [createPassword Buat password. default pbkdf2 atau lihat di application/libraries/hash]
 * @param  string $str [string yang akan dibuat password]
 * @return [type]      [description]
 */
	function createPassword($str){

		require(dirname(__FILE__).'/hash/'.$this->hash.'.php');
		$strSec=create_hash($str);
		return $strSec;
	}

/**
 * [validationPassword Validasi password]
 * @param  string $str  [String biasa untuk membandingkan]
 * @param  string $hash [Hash String untuk dibandingkan]
 * @return boolean       [description]
 */
	function validationPassword($str,$hash){
		require(dirname(__FILE__).'/hash/'.$this->hash.'.php');
		if(validate_password($str,$hash)==true)
		{
			return true;
		}else{
			return false;
		}
	}



}
