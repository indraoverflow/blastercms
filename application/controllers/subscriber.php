<?php
/**
 * 
 */
class Subscriber extends CI_Controller {
	
	function __construct() {
		parent::__construct();
        $this -> load -> model('msubscriber');
	}
    
    function index(){
        CheckLogin();
        $data['title']  = 'Daftar Subscriber';
        $data['r']      = $this -> msubscriber -> getAll();
        
        $this -> load -> view('subscriber/data', $data);
    }
    
    function add(){
        CheckLogin();
        $data['edit']   = FALSE;
        $data['title']  = 'Subscribe Baru';
        
        $rules = array(
            array(
                'field' => 'Email',
                'label' => 'Email',
                'rules' => 'required'
            )
        );
        
        $all = $this -> input -> post('IsAll');
        $this -> form_validation -> set_rules($rules);
        
        if($this -> form_validation -> run()){
            $last = $this -> msubscriber -> getLast()+1;
            
            $categoryid = $this -> input -> post('CategoryID');
            
            if(empty($categoryid)){
                $al = 1;
            }else{
                $al = 0;
            }
            
            $data = array(
                'SubscriberID'  => $last,
                'Email'         => $this -> input -> post('Email'),
                'IsAll'         => $all==1? 1:$al
            );
            
            $this -> msubscriber -> insert($data);
            
            if(empty($all)){
                #$categoryid = $this -> input -> post('CategoryID');    
                if(is_array($categoryid)){
                    $categoryid = array_unique($categoryid);
                    foreach ($categoryid as $cat) {
                        $datacat = array(
                            'SubscriberID' => $last,
                            'CategoryID' => $cat
                        );
                        $this -> msubscriber -> insertCat($datacat);
                    }
                }
            }
            
            
            redirect(site_url('subscriber/edit/'.$last).'?success=1');
        }else{
            $this -> load -> view('subscriber/form', $data);   
        }   
    }
    
    function edit($id){
        CheckLogin();
        $data['edit']       = TRUE;
        $data['title']      = 'Ubah Subscribe';
        $data['result']     = $this -> msubscriber -> getRow($id);
        $data['categories'] = $this -> db -> join('categories c','c.CategoryID = sc.CategoryID')
                                             -> where('sc.SubscriberID',$id)
                                                -> get('subscribercategories sc');
        
        $rules = array(
            array(
                'field' => 'Email',
                'label' => 'Email',
                'rules' => 'required'
            )
        );
        
        $all = $this -> input -> post('IsAll');
        
        $this -> form_validation -> set_rules($rules);
        
        if($this -> form_validation -> run()){
            $categoryid = $this -> input -> post('CategoryID');
            
            if(empty($categoryid)){
                $al = 1;
            }else{
                $al = 0;
            }
            
            $data = array(
                'Email'         => $this -> input -> post('Email'),
                'IsAll'         => $all==1 ? 1 : $al
            );
            
            $this -> msubscriber -> update($data, $id);

            
            if(empty($all)){
                
                        
                $this -> msubscriber -> deleteCat($id);
                
                if(is_array($categoryid)){
                    $categoryid = array_unique($categoryid);
                    foreach ($categoryid as $cat) {
                        $datacat = array(
                            'SubscriberID' => $id,
                            'CategoryID' => $cat
                        );
                        
                        $this -> msubscriber -> insertCat($datacat);
                    }
                }
            }
            
            redirect(site_url('subscriber/edit/'.$id).'?success=1');
        }else{
            $this -> load -> view('subscriber/form', $data);   
        }
    }
    
    function delete(){
        CheckLogin();
        $data = $this -> input -> post('cekbox');
        
        $del = 0;
        
        for($i=0; $i<count($data); $i++){
            $this -> msubscriber -> delete($data[$i]);
            $del++ ;
        } 
        
        if($del){
            ShowJsonSuccess($del." data sudah dihapus");
        }else{
            ShowJsonSuccess($del." data sudah dihapus");
        }
    }
    
}
