<?php $this->load->view(ADMINHEADERVIEW) ?>
<link rel="stylesheet" href="<?=base_url()?>assets/colorpicker/css/colorpicker.css" type="text/css" />
<script type="text/javascript" src="<?=base_url()?>assets/colorpicker/js/colorpicker.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/colorpicker/js/eye.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/colorpicker/js/utils.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/colorpicker/js/layout.js?ver=1.0.2"></script>

<h2>Watermark</h2>

<div style="background-color: #FFF;border-radius: 6px;box-shadow: 0 1px 2px rgba(0,0,0,0.3);padding: 8px 10px">

<?php
	if(validation_errors()){
		?>
		<div class="error alert alert-danger">
			<?=validation_errors()?>
		</div>
		<?php
	}
?>

<?=$images?>
<?=form_open(current_url()."?ids=".$this->input->get('ids'))?>

<div class="col-md-5">
<br />    
<h4>Text Watermark</h4>
<input autofocus="" required="" type="text" class="required form-control" name="WatermarkText" />

<h4>Jenis Font</h4>
<select class="form-control" name="WatermarkFont">
	<?php
		foreach ($fonts as $font) {
			?>
			<option value="<?=$font?>" style="font-family: <?=FontName($font)?>; font-size: 16px;"><?=FontName($font)?></option>
			<?php
		}
	?>
</select>
<h4>Ukuran Font</h4>
<input class="form-control" type="text" name="WatermarkSize" value="18">

<h4>Warna Text</h4>
<input class="form-control" type="text" class="" id="colorPickerBackground" name="WatermarkColor" />

<h4>Posisi Vertikal</h4>
<select class="form-control" name="VerticalPosition">
	<option value="top">Atas</option>
	<option value="bottom">Bawah</option>
	<option value="middle">Pertengahan</option>
</select>

<h4>Posisi Horizontal</h4>
<select class="form-control" name="HorizontalPosition">
	<option value="left">Kiri</option>
	<option value="right">Kanan</option>
	<option value="center">Tengah</option>
</select>
<br />
<p>
    <input type="checkbox" checked="" name="KeepOldImage" value="1" id="Keepz" /> <label for="Keepz">Jaga Data Lama</label> 
</p>
<p>
    <button class="ui btn btn-primary"><b class="glyphicon glyphicon-save"></b> Simpan</button>
</p>
</div>
<?=form_close()?>
<div class="clearfix"></div>
</div>

<script>
	$(function() {
        $( "#slider" ).slider({
            value:50,
            min: 0,
            max: 100,
            step: 10,
            slide: function( event, ui ) {
                $( ".transparancy" ).val(ui.value);
            }
        });
        $(".transparancy").val($( "#slider" ).slider( "value" ));
        
        $('#colorPickerBackground').ColorPicker({
			onSubmit: function(hsb, hex, rgb, el) {
				$(el).val(hex);
				$(el).css('background','#'+hex);
				$(el).ColorPickerHide();
			},
			onBeforeShow: function () {
				$(this).ColorPickerSetColor(this.value);
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});
    });
</script>

<?php $this->load->view(ADMINFOOTERVIEW) ?>
