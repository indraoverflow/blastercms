<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends CI_Model
{

    function __construct ()
    {
        parent::__construct();
    }

    public function run ($params = array())
    {
        $id = $params['id'];
		$a = PrintCustomMenu($id);
		return $a;
    }
}