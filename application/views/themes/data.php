<?php $this -> load -> view('admin/header')?>

<h2><?php echo $title ?></h2>

<div style="background-color: #FFF;border-radius: 6px;box-shadow: 0 1px 2px rgba(0,0,0,0.3);padding: 15px 0px">

<?php if($this -> input -> get('success')){?>
    <div class="success alert alert-success">
        Tema baru sudah diaktifkan, <?=anchor(site_url(),'klik disini ',array('target'=>'_blank'))?> untuk melihat.
    </div>
<?php }?>

<?php if(empty($themes)){?>
    <div class="error alert alert-danger">
        Theme Tidak Ada
    </div>
<?php }else {?>
    <div id="themes">
        
    <?php
    $i=0;
    
    $folders = $folder['desktop'];
    foreach ($themes as $theme => $themename) {
        $i++;
        $fileinfo = $folders."/".$theme.'/info.txt';
        $read = read_file($fileinfo);
        $info = json_decode($read);
        $preview = $folders."/".$theme.'/preview.jpg';
        if(is_file($preview)){
            $image = base_url().$folders."/".$theme."/preview.jpg";
            $image = str_replace("./", "", $image);
        }else{
            $image = base_url().'assets/images/no-image.png';
        }
        ?>
        <div class="col-sm-4">
        <div class="themebox panel panel-info">
            <img src="<?=$image?>" alt="Preview" />
            <h4 class="titless alert alert-info"><?=$info->ThemeName?><br /><small> by <?=anchor($info->AuthorURL,$info->Author,array('target'=>'_blank'))?></small></h4>
        
        <!-- <strong>Version</strong> <?=$info->Version?> <br /> -->
        <strong>Category</strong> <?=$info->Category?> <br />
        <strong>Description</strong>
        <p>
        <?=$info->Description?>
        </p>
        
        <?php
        $activetheme = ACTIVETHEME;
        if($theme != $activetheme){
            ?>
            <?=anchor(site_url('themes/active/'.$theme),'<b class="glyphicon glyphicon-save"></b> Aktifkan',array('class'=>' btn btn-primary'))?>
            <?=anchor(site_url()."?previewtheme=".$theme,'<b class="glyphicon glyphicon-play"></b> Preview',array('class'=>'preview btn btn-default'))?>
            <?php
        }else{
            ?>
            <div class="alert alert-success" style="padding: 6px 15px; margin-bottom: 0">
                <i>Sudah diaktifkan</i>
            </div>
            <?php
        }
            
        ?>
        </div>
        </div>
        <?php
            if($i % 4 == 0){
                ?>
                <!-- <div class="clear"></div> -->
                <?php
            }
        ?>
        <?php
    }
    ?>
    </div>
    
<?php }?>
<div class="clear"></div>
</div>
<?php $this -> load -> view('admin/footer')?>
