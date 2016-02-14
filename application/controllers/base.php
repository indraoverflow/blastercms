<?php
/**
 * 
 */
class Base extends CI_Controller {
	
	function __construct() {
		parent::__construct();
        $this->load->model('mpage');
	}
    
    function index(){
        $this->load->library('shortcodes');
        
        #$oldid = GetSetting('HomePageID');
        # $homeid = GetContentSetting(ActiveLangID(),GetActiveGadgetID(), "HomePageID") == "" ? $oldid : GetContentSetting(ActiveLangID(),GetActiveGadgetID(), "HomePageID") ;
        
        $pageid = GetSetting("HomePageID");
        
        
        $data['model'] = $model = $this->mpage->GetAll(array('PageID'=>$pageid))->row();
        $data['title'] = "";
        
        $this->load->view('base',$data);
    }
}
