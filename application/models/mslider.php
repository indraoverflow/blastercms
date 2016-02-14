<?php
/**
 * 
 */
class MSlider extends CI_Model {
	
    var $table = 'sliders';
    
	function __construct() {
		parent::__construct();
	}
    
    function insert($data){
        $this -> db -> insert($this -> table, $data);
    }
    
    function update($id, $data){
        $this -> db -> update($this -> table, $data, array('SliderID' => $id));
    }
    
    function delete($id){
        $this -> db -> where('SliderID', $id);
        $this -> db -> delete($this -> table);
        return TRUE;
    }
    
    function getAll($param=""){
        if(!empty($param)){
            $this -> db -> where($param);
        }
        
        $this -> db -> join('media m', 'm.MediaID = p.MediaID', 'LEFT');
        
        return $this -> db -> get($this -> table. ' p');
    }
    
    function getRow($id){
        return $this -> db -> where('SliderID', $id) -> get($this -> table) -> row();
    }
    
    function lastID(){
        $cek = $this -> db -> order_by('SliderID','desc') -> limit(1) -> get($this-> table) -> row();
        if(empty($cek)){
            return 0;
        }else{
            return $cek -> SliderID;
        }
    }
}
