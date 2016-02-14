<?=$this->load->view('admin/header')?>

<h2><?=$title?></h2>

<div style="background-color: #FFF;border-radius: 6px;box-shadow: 0 1px 2px rgba(0,0,0,0.3)">
    
<?php if($this->input->get('success')) { ?>
    <div class="success">
        Data berhasil di simpan
    </div>
<?php } ?>

<div style="padding: 15px 10px">
    
<?php
    $post = $this -> db -> where('PostID',$result -> PostID) -> get('posts') -> row();
?>

<?=form_open(current_url())?>

<?=anchor('comment','<b class="glyphicon glyphicon-comment"></b> Daftar Komentar',array('class'=>'ui btn btn-info'))?>
<br /><br />
<div class="clear"></div>
<fieldset>
<table class="table table-responsive table-striped">
    <tbody>
    <tr>
        <td>Nama</td>
        <td>:</td>
        <td><?=$result -> Name?></td>
    </tr>
    <tr>
        <td>Email</td>
        <td>:</td>
        <td><?=$result -> Email?></td>
    </tr>
    <tr>
        <td>Komentar pada post</td>
        <td>:</td>
        <td><?=$post -> PostTitle?></td>
    </tr>
    <tr>
        <td>Tanggal / Waktu</td>
        <td>:</td>
        <td><?=date('d-M-Y H:i:s',strtotime($result -> CommentDate))?></td>
    </tr>
    <tr>
        <td>Isi Komentar</td>
        <td>:</td>
        <td><textarea class="form-control" readonly=""><?=$result -> Comment?></textarea></td>
    </tr>
    </tbody>    
</table>
    
</fieldset>

<!-- <h3>Tampil Komentar</h3>
<input id="tampil" type="checkbox" name="IsVerified" value="1" checked="" <?=$result->IsVerified? 'checked=""':''?> />
<label for="tampil" style="vertical-align: top  ">tampilkan komentar ini</label><br /><br />

<p>
    <button class="ui" type="submit">Simpan</button>
</p> -->

<?=form_close()?>

</div>
</div>


<?=$this -> load -> view('admin/footer') ?>