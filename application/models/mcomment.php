<?php
/**
 * 
 */
class MComment extends CI_Model {
	var $table = 'comments';
    
	function __construct() {
		parent::__construct();
	}
    
    function getAll($param=""){
        if(!empty($param)){
            $this -> db -> where($param);
        }
        
        return $this -> db -> get($this->table);
    }
    
    function getRow($id){
        return $this -> db -> where('CommentID', $id) -> get($this -> table) -> row();
    }
    
    function getLast(){
        $cek = $this -> db -> order_by('CommentID','desc') -> limit(1) -> get($this -> table) -> row();
        if(empty($cek)){
            return 0;
        }else{
            return $cek -> CommentID;
        }
    }
    
    function insert($data){
        $this -> db -> insert($this->table, $data);
    }
    
    function update($id, $data){
        $this -> db -> update($this -> table, $data, array('CommentID' => $id));
    }
    
    function delete($id){
        $this -> db -> where('CommentID', $id);
        $this -> db -> delete($this->table);
        return TRUE;
    }
}
