<?php
$gadgetid = $this->input->get('GadgetID');
$data = array();
$i = 0;
foreach ($r->result() as $d) {
	    
	if($d->MenuID == GetSetting("MainMenuID")){
        $setmain = "Aktifkan | ".anchor('setting/unsetmainmenu/'.$d->MenuID,'Non-aktif');
    }else{
        $setmain = anchor('setting/setmainmenu/'.$d->MenuID,'Aktifkan')." | Non-aktif";
    }
    
	if($d->MenuID == GetSetting("TopMenuID")){
		$settop = "Aktifkan | ".anchor('setting/unsettopmenu/'.$d->MenuID,'Non-aktif');
	}else{
		$settop = anchor('setting/settopmenu/'.$d->MenuID,'Aktifkan')." | Non-aktif";
	}
	
	if($d->MenuID == GetSetting("FooterMenuID")){
		$setfooter = "Aktifkan | ".anchor('setting/unsetfootermenu/'.$d->MenuID,'Non-aktif');
		
	}else{
		$setfooter = anchor('setting/setfootermenu/'.$d->MenuID,'Aktifkan')." | Non-aktif";
	}
	
	$data[$i] = array(
					'<input type="checkbox" class="cekbox" name="cekbox[]" value="'.$d->MenuID.'" />',
					$d->MenuID,
					anchor('menu/edit/'.$d->MenuID,$d->MenuTitle),
					$setmain,
					$settop,
					$setfooter
				);
	$i++;
}
$data = json_encode($data);
?>
<?php $this->load->view('admin/header') ?>

<!-- <h2>Data Menu</h2> -->
<h2><?=$title ?></h2>

<div style="background-color: #FFF;border-radius: 6px;box-shadow: 0 1px 2px rgba(0,0,0,0.3);padding: 15px 10px">
<p>
	<?=anchor('menu/delete','<b class="glyphicon glyphicon-trash"></b> Hapus',array('class'=>'cekboxaction ui btn btn-warning','confirm'=>'Apa anda yakin?'))?>
</p>
<form id="dataform" method="post" action="#">
<table id="datamenu" cellpadding="0" cellspacing="0" border="0" class="display">
	
</table>
</form>
</div>
<div class="clear"></div>
<script type="text/javascript">
		var pelangganTable = $('#datamenu').dataTable( {
	        "aaData": <?=$data?>,
	        "bJQueryUI": true,
	        "aaSorting" : [[1,'desc']],
        	"sPaginationType": "full_numbers",
        	"iDisplayLength": 100,
    		"aLengthMenu": [[100, 1000, 5000, -1], [100, 1000, 5000, "Semua"]],
	        "aoColumns": [
	        	{"sTitle": "<input type=\"checkbox\" id=\"cekbox\" class=\"cekbox\" />","sWidth":15,bSortable:false},
	            {"sTitle": "ID"},
	            {"sTitle": "Menu"},
	            {"sTitle": "Main menu"},
	            {"sTitle": "Top menu"},
	            {"sTitle": "Footer menu"}
	        ]
	    });
	    $("input[aria-controls=datamenu]").unbind().bind('keyup',function(e){
		    if (e.keyCode == 13) {
		        pelangganTable.fnFilter(this.value);
		    }
		});
</script>

<?php $this->load->view('admin/footer') ?>