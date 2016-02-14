<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

class Widget extends CI_Model
{

    function __construct ()
    {
        parent::__construct();
		$this->load->model('mwidget');
    }

    public function run ($params = array())
    {
        $id = $params['id'];
		if(!array_key_exists('id', $params)){
			return "";
		}
		$a = GetWidget($id);
		return $a;
    }
}