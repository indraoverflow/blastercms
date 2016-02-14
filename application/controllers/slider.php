<?php
/**
 * 
 */
class Slider extends CI_Controller {
	
	function __construct() {
		parent::__construct();
        $this -> load -> model('mslider');
	}
    
    function index(){
        CheckLogin();
        $data['title']  = 'Daftar Slider';
        $data['r']      = $this -> mslider -> getAll();
        
        $this -> load -> view('slider/data', $data);
    }
    
    function add(){
        CheckLogin();
        $data['edit']   = FALSE;
        $data['title']  = 'Slider Baru';
        
        $rules = array(
            array(
                'field' => 'SliderName',
                'label' => 'Slider Name',
                'rules' => 'required'
            ),
            array(
                'field' => 'MediaID',
                'label' => 'Media',
                'rules' => 'required'
            )
        );
        
        $this -> form_validation -> set_rules($rules);
        
        
        if($this -> form_validation -> run()){
            $lastid = $this -> mslider -> lastID()+1;
            
            $insert = array(
                'SliderID'          => $lastid,
                'SliderName'        => $this -> input -> post('SliderName'),
                'SliderText'        => $this -> input -> post('SliderText'),
                'MediaID'           => $this -> input -> post('MediaID'),
                'SliderLink'        => $this -> input -> post('SliderLink'),
                'SliderDirection'   => $this -> input -> post('SliderDirection'),
                'SliderDelay'       => $this -> input -> post('SliderDelay')
            );
            
            $this -> mslider -> insert($insert);
            
            redirect(site_url('slider/edit/'.$lastid).'?success=1');
            
        }else{
            $this -> load -> view('slider/form', $data);
        }
    }

    
    function edit($id){
        CheckLogin();
        $data['edit']   = TRUE;
        $data['title']  = 'Ubah Slider';
        $data['result'] = $this -> mslider -> getRow($id);
        
        $rules = array(
            array(
                'field' => 'SliderName',
                'label' => 'Slider Name',
                'rules' => 'required'
            ),
            array(
                'field' => 'MediaID',
                'label' => 'Media',
                'rules' => 'required'
            )
        );
        
        $this -> form_validation -> set_rules($rules);
        
        if($this -> form_validation -> run()){
            $update = array(
                'SliderName'        => $this -> input -> post('SliderName'),
                'SliderText'        => $this -> input -> post('SliderText'),
                'MediaID'           => $this -> input -> post('MediaID'),
                'SliderLink'        => $this -> input -> post('SliderLink'),
                'SliderDirection'   => $this -> input -> post('SliderDirection'),
                'SliderDelay'       => $this -> input -> post('SliderDelay')
            );
            
            $this -> mslider -> update($id, $update);
            
            redirect(site_url('slider/edit/'.$id).'?success=1');
            
        }else{
            $this -> load -> view('slider/form', $data);
        }
    }

    
    function delete(){
        CheckLogin();
        $cek = $this -> input -> post('cekbox');
        $del = 0;
        
        for ($i=0; $i < count($cek); $i++) { 
            $this -> mslider -> delete($cek[$i]);
            $del++;
        }
        
        if($del){
            ShowJsonSuccess($del. ' data sudah dihapus');
        }else{
            ShowJsonSuccess($del. ' data sudah di hapus');
        }
        
    }
    
    
    
}
