<?php
/**
 * 
 */
class User extends CI_Controller {
	
	function __construct() {
		parent::__construct();
        $this->load->model('muser');
        $this->load->library('encrypt');
        $this->load->helper('captcha');
        $this->load->library('user_agent');
	}
    
    function process_login(){
        $this->form_validation->set_rules(
            'UserName',
            'Username',
            'required'
        );
        
        $this->form_validation->set_rules(
            'Password',
            'Password',
            'required'
        );
        
        if($this->form_validation->run() == TRUE){
            $username = $this->input->post('Username');
            $password = $this->input->post('Password');
            
            if($this->muser->CheckUser($username,$password) == TRUE){
                $data = array(
                    'UserName'=>$username,
                    'login'=>TRUE
                );
                $this->session->set_userdata($data);
                redirect('admin/dashboard');
            }else{
                $this->session->set_flasdata('message','Maaf, username atau password Anda salah');
                redirect('admin/bl_admin');
            }
        }else{
           redirect('admin/bl_admin');
        }
        
    }

    function index(){
        CheckLogin();
        $data['title']  = 'Daftar User';
        $data['r']      = $this -> muser -> getAll();
        
        $this -> load -> view('user/data', $data);
    }
    
    function add(){
        CheckLogin();
        $data['edit']   = FALSE;
        $data['title']  = 'User Baru';
        
        $rules = array(
            array(
                'field'=>'UserName',
                'label'=>'UserName',
                'rules'=>'required|is_unique[users.UserName]'
            ),
            array(
                'field'=>'Password',
                'label'=>'Password',
                'rules'=>'required'
            ),
            array(
                'field'=>'RPassword',
                'label'=>'Ulangi Password',
                'rules'=>'required|matches[Password]'
            )
        );
        
        $this -> form_validation -> set_rules($rules);
        
        if($this -> form_validation -> run()){
            $username = $this -> input -> post('UserName');
            
            $insert = array(
                'UserName'      => $username,
                'Password'      => md5($this -> input -> post('Password')),
                'RoleID'        => $this -> input -> post('RoleID'),
                'IsSuspend'     => $this -> input -> post('IsSuspend'),
            );
            $this -> muser -> insert($insert);
            
            $info = array(
                'UserName'      => $username,
                'FirstName'     => $this -> input -> post('FirstName'),
                'LastName'      => $this -> input -> post('LastName'),
                'Gender'        => $this -> input -> post('Gender'),
                'ProfilePicture' => $this -> input -> post('MediaID'),
                'BirthDate'     => $this -> input -> post('BirthDate'),
                'CountryID'     => $this -> input -> post('CountryID'),
                'ProvinceID'     => $this -> input -> post('ProvinceID'),
                'CityID'        => $this -> input -> post('CityID'),
                'Address'       => $this -> input -> post('Address'),
                'ZipCode'       => $this -> input -> post('ZipCode'),
                'Email'         => $this -> input -> post('Email'),
                'Website'       => $this -> input -> post('Website'),
                'PhoneNumber'   => $this -> input -> post('PhoneNumber'),
                'PassportNo'   => $this -> input -> post('PassportNo'),
                'Expired'       => $this -> input -> post('Expired'),
                'IsVerified'    => $this -> input -> post('IsVerified')                
            );
            $this -> muser -> insertinfo($info);
            
            
            
            redirect(site_url('user/edit/'.$username).'?success=1');
        }else{
            $this -> load -> view('user/form', $data);
        }
    }

    function edit($username){
        CheckLogin();
        $data['edit']   = TRUE;
        $data['title']  = 'Ubah Informasi User';
        $data['result'] = $this -> muser -> getAll(array('u.UserName' => $username)) -> row();
        
        $rules = array(
            array(
                'field'=>'UserName',
                'label'=>'UserName',
                'rules'=>'required'
            ),
            array(
                'field'=>'RPassword',
                'label'=>'Ulangi Password',
                'rules'=>'matches[Password]'
            )
        );
        
        $this -> form_validation -> set_rules($rules);
        
        if($this -> form_validation -> run()){
            $insert = array(
                'UserName'=>$this->input->post('UserName'),
                'RoleID'        => $this -> input -> post('RoleID'),
                'IsSuspend'     => $this -> input -> post('IsSuspend'),
            );
            if($this->input->post('Password')!=""){
                $insert['Password'] = md5($this->input->post('Password'));
            }
            $this -> muser -> update($username, $insert);
            
            $info = array(
                'UserName'=>$this->input->post('UserName'),
                'FirstName'     => $this -> input -> post('FirstName'),
                'LastName'      => $this -> input -> post('LastName'),
                'Gender'        => $this -> input -> post('Gender'),
                'ProfilePicture' => $this -> input -> post('MediaID'),
                'BirthDate'     => $this -> input -> post('BirthDate'),
                'CountryID'     => $this -> input -> post('CountryID'),
                'ProvinceID'     => $this -> input -> post('ProvinceID'),
                'CityID'        => $this -> input -> post('CityID'),
                'Address'       => $this -> input -> post('Address'),
                'ZipCode'       => $this -> input -> post('ZipCode'),
                'Email'         => $this -> input -> post('Email'),
                'Website'       => $this -> input -> post('Website'),
                'PhoneNumber'   => $this -> input -> post('PhoneNumber'),
                'PassportNo'   => $this -> input -> post('PassportNo'),
                'Expired'       => $this -> input -> post('Expired'),
                'IsVerified'    => $this -> input -> post('IsVerified')                
            );
            $this -> muser -> updateinfo($username, $info);
            
            
            
            redirect(site_url('user/edit/'.$username).'?success=1');
        }else{
            $this -> load -> view('user/form', $data);
        }
        
    }

    function delete(){
        CheckLogin();
        $cek = $this -> input -> post('cekbox');
        $del = 0;
        
        for ($i=0; $i < count($cek); $i++) { 
            $this -> muser -> delete($cek[$i]);
            $del++;
        }
        
        if($del){
            ShowJsonSuccess($del. ' data sudah dihapus');
        }else{
            ShowJsonSuccess($del. ' data sudah dihapus');
        }
        
    }

    function login(){
        if(IsUserLogin()){
            show_error('Maaf, Anda masih dalam keadaan login');
            
        }
        $data['title']  = 'Masuk';
        
        $rules = array(
            array(
                'field' => 'UserName',
                'label' => 'Username/Email',
                'rules' => 'required'
            ),
            array(
                'field' => 'Password',
                'label' => 'Password',
                'rules' => 'required'
            )
        );
        
        $username = $this -> input -> post('UserName');
        $password = $this -> input -> post('Password');
        
        $this -> form_validation -> set_rules($rules);
        
        if($this -> form_validation -> run()){
            if($this -> muser -> CheckUser($username, $password)){
                if($this->muser->CheckUser($username,$password)){
                        
                    if($this->muser->IsSuspend($username)){
                        #show_error(lang('account_suspended'));
                        redirect(site_url('user/login')."?msg=suspend");
                    }
                
                    if(!$this->muser->IsVerified($username)){
                        
                        redirect(site_url('user/login')."?msg=verify");
                    }
                    
                    if($this->muser->IsExpired($username)){
                        
                        redirect(site_url('user/login')."?msg=expired");
                    }

                    $this->session->set_userdata(array(USERLOGINSESSION=>$username));
                    #redirect('admin');
                    
                    
                    
                    //email
                $this -> load -> library('email', GetEmailConfig());
                #$this->load->library('email',$config);
                $this -> email -> set_newline("\r\n");
                
                if(IsNotifyActive(NOTIF_USER_LOGIN)){
                    $this -> load -> library('encrypt');
                    
                    $row        = $this -> muser -> GetAll(array('u.UserName'=>$username))->row();
                    $pref       = GetNotify(NOTIF_USER_LOGIN);
                    
                    $message    = ReplaceUserEmail($pref -> Content, $username);
                    $subject    = ReplaceUserEmail($pref -> Subject, $username);
                    
                    $this -> email -> from(EMAILSENDER, EMAILSENDERNAME);
                    $this -> email -> to($row -> Email);
                    $this -> email -> subject($subject);
                    $this -> email -> message($message);
                    $this -> email -> send();
                }
                    
                    if($this->input->post('redirect') == ""){
                        if($this->session->userdata(USERLOGINSESSION) != ""){
                            redirect();
                        }
                    }else{
                        if($this->session->userdata(USERLOGINSESSION) != ""){
                            redirect($this->input->post('redirect'));
                        }
                    }
                }
            }else{
                $data['error'] = 'Username atau Password tidak tepat';
                #redirect(site_url('user/login').'?msg=1');
                $this->load->view('user/login', $data);
            }   
        }else{
            $this -> load -> view('user/login', $data);            
        } 
    } 
    
    function register(){
        if(IsUserLogin()){
            show_error('Maaf, anda masih dalam keadaan login');
            
        }
        $data['title']  = 'Pendaftaran';
        
        $rules = array(
            array(
                'field' => 'UserName',
                'label' => 'UserName',
                'rules' => 'required'
            ),
            array(
                'field' => 'Password',
                'label' => 'Password',
                'rules' => 'required'
            ),
            array(
                'field' => 'RPassword',
                'label' => 'Confirm Password',
                'rules' => 'required|matches[Password]'
            ),
            array(
                'field'=>'FirstName',
                'label'=>'FirstName',
                'rules'=>'required'
            ),
            array(
                'field'=>'Email',
                'label'=>'Email',
                'rules'=>'required|valid_email'
            )
        );
        
        $this -> form_validation -> set_rules($rules);
        
        if($this -> form_validation -> run()){

            $error = "";
            $cek = $this->muser->IsEmailExist($this->input->post('Email'));
            if($cek){
                $error .= lang('email_exist')."<br />";
            }
            
            $cekuser = $this->muser->IsUsernameExist($this->input->post('UserName'));
            if($cekuser){
                $error .= lang('username_exist')."<br />";
            }
            if(!empty($error)){
                show_error($error.'<a href="javascript:history.go(-1);">'.lang('click_here_correct').'</a>');
            }
                
            $data = array(
                'UserName'      => $this -> input -> post('UserName'),
                'Password'      => md5($this -> input -> post('Password')),
                'RoleID'        => USER,
                'IsSuspend'     => 0
            );
            $this -> muser -> insert($data);
            
            $info = array(
                'UserName'      => $this -> input -> post('UserName'),
                'FirstName'     => $this -> input -> post('FirstName'),
                'LastName'      => $this -> input -> post('LastName'),
                'Gender'        => $this -> input -> post('Gender'),
                'ProfilePicture' => $this -> input -> post('MediaID'),
                'BirthDate'     => $this -> input -> post('BirthDate'),
                'CountryID'     => $this -> input -> post('CountryID'),
                'ProvinceID'     => $this -> input -> post('ProvinceID'),
                'CityID'        => $this -> input -> post('CityID'),
                'Address'       => $this -> input -> post('Address'),
                'ZipCode'       => $this -> input -> post('ZipCode'),
                'Email'         => $this -> input -> post('Email'),
                'Website'       => $this -> input -> post('Website'),
                'PhoneNumber'   => $this -> input -> post('PhoneNumber'),
                'PassportNo'   => $this -> input -> post('PassportNo'),
                'Expired'       => $this -> input -> post('Expired'),
                'IsVerified'    => GetSetting('AutoApprove')==AUTO_APPROVE_REGISTER? 1 : 0
            );
            $this -> muser -> insertinfo($info);
            
            $this->load->library('email',GetEmailConfig());
            #$this->load->library('email',$config);
            $this->email->set_newline("\r\n");
            
            if(IsNotifyActive(NOTIF_REGISTRATION_FOR_USER)){
                $pref = GetNotify(NOTIF_REGISTRATION_FOR_USER);
                
                $message = ReplaceUserEmail($pref->Content, $this->input->post('UserName'));
                $subject = ReplaceUserEmail($pref->Subject, $this->input->post('UserName'));
                
                $this->email->from(EMAILSENDER, EMAILSENDERNAME);
                $this->email->to($this->input->post('Email'));
                $this->email->subject($subject);
                $this->email->message($message);
                $this->email->send();
            }

            if(IsNotifyActive(NOTIF_REGISTRATION_FOR_ADMIN)){
                $pref = GetNotify(NOTIF_REGISTRATION_FOR_ADMIN);
                
                $message = ReplaceUserEmail($pref->Content, $this->input->post('UserName'));
                $subject = ReplaceUserEmail($pref->Subject, $this->input->post('UserName'));
                
                $adminemail = empty($pref->ToEmail) ? ADMINEMAIL : $pref->ToEmail;
                
                $this->email->from(EMAILSENDER, EMAILSENDERNAME);
                $this->email->to($adminemail);
                if(CCEMAIL){
                    $this->email->cc(CCEMAIL);
                }
                $this->email->subject($subject);
                $this->email->message($message);
                $this->email->send();
            }
            
            $haha = array(
                        'TempEmail'=>$this->input->post('Email')
            );
            
            $this->session->set_userdata($haha);
            
            redirect(site_url('user/register_success'));
            
        }else{
            $this -> load -> view('user/register', $data);    
        }
    }

    function register_success(){
        $data['success'] = TRUE;
        $this -> load -> view('user/success', $data);
    }
    
    function logout(){
        $this -> session -> unset_userdata(USERLOGINSESSION);
        redirect();
    }
    
    function forgetpassword(){
        if(IsUserLogin()){
            show_error('Maaf, anda masih dalam keadaan login');
            
        }
        $error = "";
        $data['title'] = "Lupa Password";
        
        if(isset($_POST)){
            $email = $this->input->post('Email');
            if(!$this->muser->IsEmailExist($email)){
                $error .= "<p>".$email." tidak terdaftar pada sistem. ".$email."</p>";
            }
        }
        
        $data['error'] = $error.validation_errors();
        $this->load->library(array('form_validation','encrypt'));
        $this->form_validation->set_rules(array(array('field'=>'Email','label'=>'Email','rules'=>'required|valid_email')));
        if($this->form_validation->run() && $error==""){
                        
            $row = $this->muser->GetAll(array('ui.Email'=>$email))->row();
            $encrypted = $this->encrypt->encode($email);
            
            $this->load->library('email',GetEmailConfig());
            #$this->load->library('email',$config);
            $this->email->set_newline("\r\n");
            
            
            if(IsNotifyActive(NOTIF_FORGOT_PASSWORD)){
                $pref = GetNotify(NOTIF_FORGOT_PASSWORD);
                
                $message = ReplaceUserEmail($pref->Content, $row->UserName);
                $subject = ReplaceUserEmail($pref->Subject, $row->UserName);
                
                $this->email->from(EMAILSENDER, EMAILSENDERNAME);
                $this->email->to($row->Email);
                $this->email->subject($subject);
                $this->email->message($message);
                $this->email->send();
            }
                       
            
            redirect(current_url()."?success=".$encrypted);
        }else{
            $this->load->view('user/forgetpassword',$data);
        }
    }

    function verify(){
        $id             = $this -> input -> get('token');
        #$email         = $this -> encrypt -> decode($id);
        $encrypt        = new Encryption();
        $email          = $encrypt -> decode($id);
        $cek            = $this -> db -> where('Email',$email) -> get('userinformations');
        $data['row']    = $row  = $cek -> row();
        
        if($cek -> num_rows() < 1){
            show_error('Link aktivasi tidak sah');
        }
        
        $this->db->where('UserName', $row -> UserName);
        $this->db->update('userinformations', array('IsVerified' => 1));
        
        $this->db->where('UserName', $row -> UserName);
        $this->db->update('users', array('IsSuspend' => 0));
        
        $this->load->view('user/verify', $data);
    }
    
    function changepassword($key=""){
        $key    = $this -> input -> get('token');
        $this -> load -> library(array('encrypt','form_validation'));
        
        if(empty($key)){
            show_error('Error');
        }

        $encrypt    = new Encryption();
        $email      = $encrypt -> decode($key);
        #$email = $this->encrypt->decode($key);
        
        if(!$this -> muser -> IsEmailExist($email)){
            show_error('Invalid Token Key');
        }
        
        $data['email'] = $email;
        $data['title'] = "Ganti Password";
        
        $rules = array(
                        array(
                            'field' => 'Password',
                            'label' => 'Password',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'RPassword',
                            'label' => 'Ulangi Password',
                            'rules' => 'matches[Password]'
                        )
        );
        
        $this -> form_validation -> set_rules($rules);
        
        if($this -> form_validation -> run()){
            $row    = $this -> muser -> GetAll(array('ui.Email' => $email)) -> row();
            $data   = array('Password' => md5($this -> input -> post('Password')));
            
            $this -> muser -> update($row -> UserName, $data);
            
            $encrypted = $this -> encrypt -> encode($email);
            
            $this -> load -> library('email', GetEmailConfig());
            #$this->load->library('email',$config);
            $this -> email -> set_newline("\r\n");
            
            if(IsNotifyActive(NOTIF_PASSWORD_CHANGED)){
                $pref = GetNotify(NOTIF_PASSWORD_CHANGED);
                
                $message = ReplaceUserEmail($pref->Content, $row->UserName);
                $subject = ReplaceUserEmail($pref->Subject, $row->UserName);
                
                $this->email->from(EMAILSENDER, EMAILSENDERNAME);
                $this->email->to($row->Email);
                $this->email->subject($subject);
                $this->email->message($message);
                $this->email->send();
            }
            
            redirect(current_url()."?success=1&token=".$this->input->get('token'));
        }else{
            $this->load->view('user/changepassword',$data);
        }
    }

    function sendverify($username){
        CheckLogin();
            $this->load->model('muser');
            $this->load->library('encrypt');
            $row = $this->muser->GetAll(array('u.UserName'=>$username))->row();
            
                        
            $this->load->library('email',GetEmailConfig());
            #$this->load->library('email',$config);
            $this->email->set_newline("\r\n");
            
            $pref = GetNotify(NOTIF_REGISTRATION_FOR_USER);
                
            $message = ReplaceUserEmail($pref->Content, $username);
            $subject = ReplaceUserEmail($pref->Subject, $username);
            
            $this->email->from(EMAILSENDER, EMAILSENDERNAME);
            $this->email->to($row->Email);
            $this->email->subject($subject);
            $this->email->message($message);
            $this->email->send();
                
            redirect(site_url('user')."?sent=1");
    }

    function resetpassword($username){
        CheckLogin();
        $row = $this->muser->GetAll(array('ui.UserName'=>$username))->row();
        $email = $row->Email;
            $encrypted = $this->encrypt->encode($email);
            
            $this->load->library('email',GetEmailConfig());
            #$this->load->library('email',$config);
            $this->email->set_newline("\r\n");
            
            if(IsNotifyActive(NOTIF_FORGOT_PASSWORD)){
                $pref = GetNotify(NOTIF_FORGOT_PASSWORD);
                
                $message = ReplaceUserEmail($pref->Content, $row->UserName);
                $subject = ReplaceUserEmail($pref->Subject, $row->UserName);
                
                $this->email->from(EMAILSENDER, EMAILSENDERNAME);
                $this->email->to($row->Email);
                $this->email->subject($subject);
                $this->email->message($message);
                $this->email->send();
            }
            redirect(site_url('user')."?sentpwd=1");
    }
    
    
    
}
