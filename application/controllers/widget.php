<?php
/**
 * 
 */
class Widget extends CI_Controller {
	
	function __construct() {
		parent::__construct();
        $this -> load -> model('mwidget');
	}
    
    function index(){
        CheckLogin();
        $data['title']  =   'Daftar Widget';
        $data['r']      =   $this -> mwidget -> getAll();
        
        $this -> load -> view('widget/data', $data);
    }
    
    function add(){
        CheckLogin();
        $data['edit']   =   FALSE;
        $data['title']  =   'Widget Baru';
        
        $rules = array(
            array(
                'field' => 'WidgetName',
                'label' => 'Widget Name',
                'rules' => 'required'
            )
        );
        
        $this -> form_validation -> set_rules($rules);
        
        if($this -> form_validation -> run()){
            $last = $this -> mwidget -> getLast()+1;
            
            $data = array(
                    'WidgetID'      => $last,
                    'WidgetName'    => $this -> input -> post('WidgetName'),
                    'Description'   => $this -> input -> post('Description')
            );
            $this -> mwidget -> insert($data);
            
            redirect(site_url('widget/edit/'.$last).'?success=1');
            
        }else{
            $this -> load -> view('widget/form', $data);    
        }
        
    }
    
    function edit($id){
        CheckLogin();
        $data['edit']       =   TRUE;
        $data['title']      =   'Ubah Widget';
        $data['result']     =   $this -> mwidget -> getRow($id);
        $data['details']    =   $this -> mwidget -> getAllDetail(array('WidgetID'=>$id));
        
        $rules = array(
            array(
                'field' => 'WidgetName',
                'label' => 'Widget Name',
                'rules' => 'required'
            ) 
        );
        
        $this -> load -> library('form_validation');
        
        $this -> form_validation -> set_rules($rules);
        if($this -> form_validation -> run()){
            $sidebars = $this->input->post('Sidebar');      
            $data = array(
                    'WidgetName'    => $this -> input -> post('WidgetName'),
                    'Description'   => $this -> input -> post('Description')
            );
            $this -> mwidget -> update($id, $data);
            
            $widgetdetailname = $this -> input -> post('SidebarName');
            $widgetdetailhtml = $this -> input -> post('SidebarHTML');
            
            $this -> mwidget -> deleteDetail($id);
            
            if(empty($widgetdetailname)){
                redirect(site_url('widget/edit/'.$id).'?success=1');
            }
            
            for ($i=0; $i < count($widgetdetailname); $i++) {
                $lastDetail = $this -> mwidget -> getLastDetail()+1; 
                $detail = array(
                            'WidgetDetailID'    => $lastDetail,
                            'WidgetID'          => $id,
                            'WidgetDetailName'   => $widgetdetailname[$i],
                            'WidgetDetailHTML'  => $widgetdetailhtml[$i],
                            'Order'             => $i 
                );
                $this -> mwidget -> insertDetail($detail);
            }
            
            
            redirect(site_url('widget/edit/'.$id).'?success=1');
            
        }else{
            $this -> load -> view('widget/form', $data);    
        }
        
    }
    
    function delete(){
        CheckLogin();
        $cek = $this -> input -> post('cekbox');
        $del = 0;
        
        for ($i=0; $i < count($cek); $i++) { 
            $this -> mwidget -> delete($cek[$i]);
            $del++; 
        }
        
        if($del){
            ShowJsonSuccess($del. ' data berasil di hapus');
        }else{
            ShowJsonSuccess($del. ' data berhasil di hapus');
        }
        
    }
    
}
