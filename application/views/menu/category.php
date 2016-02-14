<?php
$data = array();
$i = 0;
foreach ($r->result() as $d) {
	$data[$i] = array(
		'<input type="checkbox" name="cekbox[]" catid="'.$d->CategoryID.'" link="'.site_url('post/category/'.$d->CategorySlug).'" title="'.strip_tags($d->CategoryName).'" class="cekbox" /> '.anchor('category/edit/'.$d->CategoryID,$d->CategoryName),
		anchor('#','Pilih',array('catid'=>$d->CategoryID,'class'=>'pilihberita','link'=>site_url('post/category/'.$d->CategorySlug),'title'=>$d->CategoryName))
	);
	$i++;
}
$data = json_encode($data);
?>
<table id="dthalaman" cellpadding="0" cellspacing="0" border="0" class="display">
	
</table>
<div class="clear"></div>
<script type="text/javascript">
		var pelangganTable = $('#dthalaman').dataTable( {
	        "aaData": <?=$data?>,
	        "bJQueryUI": true,
	        "bSort" : false,
        	"sPaginationType": "full_numbers",
        	"iDisplayLength": 100,
    		"aLengthMenu": [[100, 1000, 5000, -1], [100, 1000, 5000, "Semua"]],
	        "aoColumns": [
	            {"sTitle": "<input type=\"checkbox\" id=\"cekbox\" class=\"\" /> Kategori"},
	            {"sTitle": "&nbsp;"}
	        ]
	    });
	    
	    $("input[aria-controls=dthalaman]").unbind().bind('keyup',function(e){
		    if (e.keyCode == 13) {
		        pelangganTable.fnFilter(this.value);
		    }
		});
</script>