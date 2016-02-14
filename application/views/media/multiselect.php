
<?php #$this->load->view('admin/header') ?>

<p style="float: right">
	<input type="text" id="FilterMedia" name="FilterMedia" />
	<button type="button" id="xFind">Cari</button>
</p>
<div class="clear"></div>
<ul class="mediacontainer">
<?php
$sasa = 0;
foreach ($r->result() as $d) {
	if(!FileExtension_Check($d->MediaPath, 'gambar')){
		continue;
	}
	$sasa++;
	?>
	<li keyword="<?=$d->MediaPath?> <?=$d->MediaName?>">
	<?php
		echo (empty($d->MediaPath)) ? '-' : '<img height="100" width="100" src="'.base_url().'assets/images/timthumb.php?src='.base_url().'assets/images/media/'.$d->MediaPath.'&w=100&h=100&q=20" />'."<input id='cec-".$sasa."' type='checkbox' mediaid='".$d->MediaID."' title='".$d->MediaName."' src='".$d->MediaPath."' class='selectit' /> <label for='cec-".$sasa."'>Pilih</label>";
	?>
	</li>
	<?php
}
?>
</ul>

<script type="text/javascript">
	$('#FilterMedia').keypress(function(e){
		if(e.which == 13){
			if($('#FilterMedia').val()==""){
				$('.mediacontainer li').show();
				return false;
			}
			$('.mediacontainer li').hide();
			$('.mediacontainer').find('li[keyword*='+$('#FilterMedia').val()+']').fadeIn(500);
		}
	});
	$('#xFind').click(function(){
		if($('#FilterMedia').val()==""){
			return false;
		}
		
		$('.mediacontainer li').hide();
		$('.mediacontainer').find('li[keyword*='+$('#FilterMedia').val()+']').fadeIn(500);
	});
</script>

<?php #$this->load->view('admin/footer') ?>