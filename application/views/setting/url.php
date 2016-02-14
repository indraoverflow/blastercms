<?php $this->load->view('admin/header'); ?>
<h2><?php echo $title ?></h2>

<div style="background-color: #FFF;border-radius: 6px;box-shadow: 0 1px 2px rgba(0,0,0,0.3)">
    <?=form_open(current_url(),array('class'=>'ajaxvalidate Confirm','confirm'=>'Apa anda yakin?'))?>
    
    <?php if(validation_errors()){ ?>
        <div class="error alert alert-danger">
            <?=validation_errors()?>
        </div>
    <?php } ?>
    
    <?php if($this->input->get('success')){ ?>
        <div class="success alert alert-success">
            <script type="text/javascript">
                alert('URL Admin berhasil diganti, silahkan login kembali dengan url yang baru.');
                location.href = '<?=site_url('admin/logout')?>';
            </script>
        </div>
    <?php } ?>
    
    <div class="info alert alert-info">
        Halaman login saat ini : <strong><?= site_url() ?>admin/<?=GetLoginURL()?>.html</strong>
    </div>
    
    <div class="alert alert-warning" style="padding: 0 11px">
    <?= site_url() ?>admin/<input id="Password" type="text" size="30" class="required" name="LoginURL" value="<?=GetLoginURL()?>"  />.html
    <br />
    
    
    <strong>
        <span style="color: red">Harap mengingat URL Login baru anda secara penuh atau anda tidak bisa login lagi ke halaman administrator.</span>
    </strong>
    
    <br /><br />
    
    <button type="submit" class="ui btn btn-primary"><b class="glyphicon glyphicon-save"></b> Simpan</button>
    <br /><br />
    </div>
    
    <?=form_close()?>
</div>

<?php $this->load->view('admin/footer'); ?>