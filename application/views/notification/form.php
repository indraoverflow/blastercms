<?php $this->load->view('admin/header')?>

<h2>Notifikasi Email</h2>

<div style="background-color: #FFF;border-radius: 6px;box-shadow: 0 1px 2px rgba(0,0,0,0.3)">
<?php if($this->input->get('success')){ ?>
    <div class="success alert alert-success">
        Data sudah disimpan
    </div>
<?php } ?>

<div style="padding: 8px 11px;">
<?=form_open(current_url())?>

<div style="<?php if($type != NOTIFTYPEGENERAL) echo 'display:none' ?>">
<!-- <fieldset>
<table>
    <tr>
        <td>
            <h4>Email ketika insert data</h4>
            <input style="vertical-align: middle" type="checkbox" value="1" name="EmailWhenCreate" id="EmailWhenCreate" <?php if(EMAILWHENCREATE) echo 'checked=""' ?> />                
            <label for="EmailWhenCreate">Kirim email ketika insert</label>
        </td>
        <td>
            <h4>Email ketika ubah data</h4>
            <input style="vertical-align: middle" type="checkbox" value="1" name="EmailWhenEdit" id="EmailWhenEdit" <?php if(EMAILWHENEDIT) echo 'checked=""' ?> />
            <label for="EmailWhenEdit">Kirim email ketika ubah</label>
        </td>
        <td>
            <h4>Email ketika hapus data</h4>
            <input style="vertical-align: middle" type="checkbox" value="1" name="EmailWhenDelete" id="EmailWhenDelete" <?php if(EMAILWHENDELETE) echo 'checked=""' ?> />
            <label for="EmailWhenDelete">Kirim email ketika hapus</label>
        </td>
    </tr>
</table>
</fieldset>
</div><br /> -->

<table class="form table table-bordered table-responsive table-striped">
    <tr>
        <th>Pengaturan Notifikasi</th>
        <!-- <th>Detail</th> -->
    </tr>
    <?php
    foreach ($rows->result() as $row){
        ?>
        <tr>
            <td>
            <!-- <td valign="top" width="250"> -->
                <h4 class="alert alert-info"><?= $row->NotificationName ?></h4>
                <input type="hidden" name="ids[]" value="<?=$row->NotificationID?>" />
                
                <div class="col-md-6">
                    <h4>Subject</h4>
                    <input class="form-control" type="text" name="<?=$row->NotificationID?>-Subject" value="<?=$row->Subject?>" />
                    
                    <h4>Kirim Ke (To)</h4>
                    <input class="form-control" type="text" name="<?=$row->NotificationID?>-ToEmail" value="<?=$row->ToEmail?>" />
                    <br />
                    <input type="checkbox" name="<?=$row->NotificationID?>-IsActive" value="1" <?php if($row->IsActive) echo 'checked=""' ?> />
                    Aktifkan
                    
                </div>
                <div class="col-md-6">
                    <h4>Email Pengirim</h4>
                    <input class="form-control" type="text" readonly="" name="<?=$row->NotificationID?>-SenderEmail" value="<?=EMAILSENDER?>" />
                    <h4>Nama Pengirim</h4>
                    <input class="form-control" type="text" readonly="" name="<?=$row->NotificationID?>-SenderName" value="<?=EMAILSENDERNAME?>" />
                </div>
                <div class="clearfix"></div>
                
            <!-- </td>
            <td> --><br />
                <textarea name="<?=$row->NotificationID?>-Content" id="editor-<?=$row->NotificationID?>"><?=$row->Content?></textarea>
                <script>
                    $('#editor-<?=$row->NotificationID?>').ckeditor({
                        height: 300
                    });
                </script>
                <br /><br />
            </td>
        </tr>
        <?php
    }
    ?>
</table>

<button class="ui btn btn-primary" type="submit"><b class="glyphicon glyphicon-save"></b> Simpan</button>
<?=form_close()?>
</div>
</div>

<?php $this->load->view('admin/footer')?>
