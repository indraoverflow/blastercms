<?php $this->load->view('admin/header') ?>

<h2><?php echo $title ?></h2>

<div style="background-color: #FFF;border-radius: 6px;box-shadow: 0 1px 2px rgba(0,0,0,0.3);padding: 8px 0px">
<div class="col-sm-9">

<?php if($this->input->get('success') == 1){ ?>
    <div class="success alert alert-success">
        Pengaturan sudah disimpan
    </div>
<?php } ?>

<?=form_open('setting/save')?>
<table border="0" class="table-striped" width="100%">
    <?php foreach ($r->result() as $d) { ?>

    <tr>
        <td width="25%"><label for="<?=$d->SettingName?>"><?=$d->SettingLabel?></label></td>
        <td><input required="" class="form-control required" type="text" name="<?=$d->SettingName?>" id="<?=$d->SettingName?>" value="<?=$d->SettingValue?>" /></td>
    </tr>
    <?php } ?>
    <tr>
        <td>&nbsp;</td>
        <td>
            <br />
            <button class="ui btn btn-primary" type="submit"><b class="glyphicon glyphicon-save"></b> Simpan</button>            
        </td>
    </tr>
</table>
<?=form_close()?>
<br />
<div class="col-sm-6 alert alert-info">
    <strong>Keterangan :</strong><br />
    Allow Share & Auto Approve :<br />
    <table>
        <tr>
            <td><strong>1</strong></td>
            <td>= <strong>Iya (YES)</strong></td>
        </tr>
        <tr>
            <td><strong>0</strong></td>
            <td>= <strong>Tidak (NO)</strong></td>
        </tr>
    </table>
</div>
<div class="clearfix"></div>
</div>
<div class="clearfix"></div>
</div>

<?php $this->load->view('admin/footer') ?>