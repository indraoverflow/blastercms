<?php
/**
 * 
 */
class MPost extends CI_Model {
	
    var $posttable  = 'posts';
    var $postcat    = 'postcategories';
    var $postimage  = 'postimages';
    var $tag        = 'posttags';
    
	function __construct() {
		parent::__construct();
	}
    
    function GetAll($param=""){
        if(!empty($param)){
            $this -> db -> where($param);
        }
        #$this -> db -> join('postcategories pc', 'pc.PostID = p.PostID','left');
        return $this->db->get('posts p');
    }
    function GetPostImage($id){
        $this -> db -> where('PostID', $id);
        $this -> db -> order_by('PostImageID','asc');
        $this -> db -> join('media m', 'm.MediaID = pm.MediaID','left');
        return $this -> db -> get($this -> postimage.' pm');
    }
    
    function GetByCat($id,$limit=0,$offset=0,$orderby="",$order=""){
        #$disallowed = GenerateDisallowedCategory(Role(),2);
        
        $this->db->where(array('pc.CategoryID'=>$id));
        #if(!empty($disallowed)){
        #    $this->db->where_not_in('pc.CategoryID',$disallowed);
        #}
        
        if($limit > 0){
            $this->db->limit($limit,$offset);
        }
        
        if($order == "asc" || $order == "desc"){
            if(!empty($orderby)){
                $this->db->order_by($orderby,$order);
            }
        }
        
        $this->db->join('postcategories pc', 'pc.PostID = p.PostID','INNER');
        $this->db->join('categories c', 'c.CategoryID = pc.CategoryID','LEFT');
        #$this->db->join('posttypes pt', 'pt.PostTypeID = p.PostTypeID','LEFT');
        $this->db->order_by('PostedOn','desc');
        #$this->db->join('productdetails prd', 'prd.PostID = p.PostID','LEFT');
        #$this->db->join('jobdetails jd', 'jd.PostID = p.PostID','LEFT');
        #$this->db->join('postdetails pd', 'pd.PostID = p.PostID','LEFT')->select('*,p.PostID as PostID');
        #if(HANDLEEMPTYPRODUCT == EMPTYPRODUCTHIDE){
        #    $this->db->where('prd.Stock >',0);
        #}
        return $this->db->get($this->posttable." p");
    }

    function GetByKeyword($id,$limit=0,$offset=0,$orderby="",$order=""){
        $this->db->like(array('p.PostTitle'=>$id));
        
        if($limit > 0){
            $this->db->limit($limit,$offset);
        }
        
        if($order == "asc" || $order == "desc"){
            if(!empty($orderby)){
                $this->db->order_by($orderby,$order);
            }
        }
        
        #$this->db->join('postcategories pc', 'pc.PostID = p.PostID','INNER');
        #$this->db->join('categories c', 'c.CategoryID = pc.CategoryID','LEFT');
        #$this->db->join('posttypes pt', 'pt.PostTypeID = p.PostTypeID','LEFT');
        $this->db->order_by('PostedOn','desc');
        #$this->db->join('productdetails prd', 'prd.PostID = p.PostID','LEFT');
        #$this->db->join('jobdetails jd', 'jd.PostID = p.PostID','LEFT');
        #$this->db->join('postdetails pd', 'pd.PostID = p.PostID','LEFT')->select('*,p.PostID as PostID');
        $this->db->group_by('p.PostID');
        
        $ret = $this->db->get($this->posttable." p");
        #echo $this->db->last_query();
        return $ret;
    }
    
    function GetLast(){
        $cek = $this->db->order_by('PostID','desc')->limit(1)->get($this->posttable)->row();
        if(empty($cek)){
            return 0;
        }else{
            return $cek->PostID;
        }
    }
    function GetLastPostCat(){
        $cek = $this -> db -> order_by('PostCategoryID','desc') -> limit(1) -> get($this -> postcat) -> row();
        if(empty($cek)){
            return 0;
        }else{
            return $cek->PostCategoryID;
        }
    }
    function GetLastPostImage(){
        $cek = $this -> db -> order_by('PostImageID','desc') -> limit(1) -> get($this -> postimage) -> row();
        if(empty($cek)){
            return 0;
        }else{
            return $cek -> PostImageID;
        }
    }
    function GetLastTag(){
        $cek = $this -> db -> order_by('PostTagID','desc') -> limit(1) -> get($this -> tag) -> row();
        if(empty($cek)){
            return 0;
        }else{
            return $cek -> PostTagID;
        }
    }
    
    function GetRow($id){
        return $this->db->where('PostID',$id)->get($this->posttable)->row();
    }
    function GetRowPostCat($id){
        $this -> db -> join('categories c', 'c.CategoryID = p.CategoryID','LEFT');
        return $this->db->where('p.PostID',$id)->get($this->postcat.' p');
    }
    
    function insert($data){
        $this -> db -> insert($this -> posttable, $data);
    }
    function insertpostcat($data){
        $this -> db -> insert($this -> postcat, $data);
    }
    function insertpostimage($data){
        $this -> db -> insert($this ->postimage, $data);
    }
    function insertTag($data){
        $this -> db -> insert($this -> tag, $data);
    }
    
    function update($data, $id){
        $this->db->update($this->posttable, $data, array('PostID'=>$id));
    }
    
    function delete($id){
        $this->db->where('PostID',$id);
        $this->db->delete($this -> posttable);
        $this->db->where('PostID',$id);
        $this->db->delete($this -> postimage);
        $this->db->where('PostID',$id);
        $this->db->delete($this -> postcat);
        $this->db->where('PostID',$id);
        $this->db->delete($this -> tag);
        
        return TRUE;
    }
    function deletepostimage($id){
        $this->db->where('PostID',$id);
        $this->db->delete($this -> postimage);
        
        return TRUE;
    }
    function deletepostcat($id){
        $this->db->where('PostID',$id);
        $this->db->delete($this -> postcat);
        
        return TRUE;
    }
    function deleteTag($id){
        $this->db->where('PostID',$id);
        $this->db->delete($this -> tag);
        
        return TRUE;
    }
    
    
}
