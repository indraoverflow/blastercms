<?php
$data = array();
$i = 0;
foreach ($r->result() as $d) {
	$data[$i] = array(
					anchor('post/edit/'.$d->PostID,$d->PostTitle),
					$d->CategoryName,
					$d->PostDate,
					anchor('#','Pilih',array('class'=>'pilihberita','link'=>site_url('post/berita/'.$d->PostSlug),'title'=>$d->PostTitle))
				);
	$i++;
}
$data = json_encode($data);
?>
<table id="dtberita" cellpadding="0" cellspacing="0" border="0" class="display">
	
</table>
<div class="clear"></div>
<script type="text/javascript">
		var pelangganTable = $('#dtberita').dataTable( {
	        "aaData": <?=$data?>,
	        "bJQueryUI": true,
	        "bSort" : false,
        	"sPaginationType": "full_numbers",
        	"iDisplayLength": 100,
    		"aLengthMenu": [[100, 1000, 5000, -1], [100, 1000, 5000, "Semua"]],
	        "aoColumns": [
	            {"sTitle": "Judul"},
	            {"sTitle": "Kategori"},
	            {"sTitle": "Tgl"},
	            {"sTitle": "&nbsp;"}
	        ]
	    });
	    
	    $("input[aria-controls=dtberita]").unbind().bind('keyup',function(e){
		    if (e.keyCode == 13) {
		        pelangganTable.fnFilter(this.value);
		    }
		});
</script>