<?php
/**
 * 
 */
class Category extends CI_Controller {
	
	function __construct() {
		parent::__construct();
        $this->load->model('mcategory');
	}
    
    function index(){
        $data['title'] = 'Daftar Kategori';
        $data['r'] = $this->mcategory->GetAll();
        
        $this->load->view('category/data', $data);
    }
    
    
    function add(){
        $data['edit'] = FALSE;
        $data['title'] = 'Kategori Baru';
        
        $rules = array(
            array(
                'field'=>'CategoryName',
                'label'=>'Judul',
                'rules'=>'required'
            )
        );
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules($rules);
        
        $parent = $this->input->post('ParentID');
        
        if($this->form_validation->run()){
            $slug = str_replace(array('.',' '), '-', url_title(strip_tags(strtolower($this->input->post('CategoryName')))));
            
            $last = $this->mcategory->GetLast()+1;
            $insertdata = array(
                'CategoryID'    =>$last,
                'CategoryName'  =>$this->input->post('CategoryName'),
                'ParentID'      =>!empty($parent)?$parent:NULL,
                'CategorySlug'  =>$slug,
                'ViewTypeID'   =>$this->input->post('ViewTypeID'),
                'SidebarLeft'   =>$this->input->post('SidebarLeft'),
                'SidebarRight'  =>$this->input->post('SidebarRight'),
                'SEOKeyword'    =>$this->input->post('SEOKeyword'),
                'SEODescription'=>$this->input->post('SEODescription')
            );
            
            $this->mcategory->insert($insertdata);
            
            redirect(site_url('category/edit/'.$last).'?success=1');
        }else{
            $this->load->view('category/form',$data);
        }
    }
    
    function edit($id){
        $data['result'] = $this->mcategory->GetRow($id);
        $data['edit'] = TRUE;
        $data['title'] = 'Ubah Kategori';
        
        $rules = array(
            array(
                'field'=>'CategoryName',
                'label'=>'Judul',
                'rules'=>'required'
            )
        );
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules($rules);
        
        $parent = $this->input->post('ParentID');
        
        if($this->form_validation->run()){
            $slug = str_replace(array('.',' '), '-', strtolower($this->input->post('CategorySlug')));
            $insertdata = array(
                'CategoryName'  =>$this->input->post('CategoryName'),
                'ParentID'      =>!empty($parent)?$parent:NULL,
                'CategorySlug'  =>$slug,
                'ViewTypeID'   =>$this->input->post('ViewTypeID'),
                'SidebarLeft'   =>$this->input->post('SidebarLeft'),
                'SidebarRight'  =>$this->input->post('SidebarRight'),
                'SEOKeyword'    =>$this->input->post('SEOKeyword'),
                'SEODescription'=>$this->input->post('SEODescription')
            );
            
            $this->mcategory->update($insertdata, $id);
            
            redirect(site_url('category/edit/'.$id).'?success=1');
        }else{
            $this->load->view('category/form', $data);
        }
    }
    
    
     function delete(){
        CheckLogin();
        $data = $this -> input -> post('cekbox');
        
        $del = 0;
        
        for($i=0; $i<count($data); $i++){
            $this -> mcategory -> delete($data[$i]);
            $del++ ;
        } 
        
        if($del){
            ShowJsonSuccess($del." data sudah dihapus");
        }else{
            ShowJsonSuccess($del." data sudah dihapus");
        }
    }
    
    
}
