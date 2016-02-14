<?php $this->load->view('admin/header') ?>

<h2>Menu</h2>

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

<?=form_open('menu/save')?>
<div id="MenuContainer">
	<ul id="Sort">
		<?php
			$id = 0;
			foreach ($menus->result() as $menu){
		?>
		<li id="<?=$menu->MenuID?>">
			<span class="menuTitle"><?=$menu->MenuName?></span>
			<span class="edit"><a class="editMenu" href="#">edit</a> | <a class="hapusmenu" href="#">hapus</a>
				<input type="hidden" class="MenuNames" value="<?=$menu->MenuName?>" name="MenuName[]">
				<input type="hidden" class="MenuID" value="<?=$menu->MenuID?>" name="MenuID[]">
				<input type="hidden" class="ParentID" value="0" name="ParentID[]">
				<input type="hidden" class="MenuURLs" value="<?=$menu->URL?>" name="MenuURL[]">
			</span>
			<?php
				GetChild($menu->MenuID);
			?>
		</li>
		<?php
			}
		?>
		<div class="clear"></div>
	</ul>
</div>
<button type="submit" class="ui">Simpan</button>
<?=form_close()?>

<script type="text/javascript">
	$(document).ready(function(){
		$('#MenuContainer ul').sortable({
	           connectWith: "#MenuContainer ul",
	           placeholder: "ui-state-highlight",
	           stop: function(e,ui){
	           		var parent = ui.item.parents('li').attr('id');
	           		if(typeof(parent) == "undefined"){
	           			$('.ParentID',ui.item).val(0);
	           		}else{
	           			$('.ParentID',ui.item).val(parent);
	           		}
	           }
        });
        
		$('.addMenu').click(function(){
			var a = this;
			$('#GeneralDialog').load('<?=site_url('menu/add')?>',{'edit':0},function(){
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
					$('li',$('#MenuContainer')).each(function(){
						if($(this).attr('id') > next){
							next = $(this).attr('id');
						}
					});
					next = parseInt(next) + 1;
							var cont = '<li class="">'+
								'<span class="menuTitle">'+$('#MenuName').val()+'</span>'+
								'<span class="edit">'+
									'<a href="#" class="editMenu">edit</a> | <a class="hapusmenu" href="#">hapus</a>'+
									'<input type="hidden" name="MenuName[]" value="'+$('#MenuName').val()+'" class="MenuNames" />'+
									'<input type="hidden" class="MenuID" value="'+next+'" name="MenuID[]">'+
									'<input type="hidden" class="ParentID" value="" name="ParentID[]">'+
									'<input type="hidden" name="MenuURL[]" value="'+$('#MenuURL').val()+'" class="MenuURLs" />'+
								'</span><ul></ul>'
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
					'width' : 430,
					'height' : 200,
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
					$('li',$('#MenuContainer')).each(function(){
						if($(this).attr('id') > next){
							next = $(this).attr('id');
						}
					});
					next = parseInt(next) + 1;
					var cont = '<li class="">'+
								'<span class="menuTitle">'+$(this).attr('title')+'</span>'+
								'<span class="edit">'+
									'<a href="#" class="editMenu">edit</a> | <a class="hapusmenu" href="#">hapus</a>'+
									'<input type="hidden" name="MenuName[]" value="'+$(this).attr('title')+'" class="MenuNames" />'+
									'<input type="hidden" class="MenuID" value="'+next+'" name="MenuID[]">'+
									'<input type="hidden" class="ParentID" value="" name="ParentID[]">'+
									'<input type="hidden" name="MenuURL[]" value="'+$(this).attr('link')+'" class="MenuURLs" />'+
								'</span><ul></ul>'
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
					$('li',$('#MenuContainer')).each(function(){
						if($(this).attr('id') > next){
							next = $(this).attr('id');
						}
					});
					next = parseInt(next) + 1;
					var cont = '<li class="">'+
								'<span class="menuTitle">'+$(this).attr('title')+'</span>'+
								'<span class="edit">'+
									'<a href="#" class="editMenu">edit</a> | <a class="hapusmenu" href="#">hapus</a>'+
									'<input type="hidden" name="MenuName[]" value="'+$(this).attr('title')+'" class="MenuNames" />'+
									'<input type="hidden" class="MenuID" value="'+next+'" name="MenuID[]">'+
									'<input type="hidden" class="ParentID" value="" name="ParentID[]">'+
									'<input type="hidden" name="MenuURL[]" value="'+$(this).attr('link')+'" class="MenuURLs" />'+
								'</span><ul></ul>'
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
					$('li',$('#MenuContainer')).each(function(){
						if($(this).attr('id') > next){
							next = $(this).attr('id');
						}
					});
					
					next = parseInt(next) + 1;
					var cont = '<li class="">'+
								'<span class="menuTitle">'+$(this).attr('title')+'</span>'+
								'<span class="edit">'+
									'<a href="#" class="editMenu">edit</a> | <a class="hapusmenu" href="#">hapus</a>'+
									'<input type="hidden" name="MenuName[]" value="'+$(this).attr('title')+'" class="MenuNames" />'+
									'<input type="hidden" class="MenuID" value="'+next+'" name="MenuID[]">'+
									'<input type="hidden" class="ParentID" value="" name="ParentID[]">'+
									'<input type="hidden" name="MenuURL[]" value="'+$(this).attr('link')+'" class="MenuURLs" />'+
								'</span><ul></ul>'
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
				var dial = this;
				$(this).dialog({
					buttons : {
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
					$('li',$('#MenuContainer')).each(function(){
						if($(this).attr('id') > next){
							next = $(this).attr('id');
						}
					});
					next = parseInt(next) + 1;
					var cont = '<li class="">'+
								'<span class="menuTitle">'+$(this).attr('title')+'</span>'+
								'<span class="edit">'+
									'<a href="#" class="editMenu">edit</a> | <a class="hapusmenu" href="#">hapus</a>'+
									'<input type="hidden" name="MenuName[]" value="'+$(this).attr('title')+'" class="MenuNames" />'+
									'<input type="hidden" class="MenuID" value="'+next+'" name="MenuID[]">'+
									'<input type="hidden" class="ParentID" value="" name="ParentID[]">'+
									'<input type="hidden" name="MenuURL[]" value="'+$(this).attr('link')+'" class="MenuURLs" />'+
								'</span><ul></ul>'
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
					$('#MenuName').val($('.MenuNames').eq(idx).val());
					$('#MenuURL').val($('.MenuURLs').eq(idx).val());
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
								
								$(this).dialog('close');
							},
							"Batal" : function(){
								$(this).dialog('close');
							}
						},
						"title" : "Ubah Menu",
						"modal" : true
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