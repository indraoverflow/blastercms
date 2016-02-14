<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">

	<title><?=(empty($title)) ? SITETITLE : $title." | ".SITETITLE ?></title>

	<link href="<?=GetMediaPath(GetView('Ikon'))?>" rel="shortcut icon" type="image/png" />

	<script type="text/javascript" src="<?=base_url()?>assets/template/js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/template/js/jquery-ui-1.10.0.custom.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/basic/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/template/js/layerslider.kreaturamedia.jquery-min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/template/js/jquery.jqzoom-core.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/template/js/jtwt.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/template/js/jquery.cycle.lite.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/template/js/jquery.nivo.slider.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.validate.min.js"></script>
	<script src="<?=base_url()?>assets/js/jquery.metisMenu.js"></script>
	<!-- SB Admin Scripts - Include with every page -->
	<script src="<?=base_url()?>assets/js/sb-admin.js"></script>
	<link rel="stylesheet" href="<?=base_url()?>assets/template/css/jquery-ui-1.10.0.custom.css" type="text/css" />
	<link rel="stylesheet" href="<?=base_url()?>assets/template/css/layerslider.css" type="text/css" />
	<link rel="stylesheet" href="<?=base_url()?>assets/template/css/nivo-slider.css" type="text/css" media="screen" charset="utf-8" />
	<link rel="stylesheet" href="<?=base_url()?>assets/template/css/themes/default/default.css" type="text/css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/basic/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/basic/css/bootstrap-theme.min.css" rel="stylesheet">
	<!-- Core CSS - Include with every page -->
	<link href="<?=base_url()?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">
	<!-- SB Admin CSS - Include with every page -->
	<link href="<?=base_url()?>assets/css/sb-admin.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/template/css/newstyle.css" />
	<link rel="stylesheet" type="text/css" href="<?=template_url()?>default.css" />
	<link rel="stylesheet" type="text/css" href="<?=template_url()?>style.css" />
</head>

<body>
	<div id="fb-root"></div>
	<header>
		<section class="topHeader">
			<div class="container">
				<div class="topBranchNav">
				</div>
				<ul>
					<li><i class="ir"></i><span>HOTLINE | </span> (061) 7777 7777</li>
					<li><i class="ir"></i>Mo-Fr 10:00 - 18:00 | Sa 10:00 - 16:00</li>
					<li><i class="ir"></i>guaindra@hotmail.com</li>
					<li class="sm-like">
					</li>
				</ul>
			</div>
		</section>

		<section class="mainHeader clearfix">
			<div class="container">
				<div class="logo">
					<?php if(GetMediaPath(GetView('Logo'))){ ?>
					<?php if(LOGOLINK){ ?>
					<a class="logo-general" href="<?=LOGOLINK?>" title="<?=SITETITLE?>">
						<?php } ?>
						<img height="56" src="<?=GetMediaPath(GetView('Logo'))?>" />
						<?php if(LOGOLINK){ ?>
					</a>
					<?php } ?>
					<?php }else{ ?>
					<h1 style="margin: 0"><?=SITETITLE?></h1>
					<p style="font-size: 1.2em"><?=SITEDESC?></p>
					<?php } ?>
				</div>
				<div class="headerMid">
					<div class="topLink">
						<?=PrintTopMenu()?>
					</div>
					<div class="search">
						<?=form_open(site_url('post/info'),array('method'=>'get','role'=>'form'))?>
						<div class="selecter searchCategory cover closed hidden">
							<div class="">
								<?php
								$cat = $this -> db -> get('categories');
								?>
								<select class="" name="category">
									<option value="0">All Category</option>
									<?=GetCombobox($cat, 'CategoryID', 'CategoryName')?>
								</select>
							</div>
						</div>
						<input type="search" name="s" placeholder="">
						<button type="submit"><i class="ir"></i></button>
						<?=form_close()?>
					</div>
				</div>
				<div class="headerRight">
					<div class="hidden">
						<?php if(IsUserLogin()){ ?>
						Hai <?=GetUserLogin('FirstName')?> | <?=anchor('user/logout','Logout')?>
						<?php }else{ ?>
						<?=anchor('user/register','<i class="glyphicon glyphicon-log-out"></i> Register',array('id' => 'UserRegister','class'=>'btn btn-info btn-sm'))?>
						<?=anchor('user/login','<i class="glyphicon glyphicon-log-in"></i> Login',array('id' => 'UserLogin','class'=>'btn btn-info btn-sm'))?>
						<?php } ?>
					</div>
				</div>
			</div>
		</section>
	</header>

	<div class="navbar navbar-default navweapper navphone" role="navigation">
		<div class="navbar-header logo-nav">
			<?php if(GetMediaPath(GetView('Logo'))){ ?>
			<?php if(LOGOLINK){ ?>
			<a href="<?=LOGOLINK?>" title="<?=SITETITLE?>">
				<?php } ?>
				<img class="navbar-brand" style="height: 50px" src="<?=GetMediaPath(GetView('Logo'))?>" />
				<?php if(LOGOLINK){ ?>
			</a>
			<?php } ?>
			<?php }?>

			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>

		<div class="navbar-collapse collapse">
			<div class="container">
				<ul class="nav navbar-nav">
					<?php PrintMenuBoos() ?>
				</ul>
			</div>

		</div>
	</div>

	<nav class="mainNav">
		<div class="container noPad">
			<ul class="main-nav-wrapper">
				<li class="mainNavCol nav2">
					<span class="toggle"><i class="ir"></i></span><a href="<?=GetCategoryURL('notebook')?>">Notebook</a>
					<div class="subNav">
						<div class="container">
							<div class="subNavCol">
								<ul>
									<li>
										<a href="<?=GetCategoryURL('casing-replacement')?>">Casing Replacement</a>
									</li>
									<li>
										<a href="<?=GetCategoryURL('battery-replacement')?>">Battery Replacement</a>
									</li>
									<li>
										<a href="<?=GetCategoryURL('keyboard-replacement')?>">Keyboard Replacement</a>
									</li>
									<li>
										<a href="<?=GetCategoryURL('adaptor-charger')?>">Adaptor Charger</a>
									</li>
									<li>
										<a href="<?=GetCategoryURL('laptop-fan')?>">Laptop Fan</a>
									</li>
									<li>
										<a href="<?=GetCategoryURL('lcd-replacement')?>">LCD Replacement</a>
									</li>
									<li>
										<a href="<?=GetCategoryURL('memory-ram')?>">Memory RAM</a>
									</li>
									<li>
										<a href="<?=GetCategoryURL('baterry-cell')?>">Baterry Cell</a>
									</li>
								</ul>
							</div>

						</div>
					</div>
				</li>
				<li class="mainNavCol nav3">
					<span class="toggle"><i class="ir"></i></span><a href="<?=GetCategoryURL('peripheral')?>">Peripheral</a>
				</li>
				<li class="mainNavCol nav4">
					<span class="toggle"><i class="ir"></i></span><a href="<?=GetCategoryURL('gadget')?>">Gadget</a>
				</li>
				<li class="mainNavCol nav5">
					<span class="toggle"><i class="ir"></i></span><a href="<?=GetCategoryURL('photography')?>">Photography</a>
				</li>
				<li class="mainNavCol nav6">
					<span class="toggle"><i class="ir"></i></span><a href="<?=GetCategoryURL('software')?>">Software</a>
				</li>
				<li class="mainNavCol nav7">
					<span class="toggle"><i class="ir"></i></span><a href="<?=GetCategoryURL('display')?>">Display</a>
				</li>
				<li class="mainNavCol nav8">
					<span class="toggle"><i class="ir"></i></span><a href="<?=GetCategoryURL('networking')?>">Networking</a>
				</li>
				<li class="mainNavCol nav9">
					<span class="toggle"><i class="ir"></i></span><a href="<?=GetCategoryURL('others')?>">Others</a>
				</li>
			</ul>
		</div>
	</nav>



	<div class="mainContent">
		<div class="container">




