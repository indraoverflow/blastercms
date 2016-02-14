<?=$this->load->view('admin/header')?>

<h2><?=$title?></h2>

<div style="background-color: #FFF;border-radius: 6px;box-shadow: 0 1px 2px rgba(0,0,0,0.3)">
    
<?php if(validation_errors()){?>
    <div class="error alert alert-danger">
        <?=validation_errors('')?>
    </div>    
<?php } ?>

<?php if($this->input->get('success')) { ?>
    <div class="alert alert-success success">
        Data berhasil di simpan
    </div>
<?php } ?>

<div style="padding: 15px 10px">


<?=form_open(current_url(),array('id'=>'validate'))?>


<!-- <div class="span-16 col-md-8"> -->
    
<label for="PostTitle"><h3>Judul</h3></label>
<textarea class="form-control" id="PostTitle" name="PostTitle"><?=$edit?$result->PostTitle : set_value('PostTitle')?></textarea><br />
<script>
	CKEDITOR.replace('PostTitle', {
		height : 75,
		toolbar : [{
			name : 'document',
			items : ['Source', '-']
		}, // Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
		['Undo', 'Redo'], // Defines toolbar group without name.
		{
			name : 'basicstyles',
			items : ['Bold', 'Italic', 'Styles', 'Format', 'Font', 'FontSize', 'TextColor', 'BGColor']
		}]
	}); 
</script>

<div class="col-md-12">
	<div class="form-group">
		<input type="checkbox" name="PostTypeID" value="2" id="PostTypeID" <?=$edit?$result->PostTypeID==PRODUCT?'checked="checked"':'':''?> /> 
		<label for="PostTypeID">Apakah Post ini termasuk Tipe Produk.</label>
	</div>
</div>
<div class="clearfix"></div>

<div class="col-md-12" id="ProdukDetail">
	<div class="panel panel-info">
		<div class="panel-heading">
			Detail Informasi Produk
		</div>
		<div class="panel-body">
			<div class="col-sm-6">
				<div class="form-group">
					<label for="SKU" class="">SKU</label>
					<div class="">
						<input type="text" id="SKU" class="form-control" name="SKU" value="<?=$edit?$result->SKU:''?>" />
					</div>
				</div>
				<div class="form-group">
					<label for="Price" class="">Harga</label>
					<div class="">
						<input type="text" id="Price" class="form-control angka" name="Price" value="<?=$edit?$result->Price:''?>" />
					</div>
				</div>
				<div class="form-group">
					<label for="DiscountPrice" class="">Harga Diskon</label>
					<div class="">
						<input type="text" id="DiscountPrice" class="form-control angka" name="DiscountPrice" value="<?=$edit?$result->DiscountPrice:''?>" />
					</div>
				</div>
				<div class="form-group">
					<label for="DiscountUntil" class="">Diskon Sampai</label>
					<div class="">
						<input type="text" id="DiscountUntil" class="form-control datepicker" name="DiscountUntil" value="<?=$edit?$result->DiscountUntil:''?>" />
					</div>
				</div>	
			</div>
			
			<div class="col-sm-6">
				
				<div class="form-group">
					<label for="Weight" class="">Berat Produk</label>
					<div class="">
						<input type="text" id="Weight" class="form-control angka" name="Weight" value="<?=$edit?$result->Weight:''?>" />
					</div>
				</div>
				<div class="form-group">
					<label for="Warranty" class="">Garansi</label>
					<div class="">
						<textarea id="Warranty" class="form-control" name="Warranty"><?=$edit?$result->Warranty:''?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label>Ketersediaan Stok</label>
					<div class="checkbox">
						<input id="KetersediaanStok" type="checkbox" name="KetersediaanStok" <?=$edit ? $result->KetersediaanStok?'checked=""':'' : 'checked=""'?> value="1" />
						<label for="KetersediaanStok" class="label label-primary">Tersedia stok pada produk ini.</label>
					</div>
				</div>	
			</div>	
		</div>
	</div>
		
	
</div>
<div class="clearfix"></div>

<div class="col-md-6" style="z-index: 11">
    <h3>Kategori</h3>
    <select class="cats form-control" multiple="" name="CategoryID[]">
        <?php $cat = $this -> db -> order_by('CategoryID', 'asc') -> get('categories');
        GetCombobox($cat, 'CategoryID', 'CategoryName', $catlist);
        ?>
    </select>
</div>

<div class="col-md-6">
    <style type="text/css">
        .tagsinput{
            width: auto !important;
            height: auto !important
        }
    </style>
    <label for="tags"><h3>Tags</h3></label>
    <input type="text" class="form-control" name="tags" value="<?=$edit?$tags:""?>" id="tags" />
</div>
<div class="clearfix"></div>



<fieldset style="background: #EFEFDE">
    <legend><h3>Gambar</h3></legend>
    <ul class="sortable gambars" style="list-style: none; padding: 0;" id="gambars">
        <li>
            <center>
                <a style="margin-top: 5px;" href="#" class="ui selectpicture btn btn-info"><b class="glyphicon glyphicon-upload"></b> Upload</a>
                <br />Atau<br />
                <a href="#" class="ui selectmedia btn btn-info"><b class="glyphicon glyphicon-picture"></b> Library</a>
            </center>
        </li>
        <?php if($edit && !empty($images)){ ?>
            <?php $mastermedia = GetMedia($result->MediaID); ?>
            <?php if(!empty($mastermedia)){ ?>
            <li >
                <img class="img-circle img-responsive img-thumbnail" src="<?=$mastermedia?>" />
                <a href="#" class="deletephoto deletephoto">x</a>
                <input type="hidden" name="MediaID[]" value="<?=$result->MediaID?>" />
            </li>
            <?php } ?>
            <?php foreach ($images->result() as $media) { ?>
                <li>
                    <img class="img-circle img-responsive img-thumbnail" src="<?=$media->MediaFullPath?>" />
                    <a href="#" class="deletephoto deletephoto">x</a>
                    <input type="hidden" name="MediaID[]" value="<?=$media->MediaID?>" />
                </li>
            <?php } ?>
        <?php }else{ ?>
        
        <?php } ?>
        
    </ul>
    
</fieldset>


<!-- <div class="clear"></div> -->

<label for="PostContent"><h3>Konten</h3></label>
<textarea class="ckeditor form-control" name="PostContent" id="PostContent"><?=$edit? $result->PostContent : set_value('PostContent')?></textarea>
<br />

<label for="SeoDescription"><h3>SEO Description</h3></label>
<textarea class="form-control" name="SEODescription" id="SeoDescription"><?=$edit? $result->SEODescription : set_value('SEODescription')?></textarea>
<script>
	CKEDITOR.replace('SeoDescription', {
		height : 100,
		toolbar : [{
			name : 'document',
			items : ['Source', '-']
		}, // Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
		['Undo', 'Redo'], // Defines toolbar group without name.
		{
			name : 'basicstyles',
			items : ['Bold', 'Italic', 'Styles', 'Format', 'Font', 'FontSize', 'TextColor', 'BGColor']
		}]
	}); 
</script>


<?php if($edit){?>
<div class="col-sm-12" style="padding: 0">
	<label for="url"><h3>URL</h3></label>
	<div style="background: #ccc;padding: 5px 13px;">
		
		<div class="form-group text-primary">
	
			<?=base_url()?> post/view/<input type="text" id="url" name="PostSlug" value="<?=$result->PostSlug?>" />.html
	
		</div>	
		
		<div class="form-group">
			<input type="text" class="form-control" readonly value="<?=base_url().'post/view/'.$result->PostSlug.'.html'?>" />
		</div>
		
		<div class="form-group">
			<a target="_blank" href="<?=base_url().'post/view/'.$result->PostSlug.'.html'?>" class="btn btn-info">Kunjungi Halaman</a>
		</div>
	
	</div>
</div>
<div class="clearfix"></div>
<?php } ?>



<!-- <div class="span-8 col-md-4"> -->

<div class="col-md-6">
    <label for="SidebarLeft"><h3>Sidebar Kiri (Widget ID)</h3></label>
    <input type="text" name="SidebarLeft" class="angka form-control" id="SidebarLeft" value="<?=$edit?$result->SidebarLeft:set_value('SidebarLeft')?>" />
</div>
<div class="col-md-6">
    <label for="SidebarRight"><h3>Sidebar Kanan (Widget ID)</h3></label>
    <input type="text" name="SidebarRight" class="angka form-control" id="SidebarRight" value="<?=$edit?$result->SidebarRight:set_value('SidebarRight')?>" />
</div>
<div class="clearfix"></div>

<div class="col-md-6">    
    <h3>Jenis Tampilan Detail</h3>
    <select class="form-control" name="DetailViewID">
        <option value="">-- Pilihan --</option>
        <?php $dv = $this -> db -> order_by('DetailViewID', 'asc') -> get('detailviews');
            GetCombobox($dv, 'DetailViewID', 'DetailViewName', $result->DetailViewID);
        ?>
    </select>
</div>
<div class="col-md-6">    
    <label for="PostExpiredDate"><h3>Berlaku Sampai</h3></label>
    <input style="width: 80%" type="text" id="PostExpiredDate" name="PostExpiredDate" value="<?=$edit?$result->PostExpiredDate:set_value('PostExpiredDate')?>" class="datepicker" id="PostExpiredDate" />
</div>
<div class="clearfix"></div>

<div class="col-md-6">
    <h3>Komentar</h3>
    <input type="checkbox" <?=$edit? $result->AllowComment?'checked=""':'' : ''?>  name="AllowComment" id="AllowComment" value="1" /> <label class="" for="AllowComment">Tampilkan kolom komentar</label>
</div>
<div class="col-md-6">    
    <h3>View Detail</h3>
    <input type="checkbox" <?=$edit ? $result->AllowViewDetail?'checked=""':'' : 'checked=""'?> name="AllowViewDetail" id="AllowViewDetail" value="1"/> <label for="AllowViewDetail">Tampilkan Detail</label>
</div>

<div class="clearfix"></div>
<!-- </div> -->

<!-- <div class="clear"></div> -->

<p>
    <button class="ui btn btn-primary" type="submit"><b class="glyphicon glyphicon-save"></b> Simpan</button>
</p>


<?php if($edit){ ?>
    <table class="meta ui-state-default" border="1">
        <tr>
            <td>
                Dibuat Oleh:
            </td>
            <td><?=$result->PostedBy?></td>
        </tr>
        <tr>
            <td>
                Dibuat Pada:
            </td>
            <td><?=$result->PostedOn?></td>
        </tr>
        <tr>
            <td>
                Diubah Oleh:
            </td>
            <td><?=$result->UpdateBy?></td>
        </tr>
        <tr>
            <td>
                Diubah Pada:
            </td>
            <td><?=$result->UpdateOn?></td>
        </tr>
    </table>
<?php } ?>

<?=form_close()?>

</div>
</div>

<form id="uploader" enctype="multipart/form-data" method="post">
    <input type="file" style="visibility: hidden" id="filer" name="userfile" class="userfile" />
</form>

<script type="text/javascript">
	$(document).ready(function() {
		if($('#PostTypeID').is(':checked')){
			$('#ProdukDetail').slideDown();
		}else{
			$('#ProdukDetail').slideUp();
		}
			
		$('#PostTypeID').change(function(){
			if($(this).is(':checked')){
				$('#ProdukDetail').slideDown();
			}else{
				$('#ProdukDetail').slideUp();
			}
		});
		
	    $('#tags').tagsInput();
	    $('.tagsinput').addClass('form-control');
	    $('#ddcl-1').addClass('form-control');
	    
	    
		$(".cats").dropdownchecklist({
    			icon : {
    				placement : 'right',
    				toOpen : 'ui-icon-arrowthick-1-s',
    				toClose : 'ui-icon-arrowthick-1-n'
    			},
    			maxDropHeight : 300,
    			width : 300
    		});
    		
    	});
	
		function pushuploader(){
            var uploadercontent = '<li>'+
                                    '<center><a style="margin-top: 5px;" href="#" class="ui selectpicture btn btn-info"><b class="glyphicon glyphicon-upload"></b> Upload</a>'+
                                    '<br />Atau<br />'+
                                    '<a href="#" class="ui selectmedia btn btn-info"><b class="glyphicon glyphicon-picture"></b> Library</a></center>'+
                                '</li>';
            $('#gambars').prepend(uploadercontent);
        }
                
        function upload(idx){
            $('.userfile').unbind().change(function(){
                $('#gambars li').eq(idx).html('<img style="width:auto; height:auto;" src="<?=base_url()?>assets/images/load.gif" /> <br /> Uploading...');
                $(this).parent().ajaxSubmit({
                    dataType: 'json',
                    url: '<?=site_url('media/upload')?>',
                    success : function(data){
                        var con =   '<img class="fancybox img-circle img-responsive img-thumbnail" src="'+data.fullmediapath+'" />'+
                                    '<a href="#" class="deletephoto deletephoto">x</a>'+
                                    '<input type="hidden" name="MediaID[]" value="'+data.mediaid+'" />';
                        $('#gambars li').eq(idx).html(con);
                        pushuploader();
                    }
                });
            });
        }
                
        $(document).ready(function(){
            $('#gambars').sortable();
            $('.deletephoto').live('click',function(){
                var yakin = confirm('Apa anda yakin?');
                if(yakin){
                    $(this).parents('li').remove();
                    if($('#gambars li').length == 0){
                        pushuploader();
                    }
                }
                return false;
            })
            
            $('.selectpicture').live('click',function(){
                var par = $(this).parents('li');
                var idx = $('#gambars li').index(par);
                upload(idx);
                $('#filer').click();
                return false;
            });
            
            $('.selectmedia').live('click',function(){
                var a = this;
                var par = $(this).parents('li');
                var idx = $('#gambars li').index(par);
                
                $('#GeneralDialog').load('<?=site_url('media/multiselect')?>',{},function(){
                    var dlg = this;
                    $(dlg).dialog({
                        modal:true,
                        width:70+'%',
                        height:500,
                        show: 'clip',
                        title: 'Pilih Gambar',
                        buttons:{
                            "OK" : function(){
                                $('li input:checked',$(dlg)).each(function(){
                                    var conz =  '<li><img class="img-circle img-responsive img-thumbnail" src="<?=base_url()?>assets/images/media/'+$(this).attr('src')+'" />'+
                                                '<a href="#" class="deletephoto deletephoto">x</a>'+
                                                '<input type="hidden" name="MediaID[]" value="'+$(this).attr('mediaid')+'" /> </li>';
                                    $('#gambars').append(conz);
                                });
                                $(dlg).dialog('close');
                            },
                            "Batal" : function(){
                                $(dlg).dialog('close');
                            }
                        }
                    });
                })
                return false;
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
            
            
            
        });
	 
</script>

<?=$this -> load -> view('admin/footer') ?>