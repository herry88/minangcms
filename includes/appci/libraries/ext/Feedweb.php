<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Feedweb
{
	var $feed;
    public function add($title, $author, $link, $pubdate, $description)
    {
        $this->items[] = array(
            'title' => $title,
            'author' => $author,
            'link' => $link,
            'pubdate' => $pubdate,
            'description' => $description
        );
    }

    public function render($format = 'atom',$view)
    {
        $CI =& get_instance();

        if (empty($this->lang)) $this->lang = $CI->config->item('language');
        if (empty($this->link)) $this->link = $CI->config->item('base_url');
        if (empty($this->pubdate)) $this->pubdate = date('D, d M Y H:i:s O');

        $data['channel'] = array(
            'title'=>$this->title,
            'description'=>$this->description,
            'link'=>$this->link,
            'lang'=>$this->lang,
            'pubdate'=>$this->pubdate
        );

        $data['items'] = $this->items;

        $CI->load->view($view.'/'.$format, $data);
    }
    
    
    function rss($feed) 
    {   
    	$this->feed = $feed;  
    }
    
    function parse() 
    {
	    $rss = simplexml_load_file($this->feed);
	    
	    $rss_split = array();
	    foreach ($rss->channel->item as $item) {
	    $title = (string) $item->title; // Title
	    $link   = (string) $item->link; // Url Link
	    $description = (string) $item->description; //Description
	    $rss_split[] = '<div>
	        <a href="'.$link.'" target="_blank" title="" >
	            '.$title.' 
	        </a>
	   <hr>
	          </div>
	';
	    }
	    return $rss_split;
	  }
	  
	 function display($numrows,$head) 
	  {
	    $rss_split = $this->parse();

	    $i = 0;
	    $rss_data = '<div class="vas">
	           <div class="title-head">
	         '.$head.'
	           </div>
	         <div class="feeds-links">';
	    while ( $i < $numrows ) 
	   {
	      $rss_data .= $rss_split[$i];
	      $i++;
	    }
	    $trim = str_replace('', '',$this->feed);
	    $user = str_replace('&lang=en-us&format=rss_200','',$trim);
	    $rss_data.='</div></div>';
	    return $rss_data;
	  }

}