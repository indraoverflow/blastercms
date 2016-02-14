<?php $this->load->view('admin/header') ?>

<h2><?php echo $title?></h2>
<div style="background-color: #FFF;border-radius: 6px;box-shadow: 0 1px 2px rgba(0,0,0,0.3)">

<?php if($this -> input -> get('success')){ ?>
    <div class="success alert alert-success">Pengaturan email berhasil di simpan</div>
<?php }?>
<div style="padding: 8px 11px;">
<?=form_open(current_url(),array('id'=>'validate'))?>

<h3>Email Protocol</h3>
<input type="radio" id="mail" <?=EMAILPROTOCOL == "mail" ? 'checked=""' : ''?> name="EmailProtocol" value="mail" />
<label for="mail">Mail</label>
<input type="radio" id="smtp" <?=EMAILPROTOCOL == "smtp" ? 'checked=""' : ''?> name="EmailProtocol" value="smtp" />
<label for="smtp">SMTP</label>

<br /><br />

<fieldset>
    <legend>SMTP Setting</legend>
    <div class="notice alert alert-warning">
        Advanced Setting, please dont change if you don't know about SMTP.<br />
       (Pengaturan Lanjutan, jangan diubah jika anda tidak mengetahui tentang SMTP.)
    </div>
    <h3>SMTP Host</h3>
    <input class="form-control" type="text" name="SMTPHost" value="<?=SMTPHOST?>" />
    <h3>SMTP Port</h3>
    <input class="form-control" type="text" name="SMTPPort" value="<?=SMTPPORT?>" />
    <h3>Email</h3>
    <input class="form-control" type="text" name="SMTPEmail" value="<?=SMTPEMAIL?>" />
    <h3>Password</h3>
    <input class="form-control" type="password" name="SMTPPassword" value="<?=SMTPPASSWORD?>" />
</fieldset>
<br />
<button class="ui btn btn-primary" type="submit"><b class="glyphicon glyphicon-save"></b> Simpan</button>
<?=form_close()?>
</div>
</div>
<br />
<?php $this->load->view('admin/footer'); ?>