<?php
    /**
     * 
     */
    class MMedia extends CI_Model {
        var $table = "media";
        function __construct() {
            parent::__construct();
        }
        function insert($data){
            $this->db->insert($this->table,$data);
            return TRUE;
        }
        function lastid(){
            $this->db->limit(1);
            $this->db->order_by('MediaID','desc');
            $a = $this->db->get($this->table)->row();
            if(empty($a)){
                return 0;
            }
            return $a->MediaID;
        }
        
        function GetAll($param='',$param2=''){
            if(!empty($param)){ 
                $this->db->where($param);
            }
            if(!empty($param2)){
                $this->db->order_by($param);
            }
            $this->db->order_by('MediaID','desc');
            return $this->db->get($this->table." p");
        }
        function GetOrder(){
            $this->db->order_by('Order','asc');
            return $this->db->get($this->table." p");
        }
        function update($data,$id){
            $this->db->update($this->table,$data,array('MediaID'=>$id));
            return TRUE;
        }
        function delete($id){
            $this->db->delete($this->table,array('MediaID'=>$id));
            return TRUE;
        }
    }
?>