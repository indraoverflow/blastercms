<?php
/**
 * 
 */
class Sidebar extends CI_Controller {
	
	function __construct() {
		parent::__construct();
	}
    
    function addhtml(){
        CheckLogin();
        $data['title'] = 'Judul';
        $this -> load -> view('sidebar/addhtml', $data);
    }
    
    function addym(){
        CheckLogin();
        $data['title'] = 'Judul';
        $this -> load -> view('sidebar/addym', $data);
    }
    
    function addmenu(){
        CheckLogin();
        $data['title'] = 'Judul';
        $this -> load -> view('sidebar/addmenu', $data);
    }
    
    function addsubscribe(){
        CheckLogin();
        $data['title'] = 'Judul';
        $this -> load -> view('sidebar/addsubscribe', $data);
    }
}
