<?php
/**
 * 
 */
class Setting extends CI_Controller {
	
	function __construct() {
		parent::__construct();
        $this -> load -> model('msetting');
	}
    
    function general(){
        CheckLogin();
        $data['title']  = 'Pengaturan Umum';
        $data['r']      = $this -> msetting -> GetGeneral();
        
        
        
        $this -> load -> view('setting/general', $data);
    }
    
    function save(){
        CheckLogin();
        $r = $this->input->get('redirect');
        $posts = $this->input->post();
        
        foreach ($posts as $settingname => $settingvalue){
            $this->msetting->Set($settingname,$settingvalue);
        }
        
        if(empty($r)){
            redirect(site_url('setting/general')."?success=1");
        }else{
            redirect(site_url($r)."?success=1");
        }
    }
    
    function appearance(){
        CheckLogin();            
        $data['title']  = 'Pengaturan Tampilan';
        
        $rules = array(
            array(
                'field' => 'DefaultDetailView',
                'label' => 'Tampilan Detail Pos',
                'rules' => 'required'
            ),
            array(
                'field' => 'DefaultViewType',
                'label' => 'Tampilan Tipe Tampilan',
                'rules' => 'required'
            )
        );
        
        $this -> form_validation -> set_rules($rules);
        if($this -> form_validation -> run()){
            $detailview     = $this -> input -> post('DefaultDetailView');
            $viewtype       = $this -> input -> post('DefaultViewType');
            $postperpage    = $this -> input -> post('DefaultPostPerPage');
            $leftsidebar    = $this -> input -> post('DefaultSidebarLeft');
            $rightsidebar   = $this -> input -> post('DefaultSidebarRight');
            $footer         = $this -> input -> post('DefaultFooterColumn');
            
            SetSetting('DefaultDetailView', $detailview);
            SetSetting('DefaultViewType', $viewtype);
            SetSetting('DefaultPostPerPage', $postperpage);
            SetSetting('DefaultSidebarLeft', $leftsidebar);
            SetSetting('DefaultSidebarRight', $rightsidebar);
            SetSetting('DefaultFooterColumn', $footer);
            
            redirect(current_url().'?success=1');
        }else{
            $this -> load -> view('setting/appearance', $data);
        }
        
    }
    
    function email(){
        CheckLogin();
        $data['title'] = "Pengaturan Email";
        if(!empty($_POST)){
            $this->db->where('SettingName','EmailProtocol');
            $data = array('SettingValue'=>$this->input->post('EmailProtocol'));
            $this->db->update('settings',$data);
            
            redirect(current_url().'?success=1');
        }else{
            $this->load->view('setting/email',$data);
        }
    }
    
    function url(){
        CheckLogin();
        $data['title']  = 'Ubah URL Login';
        
        $rules = array(
                'field' => 'LoginURL',
                'label' => 'Login URL',
                'rules' => 'required'
        );
        $this -> form_validation -> set_rules($rules);
        if($this -> form_validation -> run()){
            $url = $this -> input -> post('LoginURL');
            SetLoginURL($url);
            
            redirect(current_url().'?success=1');                
        }else{
            $this -> load -> view('setting/url',$data);    
        }
    }
    
    
    function setHome($id){
        CheckLogin();
        
        SetSetting('HomePageID', $id);
        redirect('page');
        
    }
    
    function setMainMenu($id){
        CheckLogin();
        SetSetting('MainMenuID', $id);
        redirect('menu');
    }
    function unSetMainMenu($id){
        CheckLogin();
        SetSetting('MainMenuID', '');
        redirect('menu');
    }
    
    function setTopMenu($id){
        CheckLogin();
        SetSetting('TopMenuID', $id);
        redirect('menu');
    }
    function unSetTopMenu($id){
        CheckLogin();
        SetSetting('TopMenuID', '');
        redirect('menu');
    }
    
    function setFooterMenu($id){
        CheckLogin();
        SetSetting('FooterMenuID', $id);
        redirect('menu');
    }
    function unSetFooterMenu($id){
        CheckLogin();
        SetSetting('FooterMenuID', '');
        redirect('menu');
    }
}
