<?php
/**
 * 
 */
class Footer extends CI_Controller {
	
	function __construct() {
		parent::__construct();
        $this -> load -> model('mfooter');
	}
    
    function index(){
        CheckLogin();
        $data['title']  =   'Daftar Kolom Footer';
        $data['r']      =   $this -> mfooter -> getAll();
        
        $this -> load -> view('footer/data', $data);
    }
    
    function add(){
        CheckLogin();
        $data['edit']   =   FALSE;
        $data['title']  =   'Kolom Footer Baru';
        
        $rules = array(
            array(
                'field' => 'FooterName',
                'label' => 'Footer Name',
                'rules' => 'required'
            )
        );
        
        $this -> form_validation -> set_rules($rules);
        
        if($this -> form_validation -> run()){
            $last       = $this -> mfooter -> getLAst()+1;
            $lastorder   = $this -> mfooter -> getLastOrder()+1;
            $data = array(
                'FooterID'      => $last,
                'FooterName'    => $this -> input -> post('FooterName'),
                'TotalColumn'   => $this -> input -> post('TotalColumn'),
                'Order'         => $lastorder,
                'IsShow'      => $this -> input -> post('IsShow')
            );
            $this -> mfooter -> insert($data);
            
            redirect(site_url('footer/edit/'.$last).'?success=1');
            
        }else{
            $this -> load -> view('footer/form', $data);    
        }
        
    }
    
    function edit($id){
        CheckLogin();
        
        $data['edit']       =   TRUE;
        $data['title']      =   'Ubah Kolom Footer';
        $data['result']     =   $result     = $this -> mfooter -> getRow($id);
        $data['rowdetails'] =   $details    = $this -> mfooter -> getRowDetail($id);
        
        $footers = array();
        for ($i=0; $i < $result -> TotalColumn; $i++){ 
            $footers[$i] = array(
                                'Data'  =>$this -> mfooter -> GetFooterDetail($i, $result -> FooterID),
                                'index' =>$i
            );
        }
        $data['footers'] = $footers;
        
        $rules = array(
            array(
                'field' => 'FooterName',
                'label' => 'Footer Name',
                'rules' => 'required'
            )
        );
        
        $this -> form_validation -> set_rules($rules);
        
        if($this -> form_validation -> run()){
            $data = array(
                'FooterName'    => $this -> input -> post('FooterName'),
                'TotalColumn'   => $this -> input -> post('TotalColumn'),
                #'Order'         => $this -> input -> post('Description'),
                'IsShow'      => $this -> input -> post('IsShow')
            );
            $this -> mfooter -> update($id,$data);
            
            redirect(site_url('footer/edit/'.$id).'?success=1');
            
        }else{
            $this -> load -> view('footer/form', $data);    
        }
        
    }

    function update($id){
        CheckLogin();
        
        $data = array(
                'FooterName'    => $this -> input -> post('FooterName'),
                'TotalColumn'   => $this -> input -> post('TotalColumn'),
                'IsShow'      => $this -> input -> post('IsShow')
        );
        $this -> mfooter -> update($id,$data);
        
        redirect(site_url('footer/edit/'.$id).'?success=1');    
        
    }
    
    function save($id){
        CheckLogin();
        $names = $this->input->post('SidebarName');
        $htmls = $this->input->post('SidebarHTML');
        // isleft ini adalah indexnya.
        $islefts = $this->input->post('IsLeft');
        
        $this -> mfooter -> deleteDetail($id);
        
        if(empty($names)){
            redirect(site_url('footerc/edit/'.$id)."?success=1");
        }
        
        for ($i=0; $i < count($names); $i++) {
            $lastdetail = $this -> mfooter -> getLastDetail()+1;
            $data = array(
                        'FooterDetailID'    => $lastdetail,
                        'FooterDetailName'  => $names[$i],
                        'FooterID'          => $id,
                        'HTMLFooter'        => $htmls[$i],
                        'Order'             => $i,
                        'Index'             => $islefts[$i]
            );
            $this -> mfooter -> insertDetail($data);
        }
        redirect(site_url('footer/edit/'.$id)."?success=1");
    }
    
    
    function delete(){
        CheckLogin();
        $cek = $this -> input -> post('cekbox');
        $del = 0;
        
        for ($i=0; $i < count($cek); $i++) { 
            $this -> mfooter -> delete($cek[$i]);
            $del++;
        }
        
        if($del){
            ShowJsonSuccess($del.' data berhasil dihapus');
        }else{
            ShowJsonSuccess($del. ' data berhasil dihapus');
        }
    }

    function show(){
        CheckLogin();
        $cek = $this -> input -> post('cekbox');
        $del = 0;
        
        for ($i=0; $i < count($cek); $i++) {
            $aktif = array('IsShow' => 1); 
            $this -> mfooter -> updateActive($cek[$i], $aktif);
            $del++;
        }
        
        if($del){
            ShowJsonSuccess($del.' data berhasil ditampilkan');
        }else{
            ShowJsonSuccess($del. ' data berhasil ditampilkan');
        }
    }
    
    function hide(){
        CheckLogin();
        $cek = $this -> input -> post('cekbox');
        $del = 0;
        
        for ($i=0; $i < count($cek); $i++) { 
            $aktif = array('IsShow' => 0); 
            $this -> mfooter -> updateActive($cek[$i], $aktif);
            $del++;
        }
        
        if($del){
            ShowJsonSuccess($del.' data berhasil disembunyikan');
        }else{
            ShowJsonSuccess($del. ' data berhasil disembunyikan');
        }
    }



}
