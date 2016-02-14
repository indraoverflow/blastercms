<?php $this->load->view('header')?>

<h2>Ganti Password untuk <?=$email?></h2>

<?php
if(validation_errors()){
	?>
	<div class="error">
		<?=validation_errors()?>
	</div>
	<?php
}
?>

<?php
	if($this->input->get('success')){
		?>
		<div class="success">
			Password anda sudah diganti, <?=anchor('user/login','klik disini')?> untuk login.
		</div>
		<?php
	}else{
?>

<?=form_open(current_url()."?token=".$this->input->get('token'))?>
<div class="info" style="width: 250px">
<h3>Password</h3>
<input value="" style="width: 100%" type="password" class="" name="Password" /><br />
<h3>Ulangi Password</h3>
<input value="" style="width: 100%" type="password" class="" name="RPassword" /><br />
</div>
<button class="ui">Ganti</button>
<?=form_close()?>
	
	<?php
	}
	?>
	
<br />

<?php $this->load->view('footer')?>