<?php
/**
 * 
 */
class MSetting extends CI_Model {
	private $table = "settings";
	function __construct() {
		parent::__construct();
	}
	
	function GetAll(){
		return $this->db->get($this->table);
	}
	
	function GetGeneral(){
		return $this->db->where('IsGeneral',1)->get($this->table);
	}
	
	function Get($settingname){
		$a = $this->db->where('SettingName',$settingname)->get($this->table)->row();
		if(empty($a)){
			return "";
		}else{
			return $a->SettingValue;
		}
	}
	
	function Set($settingname,$value){
		$this->db->where('SettingName',$settingname);
		$data = array('SettingValue'=>$value);
		$this->db->update($this->table,$data);
		return TRUE;
	}
}