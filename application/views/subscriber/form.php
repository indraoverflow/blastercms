<?php $this->load->view('admin/header') ?>

<h2><?php echo $title?></h2>

<div style="background-color: #FFF;border-radius: 6px;box-shadow: 0 1px 2px rgba(0,0,0,0.3);padding: 15px 10px">

<?php 
if($this->input->get('success')){
    ?>
    <div class="success alert alert-success">Data berhasil disimpan</div>
    <?php
}
?>


<?=form_open(current_url(),array('id' => 'validate'))?>

<div class="col-sm-6">
    <label for="Email"><h3>Email</h3></label>
    <input required="" type="text" name="Email" class="required email form-control" id="Email" value="<?=$edit?$result -> Email:set_value('Email')?>" />
</div>

<div class="col-sm-6">

<h3>Kategori</h3>
<input type="checkbox" <?=$edit?$result -> IsAll?'checked=""':'':'checked=""'?> name="IsAll" value="1" id="IsAll" />
<label for="IsAll">Semua Kategori</label>
<br />

<div id="CategoryList" <?=$edit?$result -> IsAll?'style="display:none"':'':'style="display:none"'?> >
    <fieldset>
        <legend>Pilih Kategori</legend>
    
    <a href="#" class="addKategoria ui btn btn-default"><b class="glyphicon glyphicon-plus-sign"></b> Tambah kategori</a>
    <a href="#" class="deleteUrla ui btn btn-warning"><b class="glyphicon glyphicon-trash"></b> Hapus</a>
    <br />
    <select class="form-control" style="height: 150px" id="CategoryID" multiple="multiple" name="CategoryID[]">
        <?php if($edit){
            foreach ($categories->result() as $category) {
                ?>
                <option value="<?=$category->CategoryID?>"><?=$category->CategoryName?></option>
                <?php
            }
        }
        ?>
    </select>
    </fieldset>
    <div class="clear"></div>
</div>
</div>

<div class="clearfix"></div>
<br />
<button type="submit" class="ui btn btn-primary"><b class="glyphicon glyphicon-save"></b> Simpan</button>
<?=form_close()?>

</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#validate').submit(function(){
            $('#CategoryID option').attr('selected',true);
        });
            
        
        
        if($('#IsAll').attr('checked')){
            $('#CategoryList').hide();
        }else{
            $('#CategoryList').fadeIn();
        }
        
        
        $('#IsAll').change(function(){
            if($(this).attr('checked')){
                $('#CategoryList').slideUp();
            }else{
                $('#CategoryList').slideDown();
            }
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
                                $('#CategoryID').append('<option value="'+$(this).attr('catid')+'">'+$(this).attr('title')+'</option>');
                            });
                            dlg.dialog('close');
                        },
                        Batal: function(){
                            dlg.dialog('close');
                        }
                    }
                });
                $('.pilihberita',dlg).click(function(){
                    $('#CategoryID').append('<option value="'+$(this).attr('catid')+'">'+$(this).attr('title')+'</option>');
                    dlg.dialog('close');
                    return false;
                });
            });
            return false;
        });
        
        $('.deleteUrla').live('click',function(){
            if($('#CategoryID option:selected').length < 1){
                alert('Tidak ada yg dipilih');
                return false;
            }
            var yakin = confirm('Apakah anda yakin?');
            if(yakin){
                $('#CategoryID option:selected').remove();
            }
            return false;
        });
        
    });
</script>
<?php $this->load->view('admin/footer') ?>