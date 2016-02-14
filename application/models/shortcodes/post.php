<?php
/**
 * 
 */
class Post extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this -> load -> model('mpost');
	}
	public function run($params = array()){
		
		$viewtypes = $this -> db -> get('viewtypes');
		
		$viewdata = array();
		
		foreach ($viewtypes -> result() as $viewtype) {
			$viewdata[$viewtype -> ViewTypeID] = $viewtype -> ViewTypeFile;
		}
		
		/*
		$viewdata = array(
						1=>'viewtype/list',
						2=>'viewtype/thumb',
		);
		 * */
		
		$viewtype = (array_key_exists('viewtype', $params)) ? $params['viewtype'] : 1;
		$src = (array_key_exists('src', $params)) ? $params['src'] : "post";
		$src = strtolower($src);
		$order = (array_key_exists('order', $params)) ? $params['order'] : "asc";
		
		if( !array_key_exists('cats', $params) && !array_key_exists('id', $params) && $src != 'testimonial'){
    		return "Undefined ID";
    	}
		
		if($src == "post"){
			$posttype = 2;
		}else if($src == "product"){
			$posttype = 2;
		}else{
		    $posttype = 0;
		}
		
		$data['countzz'] = $count = (array_key_exists('count', $params)) ? $params['count'] : 10;
		$data['col'] = $count = (array_key_exists('col', $params)) ? $params['col'] : 4;
		
		if(array_key_exists('cats', $params)){
			$cats = explode(" ",$params['cats']);
			
			$this -> db -> where('p.PostTypeID',$posttype);
			
			$this -> db -> where_in('pc.CategoryID',$cats);
			
			$orderby = $this -> input -> get('orderby');
			#$order = $this->input->get('order');
			
			$orderby = (empty($orderby)) ? "PostedOn" : $orderby;
			
			$this -> db -> order_by($orderby,$order);
			
			if(array_key_exists('pagination', $params)){
				
			}else{
				if($count > 0){
					$this->db->limit($count);
				}
			}
			
			$this->db->where("((p.PostExpiredDate >= '".date('Y-m-d')."') OR (p.PostExpiredDate IS NULL) OR (p.PostExpiredDate = ''))");
			
			$this->db->join('postcategories pc', 'pc.PostID = p.PostID','INNER');
			$this->db->join('categories c', 'c.CategoryID = pc.CategoryID','LEFT');
			#$this->db->join('posttypes pt', 'pt.PostTypeID = p.PostTypeID','LEFT');
			#$this->db->join('productdetails prd', 'prd.PostID = p.PostID','LEFT');
			#$this->db->join('jobdetails jd', 'jd.PostID = p.PostID','LEFT');
			#$this->db->join('properties ps', 'ps.ProductID = p.PostID','LEFT');
			#$this->db->join('postdetails pd', 'pd.PostID = p.PostID','LEFT')->select('*,p.PostID as PostID');
			
			$this->db->group_by('p.PostID');
			
			#if(HANDLEEMPTYPRODUCT == EMPTYPRODUCTHIDE){
			#	$this->db->where('prd.Stock >',0);
			#}
			
			$data['allmodel'] = $allmodel = $this->db->get("posts p");
			
			#echo $this->db->last_query();
			
			if(array_key_exists('pagination', $params)){
				//pagination
				if($this->input->get('page')==""){
					$page = 1;
				}else{
					$page = $this->input->get('page');
				}
				
				$perpage = (is_numeric($params['pagination'])) ? $params['pagination'] : 10;
				$allrow = $allmodel->num_rows();
				
				if($allrow > 0){
					$data['exist'] = $exist = TRUE;
				}else{
					$data['exist'] = $exist = FALSE;
				}
				
				if($exist){
					$from = ($page*$perpage) - $perpage;
					$data['pagenum'] = ceil($allrow / $perpage);
					$data['page'] = $page;
				}else{
					$from = 0;
				}
				
				$orderby = $this->input->get('orderby');
				
				$orderby = (empty($orderby)) ? "PostedOn" : $orderby;
				
				//create new model with pagination
				$this -> db -> where('p.PostTypeID',$posttype);
			
				$this -> db -> where_in('pc.CategoryID',$cats);
				$this -> db -> order_by($orderby,$order);
				$this -> db -> limit($perpage,$from);
								
				$this -> db -> join('postcategories pc', 'pc.PostID = p.PostID','INNER');
				$this -> db -> join('categories c', 'c.CategoryID = pc.CategoryID','LEFT');
				#$this -> db ->join('posttypes pt', 'pt.PostTypeID = p.PostTypeID','LEFT');
				#$this -> db ->join('productdetails prd', 'prd.PostID = p.PostID','LEFT');
				#$this -> db ->join('jobdetails jd', 'jd.PostID = p.PostID','LEFT');
				#$this -> db ->join('properties ps', 'ps.ProductID = p.PostID','LEFT');
				#$this -> db ->join('postdetails pd', 'pd.PostID = p.PostID','LEFT')->select('*,p.PostID as PostID');
				$data['model'] = $model = $this->db->get("posts p");
				
			}else{
				$data['nopagination'] = 1;
				$data['model'] = $allmodel;
			}
		}else{
			
			if(!array_key_exists('id', $params)){
				if(!array_key_exists('pagination', $params)){
					$data['nopagination'] = 1;
				}
				$query = "SELECT *, `p`.`PostID` as PostID FROM (`posts` p) 
							INNER JOIN `postcategories` pc ON `pc`.`PostID` = `p`.`PostID` 
							LEFT JOIN `categories` c ON `c`.`CategoryID` = `pc`.`CategoryID`
					WHERE 
							`p`.`PostTypeID` = ".$posttype." GROUP BY p.PostID ORDER BY p.PostedOn LIMIT ".$count;
			}else{
				$ids = explode(" ",$params['id']);
				$komaids = Komakan($ids);
				$query = "SELECT *, `p`.`PostID` as PostID FROM (`posts` p) 
								INNER JOIN `postcategories` pc ON `pc`.`PostID` = `p`.`PostID` 
								LEFT JOIN `categories` c ON `c`.`CategoryID` = `pc`.`CategoryID`
						WHERE 
								`p`.`PostTypeID` = ".$posttype." AND 
								`p`.`PostID` IN (".$komaids.") GROUP BY p.PostID ORDER BY FIELD(p.PostID, ".$komaids.") LIMIT ".$count;
				$data['nopagination'] = 1;
			}
			$data['model'] = $model = $this->db->query($query);
		}
		
		return $this->load->view($viewdata[$viewtype],$data,TRUE);
	}
}