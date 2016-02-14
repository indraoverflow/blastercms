<?php
/**
 * 
 */
class MTag extends CI_Model {
    private $table = "tags";
    function __construct() {
        parent::__construct();
    }
    function delete($id){
        $this -> db -> where('PostID',$id) -> delete('posttags');
        return TRUE;
    }
    function exist($tag){
        $tag = strtolower($tag);
        $cek = $this -> db -> where('TagName',$tag) -> get($this -> table);
        if($cek->num_rows()){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    function GetIDByName($name){
        $cek = $this -> db -> where('TagName',$name) -> get($this -> table) -> row();
        return $cek -> TagID;
    }
    function insert($data){
        $this -> db -> insert($this->table,$data);
        return TRUE;
    }
    function GetLastIncrement(){
        $last = $this -> db -> order_by('TagID','desc') -> limit(1) -> get($this->table) -> row();
        if(empty($last)){
            return 0;
        }
        return $last -> TagID;
    }
    function GetTags($id){
        return $this -> db -> where('PostID',$id) ->join('tags','tags.TagID = posttags.TagID') -> get('posttags');
    }
}
