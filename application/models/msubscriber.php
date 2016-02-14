<?php
/**
 * 
 */
class MSubscriber extends CI_Model {
	var $table  = 'subscribers';
    var $cat    = 'subscribercategories';
    
	function __construct() {
		parent::__construct();
	}
    
    function getAll($param=""){
        if(!empty($param)){
            $this -> db -> where($param);
        }
        
        #$this -> db -> join('subscribercategories sc', 'sc.SubscriberID = s.SubscriberID','left');
        return $this -> db -> get($this -> table);
    }
    
    function getRow($id){
        return $this -> db -> where('SubscriberID',$id) -> get($this -> table) -> row();
    }
    function getRowSubCat($id){
        $this -> db -> join('categories c', 'c.CategoryID = sc.CategoryID','LEFT');
        return $this->db->where('sc.SubscriberID',$id)->get($this -> cat.' sc');
    }
    
    function getLast(){
        $cek = $this -> db -> order_by('SubscriberID','desc') -> limit(1) -> get($this -> table) -> row();
        if(empty($cek)){
            return 0;
        }else{
            return $cek -> SubscriberID;
        }
    }
    
    
    function insert($data){
        $this -> db -> insert($this -> table, $data);
    }
    function insertCat($data){
        $this -> db -> insert($this -> cat, $data);
    }
    
    function update($data, $id){
        $this -> db -> update($this -> table, $data, array('SubscriberID' => $id));
    }
    
    function delete($id){
        $this -> db -> where('SubscriberID',$id);
        $this -> db -> delete($this -> table);
        $this -> db -> where('SubscriberID',$id);
        $this -> db -> delete($this -> cat);
        
        return TRUE;
    }
    
    function deleteCat($id){
        $this -> db -> where('SubscriberID',$id);
        $this -> db -> delete($this -> cat);
        
        return TRUE;
    }
    
    
}
