<?=$this->load->view('header')?>

<section id="main">
    
    <script type="text/javascript" src="<?=base_url()?>assets/basic/offcanvas.js"></script>
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/basic/offcanvas.css" />
    
    <div class="row row-offcanvas row-offcanvas-right">
   <table width="100%">
        <tr>
            <?php if($sidebarleft){ ?>
            <td class="sidebar col-xs-12 col-sm-3" id="SidebarLeft sidebar" role="navigation" >
                <?php echo Do_Shortcode("[ai:widget id=".$sidebarleft."]"); ?>
            </td>
            <?php } ?>
            <td class="sidebar col-xs-12 col-sm-6" id="main_postcontent" style=" <?php #if($sidebarleft){ echo 'padding-left:10px;'; } ?> <?php #if($sidebarright){ echo 'padding-right:10px;'; } ?>">
                <?php if($sidebarleft){ ?>
                    <p class="pull-right visible-xs">
                        <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
                    </p>
                <? }?>
                
                <?php $this->load->view($loadview)?>
                
                <?php if($sidebarright){ ?>
                    <p class="pull-left visible-xs">
                        <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
                    </p>
                <? }?>
                
            </td>
            <?php if($sidebarright){ ?>
            <td class="sidebar sidebar col-xs-12 col-sm-3" id="SidebarRight sidebar" role="navigation">
                <?php echo Do_Shortcode("[ai:widget id=".$sidebarright."]"); ?>
                <!-- <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
                      <div class="list-group">
                        <a href="#" class="list-group-item active">Link</a>
                        <a href="#" class="list-group-item">Link</a>
                        <a href="#" class="list-group-item">Link</a>
                        <a href="#" class="list-group-item">Link</a>
                        <a href="#" class="list-group-item">Link</a>
                        <a href="#" class="list-group-item">Link</a>
                        <a href="#" class="list-group-item">Link</a>
                        <a href="#" class="list-group-item">Link</a>
                        <a href="#" class="list-group-item">Link</a>
                        <a href="#" class="list-group-item">Link</a>
                      </div>
                </div> -->
            </td>
            <?php } ?>
        </tr>
    </table>
    </div>
    
    <script type="text/javascript">
        $(document).ready(function(){
           if($('a[href="<?=current_url()?>"]')){
                $(this).parent().removeClass('active');   
           } 
        });
    </script>
    
</section>

<?=$this->load->view('footer')?>
