<?php
$data = array();
$i = 0;
foreach ($r->result() as $d) {
	$data[$i] = array(
					'<input type="checkbox" name="cekbox[]" link="'.site_url('halaman/form/'.$d->URL).'" title="'.strip_tags($d->FormName).'" class="cekbox" /> '.anchor('form/edit/'.$d->FormID,$d->FormName),
					anchor('#','Pilih',array('class'=>'pilihberita','link'=>site_url('halaman/form/'.$d->URL),'title'=>$d->FormName))
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
	            {"sTitle": "<input type=\"checkbox\" id=\"cekbox\" class=\"\" /> Halaman"},
	            {"sTitle": "&nbsp;"}
	        ]
	    });
	    
	    $("input[aria-controls=dthalaman]").unbind().bind('keyup',function(e){
		    if (e.keyCode == 13) {
		        pelangganTable.fnFilter(this.value);
		    }
		});
</script>