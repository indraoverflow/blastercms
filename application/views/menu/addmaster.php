<?php $this->load->view('admin/header') ?>
	<style type="text/css">
		.placeholder {
			border: 1px dashed #4183C4;
			-webkit-border-radius: 3px;
			-moz-border-radius: 3px;
			border-radius: 3px;
		}

		.mjs-nestedSortable-error {
			background: #fbe3e4;
			border-color: transparent;
		}

		ul {
			margin: 0;
			padding: 0;
			padding-left: 30px;
		}

		ul.sortable, ul.sortable ul {
			margin: 0 0 0 25px;
			padding: 0;
			list-style-type: none;
		}

		ul.sortable {
			margin: 1em 0;
		}

		.sortable li {
			margin: 5px 0 0 0;
			padding: 0;
		}

		.sortable li div  {
			border: 1px solid #d4d4d4;
			-webkit-border-radius: 3px;
			-moz-border-radius: 3px;
			border-radius: 3px;
			border: 1px solid #CCC;
			padding: 7px;
			margin: 0;
			cursor: move;
			background: #f6f6f6;
			background: -moz-linear-gradient(top,  #ffffff 0%, #f6f6f6 47%, #ededed 100%);
			background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(47%,#f6f6f6), color-stop(100%,#ededed));
			background: -webkit-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#ededed 100%);
			background: -o-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#ededed 100%);
			background: -ms-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#ededed 100%);
			background: linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#ededed 100%);
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#ededed',GradientType=0 );
			font-weight: bold;
			color: #444;
		}
		.sortable li .edit{
			float: right;
		}
	</style>

<h2>Menu</h2>

<div style="background-color: #FFF;border-radius: 6px;box-shadow: 0 1px 2px rgba(0,0,0,0.3);padding: 15px 10px">

<?php
	if(validation_errors()){
		?>
			<div class="error"><?=validation_errors()?></div>
		<?php
	}
?>

<?php if($this->input->get('success') == 1){ ?>
<div class="success">
	Menu berhasil disimpan
</div>
<?php } ?>

<p><a href="#" class="tbh ui">+ Tambah Menu</a></p>
<div class="sumbermenu" style="display: none">
	<ul class="hormenu">
		<li><?=anchor('menu/add','+ Dari Link',array('class'=>'addMenu ui'))?></li>
		<li><?=anchor('menu/halaman','+ Dari Halaman',array('class'=>'addHalaman ui'))?></li>
		<li><?=anchor('menu/kategori','+ Dari Kategori',array('class'=>'addKategori ui'))?></li>
		<li><?=anchor('menu/berita','+ Dari Berita',array('class'=>'addBerita ui'))?></li>
		<li><?=anchor('menu/produk','+ Dari Produk',array('class'=>'addProduk ui'))?></li>
		<div class="clear"></div>	
	</ul>
</div>

<?=form_open('menu/addedmaster',array('id'=>'MenuForm'))?>

<h3>Nama Menu</h3>
<input style="width: 50%" type="text" id="MenuTitle" name="MenuTitle" class="required" />

<div id="MenuContainer" style="width: 98%; background: rgba(0,0,0,0.6)">
	<ul class="sortable">
		<div class="clear"></div>
	</ul>
</div>
<button type="submit" class="ui">Simpan</button> <img src="<?=base_url()?>assets/images/load.gif" class="load" style="display:none" />
<?=form_close()?>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		
		$('#MenuForm').submit(function(){
			if($('#MenuTitle').val()==""){
				alert('Silahkan isi nama menu');
				return false;
			}
			
			var serialized = $('ul.sortable').nestedSortable('serialize');
			var arraied = $('ul.sortable').nestedSortable('toArray', {startDepthCount: 0});
			$('.load').show();
			
			var $data = [];
			var idx;
			var obj;
			
			for (var i=1; i < arraied.length; i++) {
				idx = i - 1;
				obj = arraied[i].item_id+'^*'+arraied[i].parent_id+'^*'+$('#list_'+arraied[i].item_id).find('.MenuNames').eq(0).val()+'^*'+$('#list_'+arraied[i].item_id).find('.MenuURLs').eq(0).val()+'^*'+$('#list_'+arraied[i].item_id).find('.CustomSubMenus').eq(0).val()+'^*'+$('#list_'+arraied[i].item_id).find('.Blinks').eq(0).val()+'^*'+$('#list_'+arraied[i].item_id).find('.MediaIDs').eq(0).val()+'^*'+$('#list_'+arraied[i].item_id).find('.LinkTypes').eq(0).val();
				$data.push(obj);
			};
			
			$.post($(this).attr('action'),{'menus':$data,'MenuTitle':$('#MenuTitle').val(),'GadgetID':$('#GadgetID').val()},function(redirect){
				window.location.href = redirect;
			});
			return false;
			
			//$.post($(this).attr('action'),serialized+"&"+$(this).serialize(),function(redirect){
				//window.location.href = redirect;
			//});
		});
		
		$('ul.sortable').nestedSortable({
			disableNesting: 'no-nest',
			forcePlaceholderSize: true,
			handle: 'div',
			helper:	'clone',
			items: 'li',
			listType: 'ul',
			maxLevels: 3,
			opacity: .6,
			placeholder: 'placeholder',
			revert: 250,
			tabSize: 25,
			tolerance: 'pointer',
			toleranceElement: '> div'
		});

		$('.addMenu').click(function(){
			var a = this;
			$('#GeneralDialog').load('<?=site_url('menu/add')?>',{'edit':0},function(){
				if (CKEDITOR.instances['CustomSubMenu']) {
				    CKEDITOR.remove(CKEDITOR.instances['CustomSubMenu']);
				}
				$('#GeneralDialog').find('#CustomSubMenu').ckeditor();
				if (CKEDITOR.instances['MenuName']) {
				    CKEDITOR.remove(CKEDITOR.instances['MenuName']);
				}
				$('#GeneralDialog').find('#MenuName').ckeditor();
				$(this).dialog({
					buttons : {
						"OK" : function(){
							if($('#MenuName').val()==""){
								alert('Silahkan isi nama menu');
								return;
							}
							if($('#MenuURL').val()==""){
								alert('Silahkan isi URL');
								return;
							}
							var next = 0;
					$('li',$('.sortable')).each(function(){
						if($(this).attr('id').substr(5) > next){
							next = $(this).attr('id').substr(5);
						}
					});
					next = parseInt(next) + 1;
							var cont = '<li id="list_'+next+'"><div>'+
								'<span class="menuTitle">'+$('#MenuName').val()+'</span>'+
								'<span class="edit">'+
									'<a href="#" class="editMenu">edit</a> | <a class="hapusmenu" href="#">hapus</a>'+
									'<input type="hidden" name="MenuName[]" value="'+$('#MenuName').val()+'" class="MenuNames" />'+
									'<input type="hidden" class="MenuID" value="'+next+'" name="MenuID[]">'+
									'<input type="hidden" class="ParentID" value="" name="ParentID[]">'+
									'<input type="hidden" name="Blink[]" value="'+$('#Blink').val()+'" class="Blinks" />'+
									'<input type="hidden" name="MediaID[]" value="'+$('#MediaID').val()+'" class="MediaIDs" />'+
									'<input type="hidden" name="LinkType[]" value="'+$('#LinkType').val()+'" class="LinkTypes" />'+
									'<input type="hidden" name="MenuURL[]" value="'+$('#MenuURL').val()+'" class="MenuURLs" />'+
								'</span></div><ul></ul>'
							'</li>';
							$('#MenuContainer ul').eq(0).append(cont);
							activateedit();
							activatehapus();
							$(this).dialog('close');
						},
						"Batal" : function(){
							$(this).dialog('close');
						}
					},
					'width' : '90%',
					'height' : 500,
					"title" : "Menu Baru",
					"modal" : true
				});
			});
			return false;
		});
		
		$('.addBerita').click(function(){
			var a = this;
			$('#GeneralDialog').load($(a).attr('href'),{'edit':0},function(){
				var dial = this;
				$(this).dialog({
					buttons : {
						"Batal" : function(){
							$(this).dialog('close');
						}
					},
					'width' : 800,
					'height' : 400,
					"title" : "Pilih Berita",
					"modal" : true
				});
				
				$('.pilihberita').click(function(){
					var next = 0;
					$('li',$('.sortable')).each(function(){
						if($(this).attr('id').substr(5) > next){
							next = $(this).attr('id').substr(5);
						}
					});
					next = parseInt(next) + 1;
					var cont = '<li class="" id="list_'+next+'"><div>'+
								'<span class="menuTitle">'+$(this).attr('title')+'</span>'+
								'<span class="edit">'+
									'<a href="#" class="editMenu">edit</a> | <a class="hapusmenu" href="#">hapus</a>'+
									'<input type="hidden" name="MenuName[]" value="'+$(this).attr('title')+'" class="MenuNames" />'+
									'<input type="hidden" class="MenuID" value="'+next+'" name="MenuID[]">'+
									'<input type="hidden" class="ParentID" value="" name="ParentID[]">'+
									'<input type="hidden" name="Blink[]" value="" class="Blinks" />'+
									'<input type="hidden" name="MediaID[]" value="" class="MediaIDs" />'+
									'<input type="hidden" name="LinkType[]" value="<?=LINKTYPEGENERAL?>" class="LinkTypes" />'+
									'<input type="hidden" name="MenuURL[]" value="'+$(this).attr('link')+'" class="MenuURLs" />'+
								'</span></div><ul></ul>'
							'</li>';
					$('#MenuContainer ul').eq(0).append(cont);
					activateedit();
					activatehapus();
					$(dial).dialog('close');
					return false;
				});
			});
			return false;
		});
		
		$('.addHalaman').click(function(){
			var a = this;
			$('#GeneralDialog').load($(a).attr('href'),{'edit':0},function(){
				$('#GeneralDialog').find('#cekbox').change(function(){
					var aa = $(this);
					if(aa.attr('checked')){
						$('#GeneralDialog').find('.cekbox').attr('checked',true);
					}else{
						$('#GeneralDialog').find('.cekbox').attr('checked',false);
					}
				});
				var dial = this;
				$(this).dialog({
					buttons : {
						"OK" : function(){
							$(this).find('.cekbox:checked').each(function(i,elm){
								var next = 0;
								$('li',$('.sortable')).each(function(){
									if( parseInt($(this).attr('id').substr(5)) > parseInt(next) ){
										next = $(this).attr('id').substr(5);
									}
								});
								next = parseInt(next) + 1;
								var cont = '<li class="" id="list_'+next+'"><div>'+
											'<span class="menuTitle">'+$(this).attr('title')+'</span>'+
											'<span class="edit">'+
												'<a href="#" class="editMenu">edit</a> | <a class="hapusmenu" href="#">hapus</a>'+
												'<input type="hidden" name="MenuName[]" value="'+$(this).attr('title')+'" class="MenuNames" />'+
												'<input type="hidden" class="MenuID" value="'+next+'" name="MenuID[]">'+
												'<input type="hidden" name="MenuURL[]" value="'+$(this).attr('link')+'" class="MenuURLs" />'+
												'<input type="hidden" name="Blink[]" value="" class="Blinks" />'+
												'<input type="hidden" name="MediaID[]" value="" class="MediaIDs" />'+
												'<input type="hidden" name="LinkType[]" value="<?=LINKTYPEGENERAL?>" class="LinkTypes" />'+
												'<textarea style="display:none" class="CustomSubMenus" name="CustomSubMenu[]"></textarea>'+
											'</span></div><ul></ul>'
										'</li>';
								$('#MenuContainer ul').eq(0).append(cont);
							});
							activateedit();
							activatehapus();
							$(this).dialog('close');
						},
						"Batal" : function(){
							$(this).dialog('close');
						}
					},
					'width' : 800,
					'height' : 400,
					"title" : "Pilih Halaman",
					"modal" : true
				});
				
				$('.pilihberita').click(function(){
					var next = 0;
					$('li',$('.sortable')).each(function(){
						if($(this).attr('id').substr(5) > next){
							next = $(this).attr('id').substr(5);
						}
					});
					next = parseInt(next) + 1;
					var cont = '<li class="" id="list_'+next+'"><div>'+
								'<span class="menuTitle">'+$(this).attr('title')+'</span>'+
								'<span class="edit">'+
									'<a href="#" class="editMenu">edit</a> | <a class="hapusmenu" href="#">hapus</a>'+
									'<input type="hidden" name="MenuName[]" value="'+$(this).attr('title')+'" class="MenuNames" />'+
									'<input type="hidden" class="MenuID" value="'+next+'" name="MenuID[]">'+
									'<input type="hidden" class="ParentID" value="" name="ParentID[]">'+
									'<input type="hidden" name="Blink[]" value="" class="Blinks" />'+
									'<input type="hidden" name="MediaID[]" value="" class="MediaIDs" />'+
									'<input type="hidden" name="LinkType[]" value="<?=LINKTYPEGENERAL?>" class="LinkTypes" />'+
									'<input type="hidden" name="MenuURL[]" value="'+$(this).attr('link')+'" class="MenuURLs" />'+
								'</span></div><ul></ul>'
							'</li>';
					$('#MenuContainer ul').eq(0).append(cont);
					activateedit();
					activatehapus();
					$(dial).dialog('close');
					return false;
				});
			});
			return false;
		});
		
		$('.addProduk').click(function(){
			var a = this;
			$('#GeneralDialog').load($(a).attr('href'),{'edit':0},function(){
				var dial = this;
				$(this).dialog({
					buttons : {
						"Batal" : function(){
							$(this).dialog('close');
						}
					},
					'width' : 800,
					'height' : 400,
					"title" : "Pilih Halaman",
					"modal" : true
				});
				
				$('.pilihberita').click(function(){
					var next = 0;
					$('li',$('.sortable')).each(function(){
						if($(this).attr('id').substr(5) > next){
							next = $(this).attr('id').substr(5);
						}
					});
					
					next = parseInt(next) + 1;
					var cont = '<li class="" id="list_'+next+'"><div>'+
								'<span class="menuTitle">'+$(this).attr('title')+'</span>'+
								'<span class="edit">'+
									'<a href="#" class="editMenu">edit</a> | <a class="hapusmenu" href="#">hapus</a>'+
									'<input type="hidden" name="MenuName[]" value="'+$(this).attr('title')+'" class="MenuNames" />'+
									'<input type="hidden" class="MenuID" value="'+next+'" name="MenuID[]">'+
									'<input type="hidden" class="ParentID" value="" name="ParentID[]">'+
									'<input type="hidden" name="Blink[]" value="" class="Blinks" />'+
									'<input type="hidden" name="MediaID[]" value="" class="MediaIDs" />'+
									'<input type="hidden" name="LinkType[]" value="<?=LINKTYPEGENERAL?>" class="LinkTypes" />'+
									'<input type="hidden" name="MenuURL[]" value="'+$(this).attr('link')+'" class="MenuURLs" />'+
								'</span></div><ul></ul>'
							'</li>';
					$('#MenuContainer ul').eq(0).append(cont);
					activateedit();
					activatehapus();
					$(dial).dialog('close');
					return false;
				});
			});
			return false;
		});
		
		$('.addKategori').click(function(){
			var a = this;
			$('#GeneralDialog').load($(a).attr('href'),{'edit':0},function(){
				$('#GeneralDialog').find('#cekbox').change(function(){
					var aa = $(this);
					if(aa.attr('checked')){
						$('#GeneralDialog').find('.cekbox').attr('checked',true);
					}else{
						$('#GeneralDialog').find('.cekbox').attr('checked',false);
					}
				});
				var dial = this;
				$(this).dialog({
					buttons : {
						"OK" : function(){
							$(this).find('.cekbox:checked').each(function(i,elm){
								var next = 0;
								$('li',$('.sortable')).each(function(){
									if( parseInt($(this).attr('id').substr(5)) > parseInt(next) ){
										next = $(this).attr('id').substr(5);
									}
								});
								next = parseInt(next) + 1;
								var cont = '<li class="" id="list_'+next+'"><div>'+
											'<span class="menuTitle">'+$(this).attr('title')+'</span>'+
											'<span class="edit">'+
												'<a href="#" class="editMenu">edit</a> | <a class="hapusmenu" href="#">hapus</a>'+
												'<input type="hidden" name="MenuName[]" value="'+$(this).attr('title')+'" class="MenuNames" />'+
												'<input type="hidden" class="MenuID" value="'+next+'" name="MenuID[]">'+
												'<input type="hidden" name="MenuURL[]" value="'+$(this).attr('link')+'" class="MenuURLs" />'+
												'<input type="hidden" name="Blink[]" value="" class="Blinks" />'+
												'<input type="hidden" name="MediaID[]" value="" class="MediaIDs" />'+
												'<input type="hidden" name="LinkType[]" value="<?=LINKTYPEGENERAL?>" class="LinkTypes" />'+
												'<textarea style="display:none" class="CustomSubMenus" name="CustomSubMenu[]"></textarea>'+
											'</span></div><ul></ul>'
										'</li>';
								$('#MenuContainer ul').eq(0).append(cont);
							});
							activateedit();
							activatehapus();
							$(this).dialog('close');
						},
						"Batal" : function(){
							$(this).dialog('close');
						}
					},
					'width' : 800,
					'height' : 400,
					"title" : "Pilih Kategori",
					"modal" : true
				});
				
				$('.pilihberita').click(function(){
					var next = 0;
					$('li',$('.sortable')).each(function(){
						if($(this).attr('id').substr(5) > next){
							next = $(this).attr('id').substr(5);
						}
					});
					next = parseInt(next) + 1;
					var cont = '<li class="" id="list_'+next+'"><div>'+
								'<span class="menuTitle">'+$(this).attr('title')+'</span>'+
								'<span class="edit">'+
									'<a href="#" class="editMenu">edit</a> | <a class="hapusmenu" href="#">hapus</a>'+
									'<input type="hidden" name="MenuName[]" value="'+$(this).attr('title')+'" class="MenuNames" />'+
									'<input type="hidden" class="MenuID" value="'+next+'" name="MenuID[]">'+
									'<input type="hidden" class="ParentID" value="" name="ParentID[]">'+
									'<input type="hidden" name="Blink[]" value="" class="Blinks" />'+
									'<input type="hidden" name="MediaID[]" value="" class="MediaIDs" />'+
									'<input type="hidden" name="LinkType[]" value="<?=LINKTYPEGENERAL?>" class="LinkTypes" />'+
									'<input type="hidden" name="MenuURL[]" value="'+$(this).attr('link')+'" class="MenuURLs" />'+
								'</span></div><ul></ul>'
							'</li>';
					$('#MenuContainer ul').eq(0).append(cont);
					activateedit();
					activatehapus();
					$(dial).dialog('close');
					return false;
				});
			});
			return false;
		});
		
		function activateedit(){
			$('.editMenu').unbind().click(function(){
				var a = this;
				var idx = $('.editMenu').index(this);
				$('#GeneralDialog').load('<?=site_url('menu/add')?>',{'edit':1},function(){
					if (CKEDITOR.instances['CustomSubMenu']) {
					    CKEDITOR.remove(CKEDITOR.instances['CustomSubMenu']);
					}
					$('#GeneralDialog').find('#CustomSubMenu').ckeditor();
					if (CKEDITOR.instances['MenuName']) {
					    CKEDITOR.remove(CKEDITOR.instances['MenuName']);
					}
					$('#GeneralDialog').find('#MenuName').ckeditor();
					$('#MenuName').val($('.MenuNames').eq(idx).val());
					$('#MenuURL').val($('.MenuURLs').eq(idx).val());
					$('#CustomSubMenu').val($('.CustomSubMenus').eq(idx).val());
					$('#Blink').val($('.Blinks').eq(idx).val());
					$('#MediaID').val($('.MediaIDs').eq(idx).val());
					$('#LinkType').val($('.LinkTypes').eq(idx).val());
					
					$.ajax({
						url : '<?=site_url('media/getjsondetail')?>',
						data: {'id':$('.MediaIDs').eq(idx).val()},
						type: 'post',
						dataType: 'json'
					}).done(function(data){
						if(data!="no" && data!=""){
							$('.infomedia',dlg).html('<img src="<?=base_url()?>assets/images/media/'+data.MediaPath+'" width="100" /> <br />Gambar sudah dipilih <strong>'+data.MediaPath+'</strong>.').show();
							$('.uploadstatus',dlg).empty();
							//input.val('');
						}
					});
										
					var dlg = $(this);
					$(this).dialog({
						buttons : {
							"OK" : function(){
								if($('#MenuName').val()==""){
									alert('Silahkan isi nama menu');
									return;
								}
								if($('#MenuURL').val()==""){
									alert('Silahkan isi URL');
									return;
								}
								
								$('.MenuNames').eq(idx).val($('#MenuName').val());
								$('.menuTitle').eq(idx).html($('#MenuName').val());
								$('.MenuURLs').eq(idx).val($('#MenuURL').val());
								$('.CustomSubMenus').eq(idx).val($('#CustomSubMenu').val());
								$('.Blinks').eq(idx).val($('#Blink').val());
								$('.MediaIDs').eq(idx).val($('#MediaID').val());
								$('.LinkTypes').eq(idx).val($('#LinkType').val());
																
								$(this).dialog('close');
							},
							"Batal" : function(){
								$(this).dialog('close');
							}
						},
						"title" : "Ubah Menu",
						"modal" : true,
						"width" : '90%',
						"height" : 500
					});
				});
				return false;
			});
		}
		activateedit();
		function activatehapus(){
			$('.hapusmenu').unbind().click(function(){
				var yakin = confirm('Apa anda yakin?');
				if(yakin){
					$(this).closest('li').fadeOut(500,function(){
						$(this).remove();
					});
				}
			});
		}
		activatehapus();
		
		var sumberopen = 0;
		$('.tbh').click(function(){
			if(sumberopen == 0){
				$('.sumbermenu').slideDown();
				sumberopen = 1;
			}else{
				$('.sumbermenu').slideUp();
				sumberopen = 0;
			}
		});
	});
</script>
<?php $this->load->view('admin/footer') ?>