<?php $this->load->view('admin/header') ?>

<h2>Ganti Logo</h2>

<div style="background-color: #FFF;border-radius: 6px;box-shadow: 0 1px 2px rgba(0,0,0,0.3);padding: 15px 10px">

<?php 
if($this->input->get('success')){
    ?>
    <div class="success">Berhasil diubah</div>
    <?php
}
?>

<p class="logcon">
<?=anchor(site_url('view/logo'),'<b class="glyphicon glyphicon-picture"></b> Logo',array('class'=>'ui logo btn btn-default'))?>
&nbsp;
<?=anchor(site_url('view/ikon'),'<b class="glyphicon glyphicon-picture"></b> Favicon',array('class'=>'ui ikon btn btn-default'))?>
</p>

<?=form_open('view/logo')?>

<div class="span-18">
<br />
<input style="width: auto; max-width: 250px" type="file" name="userfile" id="userfile" class="btn btn-info" />

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; atau &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />

<a href="<?=site_url('media/select')?>" class="pilihmedia btn btn-info"><b class="glyphicon glyphicon-picture"></b> Media</a>
<input type="hidden" id="MediaID" name="MediaPath" value="" />
<br /><br />

<span class="uploadstatus"></span>
<?php if(GetView('Logo')){ ?>
<div class="success infomedia alert alert-success">
    <img src="<?=GetMediaPath(GetView('Logo'))?>" width="100" /> <br />Gambar sudah dipilih.
    <a href="#" class="removemedia">x</a>
</div>
<?php }else{ ?>
<div class="success infomedia alert alert-success" style="display: none">
    
</div>
<?php } ?>
</div>

<div class="clear"></div>

<br />
<button type="submit" class="ui btn btn-primary"><b class="glyphicon glyphicon-save"></b> Simpan</button>

<?=form_close()?>

</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('.pilihmedia').click(function(){
            var a = this;
            $('#GeneralDialog').load($(a).attr('href'),{},function(){
                var dlg = this;
                $(dlg).dialog({
                    modal:true,
                    width:800,
                    height:500,
                    show: 'clip',
                    title: 'Pilih Gambar'
                });
                $('.selectit',dlg).click(function(){
                    $('.removemedia').show();
                    $('#MediaID').val($(this).attr('mediaid'));
                    $('.infomedia').html('<img src="<?=base_url()?>assets/images/media/'+$(this).attr('src')+'" width="100" /> <br />Gambar sudah dipilih <strong>'+$(this).attr('title')+'</strong>. <a href="#" class="removemedia">x</a>').show();
                    $(dlg).dialog('close');
                    return false;
                });
            })
            return false;
        });
        
        $('#userfile').change(function(){
            $(this).attr('disable',true);
            $('.uploadstatus').html('Sedang mengupload file <img src="<?=base_url()?>assets/images/load.gif" alt="ajaxloading" />');
            $('form').ajaxSubmit({
                dataType: 'json',
                url: '<?=site_url('media/upload')?>',
                success : function(data){
                    $('.removemedia').show();
                    $('#MediaID').val(data.mediaid);
                    $('.infomedia').html('<img src="<?=base_url()?>assets/images/media/'+data.mediapath+'" width="100" /> <br />Gambar sudah dipilih <strong>'+data.mediapath+'</strong>.  <a href="#" class="removemedia">x</a>').show();
                    $(this).attr('disable',false);
                    $('.uploadstatus').empty();
                }
            });
        });
        
        $('.removemedia').click(function(){
            var kos = 0;
            var yakin = confirm('Apa anda yakin?');
            if(!yakin){
                return false;
            }
            $('#MediaID').val(kos);
            $(this).closest('.infomedia').empty().hide();
            return false;
        });
    });
</script>
<?php $this->load->view('admin/footer') ?>