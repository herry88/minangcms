<?php
/**
 * Minang Igniter
 *
 * Engine code untuk pengembangan aplikasi berbasis codeigniter
 * @link	http://ilmuprogrammer.com
 *
 * M_net
 *
 * Description:
 * Librari ini digunakan untuk memudahkan penggunaan resource internet
 *
 * Copy file ini pada application/libraries/M_net.php
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

class M_net{

	protected $CI;

	function __construct(){
		$this->CI=& get_instance();
	}

/**
 * [getFTPList description]
 * @param  string $hostname [Nama hostname, contoh ftp.domain.com atau 222.222.222.222]
 * @param  string $username [Username FTP]
 * @param  string $password [Password FTP]
 * @param  string $folder   [folder FTP, Contoh public_html/folderku/]
 * @return [type]           [description]
 */
	function getFTPList($hostname,$username,$password,$folder)
	{

		$this->CI->load->library('ftp');

		$config['hostname'] = $hostname;
		$config['username'] = $username;
		$config['password'] = $password;
		$config['debug'] = TRUE;

		$this->CI->ftp->connect($config);

		$list = $this->CI->ftp->list_files($folder);
		if(!empty($list))
		{
			return $list;
		}
		$this->CI->ftp->close();
	}

/**
 * [downloadFTPFile description]
 * @param  string $hostname [Nama hostname, contoh ftp.domain.com atau 222.222.222.222]
 * @param  string $username [Username FTP]
 * @param  string $password [Password FTP]
 * @param  string $fromfile [File FTP yg akan di download. Contoh /public_html/folderku/file.zip]
 * @param  string $tofile   [Letak file yg telah didownload. Contoh ./upload/ftp/]
 * @return [type]           [description]
 */
	function downloadFTPFile($hostname,$username,$password,$fromfile,$tofile)
	{

		$this->CI->load->library('ftp');

		$config['hostname'] = $hostname;
		$config['username'] = $username;
		$config['password'] = $password;
		$config['debug'] = TRUE;

		$this->CI->ftp->connect($config);

		$this->CI->ftp->download($fromfile, $tofile, 'ascii');

		$this->CI->ftp->close();
	}

/**
 * [uploadFTPFile description]
 * @param  string $hostname [Nama hostname, contoh ftp.domain.com atau 222.222.222.222]
 * @param  string $username [Username FTP]
 * @param  string $password [Password FTP]
 * @param  string $fromfile   [File lokal. Contoh ./untukupload/dokumen.pdf]
 * @param  string $tofile     [File pada FTP. Contoh /public_html/folderku/dokumen.pdf]
 * @param  string $permission [Contoh 644,755]
 * @return [type]             [description]
 */
	function uploadFTPFile($hostname,$username,$password,$fromfile,$tofile,$permission='0644')
	{
		$this->CI->load->library('ftp');

		$config['hostname'] = $hostname;
		$config['username'] = $username;
		$config['password'] = $password;
		$config['debug'] = TRUE;

		$this->CI->ftp->connect($config);

		$this->CI->ftp->upload($fromfile, $tofile, 'ascii', $permission);

		$this->CI->ftp->close();
	}

/**
 * [SendEmail Mengirim email base codeigniter]
 * @param string $YourEmail [Email anda. Contoh company@domain.com]
 * @param string $YourName  [Nama Anda. Contoh Company Name]
 * @param string $ToEmail   [Email tujuan. Contoh destination@domain.com]
 * @param string $Subject   [Subjek Email. Dapat menggunakan tag HTML Typo]
 * @param string $Message   [Pesan email anda. Dapat menggunakan HTML Tag]
 * @param string $Cc        [null]
 * @param string $Bcc       [null]
 * @param string $UserAgent [default MinangIgniter]
 */
	function SendEmail($YourEmail,$YourName,$ToEmail,$Subject,$Message,$Cc='',$Bcc='',$UserAgent='MinangIgniter')
    {
        $config['useragent']=$UserAgent;
        $config['protocol']='mail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = "html";

        $this->CI->load->library('email');
        $this->CI->email->initialize($config);
        $this->CI->email->from($YourEmail, $YourName);
        $this->CI->email->to($ToEmail);
        $this->CI->email->cc($Cc);
        $this->CI->email->bcc($Bcc);
        $this->CI->email->subject($Subject);
        $this->CI->email->message($Message);

        if($this->CI->email->send(FALSE))
        {
            return true;
        }else{
            $this->CI->email->print_debugger(array('headers'));
            return false;
        }

    }

/**
 * [seoMeta Untuk meta agar SEO (search engine optimization) lebih maknyos]
 * @param  string $title        [Judul Halaman]
 * @param  string $description  [Deskripsi Halaman]
 * @param  string $keyword      [Keyword Halaman]
 * @param  string $author       [Auhor Halaman]
 * @param  [boolean] $searchengine [TRUE or FALSE. Apakah web atau aplikasi anda dapat ditemukan search engine]
 * @return [type]               [description]
 */
    function seoMeta($title='',$description='',$keyword='',$author='',$searchengine=FALSE){
		$output='';
		$output.='<title>'.$title.'</title>'."\n";
		$output.='<meta name="description" content="'.$description.'"/>'."\n";
		$output.='<meta name="keywords" content="'.$keyword.'" />'."\n";
		$output.='<meta name="author" content="'.$author.'">'."\n";
		if($searchengine==TRUE){
			$output.="<meta name='robots' content='noindex,follow' />";
		}
		return $output;
	}

/**
 * [seoWebmaster description]
 * @param  string $alexa  [alexa ID]
 * @param  string $google [google ID]
 * @param  string $bing   [bing ID]
 * @return [type]         [description]
 */
	function seoWebmaster($alexa='',$google='',$bing=''){
		$output='';
		$output.='<meta name="alexaVerifyID" content="'.$alexa.'"/>';
		$output.='<meta name="google-site-verification" content="'.$google.'"/>';
		$output.='<meta name="msvalidate.01" content="'.$bing.'"/>';
		return $output;
	}

/**
 * [curlNet description]
 * @param  string $method post,get,put,delete,call,download
 * @param  string $url    [Url target. Jika method berupa post, dapat menggunakan URL dengan parameter get]
 * @param  array  $param  [Parameter tambahan]
 * @param  boolean $ssl  [support SSL]
 * @return html         [description]
 */
 
 	function curlNet($method,$url,$param=array(),$ssl=FALSE){
		$exMethod=strtolower($method);
		$this->CI->load->library('ext/curl');
		if($ssl==TRUE){
			$this->CI->curl->setOpt(CURLOPT_SSL_VERIFYPEER,FALSE);
		}
		$this->CI->curl->$exMethod($url,$param);
		if($this->CI->curl->error){
			echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage;
    		$this->CI->curl->close();
		}else{
			return $this->CI->curl->response;
			$this->CI->curl->close();
		}
	}
 
	function curlNet2($method,$url,$param=array(),$ssl=FALSE){
		require(dirname(__FILE__).'/ext/curl.php');

		$curl = new Curl();
		$exMethod=strtolower($method);
		if($ssl==TRUE){
			$curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
		}
		$curl->$exMethod($url,$param);
		if ($curl->error) {
    		echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage;
    		$curl->close();
		}
		else {
		    return $curl->response;
		    $curl->close();
		    unset($curl);
		}
	}
	
	
	function curlGet($url){
		$ch = curl_init();
		$url = $urlSimas."/api/remote/";
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "action=$aksi&table=$table");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, base_url());
		$output = curl_exec ($ch);
		 
		curl_close ($ch);
		return $output;
	}

/**
 * [shorturl description]
 * @param  string $url     [URL yg akan dipotong]
 * @param  string $service [bitly,tinyurl,isgd lihat pada libraries/shorturl]
 * @param  array  $param   [null or not null if need auth]
 * @return string          [description]
 */
	function shorturl($url,$service,$param=array()){		
		require(dirname(__FILE__).'/shorturl/'.$service.'.php');
		$short=new $service;				
		return $short->generate($url,$param);		
		
	}

}
