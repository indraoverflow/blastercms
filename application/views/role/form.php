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

<div style="padding: 8px 11px;">

<?=form_open(current_url(),array('id'=>'validate'))?>

<label for="RoleName"><h3>Nama Role</h3></label>
<input required="" autofocus="" class="form-control" type="text" class="required" id="RoleName" name="RoleName" value="<?=$edit? $result->RoleName : set_value('RoleName')?>" />
<br />

<?php if($edit){ ?>
<fieldset>
    <legend>Hak Backend</legend>
    <?php if($result->RoleID != UNLOGINROLE){ ?>
        <h4>Berdasarkan Modul</h4>
        <table id="modules" class="table table-bordered table-responsive table-striped" >
            <thead>
            <tr>
                <th>
                    <center>Modul</center>
                </th>
                <th>
                    <center>Buat<br />
                    <input type="checkbox" class="maintopcekbox" id="cekbox-buat" />
                    </center>
                </th>
                <th>
                    <center>Ubah <br />
                    <input type="checkbox" class="maintopcekbox" id="cekbox-ubah" />
                    </center>
                </th>
                <th>
                    <center>Hapus<br />
                    <input type="checkbox" class="maintopcekbox" id="cekbox-hapus" />
                    </center>
                </th>
                <th>
                    <center>Lihat<br />
                    <input type="checkbox" class="maintopcekbox" id="cekbox-lihat" />
                    </center>
                </th>
            </tr>
            </thead>
            <tbody>
            <?php
                foreach ($modules->result() as $modul) {
                    $id = $modul->ModuleID;
                    ?>
                    <tr>
                        <td>
                            <input type="checkbox" class="mainleftcekbox" id="cekbox-<?=$id?>" />
                            <label for="cekbox-<?=$id?>"><?=$modul->ModuleName?></label>
                            <input type="hidden" name="modules[]" value="<?=$modul->ModuleID?>" />
                        </td>
                        <td align="center"><input <?php if(IsAllowInsert($id,$result->RoleID)) echo 'checked=""' ?> class="cekbox-buat cekbox-<?=$id?>" type="checkbox" name="<?=$modul->ModuleID?>-Buat" value="1" /></td>
                        <td align="center"><input <?php if(IsAllowUpdate($id,$result->RoleID)) echo 'checked=""' ?> class="cekbox-ubah cekbox-<?=$id?>" type="checkbox" name="<?=$modul->ModuleID?>-Ubah" value="1" /></td>
                        <td align="center"><input <?php if(IsAllowDelete($id,$result->RoleID)) echo 'checked=""' ?> class="cekbox-hapus cekbox-<?=$id?>" type="checkbox" name="<?=$modul->ModuleID?>-Hapus" value="1" /></td>
                        <td align="center"><input <?php if(IsAllowView($id,$result->RoleID)) echo 'checked=""' ?> class="cekbox-lihat cekbox-<?=$id?>" type="checkbox" name="<?=$modul->ModuleID?>-Lihat" value="1" /></td>
                    </tr>
                    <?php
                }
            ?>
            </tbody>
        </table>
    <?php } ?>
    <h4>Kategori yang diizinkan untuk post</h4>
    
    <p>
        <input type="checkbox" <?php if($result->IsAllCategory) echo 'checked=""' ?> name="IsAllCategory" value="1" id="IsAllCategory" />
        <label for="IsAllCategory">Semua Kategori</label>
    </p>
    <div id="AllowedCatContent" <?php if($result->IsAllCategory) echo 'style="display:none"' ?>>
        <select multiple="" id="AllowedCategories" name="AllowedPostCategories[]" style="width: 500px; height: 200px; float: left">
            <?php
                foreach ($allowedpostcategories->result() as $category) {
                    ?>
                    <option value="<?=$category->CategoryID?>"><?=$category->CategoryName?></option>
                    <?php
                }
            ?>
        </select>
        <a href="#" class="addKategoria ui btn btn-info"><b class="glyphicon glyphicon-plus-sign"></b> Tambah kategori</a><br />
        <a href="#" class="deleteUrla ui btn btn-warning"><b class="glyphicon glyphicon-remove-sign"></b> Hapus</a>
        <div class="clear"></div>
    </div>
</fieldset>

<br />
<fieldset>
    <legend>Hak Frontend</legend>
    
    <h4>URL yang tidak diizinkan</h4>
    <a href="#" class="addUrl ui btn btn-info"><b class="glyphicon glyphicon-plus-sign"></b> Tambah URL</a>
    <a href="#" class="addPage ui btn btn-info"><b class="glyphicon glyphicon-plus-sign"></b> Tambah dari halaman</a>
    <a href="#" class="addKategori ui btn btn-info"><b class="glyphicon glyphicon-plus-sign"></b> Tambah dari kategori</a>
    <a href="#" class="editUrl ui btn btn-info"><b class="glyphicon glyphicon-edit"></b> Ubah</a>
    <a href="#" class="deleteUrl ui btn btn-warning"><b class="glyphicon glyphicon-remove-sign"></b> Hapus</a>
    <select class="form-control" multiple="" id="DisallowedList" name="Disallowed[]" style="height: 200px">
        <?php
            foreach ($disallowedurls->result() as $url) {
                ?>
                <option value="<?=$url->URL?>"><?=$url->URL?></option>
                <?php
            }
        ?>
    </select>
    <div class="clear"></div>
    
    <br />
    <h4>Tidak diizinkan melihat detail post dengan kategori berikut</h4>
    <a href="#" class="addKategori3 ui btn btn-info"><b class="glyphicon glyphicon-plus-sign"></b> Tambah kategori</a>
    <a href="#" class="deleteUrl3 ui btn btn-warning"><b class="glyphicon glyphicon-remove-sign"></b> Hapus</a>
    <select class="form-control" multiple="" id="BlockedCategories" name="BlockedCategories[]" style="height: 200px">
        <?php
            foreach ($blockedcategories->result() as $category) {
                ?>
                <option value="<?=$category->CategoryID?>"><?=$category->CategoryName?></option>
                <?php
            }
        ?>
    </select>
    <div class="clear"></div>
    
    <br />
    <h4>Kategori yang tidak ditampilkan pada list</h4>
    <a href="#" class="addKategori2 ui btn btn-info"><b class="glyphicon glyphicon-plus-sign"></b> Tambah kategori</a>
    <a href="#" class="deleteUrl2 ui btn btn-warning"><b class="glyphicon glyphicon-remove-sign"></b> Hapus</a>
    <select class="form-control" multiple="" id="DisallowedCategories" name="DisallowedCategories[]" style=" height: 200px">
        <?php
            foreach ($disallowedcategories->result() as $category) {
                ?>
                <option value="<?=$category->CategoryID?>"><?=$category->CategoryName?></option>
                <?php
            }
        ?>
    </select>
    
    
    <div class="clear"></div>
</fieldset>

<?php }?>

<br />
<button type="submit" class="ui btn btn-primary"><b class="glyphicon glyphicon-save"></b> Simpan</button>

<?=form_close()?>

</div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#validate').submit(function(){
            $('#DisallowedList option').attr('selected',true);
            $('#DisallowedCategories option').attr('selected',true);
            $('#BlockedCategories option').attr('selected',true);
            $('#AllowedCategories option').attr('selected',true);
        });
        
        $('#IsAllCategory').change(function(){
            if($(this).attr('checked')){
                $('#AllowedCatContent').slideUp();
            }else{
                $('#AllowedCatContent').slideDown();
            }
        });
        
        $('.addUrl').click(function(){
            var dlg = $('#GeneralDialog').load('<?=site_url('role/addlink')?>',{},function(){
                dlg.dialog({
                    modal : true,
                    title: 'URL',
                    width: 'auto',
                    height: 'auto',
                    buttons: {
                        OK : function(){
                            if($('#tburl',dlg).val() == ""){
                                alert('Silahkan isi URL Terlebih dahulu');
                                return false;
                            }
                            $('#DisallowedList').append('<option value="'+$('#tburl',dlg).val()+'">'+$('#tburl',dlg).val()+'</option>');
                            dlg.dialog('close');
                        },
                        Batal: function(){
                            dlg.dialog('close');
                        }
                    }
                });
            });
            return false;
        });
        $('.addPage').click(function(){
            var dlg = $('#GeneralDialog').load('<?=site_url('menu/halaman')?>',{},function(){
                
                $('#GeneralDialog').find('#cekbox').change(function(){
                    var aa = $(this);
                    if(aa.attr('checked')){
                        $('#GeneralDialog').find('.cekbox').attr('checked',true);
                    }else{
                        $('#GeneralDialog').find('.cekbox').attr('checked',false);
                    }
                });
                
                dlg.dialog({
                    modal : true,
                    title: 'URL',
                    width: 800,
                    height: 'auto',
                    buttons: {
                        OK : function(){
                            dlg.find('.cekbox:checked').each(function(i,elm){
                                $('#DisallowedList').append('<option value="'+$(this).attr('link')+'">'+$(this).attr('link')+'</option>');
                            });
                            dlg.dialog('close');
                        },
                        Batal: function(){
                            dlg.dialog('close');
                        }
                    }
                });
                $('.pilihberita',dlg).click(function(){
                    $('#DisallowedList').append('<option value="'+$(this).attr('link')+'">'+$(this).attr('link')+'</option>');
                    dlg.dialog('close');
                    return false;
                });
            });
            return false;
        });
        
        $('.addKategori').click(function(){
            var dlg = $('#GeneralDialog').load('<?=site_url('menu/kategori')?>',{},function(){
                $('#GeneralDialog').find('#cekbox').change(function(){
                    var aa = $(this);
                    if(aa.attr('checked')){
                        $('#GeneralDialog').find('.cekbox').attr('checked',true);
                    }else{
                        $('#GeneralDialog').find('.cekbox').attr('checked',false);
                    }
                });
                
                dlg.dialog({
                    modal : true,
                    title: 'URL',
                    width: 800,
                    height: 'auto',
                    buttons: {
                        OK : function(){
                            dlg.find('.cekbox:checked').each(function(i,elm){
                                $('#DisallowedList').append('<option value="'+$(this).attr('link')+'">'+$(this).attr('link')+'</option>');
                            });
                            dlg.dialog('close');
                        },
                        Batal: function(){
                            dlg.dialog('close');
                        }
                    }
                });
                $('.pilihberita',dlg).click(function(){
                    $('#DisallowedList').append('<option value="'+$(this).attr('link')+'">'+$(this).attr('link')+'</option>');
                    dlg.dialog('close');
                    return false;
                });
            });
            return false;
        });
        
        $('.editUrl').live('click',function(){
            if($('#DisallowedList option:selected').length < 1){
                alert('Tidak ada yg dipilih');
                return false;
            }
            var edited = $('#DisallowedList option:selected').eq(0).val();
            var idx = $('#DisallowedList option').index($('#DisallowedList option:selected').eq(0));
            var dlg = $('#GeneralDialog').load('<?=site_url('role/addlink')?>',{},function(){
                $('#tburl').val(edited);
                dlg.dialog({
                    modal : true,
                    title: 'URL',
                    width: 'auto',
                    height: 'auto',
                    buttons: {
                        OK : function(){
                            if($('#tburl',dlg).val() == ""){
                                alert('Silahkan isi URL Terlebih dahulu');
                                return false;
                            }
                            $('#DisallowedList option').eq(idx).val($('#tburl',dlg).val()).html($('#tburl',dlg).val());
                            dlg.dialog('close');
                        },
                        Batal: function(){
                            dlg.dialog('close');
                        }
                    }
                });
            });
            return false;
        });
        
        $('.deleteUrl').live('click',function(){
            if($('#DisallowedList option:selected').length < 1){
                alert('Tidak ada yg dipilih');
                return false;
            }
            var yakin = confirm('Apakah anda yakin?');
            if(yakin){
                $('#DisallowedList option:selected').remove();
            }
            return false;
        });
        
        $('.addKategori2').click(function(){
            var dlg = $('#GeneralDialog').load('<?=site_url('menu/kategori')?>',{},function(){
                $('#GeneralDialog').find('#cekbox').change(function(){
                    var aa = $(this);
                    if(aa.attr('checked')){
                        $('#GeneralDialog').find('.cekbox').attr('checked',true);
                    }else{
                        $('#GeneralDialog').find('.cekbox').attr('checked',false);
                    }
                });
                
                dlg.dialog({
                    modal : true,
                    title: 'URL',
                    width: 800,
                    height: 'auto',
                    buttons: {
                        OK : function(){
                            dlg.find('.cekbox:checked').each(function(i,elm){
                                $('#DisallowedCategories').append('<option value="'+$(this).attr('catid')+'">'+$(this).attr('title')+'</option>');
                            });
                            dlg.dialog('close');
                        },
                        Batal: function(){
                            dlg.dialog('close');
                        }
                    }
                });
                $('.pilihberita',dlg).click(function(){
                    $('#DisallowedCategories').append('<option value="'+$(this).attr('catid')+'">'+$(this).attr('title')+'</option>');
                    dlg.dialog('close');
                    return false;
                });
            });
            return false;
        });
        
        $('.deleteUrl2').live('click',function(){
            if($('#DisallowedCategories option:selected').length < 1){
                alert('Tidak ada yg dipilih');
                return false;
            }
            var yakin = confirm('Apakah anda yakin?');
            if(yakin){
                $('#DisallowedCategories option:selected').remove();
            }
            return false;
        });
        
        $('.addKategori3').click(function(){
            var dlg = $('#GeneralDialog').load('<?=site_url('menu/kategori')?>',{},function(){
                $('#GeneralDialog').find('#cekbox').change(function(){
                    var aa = $(this);
                    if(aa.attr('checked')){
                        $('#GeneralDialog').find('.cekbox').attr('checked',true);
                    }else{
                        $('#GeneralDialog').find('.cekbox').attr('checked',false);
                    }
                });
                
                dlg.dialog({
                    modal : true,
                    title: 'URL',
                    width: 800,
                    height: 'auto',
                    buttons: {
                        OK : function(){
                            dlg.find('.cekbox:checked').each(function(i,elm){
                                $('#BlockedCategories').append('<option value="'+$(this).attr('catid')+'">'+$(this).attr('title')+'</option>');
                            });
                            dlg.dialog('close');
                        },
                        Batal: function(){
                            dlg.dialog('close');
                        }
                    }
                });
                $('.pilihberita',dlg).click(function(){
                    $('#BlockedCategories').append('<option value="'+$(this).attr('catid')+'">'+$(this).attr('title')+'</option>');
                    dlg.dialog('close');
                    return false;
                });
            });
            return false;
        });
        
        $('.deleteUrl3').live('click',function(){
            if($('#BlockedCategories option:selected').length < 1){
                alert('Tidak ada yg dipilih');
                return false;
            }
            var yakin = confirm('Apakah anda yakin?');
            if(yakin){
                $('#BlockedCategories option:selected').remove();
            }
            return false;
        });
        
        $('.addKategoria').click(function(){
            var dlg = $('#GeneralDialog').load('<?=site_url('menu/kategori')?>',{},function(){
                $('#GeneralDialog').find('#cekbox').change(function(){
                    var aa = $(this);
                    if(aa.attr('checked')){
                        $('#GeneralDialog').find('.cekbox').attr('checked',true);
                    }else{
                        $('#GeneralDialog').find('.cekbox').attr('checked',false);
                    }
                });
                
                dlg.dialog({
                    modal : true,
                    title: 'URL',
                    width: 800,
                    height: 'auto',
                    buttons: {
                        OK : function(){
                            dlg.find('.cekbox:checked').each(function(i,elm){
                                $('#AllowedCategories').append('<option value="'+$(this).attr('catid')+'">'+$(this).attr('title')+'</option>');
                            });
                            dlg.dialog('close');
                        },
                        Batal: function(){
                            dlg.dialog('close');
                        }
                    }
                });
                $('.pilihberita',dlg).click(function(){
                    $('#AllowedCategories').append('<option value="'+$(this).attr('catid')+'">'+$(this).attr('title')+'</option>');
                    dlg.dialog('close');
                    return false;
                });
            });
            return false;
        });
        
        $('.deleteUrla').live('click',function(){
            if($('#AllowedCategories option:selected').length < 1){
                alert('Tidak ada yg dipilih');
                return false;
            }
            var yakin = confirm('Apakah anda yakin?');
            if(yakin){
                $('#AllowedCategories option:selected').remove();
            }
            return false;
        });
        
    });
    
    $('.mainleftcekbox').change(function(){
        if($(this).attr('checked')){
            $('.'+$(this).attr('id')).attr('checked',true);
        }else{
            $('.'+$(this).attr('id')).attr('checked',false);
        }
    });
    $('.maintopcekbox').change(function(){
        if($(this).attr('checked')){
            $('.'+$(this).attr('id')).attr('checked',true);
        }else{
            $('.'+$(this).attr('id')).attr('checked',false);
        }
    });
</script>


<?=$this->load->view('admin/footer')?>