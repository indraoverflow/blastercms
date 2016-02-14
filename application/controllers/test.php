<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('html','url')); 
	}
	
	public function index()
	{
		$this->load->view('test');
	}
	
	public function upload()
	{
		if(isset($_FILES['image']))
		{
			$config['upload_path'] = './assets/uploads';
			$config['allowed_types'] = 'gif|jpg|png|bmp';
			$this->load->library('upload', $config);
			if($this->upload->do_upload('image'))
			{
				$image_data = $this->upload->data();
				
				echo img(array(
					'src'=>base_url("assets/uploads/$image_data[file_name]"),
					'width'=>600,
					'style'=>'margin-top:10px; padding:10px; background:#bbb'
				)); 
			}
		}	
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */