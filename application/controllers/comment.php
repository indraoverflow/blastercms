<?php
/**
 * 
 */
class Comment extends CI_Controller {
	
	function __construct() {
		parent::__construct();
        $this -> load -> model('mcomment');
	}
    
    function index(){
        CheckLogin();
        $data['title'] = 'Daftar Komentar';
        
        $ap = $this -> input -> get('approved');
        
        if(!empty($ap)){
            if($ap==0){
                $data['r'] = $this -> mcomment -> getAll(array('IsVerified' => 0));
            }else if($ap==1){
                $data['r'] = $this -> mcomment -> getAll(array('IsVerified' => 1));
            }else{
                $data['r'] = $this -> mcomment -> getAll();
            }    
        }else{
            $data['r'] = $this -> mcomment -> getAll();
        }
        
        
        $this->load->view('comment/data',$data);
    }
    
    function show(){
        CheckLogin();
        $cek = $this -> input -> post('cekbox');
        $update = 0;
        
        for ($i=0; $i < count($cek); $i++) { 
            $dupdate = array('IsVerified' => 1);
            $this -> mcomment -> update($cek[$i], $dupdate);
            $update++;
        }
        
        ShowJsonSuccess($update." data sudah ditampilkan");
    }
    
    
    function hide(){
        CheckLogin();
        $cek = $this -> input -> post('cekbox');
        $update = 0;
        
        for ($i=0; $i < count($cek); $i++) {

            $dupdate = array('IsVerified' => 0);
            $this -> mcomment -> update($cek[$i], $dupdate);
            $update++;
        }
        
        ShowJsonSuccess($update." data sudah disembunyikan");
        
    }
    
    
    function delete(){
        CheckLogin();
        $cek = $this->input->post('cekbox');
        $del = 0;
        
        for ($i=0; $i < count($cek); $i++) { 
            $this -> mcomment -> delete($cek[$i]);
            $del++;
        }
        
        if($del){
            ShowJsonSuccess($del." data sudah dihapus");
        }else{
            ShowJsonSuccess($del." data sudah dihapus");
        }
    }
    
    
    function view($id){
        CheckLogin();
        $data['title']  = 'Komentar';
        $data['result'] = $this -> mcomment -> getRow($id);
        
        $this -> load -> view('comment/view',$data);    
       
       
    }
    
    
    
    
}
