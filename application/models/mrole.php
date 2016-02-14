<?php
/**
 * 
 */
class MRole extends CI_Model {
	
    var $table  = 'roles';
    var $access = 'roleaccess';
    
    var $modul  = 'modules';
    
	function __construct() {
		parent::__construct();
	}
    
    function getAll($param=""){
        if(!empty($param)){
            $this -> db -> where($param);
        }
        
        return $this -> db -> get($this -> table);
    }
    
    function getRow($id){
        return $this -> db -> where('RoleID',$id) -> get($this -> table) -> row();
    }
    
    function lastID(){
        $cek = $this -> db -> order_by('RoleID','desc') -> limit(1) -> get($this -> table) -> row();
        if(empty($cek)){
            return 0;
        }else{
            return $cek -> RoleID;
        }
    }
    
    function insert($data){
        $this -> db -> insert($this -> table, $data);
    }
    
    function update($id, $data){
        $this -> db -> update($this -> table, $data, array('RoleID' => $id));
    }
    
    function delete($id){
        $this -> db -> where('RoleID', $id);
        $this -> db -> delete($this -> table);
        
        return TRUE;
    }
    
    
    
    function getAllModule(){
        return $this -> db -> get($this -> modul);
    }
    function getLastAccess(){
        $cek = $this -> db -> order_by('RoleAccessID','desc') -> limit(1) -> get($this -> access) -> row();
        if(empty($cek)){
            return 0;
        }else{
            return $cek -> RoleAccessID;
        }
    }
    
    function insertAccess($data){
        $this -> db -> insert($this -> access, $data);
    }
    
    function deleteAccess($id){
        $this -> db -> where('RoleID', $id);
        $this -> db -> delete($this -> access);
        return TRUE;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
