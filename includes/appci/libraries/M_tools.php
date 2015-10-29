<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_tools{
	
	private $CI;
	function __construct(){
		$this->CI=& get_instance();
	}
	
/**
 * [createBarcode description]
 * @param  string $type   [Code128,Code25,Code25interleaved,Ean2,Ean5,Ean8,Ean13,Code39,Identcode,Itf14,Upca,Upce]
 * @param  string $str    [Kode Barcode]
 * @param  string $height [optional height]
 * @param  string $width  [optional width]
 * @return [type]         [description]
 */
	function createBarcode($type,$str,$height='48',$width='1.7'){
		$this->CI->load->library('ext/zend','Zend/Barcode');
 		$barcodeOPT = array(
		    'text' => $str,
		    'barHeight'=> $height,
		    'factor'=>$width,
		    'drawText'=>TRUE,
		);

		$renderOPT = array();
		$render = Zend_Barcode::factory(
	    $type, 'image', $barcodeOPT, $renderOPT
		)->render();
	}
	
	
	function createQRCode($str){
		require dirname(__FILE__).'/ext/phpqrcode/qrlib.php';		
		$rn=strtotime(date("Y-m-d H:i:s"));
		QRCode::png($str,$rn.'.png',"large",10,3);		
		header("Content-type: image/png");
		readfile($rn.'.png');
		unlink($rn.'.png');
		exit(0);
	}
	
	
	function minifySource($type,$fileArray){
		$this->CI->load->library('ext/minify/minify');
		if($type=="css"){
			$this->CI->minify->css($fileArray);
			return $this->CI->minify->deploy_css();
		}elseif($type=="js"){
			$this->CI->minify->js($fileArray);
			return $this->minify->deploy_js();
		}
	}
	
}