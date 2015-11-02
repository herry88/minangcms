<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        checkAccess();
    }
    
    function index()
    {
        $meta['judul']="Dashboard";
        $this->load->view('public/header',$meta);
        $this->load->view('dashboardview');
        $this->load->view('public/footer');
    }
    
    function getfeed(){
    	
		$feedUrl=optionGet('feed_minangcms');
		$feedContent = "";
		$output="";

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $feedUrl);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HEADER, false);
		
		curl_setopt($curl, CURL_HTTP_VERSION_1_1, true);
		curl_setopt($curl, CURLOPT_ENCODING, "gzip, deflate");
		curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3");

		$feedContent = curl_exec($curl);
		curl_close($curl);
		$limit=10;
		if($feedContent && !empty($feedContent)){					
		  $feedXml = @simplexml_load_string($feedContent);
		  if($feedXml){
		  	$output='';			
			$i=0;
			if($i <= $limit){
				$output.='<ul>';
				foreach($feedXml->channel->item as $item){
				$i+=1;
				$output.='<li><a href="'.$item->link.'" target="_blank">'.$item->title.'</a></li>';
				}
				$output.='</ul>';
			}			
		  }
		}else{
			$output.='Tidak dapat mengakses berita';
		}
		
		echo $output;
	}
    
}