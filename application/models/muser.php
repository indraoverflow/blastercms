<?php
/**
 * 
 */
class MUser extends CI_Model {
	
    var $table  = 'users';
    var $info   = 'userinformations';
    
	function __construct() {
		parent::__construct();
	}
    
    function CheckUser($username,$password){
        $password = md5($password);
        $this->db->where(array('UserName'=>$username,'Password'=>$password,'RoleID'=>1));
        $query = $this->db->get($this->table);
        
        if($query->num_rows() > 0){
            return TRUE;    
        }else{
            return FALSE;
        }
    }
    
    function getAll($param=""){
        if(!empty($param)){
            $this -> db -> where($param);
        }
        $this -> db -> join('userinformations ui','ui.UserName = u.UserName','LEFT');
        return $this -> db -> get($this -> table.' u');
    }
    
    
    function insert($data){
        $this -> db -> insert($this -> table, $data); 
    }
    function insertinfo($data){
        $this -> db -> insert($this -> info, $data);
    }
    
    function update($username, $data){
        $this -> db -> update($this -> table, $data, array('UserName' => $username));
    }
    function updateinfo($username, $data){
        $this -> db -> update($this -> info, $data, array('UserName' => $username));
    }
    
    function delete($username){
        $this -> db -> where('UserName', $username);
        $this -> db -> delete($this -> table);
        $this -> db -> where('UserName', $username);
        $this -> db -> delete($this -> info);
        
        return TRUE;
    }
    
    function IsEmailExist($username){
        $cek = $this -> db 
                      -> where('userinformations.Email',$username)
                       -> join('userinformations','userinformations.UserName = users.UserName','left')
                        -> get($this -> table) 
                         -> num_rows();

        if($cek < 1){
            return FALSE;
        }else{
            return TRUE;
        }
    }
    
    function IsSuspend($username){
        $cek = $this -> db 
                      -> where('UserName',$username) 
                       -> where('IsSuspend',1) 
                        -> get($this -> table);
        
        if($cek -> num_rows() < 1){
            return FALSE;
        }else{
            return TRUE;
        }
    }
    function IsVerified($username){
        $row = $this -> getAll(array('u.Username'=>$username)) -> row();
        #$cek = $this->db->where('UserName',$username)->where('IsVerified',1)->get($this->table)->num_rows();
        if(!$row -> IsVerified){
            return FALSE;
        }else{
            return TRUE;
        }
    }
    function IsExpired($username){
        $cek = $this -> db 
                      -> join($this -> info." ui",'ui.UserName = u.UserName','inner')
                       ->where('u.UserName',$username)
                        ->where('ui.Expired !=',"0000-00-00")
                         ->where('ui.Expired <',date('Y-m-d'))
                          ->get($this -> table." u")
                           ->num_rows();
        #echo $this->db->last_query();
        if($cek < 1){
            return FALSE;
        }else{
            return TRUE;
        }
    }
    function IsUsernameExist($username){
        $cek = $this->db->where('UserName',$username)->get($this->table);
        if($cek->num_rows() < 1){
            return FALSE;
        }else{
            return TRUE;
        }
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
}
