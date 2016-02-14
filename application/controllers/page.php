<?php
/**
 * 
 */
class Page extends CI_Controller {
	
	function __construct() {
		parent::__construct();
        $this->load->model('mpage');
	}
    
    function index(){
        CheckLogin();
        $data['title'] = 'Daftar Halaman';
        
        $data['r'] = $this->mpage->GetAll();
        
        $this->load->view('page/data',$data);
    }
    
    function add(){
        CheckLogin();
        $data['edit'] = FALSE;
        $data['title'] = 'Halaman Baru';
        
        $rules = array(
            array(
                'field'=>'PageName',
                'label'=>'Nama Halaman',
                'rules'=>'required'
            )
        );
        
        $this->form_validation->set_rules($rules);
        
        if($this->form_validation->run()){
            $pageurl = ($this->input->post('PageURL')=="") ? url_title(strip_tags(strtolower($this->input->post('PageName')))) : strtolower($this->input->post('PageURL'));
            $pageurl = str_replace('.', '-', $pageurl);
            $last = $this->mpage->GetLast()+1;
            
            if($this->input->post('selectedEditor') == FORMBASICID){
                $html = $this->input->post('editorz');
            }else if($this->input->post('selectedEditor') == FORMSCRIPTID){
                $html = $this->input->post('HTML');
            }
            
            $insertdata = array(
                'PageID'            => $last,
                'PageName'          => $this->input->post('PageName'),
                'HTML'              => $html,
                'CSS'               => $this->input->post('CSS'),
                'Javascript'        => $this->input->post('Javascript'),
                'EditorType'        => $this->input->post('selectedEditor'),
                'ShowTitle'         => $this->input->post('ShowTitle'),
                'SEOKeyword'        => $this->input->post('SEOKeyword'),
                'SEODescription'    => $this->input->post('SEODescription'),
                'PageURL'           => $pageurl,
                'CreatedBy'         => GetAdminLogin('UserName'),
                'CreatedOn'         => date('Y-m-d H:i:s')
            );
            
            $this->mpage->insert($insertdata);
            
            redirect(site_url('page/edit/'.$last).'?success=1');
            
        }else{
            $this->load->view('page/form',$data);
        }
        
    }
       
       
    function edit($id){
        CheckLogin();
        $data['edit'] = TRUE;
        $data['title'] = 'Edit Halaman';
        
        $data['page'] = $this->mpage->GetRow($id);
        
        $rules = array(
            array(
                'field'=>'PageName',
                'label'=>'Nama Halaman',
                'rules'=>'required'
            )
        );
        
        $this->form_validation->set_rules($rules);
        
        if($this->form_validation->run()){
            $pageurl = ($this->input->post('PageURL')=="") ? url_title(strip_tags(strtolower($this->input->post('PageName')))) : strtolower($this->input->post('PageURL'));
            $pageurl = str_replace('.', '-', $pageurl);
            $last = $this->mpage->GetLast()+1;
            
            if($this->input->post('selectedEditor') == FORMBASICID){
                $html = $this->input->post('editorz');
            }else if($this->input->post('selectedEditor') == FORMSCRIPTID){
                $html = $this->input->post('HTML');
            }
            
            #echo $html;
            #return;
            
            $insertdata = array(
                'PageName'          => $this->input->post('PageName'),
                'HTML'              => $html,
                'CSS'               => $this->input->post('CSS'),
                'Javascript'        => $this->input->post('Javascript'),
                'EditorType'        => $this->input->post('selectedEditor'),
                'ShowTitle'         => $this->input->post('ShowTitle'),
                'SEOKeyword'        => $this->input->post('SEOKeyword'),
                'SEODescription'    => $this->input->post('SEODescription'),
                'PageURL'           => $pageurl,
                'UpdateBy'          => GetAdminLogin('UserName'),
                'UpdateOn'          => date('Y-m-d H:i:s')
            );
            
            $this->mpage->update($id, $insertdata);
            
            redirect(site_url('page/edit/'.$id).'?success=1');
            
        }else{
            $this->load->view('page/form',$data);
        }
        
    }
    
    function active($id){
        CheckLogin();
    }
    
    function delete(){
        CheckLogin();
        $cek = $this -> input -> post('cekbox');
        $delete = 0;
        
        for ($i=0; $i < count($cek); $i++) { 
            $this -> mpage -> delete($cek[$i]);
            $delete++;
        }
        
        if($delete){
            ShowJsonSuccess($delete. " data sudah dihapus");
        }else{
            ShowJsonSuccess($delete. " data sudah dihapus");
        }
    }
    
    
    function view($url){
        $this->load->library('shortcodes');
        $data['model'] = $model = $this->mpage->GetAll(array('PageURL'=>$url))->row();
        $data['title'] = $model->PageName;
        $data['description'] = $model->SEODescription;
        $data['keyword'] = $model->SEOKeyword;
        
        // if($model->PageTemplateID){
            // $temprow = $this->db->where('PageTemplateID',$model->PageTemplateID)->get('pagetemplates')->row();
//             
            // $this->load->model('mpost');
            // $this->load->helper('captcha');
//             
            // $data['model'] = $models = $this->mpost->GetByCats(explode(",",$model->Categories));
//             
            // //pagination
            // if($this->input->get('page')==""){
                // $page = 1;
            // }else{
                // $page = $this->input->get('page');
            // }
//             
            // $perpage = GetSetting('CategoryPerPage');
            // $allrow = $models->num_rows();
            // $from = ($page*$perpage) - $perpage;
            // $data['pagenum'] = ceil($allrow / $perpage);
            // $data['page'] = $page;
// 
            // $data['model'] = $models = $this->mpost->GetByCats(explode(",",$model->Categories),$perpage,$from);
            // $data['title'] = $model->FormName;
            // $this->load->view($temprow->PageFile,$data);
//             
        // }else{
            $this->load->view('base',$data);
        //}
    }
    function block(){
        $this->load->view('page/block');
    }
    
    
}
