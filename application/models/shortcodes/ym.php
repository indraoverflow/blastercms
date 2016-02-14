<?php
/**
 * 
 */
class YM extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	public function run($params = array()){
		if(!array_key_exists('id', $params)){
			return "Please Provide Yahoo! ID";
		}
		if(!array_key_exists('id', $params)){
			$viewtype = 19;
		}else{
			$viewtype = $params['viewtype'];
		}
		
		$content = '<a href="ymsgr:sendIM?'.$id.'"><br/><img border=0 src="http://opi.yahoo.com/online?u='.$id.'&amp;m=g&amp;t='.$viewtype.'" /> </a>';
		return $content;
	}
	
}