<?php
/**
 * 
 */
class MFooter extends CI_Model {
	
    var $table  = 'footers';
    var $detail = 'footerdetails';
    
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
        return $this -> db -> where('FooterID',$id) -> get($this -> table) -> row();
    }
    function getRowDetail($id){
        return $this -> db -> where('FooterID',$id) -> get($this -> detail) -> row();
    }
    
    function getLast(){
        $cek = $this -> db -> order_by('FooterID','desc') -> limit(1) -> get($this -> table) -> row();
        
        if(empty($cek)){
            return 0;
        }else{
            return $cek -> FooterID;
        }
    }
    function getLastOrder(){
        $cek = $this -> db -> order_by('Order','desc') -> limit(1) -> get($this -> table) -> row();
        
        if(empty($cek)){
            return 0;
        }else{
            return $cek -> FooterID;
        }
    }
    function updateActive($id, $data){
        $this->db->update($this -> table, $data,array('FooterID'=>$id));
    }
    
    
    function getAllDetail(){
        return $this->db->get($this->detail);
    }
    function getFooterDetail($index,$fcid){
        $this->db->where('FooterID',$fcid)->where('Index',$index);
        $this->db->order_by('Order','asc');
        return $this->db->get($this->detail);
    }
    function getLastDetail(){
        $cek = $this -> db -> order_by('FooterDetailID','desc') -> limit(1) -> get($this -> detail) -> row();
        
        if(empty($cek)){
            return 0;
        }else{
            return $cek -> FooterDetailID;
        }
    }
    
    
    
    
    
    function insert($data){
        $this -> db -> insert($this -> table, $data);
    }
    function insertDetail($data){
        $this -> db -> insert($this -> detail, $data);
    }
    
    function update($id, $data){
        $this -> db -> update($this -> table, $data, array('FooterID' => $id));
    }
    
    function delete($id){
        $this -> db -> where('FooterID',$id);
        $this -> db -> delete($this -> table);
        $this -> db -> where('FooterID',$id);
        $this -> db -> delete($this -> detail);
        
        return TRUE;
    }
    
    function deleteDetail($id){
        return $this -> db -> delete($this -> detail, array('FooterID' => $id));
    }
    
    
    
    
    
    
    
    
}
