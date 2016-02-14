<?php
/**
 * 
 */
class MView extends CI_Model {
	
    private $table = 'views';
    
	function __construct() {
		parent::__construct();
	}
    
    function insert($data){
        $this -> db -> insert($this -> table, $data);
    }
    function update($id, $data){
        $this -> db -> update($this -> table, $data, $id);
    }
    function delete($id){
        $this -> db -> where('ViewID', $id);
        $this -> db -> delete($this -> table);
        
        return TRUE;
    }
    
    
    function GetAll($param=""){
        if(!empty($param)){
            $this -> db -> where($param);
        }
        
        return $this -> db ->get($this -> table);
    }
    
    function GetRow($id){
        return $this -> db -> where('ViewID',$id) -> get($this -> table) -> row();
    }
    
    function GetLast(){
        $cek = $this -> db -> where('ViewID','desc') -> limit(1) -> get($this -> table) -> row();
        if(empty($cek)){
            return 0;
        }else{
            return $cek -> ViewID;
        }
    }
    
    function GetGeneral(){
        return $this->db->where('IsGeneral',1)->get($this->table);
    }
    
    function get($viewname){
        $a = $this->db->where('ViewName',$viewname)->get($this->table)->row();
        if(empty($a)){
            return "";
        }else{
            return $a->ViewValue;
        }
    }
    
    function set($viewname,$value){
        $this->db->where('ViewName',$viewname);
        $data = array('ViewValue'=>$value);
        $this->db->update($this->table,$data);
        return TRUE;
    }
}
