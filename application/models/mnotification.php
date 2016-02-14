<?php
/**
 * 
 */
class MNotification extends CI_Model {
	
    var $table  = 'notifications';
    var $type   = 'notificationtypes';
    
	function __construct() {
		parent::__construct();
	}
    
    function getAll($param=""){
        if(!empty($param)){
            $this -> db -> where($param);
        }
        
        $this -> db -> order_by('NotificationID','asc');
        return $this -> db -> get($this -> table);
    }
    
    
    function insert($data){
        $this -> db -> insert($this -> table, $data);
    }
    
    function update($id, $data){
        $this -> db -> update($this -> table, $data, array('NotificationID' => $id));
    }
    
    function delete($id){
        $this -> db -> where('NotificationID', $id);
        $this -> db -> delete($this -> table);
        return TRUE;
    }
    
}
