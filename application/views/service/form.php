<?=$this->load->view('admin/header')?>

<h2><?=$title?></h2>
<?=form_open(current_url())?>
<div class="col-md-6">
    <label for="SidebarLeft"><label>No. Service</label></label>
    <input type="text" name="KodeService" class=" form-control" id="KodeService" value="<?=$edit?$result->KodeService:set_value('KodeService')?>" />
</div>
<div class="col-md-6">
    <label for="SidebarRight"><label>Nama Pelanggan</label></label>
    <input type="text" name="Nama" class=" form-control" id="Nama" value="<?=$edit?$result->Nama:set_value('Nama')?>" />
</div>

<div class="col-md-6">
    <label for="SidebarLeft"><label>Tanggal Terima</label></label>
    <input type="text" name="TanggalService" style="width: 80%; display:inline-block" class="datepicker  form-control" id="TanggalService" value="<?=$edit?$result->TanggalService:set_value('TanggalService')?>" />
</div>
<div class="col-md-6">
    <label for="SidebarRight"><label>HP</label></label>
    <input type="text" name="HP" class=" form-control" id="HP" value="<?=$edit?$result->HP:set_value('HP')?>" />
</div>

<div class="col-md-6">
    <label for="SidebarLeft"><label>Status Pengambilan</label></label>
    <br />
    <label style="display: block"><input <?= $edit ? $result->SudahDiambil ? 'checked=""' : '' : '' ?> type="checkbox" class="ambilcek" value="1" name="SudahDiambil" /> Sudah Diambil?</label>
    <div class="ambiltext">
    	<input type="text" name="TanggalAmbil" style="width: 80%; display:inline-block" class="datepicker  form-control " id="TanggalAmbil" value="<?=$edit?$result->TanggalAmbil:set_value('TanggalAmbil')?>" />
	</div>
</div>
<div class="col-md-6">
    <label for="SidebarRight"><label>Alamat</label></label>
    <textarea type="text" name="Alamat" class=" form-control" id="Alamat"><?=$edit?$result->Alamat:set_value('Alamat')?></textarea>
</div>
<div class="col-md-6">
    <label for="SidebarLeft"><label>Status Pembatalan</label></label>
    <br />
    <label style="display: block"><input <?= $edit ? $result->Dibatalkan ? 'checked=""' : '' : '' ?> type="checkbox" class="batalcek" value="1" name="Dibatalkan" /> Dibatalkan?</label>
    <div class="bataltext">
    	<input type="text" name="TanggalBatal" style="width: 80%; display:inline-block" class="datepicker  form-control " id="TanggalBatal" value="<?=$edit?$result->TanggalBatal:set_value('TanggalBatal')?>" />
	</div>
</div>
<div class="col-md-6">
    <label for="SidebarRight"><label>Status Service</label></label>
    <select name="StatusServiceID" class="form-control">
    	<option value="">Status Service</option>
    	<?= GetCombobox($status, 'StatusServiceID', 'StatusServiceName',$edit ? $result->StatusServiceID : '') ?>
    </select>
</div>


<div class="col-md-12">
<label>Nama Barang Servis</label>
<textarea class="form-control" name="BarangServis"><?=$edit?$result->BarangServis:set_value('BarangServis')?></textarea>
<label>Perlengkapan</label>
<textarea class="form-control" name="Perlengkapan"><?=$edit?$result->Perlengkapan:set_value('Perlengkapan')?></textarea>
<label>Kerusakan</label>
<textarea class="form-control" name="Kerusakan"><?=$edit?$result->Kerusakan:set_value('Kerusakan')?></textarea>
<label>Kondisi Barang</label>
<textarea class="form-control" name="KondisiBarang"><?=$edit?$result->KondisiBarang:set_value('KondisiBarang')?></textarea>
</div>
<div class="pull-right col-md-4">
	<label>Perkiraan Biaya Servis</label>
	<input type="text" class="form-control uang angka" name="EstimasiBiaya" value="<?=$edit?desimal($result->EstimasiBiaya):set_value('EstimasiBiaya')?>" />
	<label>Biaya Servis</label>
	<input type="text" class="form-control uang angka" name="Biaya" value="<?=$edit?desimal($result->Biaya):set_value('Biaya')?>" />
</div>
<div class="col-md-12">
	<button type="submit" class="btn btn-primary" name="Simpan">Simpan</button>
</div>
<div class="clearfix"></div>
<br /><br />
<?=form_close()?>
<script>
	$('.ambilcek').change(function(){
		if($(this).is(':checked')){
			$('.ambiltext').show();
		}else{
			$('.ambiltext').hide().val('');
		}
	});
	$('.batalcek').change(function(){
		if($(this).is(':checked')){
			$('.bataltext').show();
		}else{
			$('.bataltext').hide().val('');
		}
	});
	$(document).ready(function(){
		$('.batalcek,.ambilcek').trigger('change');
		
		$('.uang').live('focus',function(){
			$(this).val(toNum($(this).val()));
		}).live('blur',function(){
			$(this).val(desimal($(this).val()));
		});
	});
</script>
<?=$this -> load -> view('admin/footer') ?>