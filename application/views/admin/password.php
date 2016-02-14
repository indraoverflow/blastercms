<?=$this->load->view('admin/header')?>
<h2><?=$title?></h2>

<div style="background-color: #FFF;border-radius: 6px;box-shadow: 0 1px 2px rgba(0,0,0,0.3)">

<?php if(validation_errors()){?>
    <div class="error  alert alert-danger">
        <?=validation_errors('')?>
    </div>    
<?php }?>

<?php if($this->input->get('oldpassword')=='false'){ ?>
    <div class="error alert alert-danger">
        Password lama tidak tepat
    </div>
<?php } ?>

<?php if($this->input->get('newpassword')=='false'){ ?>
    <div class="error alert alert-danger">
        Password baru tidak sama
    </div>
<?php } ?>

<?php if($this->input->get('success')){ ?>
    <div class="success alert alert-success">
        <script type="text/javascript">
            alert('Password berhasil diganti, silahkan login kembali.');
            location.href = '<?=site_url('admin/logout')?>';
        </script>
    </div>
<?php } ?>

<div style="padding: 15px 10px">

<?=form_open(current_url(),array('id'=>'validate', 'class'=>'ajaxvalidate Confirm','confirm'=>'Apa anda yakin?'))?>

<table border="0">
    <tr>
        <td><label for="OldPassword">Password Lama</label></td>
        <td>
        <input required autofocus class="form-control" id="OldPassword" type="text" size="30" class="required" name="OldPassword" value="<?php set_value('Password'); ?>"  />
        </td>
    </tr>
    
    <tr>
        <td><label for="Password">Password Baru</label></td>
        <td>
        <input required class="form-control" id="Password" type="password" size="30" minlength="6" class="required" name="Password" value="<?php set_value('Password'); ?>"  />
        </td>
    </tr>
    
    <tr>
        <td><label for="RPassword">Ulangi Password</label></td>
        <td>
        <input required class="form-control" id="RPassword" type="password" size="30" minlength="6" class="required" name="RPassword" value="<?php set_value('Password'); ?>"  />
        </td>
    </tr>
    
</table>


<div class="clear"></div>
<br />
<button type="submit" class="ui btn btn-primary"><b class="glyphicon glyphicon-save"></b> Simpan</button>

<?=form_close()?>
</div>
</div>

<?=$this->load->view('admin/footer')?>