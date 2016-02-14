<?php $this->load->view('admin/header')?>

<h2><?=$title?></h2>

<div style="background-color: #FFF;border-radius: 6px;box-shadow: 0 1px 2px rgba(0,0,0,0.3);padding: 15px 0px">

<?php if($this->input->get('success') == 1){ ?>
    <div class="success alert alert-success">
        Layer Slider sudah disimpan
    </div>
<?php } ?>

<?php if(validation_errors()){ ?>
    <div class="error alert alert-danger">
        <?= validation_errors() ?>
    </div>
<?php } ?>

<?=form_open(current_url(),array('id'=>'validate'))?>
<div class="col-sm-7">
<h3>Nama Slider</h3>
<input required="" class="required form-control" type="text" name="SliderName" value="<?=$edit?$result->SliderName:set_value('SliderName')?>" class="required" />

<h3>Gambar</h3>
<div class="well">
<input style="width: auto; max-width: 220px" type="file" name="userfile" id="userfile" class="btn btn-info" />

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; atau &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />

<a href="<?=site_url('media/select')?>" class="pilihmedia btn btn-info"><b class="glyphicon glyphicon-picture"></b> Media</a>
<input type="hidden" id="MediaID" name="MediaID" value="<?=$edit?$result->MediaID:''?>" />
<br /><br />
<span class="uploadstatus"></span>
<div class="success infomedia alert alert-success" style="<?php if(empty($result->MediaID) || !$edit){ ?>display: none<?php } ?>">
    <?php
        if($edit){
            if(!empty($result->MediaID)){
            $media = $this->db->where('MediaID',$result->MediaID)->get('media')->row();
                ?>
                <img class="img-thumbnail" src="<?=base_url()?>assets/images/media/<?=$media->MediaPath?>" width="300" /> <br />Gambar sudah dipilih <strong><?=$media->MediaName?></strong>.'
                <?php
            }
        }
    ?>
    <a href="#" class="removemedia">x</a>
</div>
</div>

<h3>Link Slider</h3>
<input class="form-control" type="text" name="SliderLink" value="<?=$edit?$result->SliderLink:set_value('SliderLink')?>" />

<h3>Text Slider</h3>
<textarea class="form-control" name="SliderText"><?=$edit?$result->SliderText:set_value('SliderText')?></textarea>

<h3>Arah Slider</h3>
<select class="form-control" name="SliderDirection">
    <option value="">Not Set</option>
    <?php
        foreach (GetArrDirection() as $direction) {
            ?>
            <option <?php if($edit){ if($direction == $result->SliderDirection) echo 'selected="selected"'; } ?> value="<?=$direction?>"><?=$direction?></option>
            <?php
        }
    ?>
</select>

<h3>Slider Delay</h3>
<input class="form-control" style="width: 80%;display: inline-block" type="text" name="SliderDelay" value="<?=$edit?$result->SliderDelay:set_value('SliderDelay')?>" class="angka" /> milisecond

<br /><br />
<p><button type="submit" class="ui btn btn-primary"><b class="glyphicon glyphicon-save"></b> Simpan</button></p>

</div>
<div class="clearfix"></div>
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
                    $('.infomedia').html('<img src="<?=base_url()?>assets/images/media/'+$(this).attr('src')+'" width="300" /> <br />Gambar sudah dipilih <strong>'+$(this).attr('title')+'</strong>. <a href="#" class="removemedia">x</a>').show();
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
                    $('.infomedia').html('<img src="<?=base_url()?>assets/images/media/'+data.mediapath+'" width="300" /> <br />Gambar sudah dipilih <strong>'+data.mediapath+'</strong>.  <a href="#" class="removemedia">x</a>').show();
                    $(this).attr('disable',false);
                    $('.uploadstatus').empty();
                }
            });
        });
        
        $('.removemedia').live('click',function(){
            var kos = 0;
            var yakin = confirm('Apa anda yakin?');
            if(!yakin){
                return false;
            }
            $('#MediaID').val(kos);
            $(this).closest('.infomedia').empty().hide();
            return false;
        });
        
        
        
        $(".cats").dropdownchecklist( { icon: { placement: 'right', toOpen: 'ui-icon-arrowthick-1-s'
                                            , toClose: 'ui-icon-arrowthick-1-n' }
                                            , maxDropHeight: 300, width: 300 } );
    });
</script>

<?php $this->load->view('admin/footer') ?>