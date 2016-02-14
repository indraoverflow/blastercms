<?php
$data = array();
$i = 0;
foreach ($r->result() as $d) {
	if(FileExtension_Check($d->MediaPath, 'gambar')){
		$data[$i] = array(
					'<input type="checkbox" class="cekbox" name="cekbox[]" value="'.$d->MediaID.'" /> <input type="hidden" name="medias[]" value="'.$d->MediaID.'" />',
					(empty($d->MediaPath)) ? '-' : '<img class="img-thumbnail" height="100" width="100" src="'.base_url().'assets/images/timthumb.php?src='.base_url().'assets/images/media/'.$d->MediaPath.'&w=100&h=100&q=20" /> '.anchor('media/crop/'.$d->MediaID,'Crop',array('class'=>'ui btn btn-info')),
					anchor('media/edit/'.$d->MediaID,$d->MediaName).'<br /><textarea class="select form-control" readonly="">'.base_url().'assets/images/media/'.$d->MediaPath.'</textarea>'
				);
	}else{
		$data[$i] = array(
					'<input type="checkbox" class="cekbox" name="cekbox[]" value="'.$d->MediaID.'" /> <input type="hidden" name="medias[]" value="'.$d->MediaID.'" />',
					'<h2>'.FileExtension($d->MediaPath).'</h2>',
					anchor('media/edit/'.$d->MediaID,$d->MediaName).'<br /><textarea class="select form-control" readonly="" >'.base_url().'assets/images/media/'.$d->MediaPath.'</textarea>'
				);
	}
	$i++;
}
$data = json_encode($data);
?>
<?php $this->load->view('admin/header') ?>

<h2>Data Media</h2>


<div style="background-color: #EEEEEE;border-radius: 6px;box-shadow: 0 1px 2px rgba(0,0,0,0.3);padding: 15px 10px">



<p>
	<?=anchor('media/delete','<b class="glyphicon glyphicon-trash"></b> Hapus',array('class'=>'cekboxaction ui btn btn-warning','confirm'=>'Apa anda yakin?'))?>
	<?=anchor('media/watermark','Watermark',array('class'=>'watermark ui btn btn-info','confirm'=>'Apa anda yakin?'))?>
	<?=anchor('media/rotation','Rotasi',array('class'=>'rotasi ui btn btn-info','confirm'=>'Apa anda yakin?'))?>
</p>
<?php
	if(GetAdminLogin('UserName')){
?>
<form id="dataform" method="post" action="#">
<table id="datamedia" cellpadding="0" cellspacing="0"  class="display">
	
</table>
</form>
<?php }else{ ?>
<div class="error">Tidak diizinkan</div>
<?php } ?>

<div class="clear"></div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('.select').on('click',function(){
			$(this).select();
		});
	});
		var basewm = '<?=site_url('media/watermark')?>';
		var baser = '<?=site_url('media/rotasi')?>';
		
		$('.watermark').click(function(){
			if($('.cekbox:checked').length){
				var ser = $('#dataform').serialize();
				var ids = "";
				var i = 0;
				$('.cekbox:checked').each(function(){
					i++;
					if(i > 1){
						ids = ids+","+$(this).val();
					}else{
						ids = ids+$(this).val();
					}
				});
				location.href = basewm+'?ids='+ids;
			}else{
				alert('Tak ada yg terpilih');
			}
			return false;
		});
		$('.rotasi').click(function(){
			if($('.cekbox:checked').length){
				var ser = $('#dataform').serialize();
				var ids = "";
				var i = 0;
				$('.cekbox:checked').each(function(){
					i++;
					if(i > 1){
						ids = ids+","+$(this).val();
					}else{
						ids = ids+$(this).val();
					}
				});
				location.href = baser+'?ids='+ids;
			}else{
				alert('Tak ada yg terpilih');
			}
			return false;
		});
		
		var pelangganTable = $('#datamedia').dataTable( {
	        "aaData": <?=$data?>,
	        "bJQueryUI": true,
	        "bSort" : true,
        	"sPaginationType": "full_numbers",
        	"iDisplayLength": 100,
    		"aLengthMenu": [[100, 1000, 5000, -1], [100, 1000, 5000, "Semua"]],
	        "aoColumns": [
	        	{"sTitle": "<input type=\"checkbox\" id=\"cekbox\" class=\"cekbox\" />","sWidth":15,bSortable:false},
	            {"sTitle": "Gambar"},
	            {"sTitle": "Nama / Lokasi"}
	        ]
	    });
	    $("input[aria-controls=datamedia]").unbind().bind('keyup',function(e){
		    if (e.keyCode == 13) {
		        pelangganTable.fnFilter(this.value);
			}
		});
</script>

<?php $this->load->view('admin/footer') ?>