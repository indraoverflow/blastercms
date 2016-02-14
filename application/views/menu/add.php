<?=form_open('menu/added',array('id'=>'file'))?>

<table width="100%">
	<tr>
		<td valign="top">Nama Menu</td>
		<td>
			<textarea id="MenuName" class="ckeditor" name="MenuName"></textarea>
		</td>
	</tr>
	<!-- <tr>
		<td>Icon</td>
		<td>
			<input type="file" name="userfile" id="userfile" />
			
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; atau &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			
			<a href="<?=site_url('media/select')?>" class="pilihmedia">Pilih dari media</a>
			<input type="hidden" id="MediaID" name="MediaID" value='' />
			<br /><br />
			<span class="uploadstatus"></span>
			<div class="success infomedia" style="display: none">
			
			<a href="#" class="removemedia">x</a>
			</div>
		</td>
	</tr> -->
	<tr>
		<td>Blink</td>
		<td>
			<input class="form-control" type="text" id="Blink" name="Blink" autofocus="" />
		</td>
	</tr>
	<tr>
		<td>URL</td>
		<td>
			<input class="form-control" type="text" id="MenuURL" name="MenuURL"  autofocus="" />
		</td>
	</tr>
	<tr>
		<td>Jenis Link</td>
		<td>
			<select id="LinkType" class="LinkType form-control" name="LinkType"  autofocus="" >
				<?php 
					foreach (GetLinkType() as $linktype) {
						?>
						<option value="<?=$linktype->LinkTypeID?>"><?=$linktype->LinkTypeName?></option>
						<?php
					}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td valign="top">Custom Sub Menu</td>
		<td>
			<textarea id="CustomSubMenu"></textarea>
		</td>
	</tr>
</table>
<?=form_close()?>

<script type="text/javascript">
	$(document).ready(function(){
		$('.pilihmedia').click(function(){
            var a = this;
            $('#GeneralDialog').load($(a).attr('href'),{},function(){
                var dlg = this;
                $(dlg).dialog({
                    modal:true,
                    width:70+'%',
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