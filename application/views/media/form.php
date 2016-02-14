<?php $this -> load -> view('admin/header'); ?>

<h2>Media Baru</h2>

<div style="background-color: #FFF;border-radius: 6px;box-shadow: 0 1px 2px rgba(0,0,0,0.3);padding: 8px 10px">

<?php if(validation_errors()){ ?>
	<div class="error alert alert-danger"><?=validation_errors()?></div>
<?php } ?>

<?php if($this->input->get('success') == 1){ ?>
<div class="success alert alert-success">
	Media sudah disimpan
</div>		
<?php }?>

<form enctype="multipart/form-data" action="<?=current_url()?>" method="post" id="validate">
	<table class="form table table-responsive table-striped">
		<tr>
			<td><label for="MerchandiseName">Nama Media</label></td>
			<td>
			<input autofocus="" required="" id="MerchandiseName" type="text" class="required posttitle form-control" name="MediaName" value="<?=$edit?$result->MediaName:set_value('MediaName')?>"  />
			</td>
		</tr>
		<tr>
			<td><label for="Description">Keterangan</label></td>
			<td><textarea class="form-control" id="Description"  name="Description"><?=$edit?$result->Description:set_value('Description')?></textarea></td>
		</tr>
		<?php if($edit){ ?>
		<?php if(FileExtension_Check($result->MediaPath, 'gambar')){ ?>
		<tr>
			<td><label for="DefaultImage">Gambar</label></td>
			<td>
			<img class="img-rounded img" height="150" src="<?=base_url()?>assets/images/media/<?=$result->MediaPath?>" />
			<br />
			<input style="width: 100%" type="file" name="userfile" /><br />
			<textarea readonly="" class="select form-control" ><?=base_url().'assets/images/media/'.$result->MediaPath?></textarea>
			</td>
		</tr>
		<?php } ?>
		<?php }else{ ?>
		<tr>
			<td><label for="DefaultImage">Gambar</label></td>
			<td>
			<input style="width: 100%" type="file" class="required" name="userfile" /><br />
			</td>
		</tr>
		<?php } ?>
		<tr>
		    <td colspan="1">&nbsp;</td>
			<td >
				<button class="ui btn btn-primary" type="submit"><b class="glyphicon glyphicon-save"></b> Simpan</button>
			</td>
		</tr>
	</table>
		<?php if($edit){ ?>
		<table class="meta ui-state-default" border="1">
			<tr>
				<td>
					Dibuat Oleh:
				</td>
				<td><?=$result->CreatedBy?></td>
			</tr>
			<tr>
				<td>
					Dibuat Pada:
				</td>
				<td><?=$result->CreatedOn?></td>
			</tr>
			<tr>
				<td>
					Diubah Oleh:
				</td>
				<td><?=$result->UpdateBy?></td>
			</tr>
			<tr>
				<td>
					Diubah Pada:
				</td>
				<td><?=$result->UpdateOn?></td>
			</tr>
		</table>
		<?php } ?>
		<br />
</form>


<script type="text/javascript">
	$(document).ready(function(){
		$('.select').on('click',function(){
			$(this).select();
		});
	});
</script>

</div>
<?php $this -> load -> view('admin/footer');?>