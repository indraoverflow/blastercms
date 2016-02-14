<?php
$statusbarang = $this -> db -> where('PostID',$model->PostID) -> get('postcategories');
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


<div class="product">
	
<h2 class="page-header"><?=$model->PostTitle?></h2>

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

<script type="text/javascript" src="<?=base_url() ?>assets/js/jquery.bxGallery.1.1.min.js"></script>

<style type="text/css" media="screen">
	.mainContent{
		margin-bottom: 0px;
	}
</style>

<?php if(ALLOWSHARE){ ?>
    <p>
    <!-- AddThis Smart Layers BEGIN -->
    <!-- Go to http://www.addthis.com/get/smart-layers to customize -->
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-524b22b515663e7b"></script>
    <script type="text/javascript">
      addthis.layers({
        'theme' : 'gray',
        'share' : {
          'position' : 'left',
          'numPreferredServices' : 5
        },  
        'whatsnext' : {},  
        'recommended' : {} 
      });
    </script>
    <!-- AddThis Smart Layers END -->
    </p>
<?php } ?>


	<div class="col-sm-4">
        <ul id="Gambar">
            <?php if($media->MediaPath){ ?> 
                <li><img src="<?=$media->MediaFullPath?>" title="" /></li>
            <?php } ?>
            <?php
                foreach ($images->result() as $image) {
                    ?>
                    <li><img src="<?=$image->MediaFullPath?>" title="" /></li>
                    <?php
                }
            ?>
        </ul>
        <div class="clearfix"></div>
	</div>
	
	<div class="col-sm-5 detailInfo">
		<div class="panel panel-default">
			<div class="panel-heading">
				Detail Information
			</div>
			<div class="panel-body">
				<table class="table table-responsive table-hover table-striped">
					<tbody>
					<tr>
						<td>SKU</td>
						<td>: <b><?=$model->SKU?></b></td>
					</tr>
					<tr>
						<td>Shipping Weight</td>
						<td>: <?=$model->Weight?> Kg</td>
					</tr>
					<tr>
						<td>Warranty</td>
						<td>: <?=$model->Warranty?></td>
					</tr>
					<tr>
						<td>Stok
							
							</td>
						<td>: <?=$model->Warranty?'Tersedia':'<font color="red">Tidak Tersedia</font>'?></td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	<div class="col-sm-3">
		<p class="statusBarang-dv text-center <?=$txtsb?>">
	    	<?=$statbrg?>
	    </p>
		<div class="">
			<?php if($model->DiscountPrice){ 
					if($model->DiscountUntil > date('Y-m-d')){ ?>
						<div class="price-line">
	                        <span class="price-label">Normal</span>
	                        <span class="price-false"><?=rupiah($model->Price)?></span>
	                    </div>
	                    <div class="price-final">
	                    	<?=rupiah($model->DiscountPrice)?>
	                    </div>
	                    <div class="DiscountUntil">
	                    	Diskon sampai : <br />
	                    	<b><?=date('D, d-M-Y',strtotime($model->DiscountUntil))?></b>
                    	</div>
					<?php }else{ ?>
						<div class="price-final">
	                    	<?=rupiah($model->Price)?>
	                    </div>
					<?php } 
				  }else{ ?>
					<div class="price-final">
	                	<?=rupiah($model->Price)?>
	                </div>
			<?php }?>
		</div>
	</div>
	<div class="clearfix"></div>


    
    <div class="col-sm-12 detail-Content">
    	<div class="boxHeader">
            <h3>Overview of <?=$model->PostTitle?></h3>
        </div>
    	
	    <div class="post-content">
	        <?=Do_Shortcode(parse_form($model->PostContent))?>
	    </div>
	    <div class="clear"></div>
	    
	    <?php if(!empty($model->SEODescription)){ ?>
	        <div class="post-content">
	        	<div class="boxHeader">
	            	<h3>Deskripsi</h3>
            	</div>
	            <?=Do_Shortcode(parse_form($model->SEODescription))?>
	        </div>
	    <?php } ?>
    </div>
    <div class="clearfix"></div>

<script type="text/javascript">
    $(document).ready(function(){
        $('.allowcomment').hide();
        $('#tombol_com').click(function(){
            $('.allowcomment').slideToggle();
        });
        
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
    $(document).ready(function(){
        
        $('#Gambar li img').click(function(){
            $.fancybox({
                'padding'       : 0,
                'href'          : $('li.on img').attr('src'),
                'title'         : '<?=trim(strip_tags($model->PostTitle))?>',
                'transitionIn'  : 'elastic',
                'transitionOut' : 'elastic'

            });
        });
        
        $('#Gambar li img').each(function(){
            if($(this).width() > $(this).height()){
                $(this).css('width','100%').css('height','auto');
                var margintop = ($(this).parent().height() - $(this).height()) / 2;
                margintop = (margintop < 1) ? 0 : margintop;
                $(this).css('margin-top',margintop);
            }else{
                $(this).css('height',$(this).parent().height()).css('width','auto');
                var marginleft = ($(this).parent().width() - $(this).width()) / 2;
                marginleft = (marginleft < 1) ? 0 : marginleft;
                $(this).css('margin-left',marginleft);
            }
        });
        
        <?php if(!empty($impactimage)){ ?>
            $('#Gambar li').hide();
            $('#Gambar').prepend('<li title="" style="position: absolute; display: list-item;"><img title="" src="<?=$impactimage?>" /></li>');
        <?php } ?>
        
        $('#Gambar').bxGallery({
            maxwidth: '',              // if set, the main image will be no wider than specified value (in pixels)
            maxheight: '225',             // if set, the main image will be no taller than specified value (in pixels)
            thumbwidth: 75,           // thumbnail width (in pixels)
            thumbcrop: false,          // if true, thumbnails will be a perfect square and some of the image will be cropped
            croppercent: .35,          // if thumbcrop: true, the thumbnail will be scaled to this 
                                       // percentage, then cropped to a square
            thumbplacement: 'bottom',  // placement of thumbnails (top, bottom, left, right)
            thumbcontainer: '',        // width of the thumbnail container div (in pixels)
            opacity: .5,               // opacity level of thumbnails
            load_text: 'Loading ...',             // if set, text will display while images are loading
            load_image: '',
                                       // image to display while images are loading
            wrapperclass: 'outer'      // classname for outer wrapping div
        });
        
    });
</script>




</div>
<div class="clear"></div>
<div class="clearfix"></div>
<!-- <br /> -->

<?php if($model->AllowComment){ ?>
<button class="ui btn btn-default"id="tombol_com"><b class="glyphicon glyphicon-comment"></b> Komentar</button><br /><br />
<div id="comments_list">
<div class="allowcomment">
    <?=form_open('post/comment/'.$model->PostID, array('id' => 'validate'))?>
    <table>
        <tr>
            <td><label for="Name">Nama*</label></td>
            <td><input class="required" type="text" style="width: 270px"  name="Name" id="Name" /><br /></td>
        </tr>
        <tr>
            <td><label for="Email">Email*</label></td>
            <td><input class="required email" type="text" style="width: 270px"  name="Email" id="Email" /><br /></td>
        </tr>
        <tr>
            <td><label for="Website">Website</label></td>
            <td><input type="text" size="30" name="Website" style="width: 270px" id="Website" class="" /><br /></td>
        </tr>
        <tr>
            <td><label for="Comment">Komentar</label><br /></td>
            <td><textarea class="required" style="width: 500px;" name="Comment" id="Comment"></textarea><br /></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><button type="submit" class="ui button">Kirim</button></td>
        </tr>
    </table>
    <?=form_close() ?>
</div>
<br />

    <!-- <h3>Daftar Komentar</h3> -->
    <ol style="list-style: none" class="commentlist" id="comments">
    <?php $i = 1; foreach ($showcomments->result() as $comment) { ?>
        <li class="comment <?php if($i % 2 == 0) echo "even thread-even"; else echo "odd thread-odd"; ?> depth-1">
        <div class="comment-body">
            <h4 class="fl"> 
                <?php #if($comment->Website){ echo '<a href="http://'.$comment->Website.'" target="_blank" rel="external nofollow">'; } ?> 
                    <?=$comment->Name?> 
                <?php #if($comment->Website){ echo '</a>'; } ?>                
            </h4>
                <abbr title="<?=date('d M Y',strtotime($comment->CommentDate))?> at <?=date('H:i a',strtotime($comment->CommentDate))?>" class="published fr"><?=date('d M Y',strtotime($comment->CommentDate))?> at <?=date('H:i a',strtotime($comment->CommentDate))?></abbr>
            <p>
                <?php echo $this->typography->auto_typography($comment->Comment); ?>
            </p>            
        </div>
        </li>
    <?php
    $i++;
    } ?>
    </ol>
</div>

<?php } ?>

