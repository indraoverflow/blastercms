<!DOCTYPE  html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
		<!--[if lt IE 9]>
		<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
		<![endif]-->

		<title><?php if(!empty($title)) echo $title," | " ?>Admin Page</title>

		<link href="<?=GetMediaPath(GetView('Ikon'))?>" rel="shortcut icon" type="image/png" />

		<script type="text/javascript" src="<?=base_url()?>assets/js/jquery-1.8.3.min.js"></script>
		<script type="text/javascript" src="<?=base_url()?>assets/basic/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=base_url()?>assets/js/jquery-ui-1.10.3.custom.min.js"></script>
		<script type="text/javascript" src="<?=base_url()?>assets/ckeditor/ckeditor.js"></script>
		<script type="text/javascript" src="<?=base_url()?>assets/ckeditor/adapters/jquery.js"></script>
		<script type="text/javascript" src="<?=base_url()?>assets/datatable/media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" src="<?=base_url()?>assets/superfish/js/hoverIntent.js"></script>
		<script type="text/javascript" src="<?=base_url()?>assets/superfish/js/superfish.js"></script>
		<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.form.js"></script>
		<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="<?=base_url()?>assets/js/function.js"></script>
		<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.tagsinput.js" charset="UTF-8"></script>

		<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.mjs.nestedSortable.js"></script>
		<script type="text/javascript" src="<?=base_url()?>assets/js/ui.dropdownchecklist-1.4-min.js"></script>
		<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.cookie.js"></script>

		<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/jquery.tagsinput.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/ui/jquery-ui-1.10.0.custom.css" />

		<link rel="stylesheet" media="screen" href="<?=base_url()?>assets/superfish/css/superfish.css">
		<link rel="stylesheet" media="screen" href="<?=base_url()?>assets/superfish/css/superfish-vertical.css">
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/datatable/media/css/demo_table_jui.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/datatable/media/css/demo_page.css" />

		<!-- Boostrec -->
		<link rel="stylesheet" href="<?=base_url()?>assets/basic/css/bootstrap.min.css" type="text/css"/>
		<link rel="stylesheet" href="<?=base_url()?>assets/basic/css/bootstrap-theme.min.css" type="text/css" />
		<!-- End Boostrec -->

		<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/new_style.css" />

		<script>

		</script>

		<style type="text/css">
			.sf-menu li.current {
				background: #8290a0;
				box-shadow: 0 0 3px rgba(0,0,0,0.5);
			}
			label.error{
				display: block;
			}
			label.error{
				background-image: linear-gradient(to bottom, #F2DEDE 0px, #E7C3C3 100%);
				background-repeat: repeat-x;
				border-color: #DCA7A7;
				box-shadow: 0 1px 0 rgba(255, 255, 255, 0.25) inset, 0 1px 2px rgba(0, 0, 0, 0.05);
				text-shadow: 0 1px 0 rgba(255, 255, 255, 0.2);
				padding: 3px 5px;
				font-weight: normal;
				color: #A94442;
				border-radius: 4px;
				background-color: #F2DEDE;
			}

			.fitur{
				display: none;
			}


			@media (max-width: 768px) {


			}
			@media (max-width: 991px) {

				#accor{
					display: none;
				}
				.short{
					display: none
				}
				.fitur{
					display: block;
				}
			}
		</style>


	</head>

	<body>
		<div class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a style="padding: 5px 15px" class="navbar-brand logo">
					<img height="40" src="<?=base_url().'assets/images/blaster.png'?>" />
				</a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="short nav navbar-nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><b class="glyphicon glyphicon-edit"></b> Buat Baru</a>
						<ul class="dropdown-menu">
							<li><?=anchor('post/add','Post')?></li>
							<li><?=anchor('page/add','Halaman')?></li>
							<li><?=anchor('category/add','Kategori')?></li>

						</ul>
					</li>
				</ul>

				<ul class="fitur nav navbar-nav">

					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><b class="glyphicon glyphicon-home"></b> Basic</a>
						<ul class="dropdown-menu">
							<li><?=anchor('admin','<b class="glyphicon glyphicon-dashboard"></b> Dashboard')?></li>
							<li><?=anchor('post/add','Post Baru')?></li>
							<li><?=anchor('post','Daftar Post')?></li>
							<li><?=anchor('page/add','Halaman Baru')?></li>
							<li><?=anchor('page','Daftar Halaman')?></li>
							<li><?=anchor('category/add','Kategori Baru')?></li>
							<li><?=anchor('category','Daftar Kategori')?></li>
							<li><?=anchor('comment','<b class="glyphicon glyphicon-comment"></b> Komentar')?></li>
						</ul>
					</li>

					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><b class="glyphicon glyphicon-gift"></b> Tampilan</a>
						<ul class="dropdown-menu">
							<li><?=anchor('themes','Daftar Tema')?></li>
							<li><?=anchor('view/logo','Logo & Ikon')?></li>
							<li><?=anchor('menu/addmaster','Menu Baru')?></li>
							<li><?=anchor('menu','Daftar Menu') ?></li>
							<li><?=anchor('slider/add','Slider Baru')?></li>
							<li><?=anchor('slider','Daftar Slider') ?></li>
							<li><?=anchor('widget/add','Widget Baru') ?></li>
							<li><?=anchor('widget','Daftar Widget') ?></li>
							<li><?=anchor('footer/add','Kolom Footer Baru') ?></li>
							<li><?=anchor('footer','Daftar Kolom Footer') ?></li>
						</ul>
					</li>

					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><b class="glyphicon glyphicon-picture"></b> Media</a>
						<ul class="dropdown-menu">
							<li><?=anchor('media/add','Media Baru')?></li>
							<li><?=anchor('media','Daftar Media')?></li>
						</ul>
					</li>

					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><b class="glyphicon glyphicon-user"></b> User</a>
						<ul class="dropdown-menu">
							<li><?=anchor('user/add','User Baru')?></li>
							<li><?=anchor('user','Daftar User')?></li>
							<li><?=anchor('subscriber/add','Subscriber Baru')?></li>
							<li><?=anchor('subscriber','Daftar Subscriber')?></li>
							<li><?=anchor('role/add','Role Baru')?></li>
							<li><?=anchor('role','Daftar Role')?></li>
							<li><?=anchor('admin/password','Ganti Password')?></li>
						</ul>
					</li>

					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><b class="glyphicon glyphicon-asterisk"></b> Pengaturan</a>
						<ul class="dropdown-menu">
							<li><?=anchor('setting/general','Umum')?></li>
							<li><?=anchor('setting/appearance','Tampilan')?></li>
							<li><?=anchor('setting/email','Email')?></li>
							<li><?=anchor('setting/url','URL Login')?></li>
							<li><?=anchor(site_url('notification/type/'.NOTIFTYPEGENERAL),'<b class="glyphicon glyphicon-envelope"></b> Notifikasi Umum')?></li>
						</ul>
					</li>
				</ul>

				<ul class="nav navbar-nav navbar-right" style="background: #E6EEFF">
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#"><b class="glyphicon glyphicon-user"></b> Hai,<?=GetAdminLogin('UserName')?></a>
						<ul class="dropdown-menu">
							<li><?=anchor(site_url('user/edit/'.GetAdminLogin('UserName')),'<b class="glyphicon glyphicon-user"></b> Profil')?></li>
							<li><?=anchor('admin/logout','<b class="glyphicon glyphicon-log-out"></b> Logout')?></li>
						</ul>
					</li>
					<div class="clearfix"></div>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
		</div>

		<div class="container contents">
			<section>
				<div class="col-md-2 menu-left">
					<div id="accor">
						<h3>Dashboard</h3>
						<div>
							<ul class="sf-menu sf-vertical adminMenu">
								<li><?=anchor('admin','Dashboard')?></li>
							</ul>
							<div class="clear"></div>
						</div>

						<h3>Services</h3>
						<div>
							<ul class="sf-menu sf-vertical adminMenu">
								<li><?=anchor('service/add','Service Baru')?></li>
								<li><?=anchor('service','Data Service')?></li>
							</ul>
							<div class="clear"></div>
						</div>

						<h3>Post</h3>
						<div>
							<ul class="sf-menu sf-vertical adminMenu">
								<li>
									<?=anchor('post','Post')?>
									<ul>
										<li><?=anchor('post/add','Post Baru')?></li>
										<li><?=anchor('post','Daftar Post')?></li>
									</ul>
								</li>
								<li>
									<?=anchor('category','Kategori')?>
									<ul>
										<li><?=anchor('category/add','Kategori Baru')?></li>
										<li><?=anchor('category','Daftar Kategori')?></li>
									</ul>
								</li>
							</ul>
							<div class="clear"></div>
						</div>

						<h3>Halaman</h3>
						<div>
							<ul class="sf-menu sf-vertical adminMenu">
								<li>
									<?=anchor('page','Halaman')?>
									<ul>
										<li><?=anchor('page/add','Halaman Baru')?></li>
										<li><?=anchor('page','Daftar Halaman')?></li>
									</ul>
								</li>
							</ul>
							<div class="clear"></div>
						</div>

						<h3>Komentar</h3>
						<div>
							<ul class="sf-menu sf-vertical adminMenu">
								<li>
									<?=anchor('comment','Daftar Komentar')?>
								</li>
							</ul>
							<div class="clear"></div>
						</div>

						<h3>Tampilan</h3>
						<div>
							<ul class="sf-menu sf-vertical adminMenu">
								<li><?=anchor('themes','Daftar Tema')?></li>
								<li><?=anchor('view/logo','Logo & Ikon')?></li>

								<li>
									<?=anchor('menu','Menu') ?>
									<ul>
										<li><?=anchor('menu/addmaster','Menu Baru')?></li>
										<li><?=anchor('menu','Daftar Menu') ?></li>
									</ul>
								</li>

								<li>
									<?=anchor('slider','Slider') ?>
									<ul>
										<li><?=anchor('slider/add','Slider Baru')?></li>
										<li><?=anchor('slider','Daftar Slider') ?></li>
									</ul>
								</li>

								<li>
									<?=anchor('widget','Widget') ?>
									<ul>
										<li><?=anchor('widget/add','Widget Baru') ?></li>
										<li><?=anchor('widget','Daftar Widget') ?></li>

									</ul>
								</li>

								<li>
									<?=anchor('footer','Kolom Footer') ?>
									<ul>
										<li><?=anchor('footer/add','Kolom Footer Baru') ?></li>
										<li><?=anchor('footer','Daftar Kolom Footer') ?></li>

									</ul>
								</li>
							</ul>
							<div class="clear"></div>
						</div>

						<h3>Media</h3>
						<div>
							<ul class="sf-menu sf-vertical adminMenu">
								<li>
									<?=anchor('media','Media')?>
									<ul>
										<li><?=anchor('media/add','Media Baru')?></li>
										<li><?=anchor('media','Daftar Media')?></li>
									</ul>
								</li>
							</ul>
							<div class="clear"></div>
						</div>

						<h3>User</h3>
						<div>
							<ul class="sf-menu sf-vertical adminMenu">
								<li>
									<?=anchor('user','User')?>
									<ul>
										<li><?=anchor('user/add','User Baru')?></li>
										<li><?=anchor('user','Daftar User')?></li>
									</ul>
								</li>
								<li>
									<?=anchor('subscriber','Subscriber')?>
									<ul>
										<li><?=anchor('subscriber/add','Subscriber Baru')?></li>
										<li><?=anchor('subscriber','Daftar Subscriber')?></li>
									</ul>
								</li>
								<li>
									<?=anchor('role','Role')?>
									<ul>
										<li><?=anchor('role/add','Role Baru')?></li>
										<li><?=anchor('role','Daftar Role')?></li>
									</ul>
								</li>
								<li><?=anchor('admin/password','Ganti Password')?></li>
							</ul>
							<div class="clear"></div>
						</div>

						<h3>Notifikasi</h3>
						<div>
							<ul class="sf-menu sf-vertical adminMenu">
								<li><?=anchor(site_url('notification/type/'.NOTIFTYPEGENERAL),'Notifikasi Umum')?></li>
							</ul>
							<div class="clear"></div>
						</div>

						<h3>Pengaturan</h3>
						<div>
							<ul class="sf-menu sf-vertical adminMenu">
								<li><?=anchor('setting/general','Umum')?></li>
								<li><?=anchor('setting/appearance','Tampilan')?></li>
								<li><?=anchor('setting/email','Email')?></li>
								<li><?=anchor('setting/url','URL Login')?></li>
							</ul>
							<div class="clear"></div>
						</div>
					</div>
				</div>

				<div class="col-md-10 content">


