<?php
/**
 * 
 */
class MWidget extends CI_Model {
	
    var $table      =   'widgets';
    var $detail     =   'widgetdetails';
    
	function __construct() {
		parent::__construct();
	}
    
    function getAll($param=""){
        if(!empty($param)){
            $this -> db -> where($param);
        }
        
        #$this -> db -> join('widgetdetals wd', 'wd.WidgetID = w.WidgetID','left');
        
        return $this -> db -> get($this -> table);
    }
    function getAllDetail($param){
        $this->db->where($param);
        $this->db->order_by('Order','asc');
        return $this -> db -> get($this -> detail);
    }
    
    function getRow($id){
        $this -> db -> where(array('WidgetID' => $id));
        #$this -> db -> join('widgetdetails wd', 'wd.WidgetID = w.WidgetID','left');
        return $this -> db -> get($this -> table) -> row();
    }
    
    function getLast(){
        $cek = $this -> db -> order_by('WidgetID','desc') -> limit(1) -> get($this -> table) -> row();
        if(empty($cek)){
            return 0;
        }else{
            return $cek -> WidgetID;
        }
    }
    function getLastDetail(){
        $cek = $this -> db -> order_by('WidgetDetailID','desc') -> limit(1) -> get($this -> detail) -> row();
        if(empty($cek)){
            return 0;
        }else{
            return $cek -> WidgetDetailID;
        }
    }
    
    
    function insert($data){
        $this -> db -> insert($this -> table, $data);
    }
    function insertDetail($data){
        $this -> db -> insert($this -> detail, $data);
    }
    
    function update($id, $data){
        $this -> db -> update($this -> table, $data, array('WidgetID' => $id));
    }
    function updateDetail($id, $data){
        $this -> db -> update($this -> detail, $data, array('WidgetID' => $id));
    }
    
    function delete($id){
        $this -> db -> where(array('WidgetID' => $id));
        $this -> db -> delete($this -> table);
        #$this -> db -> where(array('WigdetID' => $id));
        #$this -> db -> delete($this -> detail);
        
        return TRUE;
    }
    
    function deleteDetail($id){
        $this -> db -> where('WidgetID', $id);
        $this -> db -> delete($this -> detail);
        return TRUE;
    }
    
}
