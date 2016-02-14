<?php
/**
 * 
 */
class Menu extends CI_Controller {
	
	function __construct() {
		parent::__construct();
	}
	
	function index(){
		CheckLogin(TRUE);
		#$this->db->join('languages','languages.LanguageID = menus.LanguageID','left')->where('menus.LanguageID',AdminCurrentLang());
		
		#$gadgetid = $this->input->get('GadgetID');
	
		
		#if($gadgetid){
			
			#if($gadgetid == DEFAULTGADGETID){
			#	$data['r'] = $this->db->where("((GadgetID = '".$gadgetid."') OR (GadgetID IS NULL))")->get('menus');
			#}else{
				$data['r'] = $this->db->get('menus');
			#}
		#}else{
		#	$data['r'] = $this->db->where("((GadgetID = '".DEFAULTGADGETID."') OR (GadgetID IS NULL))")->get('menus');
		#}
		
		#$cek = $this->db->where('GadgetID',$gadgetid)->get('gadgets')->row();
		
		#if($gadgetid == null){
			$data['title'] = 'Data Menu Desktop';	
		#}else{
		#	$data['title'] = 'Data Menu ' .$cek->GadgetName ;
		#}
		$this->load->view('menu/data',$data);
	}
	
	function add(){
		CheckLogin();
		$this->load->view('menu/add');
	}
	
	function addmaster(){
		CheckLogin();
		$data['edit'] = FALSE;
		$data['title'] = "Menu Baru";
		$this->load->view('menu/base2',$data);
	}
	
	function edit($id){
		CheckLogin();
		$data['edit'] = TRUE;
		$data['title'] = "Ubah Menu";
		$this->db->order_by('OrderNo','asc');
		$this->db->where(array('ParentID'=>0,'MenuID'=>$id));
		$data['menus'] = $this->db->get('menudetails');
		$modela = $this->db->where(array('MenuID'=>$id))->get('menus');
		$data['model'] = $model = $modela->row();
		$this->load->view('menu/base2',$data);
	}
	
	function berita(){
		CheckLogin();
		$this->load->model('mpost');
		$data['r'] = $this->mpost->GetAll(array('p.PostTypeID'=>BERITANO));
		$this->load->view('menu/berita',$data);
	}
	
	function produk(){
		CheckLogin();
		$this->load->model('mpost');
		$data['r'] = $this->mpost->GetAll(array('p.PostTypeID'=>PRODUCTNO));
		$this->load->view('menu/produk',$data);
	}
	
	function halaman(){
		CheckLogin();
		$this->load->model('mpage');
		$data['r'] = $this->mpage->GetAll();
		$this->load->view('menu/page',$data);
	}
	
	function kategori(){
		CheckLogin();
		$this->load->model('mcategory');
		$data['r'] = $this->mcategory->GetAll();
		$this->load->view('menu/category',$data);
	}
	
	function save(){
		CheckLogin();
		$menus = $this->input->post('MenuName');
		$urls = $this->input->post('MenuURL');
		$ids = $this->input->post('MenuID');
		$parents = $this->input->post('ParentID');
		if(empty($menus)){
			#show_error('Menu tidak boleh kosong');
		}
		
		$this->db->empty_table('menus');
		
		for ($i=0; $i < count($menus); $i++) { 
			$data = array(
						'MenuID'=> $ids[$i],
						'MenuName' => $menus[$i],
						'URL' => $urls[$i],
						'OrderNo' => $i,
						'ParentID'=> $parents[$i]
			);
			$this->db->insert('menus',$data);
		}
		redirect(site_url('menu')."?success=1");
	}
	
	function save2($id){
		CheckLogin();
		$menus = $this->input->post('MenuName');
		$urls = $this->input->post('MenuURL');
		$ids = $this->input->post('MenuID');
		$lists = $this->input->post('list');
		$customsubmenus = $this->input->post('CustomSubMenu');
		if(empty($menus)){
			echo site_url('menu/edit/'.$id)."?success=1";
			return;
			#show_error('Menu tidak boleh kosong');
		}
		
		$datamaster = array(
						'MenuTitle'=>$this->input->post('MenuTitle'),
						'MenuSlug'=>url_title($this->input->post('MenuTitle')),
						'LanguageID'=>AdminCurrentLang(),
						'GadgetID'=>$this->input->post('GadgetID')
		);
		
		$this->db->update('menus',$datamaster,array('MenuID'=>$id));
		
		$this->db->delete('menudetails',array('MenuID'=>$id));
		
		for ($i=0; $i < count($menus); $i++) { 
			$data = array(
						'MenuID'=>$id,
						'JQueryID'=> $ids[$i],
						'MenuName' => $menus[$i],
						'URL' => $urls[$i],
						'OrderNo' => $i,
						'ParentID'=> $lists[$ids[$i]],
						'CustomSubMenu' => $customsubmenus[$i]
			);
			$this->db->insert('menudetails',$data);
		}
		#echo site_url('menu/edit/'.$id)."?success=1";
		redirect(site_url('menu/edit/'.$id)."?success=1");
	}

	function save3($id){
		CheckLogin();
		$menus = $this->input->post('menus');
		
		$this->load->model('mpost');
		
		if(empty($menus)){
			#echo site_url('menu/edit/'.$id)."?success=1";
			#return;
			#show_error('Menu tidak boleh kosong');
		}
		
		$datamaster = array(
						'MenuTitle'=>$this->input->post('MenuTitle'),
						'MenuSlug'=>url_title($this->input->post('MenuTitle')),
						'LanguageID'=>$this->input->post('LanguageID'),
						'GadgetID'=>$this->input->post('GadgetID')
		);
		
		$this->db->update('menus',$datamaster,array('MenuID'=>$id));
		
						
		$kali = 9999999;
		
		#$this->db->delete('menudetails',array('MenuID'=>$id*$kali));
		$updateoldmenus = $this->db->where('MenuID',$id)->update('menudetails',array('MenuID'=>$kali));
		#$this->db->delete('menudetails',array('MenuID'=>$id));
		$hapus = TRUE;
		if(!empty($menus)){
			for ($i=0; $i < count($menus); $i++) {
				$datamenus = $menus[$i];
				$datamenus = explode('^*',$datamenus);
				$blink = $datamenus[5] == "undefined" ? "" : $datamenus[5];
				$icon = $datamenus[6] == "undefined" ? "" : $datamenus[6];
				$linktype = $datamenus[7] == "undefined" ? 1 : $datamenus[7];
				$data = array(
							'MenuID'=>$id,
							'JQueryID'=> $datamenus[0],
							'MenuName' => $datamenus[2],
							'URL' => $datamenus[3],
							'OrderNo' => $i,
							'ParentID'=> $datamenus[1],
							'CustomSubMenu' => $datamenus[4],
							'IconID' => $icon,
							'MenuBlink' => $blink,
							'LinkTypeID' => $linktype
				);
				$insert = $this->db->insert('menudetails',$data);
				if(!$insert){
					$hapus = FALSE;
				}
			}
		}
		
		if($hapus){
			$this->db->delete('menudetails',array('MenuID'=>$kali));
			echo site_url('menu/edit/'.$id)."?success=1";
		}else{
			$this->db->delete('menudetails',array('MenuID'=>$id));
			$updateoldmenus = $this->db->where('MenuID',$kali)->update('menudetails',array('MenuID'=>$id));
			echo site_url('menu/edit/'.$id)."?success=2";
		}
		#redirect(site_url('menu/edit/'.$id)."?success=1");
	}
	
	function addedmaster(){
		CheckLogin();
        
		#$menus = $this->input->post('menus');
		
		// $urls = $this->input->post('MenuURL');
		// $ids = $this->input->post('MenuID');
		// $lists = $this->input->post('list');
		
		#if(empty($menus)){
			#return;
			#show_error('Menu tidak boleh kosong');
		#}
		
		$last = $this->lastid()+1;
		
		$datamaster = array(
						'MenuID'=>$last,
						'MenuTitle'=>$this->input->post('MenuTitle'),
						#'LanguageID'=>AdminCurrentLang(),
						'MenuSlug'=>url_title($this->input->post('MenuTitle')),
						'GadgetID'=>$this->input->post('GadgetID')
		);
        
        
		
		$this->db->insert('menus',$datamaster);
				
		// for ($i=0; $i < count($menus); $i++) {
			// $datamenus = $menus[$i];
			// $datamenus = explode('^*',$datamenus);
			// $linktype = $datamenus[7] == "undefined" ? 1 : $datamenus[7];
			// $data = array(
						// 'MenuID'=>$last,
						// 'JQueryID'=> $datamenus[0],
						// 'MenuName' => $datamenus[2],
						// 'URL' => $datamenus[3],
						// 'OrderNo' => $i,
						// 'ParentID'=> $datamenus[1],
						// 'CustomSubMenu' => $datamenus[4],
						// 'IconID' => $datamenus[6],
						// 'MenuBlink' => $datamenus[5],
						// 'LinkTypeID' => $linktype
			// );
			// $insert = $this->db->insert('menudetails',$data);
			// if(!$insert){
				// $hapus = FALSE;
			// }
		// }
		
		echo site_url('menu/edit/'.$last)."?success=1";
		#redirect(site_url('menu')."?success=1");
	}
	
	function lastid(){
		$this->db->limit(1);
		$this->db->order_by('MenuID','desc');
		$a = $this->db->get('menus')->row();
		if(empty($a)){
			return 0;
		}
		return $a->MenuID;
	}
	function delete(){
		$data = $this->input->post('cekbox');
		$deleted = 0;
		foreach ($data as $dat) {
			/*
			if($dat == MENUTOPID || $dat == MENUBOTTOMID || $dat == SUPERTOPMENUID){
				continue;
			}
			 * */
			if(!$this->db->delete('menus',array('MenuID'=>$dat))){
				continue;
			}
			if(!$this->db->delete('menudetails',array('MenuID'=>$dat))){
				continue;
			}
			$deleted++;
		}
		if($deleted == 0){
			ShowJsonError($deleted.' data sudah dihapus');
		}else{
			ShowJsonSuccess($deleted.' data sudah dihapus');
		}
	}
}