<?php
/**
 * 
 */
class MPage extends CI_Model {
	var $table = 'pages';
	function __construct() {
		parent::__construct();
	}
    
    function GetAll($param=""){
        if(!empty($param)){ 
            $this->db->where($param);
        }
        return $this->db->get($this->table);
    }
    
    function GetLast(){
        $cek = $this->db->order_by('PageID','desc')->get($this->table)->row();
        if(empty($cek)){
            return 0;
        }else{
            return $cek->PageID;
        }
    }
    
    function GetRow($id){
        return $this->db->where('PageID',$id)->get($this->table)->row();
    }
    
    function insert($data){
        $this->db->insert($this->table,$data);
    }
    
    function update($id,$data){
        $this->db->update($this->table, $data, array('PageID'=>$id));
    }
    
    function delete($id){
        $this->db->delete($this->table, array('PageID'=>$id));
    }
    
    function GetPage($id){
        return $this->db->where('PageID',$id)->get($this->table)->row();
    }
}
