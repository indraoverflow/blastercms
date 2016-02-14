<?php
/**
 * 
 */
class Themes extends CI_Controller {
	
	function __construct() {
		parent::__construct();
        $this->load->helper('file');
        $this->load->helper('directory');
	}
    
    function index(){
        CheckLogin();
        $folder             = array();
        $folder['desktop']  = './assets/themes';
        
        $data['folder']     = $folder;   
        $data['themes']     = directory_map($folder['desktop']);
        $data['title']      = 'Daftar Tema';
        
        $this -> load -> view('themes/data', $data);
        
    }
    
    function active($theme){
        CheckLogin();
        $this -> db -> where('ViewName', 'ActiveTheme');
        $data   = array('ViewValue' => $theme);
        $this -> db -> update('views', $data);
        
        redirect(site_url('themes').'?success=1');            
    }
 
}
