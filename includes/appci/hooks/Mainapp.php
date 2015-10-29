<?php
class Mainapp
{
    function main()
    {
        $CI=& get_instance();
        if($this->site_status()==TRUE)
        {            
            die("Site is offline");
        }
        BlockIP();
    }
    
    function configauto()
    {
		$this->setcookiename();
		$this->setencryptkey();
	}
    
    function setcookiename()
    {
		$CFG =& load_class('Config', 'core');
		require_once( BASEPATH .'database/DB.php');
		$db =& DB();
		$s=array(
		'option_key'=>'cookie_app',
		);
		$db->where($s);
		$query = $db->get('options');
		$result = $query->result();
		foreach( $result as $row )
		{
			
		}
		$lastcookie=$row->option_val;
        $CFG->set_item('sess_cookie_name', $lastcookie);
	}
	
	function setencryptkey()
    {
		$CFG =& load_class('Config', 'core');
		require_once( BASEPATH .'database/DB.php');
		$db =& DB();
		$s=array(
		'option_key'=>'encrypt_app',
		);
		$db->where($s);
		$query = $db->get('options');
		$result = $query->result();
		foreach( $result as $row )
		{
			
		}
		$lastencrypt=$row->option_val;
        $CFG->set_item('encryption_key', $lastencrypt);
	}
    
    function site_status()
    {
        require_once( BASEPATH .'database/DB'. EXT );
        $db =& DB();
        $db->where(array(
            'option_key'=>'site_offline',
            ));
        $sql = $db->get('options');
        if($sql->num_rows() > 0){							
		    $info=$sql->row()->option_val;            
            if($info=="1")
            {
                return true;
            }else{
                return false;
            }
		} else {
			return false;
		}
    }
        
}
?>