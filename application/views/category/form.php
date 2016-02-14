<?=$this->load->view('admin/header')?>
<h2><?=$title?></h2>

<div style="background-color: #FFF;border-radius: 6px;box-shadow: 0 1px 2px rgba(0,0,0,0.3)">

<?php if(validation_errors()){?>
    <div class="error alert alert-danger">
        <?=validation_errors('')?>
    </div>    
<?php }?>

<?php if($this->input->get('success')) { ?>
    <div class="success alert alert-success">
        Data berhasil di simpan
    </div>
<?php }?>

<div style="padding: 10px 0px">

<?=form_open(current_url(),array('id'=>'validate'))?>

<!-- <div class="span-16" style="float: left"> -->
<div class="col-sm-6">
<label for="CategoryName"><h3>Judul</h3></label>
<input required="" class="required form-control" type="text" id="CategoryName" name="CategoryName" value="<?=$edit? $result->CategoryName : set_value('CategoryName')?>" />

<label><h3>Sub dari</h3></label>
<select class="form-control" name="ParentID">
    <option value="">-- Tidak ada --</option>
    <?php
        $datacat = $this -> db -> get('categories');
        GetCombobox($datacat, 'CategoryID', 'CategoryName',$edit? $result->ParentID : set_value('ParentID'))
    ?>
</select>


<?php if($edit){?><h3>URL</h3>
<div style="background: #ccc;padding: 5px 10px;">
<?=base_url()?> post/category/<input type="text" name="CategorySlug" value="<?=$result->CategorySlug?>" />.html
<input class="form-control" type="text" readonly="" value="<?=base_url().'post/category/'.$result->CategorySlug.'.html'?>" />
</div>
<?php } ?>

</div>

<!-- <div class="span-8" style="float: left"> -->
<div class="col-sm-6">

<label><h3>Jenis Tampilan</h3></label>
<select class="form-control" name="ViewTypeID">
    <option value="">-- Tidak ada --</option>
    <?php
        $vt = $this -> db -> get('viewtypes');
        GetCombobox($vt, 'ViewTypeID', 'ViewTypeName',$result->ViewTypeID);
    ?>
</select>


<label for="SidebarLeft"><h3>Sidebar Kiri (Widget ID)</h3></label>
<input class="form-control" type="text" name="SidebarLeft" class="angka" id="SidebarLeft" value="<?=$edit?$result->SidebarLeft:set_value('SidebarLeft')?>" />
    
<label for="SidebarRight"><h3>Sidebar Kanan (Widget ID)</h3></label>
<input class="form-control" type="text" name="SidebarRight" class="angka" id="SidebarRight" value="<?=$edit?$result->SidebarRight:set_value('SidebarRight')?>" />

</div>
    
<div class="clearfix"></div>
<div class="clear"></div>

<div class="col-sm-6">
    <label id="SEODescription"><h3>SEO Description</h3></label>
    <textarea class="form-control" id="SEODescription" name="SEODescription"></textarea>        
</div>

<div class="col-sm-6">
    <label id="SEOKeyword"><h3>SEO Keyword</h3></label>
    <textarea class="form-control" id="SEOKeyword" name="SEOKeyword"></textarea>    
</div>

<div class="clearfix"></div>

<br />
<!-- <input type="submit" class="ui" value="Simpan" /> -->
<div class="col-sm-3">
<button class="ui btn btn-primary" type="submit"><b class="glyphicon glyphicon-save"></b> Simpan</button>
</div>
<div class="clearfix"></div>

<?=form_close()?>
</div>
</div>


<?=$this->load->view('admin/footer')?>