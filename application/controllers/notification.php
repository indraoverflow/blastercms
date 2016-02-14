<?php
/**
 * 
 */
class Notification extends CI_Controller {
	
	function __construct() {
		parent::__construct();
        $this -> load -> model('mnotification');
        $this -> load -> model('msetting');
	}
    
    function type($load){
        $data['type'] = $load;
        $data['rows'] = $this -> mnotification -> getAll(array('NotificationTypeID' => $load));
        
        if($_POST){
            $datas = $this->input->post('ids');
            foreach ($datas as $datum) {
                $data = array(
                    'Subject'=>$this->input->post($datum.'-Subject'),
                    'Content'=>$this->input->post($datum.'-Content'),
                    'SenderEmail'=>$this->input->post($datum.'-SenderEmail'),
                    'ToEmail'=>$this->input->post($datum.'-ToEmail'),
                    'SenderName'=>$this->input->post($datum.'-SenderName'),
                    'IsActive'=>$this->input->post($datum.'-IsActive')
                );
                $this -> mnotification -> update($datum, $data);
            }
            
            $create = $this->input->post('EmailWhenCreate');
            $update = $this->input->post('EmailWhenEdit');
            $delete = $this->input->post('EmailWhenDelete');
            
            SetSetting('EmailWhenCreate', $create);
            SetSetting('EmailWhenEdit', $update);
            SetSetting('EmailWhenDelete', $delete);
            
            redirect(current_url()."?success=1");
        }else{
            $this->load->view('notification/form',$data);
        }
    }    
}
