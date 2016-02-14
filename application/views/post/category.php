<?=$this->load->view('header')?>

<section id="main">
    
    <script type="text/javascript" src="<?=base_url()?>assets/basic/offcanvas.js"></script>
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/basic/offcanvas.css" />
    
    <!-- <div class="row row-offcanvas row-offcanvas-right"> -->
	<div class="mainmain">
		<?php
        $teng = 12;
		$sl = $sr = 2;
		if($sidebarleft){
			if(!$sidebarright){
				$sl = 3;
			}	
			$teng = $teng - $sl;
			
		}
		if($sidebarright){
			if(!$sidebarleft){
				$sr = 3;
			}
			$teng = $teng - $sr;
		} 
        ?>
   <table width="100%" class="tableMain">
   		<tr>
            <?php if($sidebarleft){ ?>
            <td id="SidebarLeft" class="col-sm-<?=$sl?>">
                <?php echo Do_Shortcode("[ai:widget id=".$sidebarleft."]"); ?>
            </td>
            <?php } ?>
            
            <td class="col-xs-12 col-sm-<?=$teng?>" id="main_postcontent">
                <?php $this->load->view($loadview)?>
            </td>
            <?php if($sidebarright){ ?>
            <td id="SidebarRight" class="col-sm-<?=$sr?>">
                <?php echo Do_Shortcode("[ai:widget id=".$sidebarright."]"); ?>
            </td>
            <?php } ?>
        </tr>
    </table>
    </div>
</section>

<?=$this->load->view('footer')?>
