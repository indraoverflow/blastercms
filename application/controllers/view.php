<?php
/**
 * 
 */
class View extends CI_Controller {
	
	function __construct() {
		parent::__construct();
        $this -> load -> model('mview');
	}
    
    function logo(){
        CheckLogin();
        $rules = array(
                        array(
                            'field'=>'MediaPath',
                            'label'=>'Logo',
                            'rules'=>'required'
                        )
        );
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run()){
            $this->db->where('ViewName','Logo');
            $data = array('ViewValue'=>$this->input->post('MediaPath'));
            $this->db->update('views',$data);
            redirect(current_url()."?success=1");
        }else{
            $this->load->view('view/logo');
        }
    }
    
    
    function ikon(){
        CheckLogin();
        $rules = array(
                        array(
                            'field'=>'MediaPath',
                            'label'=>'Ikon',
                            'rules'=>'required'
                        )
        );
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run()){
            $this->db->where('ViewName','Ikon');
            $data = array('ViewValue'=>$this->input->post('MediaPath'));
            $this->db->update('views',$data);
            redirect(current_url()."?success=1");
        }else{
            $this->load->view('view/ikon');
        }
    }
}
