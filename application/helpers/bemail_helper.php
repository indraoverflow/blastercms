<?php

define('NOTIF_REGISTRATION_FOR_USER', 1);
define('NOTIF_REGISTRATION_FOR_ADMIN',2);
define('NOTIF_ADMIN_LOGIN',3);
define('NOTIF_USER_LOGIN',4);
define('NOTIF_FORGOT_PASSWORD',5);
define('NOTIF_PASSWORD_CHANGED', 6);









function GetEmailConfig(){
    $local = array(
        'protocol'  => 'smtp',
        'smtp_host' => 'ssl://smtp.googlemail.com',
        'smtp_port' => 465,
        'mailtype'  => 'html',
        'smtp_user' => 'medan.job@gmail.com',
        'smtp_pass' => 'cobaajalagi'
    );
    
    $hosted = array(
        'mailtype' => 'html'
    );
    
    if(EMAILPROTOCOL == "smtp"){
        return $local;
    }else{
        return $hosted;
    }
}

function GetNotify($id){
    $CI =& get_instance();
    $CI -> load -> database();
    $row = $CI -> db -> where('NotificationID',$id)->get('notifications')->row();
    if(empty($row)){
        return FALSE;
    }else{
        return $row;
    }
}

function IsNotifyActive($id){
    $CI =& get_instance();
    $CI -> load -> database();
    $row = $CI -> db -> where('NotificationID',$id)->get('notifications')->row();
    if(empty($row)){
        return FALSE;
    }else{
        if($row -> IsActive){
            return TRUE;
        }else{
            return FALSE;
        }
    }
}

function ReplaceUserEmail($content,$username){
    $CI =& get_instance();
    $CI -> load -> model('muser');
    $CI -> load -> library('encrypt');
    
    $row            = $CI -> muser -> GetAll(array('u.UserName'=>$username))->row();
    $encrypt        = new Encryption();
    $encryptemail   = $encrypt->encode($row->Email);
    #$encryptemail  = $CI -> encrypt -> encode($row->Email);
    $activationlink = anchor(site_url('user/verify').'?token='.$encryptemail);
    $recoverylink   = anchor(site_url('user/changepassword/').'?token='.$encryptemail);
    $ip             = $_SERVER['REMOTE_ADDR'];
    
    $find = array(
            '@SITENAME@',
            '@USERNAME@',
            '@FIRSTNAME@',
            '@LASTNAME@',
            '@LINK_ACTIVATION@',
            '@LINK_RECOVERY@',
            '@TIME@',
            '@PASSWORD@',
            '@IP@'
    );
    $replace = array(
            SITETITLE,
            $username,
            $row->FirstName,
            $row->LastName,
            $activationlink,
            $recoverylink,
            date('Y-m-d H:i:s'),
            $CI -> input -> post('Password'),
            $ip
    );
    return str_replace($find, $replace, $content);
}