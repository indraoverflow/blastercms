<?php
/**
 * 
 */
class Admin extends CI_Controller {
	
	function __construct() {
		parent::__construct  ();
        $this->load->model('muser');
	}
    
    
    function index(){
        CheckLogin();
        if($this->session->userdata(LOGINSESSION) == ""){
            show_404();
        }
        
        $this -> load -> model('mpost');
        $this -> load -> model('mpage');
        $this -> load -> model('mcategory');
        $this -> load -> model('mcomment');
        
        $data['posts']       = $this -> mpost -> GetAll();
        $data['pages']       = $this -> mpage -> GetAll();
        $data['categories']   = $this -> mcategory -> GetAll();
        $data['comments']    = $this -> mcomment -> getAll();
        $data['approveds']    = $this -> mcomment -> getAll(array('IsVerified' => 1));
        $data['pendings']    = $this -> mcomment -> getAll(array('IsVerified' => 0));
        
        $data['title'] = 'Dasboard';
        $this->load->view('admin/dashboard', $data);
    }
    
    
    function login(){
        $this->load->library('uri');
        $this->session->set_userdata(array(LOGINSESSION=>''));
        
        if(strtolower($this->uri->segment(2))=='login'){
            show_404();
        }
        
        if($this->session->set_userdata(LOGINSESSION)!=''){
            redirect('admin');
        }
        
        $data['title'] = 'Login';
        
        $username = $this->input->post('Username');
        $password = $this->input->post('Password');
        
        $rules = array(
            array(
                'field' => 'Username',
                'label' => 'Username',
                'rules' => 'required'
            )
            ,array(
                'field' => 'Password',
                'label' => 'Password',
                'rules' => 'required'
            )
        );
        
        $this->form_validation->set_rules($rules);
        
        if($this->form_validation->run()){
                
            if($this->muser->CheckUser($username,$password)){
                if($this -> muser -> IsSuspend($username)){
                    show_error("Akun anda di hentikan");
                }
                
                $this -> session -> set_userdata(array(LOGINSESSION => $username));
                #redirect('admin');
                
                //email
                $this -> load -> library('email', GetEmailConfig());
                #$this->load->library('email',$config);
                $this -> email -> set_newline("\r\n");
                
                if(IsNotifyActive(NOTIF_ADMIN_LOGIN)){
                    #$username = $this -> input -> post('UserName');
                    #$this -> load -> model('muser');
                    $this -> load -> library('encrypt');
                    
                    $row        = $this -> muser -> GetAll(array('u.UserName'=>$username))->row();
                    $pref       = GetNotify(NOTIF_ADMIN_LOGIN);
                    
                    $message    = ReplaceUserEmail($pref -> Content, $username);
                    $subject    = ReplaceUserEmail($pref -> Subject, $username);
                    
                    $this -> email -> from($pref -> SenderEmail, $pref -> SenderName);
                    $this -> email -> to($row -> Email);
                    $this -> email -> subject($subject);
                    $this -> email -> message($message);
                    $this -> email -> send();
                }
                
                if($this -> input -> post('redirect') == ""){
                    if($this -> session -> userdata(LOGINSESSION) != ""){
                        redirect('admin');
                    }
                }else{
                    if($this -> session -> userdata(LOGINSESSION) != ""){
                        redirect($this -> input -> post('redirect'));
                    }
                }
                
            }else{
                $data['error'] = '<div class="alert alert-danger">Username atau Password tidak tepat</div>';
                #redirect(site_url('admin/login').'?msg=1');
                $this -> load -> view('admin/login',$data);
            }
            
        }else{
            $this -> load -> view('admin/login',$data);
        }
        
        
    }


    function logout(){
        $this->session->unset_userdata(LOGINSESSION);
        
        redirect(site_url());
    }
    
    function password(){
        CheckLogin();
        $data['title']  = 'Ganti Password';
        
        $rules = array(
                        array(
                            'field'=>'Password',
                            'label'=>'Password Baru',
                            'rules'=>'required'
                        )
        );
        
        $this -> form_validation -> set_rules($rules);
        
        if($this -> form_validation -> run()){
        
            $this -> db -> where('Password', md5($this -> input -> post('OldPassword')));
            $r = $this -> db -> get('users');
            
            if($r -> num_rows() < 1){
                redirect(current_url().'?oldpassword=false');
                #show_error('Password lama tidak tepat');
                #return;
            }
            
            if($this -> input -> post('Password') != $this -> input -> post('RPassword')){
                redirect(current_url().'?newpassword=false');
                #show_error("Password baru tidak sama");
                #return;
            }
            
            $data = array('Password' => md5($this -> input -> post('Password')));
            $this -> db -> update('users', $data, array('UserName' => $this -> session -> userdata(LOGINSESSION)));
            redirect(current_url()."?success=1");
        }else{
            $this->load->view('admin/password', $data);
        }
    }
    
    
}
