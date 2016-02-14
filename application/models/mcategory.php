<?php
/**
 * 
 */
class MCategory extends CI_Model {
	
    var $table = 'categories';
    
	function __construct() {
		parent::__construct();
	}
    
    function GetAll($param=""){
        if(!empty($param)){
            $this -> db -> where($param);
        }
        return $this->db->order_by('CategoryID','desc')->get('categories');
    }
    
    
    function GetLast(){
        $cek = $this->db->order_by('CategoryID','desc')->limit(1)->get($this->table)->row();
        
        if(empty($cek)){
            return 0;
        }else{
            return $cek->CategoryID;
        }
    }
    
    function GetRow($id){
        return $this->db->where(array('CategoryID'=>$id))->get($this->table)->row();
    }
    
    function insert($data){
        $this->db->insert($this->table,$data);
    }
    
    function update($data, $id){
        $this->db->update($this->table,$data,array('CategoryID'=>$id));
    }
    
    function delete($id){
        $this->db->delete($this->table,array('CategoryID'=>$id));
    }
}
