<?php $this -> load -> view('admin/header') ?>

<h2><?php echo $title ?></h2>

<div style="background-color: #FFF;border-radius: 6px;box-shadow: 0 1px 2px rgba(0,0,0,0.3);padding: 8px 10px">
<?php if($this -> input -> get('success')){?>
    <div class="success alert alert-success">
        Data Berhasil di simpan
    </div>
<?php } ?>

<?=form_open('setting/appearance')?>

<div class="col-md-6">
<!-- <div class="col-md-6" style="float: left; width: 50%"> -->

<label><h3>Tampilan Detail Pos</h3></label>
<select class="form-control" name="DefaultDetailView">
    <?php $dv = $this -> db -> order_by('DetailViewID','asc') -> get('detailviews') ?>
    <?=GetCombobox($dv, 'DetailViewFile', 'DetailViewName', GetSetting('DefaultDetailView'))?>
</select>

<label><h3>Tipe Tampilan (Kategori & Search)</h3></label>
<select class="form-control" name="DefaultViewType">
    <?php $vt = $this -> db -> order_by('ViewTypeID','asc') -> get('viewtypes')?>
    <?=GetCombobox($vt, 'ViewTypeFile', 'ViewTypeName', GetSetting('DefaultViewType'))?>
</select>

<label for="DefaultPostPerPage"><h3>Banyak Pos Per Halaman</h3></label>
<input class="form-control" type="text" name="DefaultPostPerPage" class="angka" id="DefaultPostPerPage" value="<?=GetSetting('DefaultPostPerPage')?>" />

</div>
<!-- <label for="DefaultSidebarLeft"><h3>Default Sidebar Kiri</h3></label>
<input type="text" name="DefaultSidebarLeft" class="angka" id="DefaultSidebarLeft" value="<?=GetSetting('DefaultSidebarLeft')?>" />

<label for="DefaultSidebarRight"><h3>Default Sidebar Kanan</h3></label>
<input type="text" name="DefaultSidebarRight" class="angka" id="DefaultSidebarRight" value="<?=GetSetting('DefaultSidebarRight')?>" /> -->

<div  class="col-md-6">
<!-- <div  class="col-md-6" style="float: left; width: 50%"> -->

<label><h3>Default Sidebar Kiri</h3></label>
<select class="form-control" name="DefaultSidebarLeft">
    <?php $vt = $this -> db -> order_by('WidgetID','asc') -> get('widgets')?>
    <option value="">-- Tidak Ada Pilihan --</option>
    <?=GetCombobox($vt, 'WidgetID', 'WidgetName', GetSetting('DefaultSidebarLeft'))?>
</select>

<label><h3>Default Sidebar Kanan</h3></label>
<select class="form-control" name="DefaultSidebarRight">
    <?php $vt = $this -> db -> order_by('WidgetID','asc') -> get('widgets')?>
    <option value="">-- Tidak Ada Pilihan --</option>
    <?=GetCombobox($vt, 'WidgetID', 'WidgetName', GetSetting('DefaultSidebarRight'))?>
</select>

<label for="DefaultFooterColumn"><h3>Jumlah Kolom Footer</h3></label>
<input class="form-control" type="text" name="DefaultFooterColumn" class="angka" id="DefaultFooterColumn" value="<?=GetSetting('DefaultFooterColumn')?>" />

</div>

<!-- <div class="clear"></div> -->
<div class="clearfix"></div>
<br />
<p>
    <button class="ui btn btn-primary" type="submit"><b class="glyphicon glyphicon-save"></b> Simpan</button>
</p>

<?=form_close()?>
</div>


<?php $this -> load -> view('admin/footer') ?>
