<?php
/**
 * Minang Igniter
 *
 * Engine code untuk pengembangan aplikasi berbasis codeigniter
 * @link	http://ilmuprogrammer.com
 *
 * M_file
 *
 * Description:
 * Librari ini digunakan untuk fungsi-fungsi file server
 *
 * Copy file ini pada application/libraries/M_file.php
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

class M_file{

	protected $CI;

	function __construct(){
		$this->CI=& get_instance();
	}
	/**
	 * [makeDir Menghapus direktori]
	 * @param  string $path [lokasi direktori, tidak url. Gunakan BASEPATH (index root) atau APPPATH (app root)]
	 * @return boolean       [description]
	 */
	function makeDir($path,$rewrite=TRUE)
	{
		if($rewrite==TRUE){
			return is_dir($path) || mkdir($path,0755);
		}else{
			return is_dir($path) || mkdir($path,0644);
		}
	     
	}

/**
 * [remDir Hapus Direktori]
 * @param  string $dir       [lokasi direktori. Gunakan BASEPATH (index root) atau APPPATH (app root)]
 * @param  boolean $subfolder [Hapus juga sub folder]
 * @return [type]            [description]
 */
	function remDir($dir,$subfolder=FALSE)
	{
		if($subfolder==TRUE){
			$this->deleteAll($dir,TRUE);
			return rmdir($dir);
		}else{
			return rmdir($dir);
		}
		
	}
	
	function deleteAll($directory, $empty = false) { 
	    if(substr($directory,-1) == "/") { 
	        $directory = substr($directory,0,-1); 
	    } 

	    if(!file_exists($directory) || !is_dir($directory)) { 
	        return false; 
	    } elseif(!is_readable($directory)) { 
	        return false; 
	    } else { 
	        $directoryHandle = opendir($directory); 
	        
	        while ($contents = readdir($directoryHandle)) { 
	            if($contents != '.' && $contents != '..') { 
	                $path = $directory . "/" . $contents; 
	                
	                if(is_dir($path)) { 
	                    $this->deleteAll($path); 
	                } else { 
	                    unlink($path); 
	                } 
	            } 
	        } 
	        
	        closedir($directoryHandle); 

	        if($empty == false) { 
	            if(!rmdir($directory)) { 
	                return false; 
	            } 
	        } 
	        
	        return true; 
	    } 
	} 

/**
 * [deleteFile description]
 * @param  string $filepath [lokasi file. Gunakan BASEPATH (index root) atau APPPATH (app root)]
 * @return boolean           [description]
 */
	function deleteFile($filepath)
	{
		$this->CI->load->helper('file');
		if(delete_files($filepath,FALSE)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}

/**
 * [uploadFile description]
 * @param  string $pathupload    [lokasi upload. Gunakan BASEPATH (index root) atau APPPATH (app root)]
 * @param  string $allowtype     [jpg|png|bmp|gif]
 * @param  integer $maxsize       [Ukuran file]
 * @param  string $inputfilename [nama field input]
 * @param  boolean $debug         [Menampilkan debug dari upload file codeigniter]
 * @return [type]                [description]
 */
	function uploadFile($pathupload,$allowtype,$maxsize,$inputfilename,$overwrite=TRUE,$debug=FALSE)
	{
		$config['upload_path'] = $pathupload;
		$config['allowed_types'] = $allowtype;
		$config['max_size']	= $maxsize;
		$config['max_filename']=0;
		$config['overwrite']=$overwrite;
		$this->CI->load->library('upload', $config);
		$output=array();
		if ( ! $this->CI->upload->do_upload($inputfilename))
		{
			if($debug==TRUE){
				return $this->CI->upload->display_errors();
			}else{
				return false;
			}
		}
		else
		{
			if($debug==TRUE){
				return $this->CI->upload->data();
			}else{
				return true;
			}
		}

	}

/**
 * [uploadImage Upload gambar sekaligus membuat thumbnailnya (jika thumbs TRUE)]
 * @param  boolean $thumbs        [Apakah akan membuat thumbnail]
 * @param  boolean $overwrite     [Menimpa file jika telah ada]
 * @param  string $imgname       [Nama gambar]
 * @param  string $pathupload    [lokasi folder upload]
 * @param  string $allowtype     [jpg|png|bmp|jpeg]
 * @param  integer $maxsize       [Maksimal Ukuran file]
 * @param  integer $maxheight     [Maksimal Tinggi gambar]
 * @param  integer $maxwidth      [Maksimal Lebar Gambar]
 * @param  string $inputfilename [Nama input file]
 * @param  boolean $debug         [Menampilkan debug dari upload codeigniter]
 * @return [type]                [description]
 */
	function uploadImageSingle($thumbs=TRUE,$overwrite=TRUE,$imgname='',$pathupload,$allowtype,$maxsize,$maxheight,$maxwidth,$inputfilename,$debug=FALSE)
	{			
		$config['upload_path'] = $pathupload;
		$config['allowed_types'] = $allowtype;
		$config['max_size']	= $maxsize;
		$config['max_filename']=0;
		$config['max_width'] = $maxheight;
		$config['max_height'] = $maxwidth;
		if(!empty($imgname)){
			$config['file_name'] = $imgname;
		}		
		$config['overwrite']=$overwrite;		
		$this->CI->load->library('upload', $config);
		if ( ! $this->CI->upload->do_upload($inputfilename))
		{
			if($debug==TRUE){
				echo $this->CI->upload->display_errors();
			}else{
				return false;
			}
		}else{
			$sdata=$this->CI->upload->data();
			$folder=$sdata['file_path'];
			$oripath=$sdata['full_path'];
			$imgname=$sdata['orig_name'];
			if($thumbs==TRUE){
				$this->imageThumbs($folder,$oripath,$imgname);
			}
			if($debug==TRUE){
				echo $sdata;
			}else{
				return true;
			}
		}
	}
	
	function uploadImageMultiple($thumbs=TRUE,$overwrite=TRUE,$pathupload,$allowtype,$maxsize,$maxheight,$maxwidth,$field,$count,$debug=FALSE)
	{
		$config['upload_path'] = $pathupload;
		$config['allowed_types'] = $allowtype;
		$config['max_size']	= $maxsize;
		$config['max_filename']=0;
		$config['max_width'] = $maxheight;
		$config['max_height'] = $maxwidth;		
		$config['overwrite']=$overwrite;
		
		$debugX=array();
		$this->CI->load->library('upload', $config);
		$isupload=0;
		for($i=1;$i<=$count;$i++){
			$isupload+=1;
			if (!empty($_FILES[$field.$i]['name'])) {
				if (!$this->CI->upload->do_upload($field.$i))
				{
					$debugX=$this->CI->upload->display_errors();
				}else{
					$sdata=$this->CI->upload->data();
					$folder=$sdata['file_path'];
					$oripath=$sdata['full_path'];
					$imgname=$sdata['orig_name'];
					array_push($debugX,$this->CI->upload->data());
					if($thumbs==TRUE){
						$this->imageThumbs($pathupload,$oripath,$imgname);
					}					
				}
			}
		}
		
		if($isupload==$count){
			if($debug==TRUE){
				return $debugX;
			}else{
				return true;
			}
		}
	}

/**
 * [imageThumbs description FUNCTION]
 * @param  [type] $folderpath [description]
 * @param  [type] $imagepath  [description]
 * @param  [type] $filename   [description]
 * @return [type]             [description]
 */
	private function imageThumbs($folderpath,$imagepath,$filename)
	{
		$this->CI->load->library('image_lib');
		$sizes=array(800,600,400,200,64);
		$folderThumbs=$folderpath.'thumbs/';
		$this->makeDir($folderThumbs);
		foreach($sizes as $size)
		{
			$this->makeDir($folderThumbs.$size);

			$config['image_library'] = 'GD2';
			$config['source_image'] =$imagepath;
			$config['maintain_ratio'] = TRUE;
			$config2['create_thumb'] = TRUE;
			$config['width'] = $size;
			$config['height'] = $size;
			$config['new_image'] =$folderThumbs."$size/".$filename;
			$this->CI->image_lib->clear();
			$this->CI->image_lib->initialize($config);
			$this->CI->image_lib->resize();
		}
	}

/**
 * [deleteImage Menghapus gambar sekaligus thumbnailnya]
 * @param  [type] $folderpath [lokasi direktori. Gunakan BASEPATH (index root) atau APPPATH (app root)]
 * @param  [type] $filename   [nama file beserta ekstensi]
 * @return [type]             [description]
 */
	function deleteImage($folderpath,$filename){
		$sizes=array(800,600,400,200,64);
		$folderUpload=$folderpath;
		$folderThumbs=$folderpath.'thumbs/';
		$path=$folderUpload;
		$parentpath=$path.$filename;
		if(file_exists($parentpath)){
			unlink($parentpath);
		}
		foreach($sizes as $size)
		{
			$realpath=$folderThumbs.$size.'/'.$filename;
			if(file_exists($realpath)){
				unlink($realpath);
			}
		}
	}

/**
 * [watermarkImage Memberikan cap pada gambar]
 * @param  string $imgsrc      [Lokasi gambar cap]
 * @param  string $text        [Tulisan Cap]
 * @param  string $font        [Lokasi Font]
 * @param  integer $fontsize    [ukuran font]
 * @param  string $fontcolor   [warna font pake # hashtag]
 * @param  string $shadowcolor [Bayangan cap pake # hashtag]
 * @param  integer $vertalign   [Letak cap vertikal]
 * @param  integer $horalign    [Letak cap horizontal]
 * @return [type]              [description]
 */
	function watermarkImage($imgsrc,$text,$font,$fontsize,$fontcolor,$shadowcolor,$vertalign,$horalign)
	{
		$this->CI->load->library('image_lib');
		$config['source_image'] = $imgsrc;
		$config['wm_text'] = $text;
		$config['wm_type'] = 'text';
		$config['wm_font_path'] = $font;
		$config['wm_font_size'] = $fontsize;
		$config['wm_font_color'] = $fontcolor;
		$config['wm_vrt_alignment'] = $vertalign;
		$config['wm_hor_alignment'] = $horalign;
		$config['wm_shadow_color']=$shadowcolor;
		$config['wm_padding'] = '20';
		$this->CI->image_lib->initialize($config);
		if(!$this->CI->image_lib->watermark())
		{
			return false;
		}else{
			return true;
		}
	}
	
	function ZipExtract($archive, $destination) {   
	    if(!class_exists('ZipArchive')) {
	      return false;
	    }
	    $zip = new ZipArchive;
	    if ($zip->open($archive) === TRUE) {
	      if(is_writeable($destination . '/')) {
	        $zip->extractTo($destination);
	        $zip->close();
	        return true;
	      }
	      else {
	        return false;
	      }
	    }
	    else {
	      return false;
	    }
   }


}
