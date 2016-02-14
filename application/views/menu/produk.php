<?php
$data = array();
$i = 0;
foreach ($r->result() as $d) {
	$categories = "";
	$a=0;
	foreach ($this->mpost->GetCategories($d->PostID)->result() as $cat) {
		if($a > 0){
			$categories .= ", ";
		}
		$categories .= $cat->CategoryName;
		$a++;
	}
	
	$data[$i] = array(
					anchor('produk/edit/'.$d->PostID,strip_tags($d->PostTitle)),
					$categories,
					$d->PostDate,
					anchor('#','Pilih',array('class'=>'pilihberita','link'=>site_url('post/produk/'.$d->PostSlug),'title'=>strip_tags($d->PostTitle)))
				);
	$i++;
}
$data = json_encode($data);
?>
<table id="dtproduk" cellpadding="0" cellspacing="0" border="0" class="display">
	
</table>
<div class="clear"></div>
<script type="text/javascript">
		var pelangganTable = $('#dtproduk').dataTable( {
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
	    
	    $("input[aria-controls=dtproduk]").unbind().bind('keyup',function(e){
		    if (e.keyCode == 13) {
		        pelangganTable.fnFilter(this.value);
		    }
		});
</script>