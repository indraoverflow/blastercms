<?php
class Encryption {
    var $skey   = "SuPerEncKey2010"; // you can change it
 
    public  function safe_b64encode($string) {
 
        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }
 
    public function safe_b64decode($string) {
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }
 
    public  function encode($value){ 
 
        if(!$value){return false;}
        $text = $value;
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->skey, $text, MCRYPT_MODE_ECB, $iv);
        return trim($this->safe_b64encode($crypttext)); 
    }
 
    public function decode($value){
 
        if(!$value){return false;}
        $crypttext = $this->safe_b64decode($value); 
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->skey, $crypttext, MCRYPT_MODE_ECB, $iv);
        return trim($decrypttext);
    }
}


define('LOGINSESSION', 'AdminLogin');
define('USERLOGINSESSION', 'UserLogin');
// define('HOMEPAGEID', 1);
define('ADMINISTRATOR', 1);
define('USER', 2);

define('UNLOGINROLE',0);
define('ADMINROLE', 1);
define('USERROLE',2);



define("MAX_SIZE_UPLOAD", GetSetting('MaxFileSize'));
define('MAX_WIDTH_UPLOAD', GetSetting('MaxFileWidth'));
define('MAX_HEIGHT_UPLOAD', GetSetting('MaxFileHeight'));
define('SITETITLE', GetSetting('SiteTitle'));
define('SITEDESC', GetSetting('SiteDesc'));
define('LOGOLINK', GetSetting('LogoLink'));
define('DEFAULTDETAILVIEW', GetSetting('DefaultDetailView'));
define('DEFAULTVIEWTYPE', GetSetting('DefaultViewType'));
define('DEFAULTPOSTPERPAGE', GetSetting('DefaultPostPerPage'));
define('DEFAULTSIDEBARRIGHT', GetSetting('DefaultSidebarRight'));
define('DEFAULTSIDEBARLEFT', GetSetting('DefaultSidebarLeft'));
define('DEFAULTFOOTERCOLUMN', GetSetting('DefaultFooterColumn'));
define('EMAILPROTOCOL',GetSetting('EmailProtocol'));
define('SMTPHOST',GetSetting('SMTPHost'));
define('SMTPPORT',GetSetting('SMTPPort'));
define('SMTPEMAIL',GetSetting('SMTPEmail'));
define('SMTPPASSWORD',GetSetting('SMTPPassword'));
define('ADMINEMAIL', GetSetting('AdminEmail'));
define('EMAILSENDER',GetSetting('EmailSender'));
define('EMAILSENDERNAME', GetSetting('EmailSenderName'));
define('CCEMAIL', GetSetting('CCEmail'));
define('ALLOWSHARE', GetSetting('AllowShare'));
define('AUTOAPPROVE', GetSetting('AutoApprove'));
define('EMAILWHENCREATE', GetSetting('EmailWhenCreate'));
define('EMAILWHENEDIT', GetSetting('EmailWhenEdit'));
define('EMAILWHENDELETE', GetSetting('EmailWhenDelete'));


define('DEFAULTSERVICESEARCH', 'service/search');

define('THEMEPATH','./assets/themes/');

define('ACTIVETHEME',GetView('ActiveTheme'));

define('LINKTYPEGENERAL',1);
define('LINKTYPEOPENNEWTAB',2);
define('LINKTYPEOPENPOPUP',3);

define('NOTIFTYPEGENERAL', 1);


define('FORMBASICID',1);
define('FORMSCRIPTID',2);

define('AUTO_APPROVE_REGISTER',1);

define('POST',1);
define('PRODUCT',2);

