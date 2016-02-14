<?php
/**
 * 
 */
class SSearch extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	function run($params=array()){
		$ret = '<div class="searchform">'.
			form_open(site_url('service/info')).'
				<input class="form-control" type="text" name="noService" placeholder="No Service ..." />
				<button type="submit" class="btn btn-block btn-info btn-sm">
					<i class="fa fa-fw fa-search"></i> Search
				</button>
			'.form_close().'
			</div>';
		return $ret;
	}
}
