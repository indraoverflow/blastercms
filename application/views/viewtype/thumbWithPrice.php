<?php if(!empty($catname)){ ?>
<div class="viewType">	
<h2 class="viewtype-title page-header"><?= $catname ?></h2>
<div class="clear"></div>


<?php } ?>

<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="<?=base_url()?>assets/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>

<!-- Add fancyBox -->
<link rel="stylesheet" href="<?=base_url()?>assets/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<script type="text/javascript" src="<?=base_url()?>assets/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>

<!-- Optionally add helpers - button, thumbnail and/or media -->
<link rel="stylesheet" href="<?=base_url()?>assets/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
<script type="text/javascript" src="<?=base_url()?>assets/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
<script type="text/javascript" src="<?=base_url()?>assets/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>

<link rel="stylesheet" href="<?=base_url()?>assets/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
<script type="text/javascript" src="<?=base_url()?>assets/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

<?php if($model->num_rows()<1){ ?>
<div class="alert alert-warning alert-dismissable">
    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
    Data tidak tersedia.
</div>
<?php }?>


<?php
	if(isset($col)){
		if($col==2){
			$kotak = 6;
		}else if($col==3){
			$kotak = 4;
		}else if($col==4){
			$kotak = 3;
		}else if($col==6){
			$kotak = 2;
		}else{
			
		}
		#$kotak = 12/$countzz;	
	}else{
		$kotak = 3;
	}
	
?>


<?php
    foreach ($model->result() as $post) {
        $media = $this->db->where('MediaID',$post->MediaID)->get('media')->row();
		
		$statusbarang = $this -> db -> where('PostID',$post->PostID) -> get('postcategories');
		$statbrg = '';
		$txtsb = '';
		foreach ($statusbarang->result() as $sb) {
			if($sb -> CategoryID == 17){
				$statbrg =  "Baru";
				$txtsb = 'text-success';
			}
			if($sb -> CategoryID == 18){
				$statbrg = "Bekas";
				$txtsb = 'text-warning';
			}
		} 
		
		
?>
<div class="vt col-xs-4 col-sm-<?=$kotak?>">
<div class="viewtypethumbs">
    
<?php
    if (empty($media)) {
        $pic = base_url() . "assets/images/no-image.png";
    } else {
        $pic = $media -> MediaFullPath;
    }
?>

    <a href="<?=$pic?>" class="fancybox" data-fancybox-group="gallery" title="<?=strip_tags($post->PostTitle)?>"> 
        <div class="imgcontainer img img-responsive">
        <?php if(empty($media)){ ?>
            <img align="center" class="img-thumbnail" src="<?=base_url()?>assets/images/no-image.png" />
        <?php }else{ ?>
            <img align="center" class="img-thumbnail" src="<?=$media->MediaFullPath?>" />
        <?php } ?>
        </div>
    </a>
    
    <!-- <p class="waktu">
        <?=date('D, d M Y', strtotime($post -> PostDate))?>
    </p> -->        
    <div class="clearfix"></div>
    <h4 class="judul">
        <?=anchor(site_url('post/view/'.$post->PostSlug),$post->PostTitle)?>
    </h4>
    
    <div class="priceN">
    	<?=$post->DiscountUntil>date('Y-m-d')?$post->DiscountPrice?rupiah($post->Price):'':''?>
    </div>
    
    <div class="price">
    	<?php
	    	if($post->DiscountPrice){
	    		if($post->DiscountUntil > date('Y-m-d')){
	    			echo anchor(site_url('post/view/'.$post->PostSlug),rupiah($post->DiscountPrice));	
	    		}else{
	    			echo anchor(site_url('post/view/'.$post->PostSlug),rupiah($post->Price));		
	    		}
	    		
	    	}else{
	    		echo anchor(site_url('post/view/'.$post->PostSlug),rupiah($post->Price));	
	    	}
    	?>
    </div>
    
    <p class="statusBarang text-center <?=$txtsb?>">
    	<?=$statbrg?>
    </p>
    <div class="clear"></div>
    <!-- <div class="clearfix"></div> -->

</div>
<!-- <div class="clearfix"></div> -->
</div>
<?php } ?>
<br />
<div class="clearfix"></div>
</div>
<div class="clearfix"></div>
<?php if(!isset($nopagination)){ ?>
    <?php if($exist){ ?>
        <?= PrintPagination($page, $pagenum, current_url(),2) ?>
    <?php } ?>
<?php } ?>

<script type="text/javascript">
    $(document).ready(function() {
        //$('.fancybox').fancybox();
        
        $('.fancybox').fancybox({
                //prevEffect : 'none',
                //nextEffect : 'none',

                closeBtn  : true,
                arrows    : true,
                nextClick : true,

                helpers : {
                    thumbs : {
                        width  : 50,
                        height : 50
                    }
                }
            });
        
    });
</script>