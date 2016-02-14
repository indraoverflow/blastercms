<?php $this->load->view(ADMINHEADERVIEW) ?>

<link rel="stylesheet" href="<?=base_url()?>assets/colorpicker/css/colorpicker.css" type="text/css" />
<script type="text/javascript" src="<?=base_url()?>assets/colorpicker/js/colorpicker.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/colorpicker/js/eye.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/colorpicker/js/utils.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/colorpicker/js/layout.js?ver=1.0.2"></script>

<h2>Rotasi</h2>

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
<div class="col-md-3">
<h3>Rotasi Ke</h3>
<select class="form-control" name="RotationTo">
	<option value="270">Kanan</option>
	<option value="90">Kiri</option>
	<option value="180">180 Derajat</option>
</select>

<br />
<p>
    <input type="checkbox" checked="" name="KeepOldImage" value="1" id="Keepz" /> <label for="Keepz">Jaga Data Lama</label> 
</p>

<button class="ui btn btn-primary" type="submit"><b class="glyphicon glyphicon-save"></b> Simpan</button>

</div>
<?=form_close()?>

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
<div class="clearfix"></div>
</div>

<?php $this->load->view(ADMINFOOTERVIEW) ?>
