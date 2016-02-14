<?php
/**
 * 
 */
class Role extends CI_Controller {
	
	function __construct() {
		parent::__construct();
        $this -> load -> model('mrole');
	}
    
    function index(){
        CheckLogin();
        $data['title']  = 'Daftar Role';
        $data['r']      = $this -> mrole -> getAll();
        
        $this -> load -> view('role/data', $data);
    }
    
    function add(){
        CheckLogin();
        $data['edit']   = FALSE;
        $data['title']  = 'Role Baru';
        
        $rules = array(
            array(
                'field' => 'RoleName',
                'label' => 'Role Name',
                'rules' => 'required'
            )
        );
        
        $this -> form_validation -> set_rules($rules);
        
        if($this -> form_validation -> run()){
            $last   = $this -> mrole -> lastID()+1;
            $insert = array(
                "RoleID"        => $last,
                'RoleName'      => $this -> input -> post('RoleName'),
                'IsAllCategory' => $this -> input -> post('IsAllCategory')
            );
            
            $this -> mrole -> insert($insert);
            
            redirect(site_url('role/edit/'.$last).'?success=1');
        }else{
            $this -> load -> view('role/form', $data);
        }
        
    }
    
    
    function edit($id){
        CheckLogin();
        $data['edit']       = TRUE;
        $data['title']      = 'Ubah Role';
        $data['result']     = $this -> mrole -> getRow($id);
        $data['modules']    = $this -> mrole -> getAllModule();
        $data['disallowedurls'] = $this->db->where('RoleID',$id)->get('roledisallowedurls');
        $data['disallowedcategories'] = $this->db->join('categories','categories.CategoryID=roledisallowedcategories.CategoryID')->where('RoleID',$id)->get('roledisallowedcategories');
        $data['blockedcategories'] = $this->db->join('categories','categories.CategoryID=roleblockedcategories.CategoryID')->where('RoleID',$id)->get('roleblockedcategories');
        $data['allowedpostcategories'] = $this->db->join('categories','categories.CategoryID=roleallowedpostcategories.CategoryID')->where('RoleID',$id)->get('roleallowedpostcategories');
        
        $rules = array(
            array(
                'field' => 'RoleName',
                'label' => 'Role Name',
                'rules' => 'required'
            )
        );
        
        $this -> form_validation -> set_rules($rules);
        
        if($this -> form_validation -> run()){
                
            $insert = array(
                'RoleName'      => $this -> input -> post('RoleName'),
                'IsAllCategory' => $this -> input -> post('IsAllCategory')
            );
            
            $this -> mrole -> update($id, $insert);
            
            
            $privileges = $this->input->post('modules');
            if(is_array($privileges)){
                $this -> mrole -> deleteAccess($id);
                foreach ($privileges as $privilege) {
                    $lastaccess = $this -> mrole -> getLastAccess()+1;
                    $dataprivilege = array(
                                    'RoleAccessID'  => $lastaccess,
                                    'RoleID'        => $id,
                                    'ModuleID'      => $privilege,
                                    'Insert'        => $this->input->post($privilege."-Buat"),
                                    'Update'        => $this->input->post($privilege."-Ubah"),
                                    'Delete'        => $this->input->post($privilege."-Hapus"),
                                    'View'          => $this->input->post($privilege."-Lihat")
                    );
                    $this -> mrole -> insertAccess($dataprivilege);
                }
            }
            
            $this->db->delete('roledisallowedurls',array('RoleID'=>$id));
            $this->db->delete('roledisallowedcategories',array('RoleID'=>$id));
            $this->db->delete('roleblockedcategories',array('RoleID'=>$id));
            $this->db->delete('roleallowedpostcategories',array('RoleID'=>$id));
            
            $disallowedurls = $this->input->post('Disallowed');
            
            if(is_array($disallowedurls)){
                $disallowedurls = array_unique($disallowedurls);
                foreach ($disallowedurls as $url) {
                    $data = array(
                        'RoleID' => $id,
                        'URL' => $url
                    );
                    $this->db->insert('roledisallowedurls',$data);
                }
            }
            
            $disallowedcategories = $this->input->post('DisallowedCategories');
            if(is_array($disallowedcategories)){
                $disallowedcategories = array_unique($disallowedcategories);
                foreach ($disallowedcategories as $category) {
                    $data = array(
                        'RoleID' => $id,
                        'CategoryID' => $category
                    );
                    $this->db->insert('roledisallowedcategories',$data);
                }
            }
            
            $blockedcategories = $this->input->post('BlockedCategories');
            if(is_array($blockedcategories)){
                $blockedcategories = array_unique($blockedcategories);
                foreach ($blockedcategories as $category) {
                    $data = array(
                        'RoleID' => $id,
                        'CategoryID' => $category
                    );
                    $this->db->insert('roleblockedcategories',$data);
                }
            }
            
            $allowedpostcategories = $this->input->post('AllowedPostCategories');
            #echo $allowedpostcategories;
            if(is_array($allowedpostcategories)){
                $allowedpostcategories = array_unique($allowedpostcategories);
                foreach ($allowedpostcategories as $category) {
                    $data = array(
                        'RoleID' => $id,
                        'CategoryID' => $category
                    );
                    $this->db->insert('roleallowedpostcategories',$data);
                }
            }
            
            
            
            redirect(site_url('role/edit/'.$id).'?success=1');
        }else{
            $this -> load -> view('role/form', $data);
        }
        
    }
    
    
    function delete(){
        CheckLogin();
        $cek = $this -> input -> post('cekbox');
        $del = 0;
        
        for ($i=0; $i < count($cek); $i++) { 
            $this -> mrole -> delete($cek[$i]);
            $del++;
        }
        
        if($del){
            ShowJsonSuccess($del. ' data sudah dihapus');
        }else{
            ShowJsonSuccess($del. ' data sudah dihapus');
        }
    }
    
    
    function addlink(){
        $this -> load -> view('role/addlink');
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
