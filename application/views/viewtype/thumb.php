<?php if(!empty($catname)){ ?>
<h2 class="viewtype-title"><?= $catname ?></h2>
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



<?php
    foreach ($model->result() as $post) {
        $media = $this->db->where('MediaID',$post->MediaID)->get('media')->row();
?>

<div class="viewtypethumbs">
    <h2 class="judul">
        <?=anchor(site_url('post/view/'.$post->PostSlug),$post->PostTitle)?>    
    </h2>
<?php
    if (empty($media)) {
        $pic = base_url() . "assets/images/no-image.png";
    } else {
        $pic = $media -> MediaFullPath;
    }
?>

    <a href="<?=$pic?>" class="fancybox" data-fancybox-group="gallery" title="<?=strip_tags($post->PostTitle)?>"> 
        <div class="imgcontainer" style="text-align: center; float: left; border: 1px solid #CCC; margin-right: 10px;">
        <?php if(empty($media)){ ?>
            <img align="center" src="<?=base_url()?>assets/images/no-image.png" />
        <?php }else{ ?>
            <img align="center" src="<?=$media->MediaFullPath?>" />
        <?php } ?>
        </div>
    </a>
    
    <!-- <p class="waktu">
        <?=date('D, d M Y', strtotime($post -> PostDate))?>
    </p> -->        
    
    <p class="content">
        <?=word_limiter(strip_tags(strip_shortcode(parse_form($post->PostContent))),20)?>
    </p>

    <div class="btn-container">
        <?=anchor(site_url('post/view/'.$post->PostSlug),"Read More",array('class'=>'ui readmore'))?>
    </div>
    <div class="clear"></div>

</div>

<?php } ?>
<br />
<?php if(!isset($nopagination)){ ?>
    <?php if($exist){ ?>
        <?= PrintPagination($page, $pagenum, current_url()) ?>
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