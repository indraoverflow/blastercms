<?php

function toNum($num){
	return str_replace(",", "", $num);
}

function media_url(){
    return base_url()."assets/images/media/";
}

function media_path(){
    return "./assets/images/media/";
}

function template_url(){
    $CI =& get_instance();
    $CI->load->helper('url');
    if($CI->input->get('previewtheme')!=""){
        return base_url()."assets/themes/".$CI->input->get("previewtheme")."/";
    }else{
        return base_url()."assets/themes/".ACTIVETHEME."/";
    }
}

function CheckLogin(){
    $CI =& get_instance();
    $CI->load->library('session');

    if($CI->session->userdata(LOGINSESSION)){
        return TRUE;
    }else{
        #redirect('admin/login');
        show_error('Silahkan Login Kembali');
    }
}

function GetAdminLogin($param=""){
    $CI =& get_instance();
    $CI->load->library('session');
    $CI->load->model('muser');
    $username = $CI->session->userdata(LOGINSESSION);
    if(empty($param)){
        return $CI->muser->GetAll(array('u.UserName'=>$username));
    }else{
        $res = $CI->muser->GetAll(array('u.UserName'=>$username))->row();
        return $res->$param;
    }
}

function GetLoginURL(){
    $CI =& get_instance();
    $CI->load->helper('file');

    $file = APPPATH.'config/blaster_login.txt';
    $url = read_file($file);
    return $url;
}

function SetLoginURL($url){
    $CI =& get_instance();
    $CI->load->helper('file');

    if(write_file(APPPATH.'config/blaster_login.txt', $url)){
        return TRUE;
    }else{
        return FALSE;
    }
}

function IsUserLogin(){
    $CI =& get_instance();
    $CI->load->library('session');
    if($CI->session->userdata(USERLOGINSESSION) == ""){
        return FALSE;
    }else{
        return TRUE;
    }
}

function GetUserLogin($param=""){
    $CI =& get_instance();
    $CI->load->library('session');
    $CI->load->model('muser');
    $username = $CI->session->userdata(USERLOGINSESSION);
    if(empty($param)){
        return $CI->muser->GetAll(array('ui.UserName'=>$username));
    }else{
        $res = $CI->muser->GetAll(array('ui.UserName'=>$username))->row();
        if(empty($res)){
            $CI->session->unset_userdata(USERLOGINSESSION);
            redirect(site_url()."?logged_out=true");
        }
        return $res->$param;
    }
}

function GetView($viewname){
    $CI =& get_instance();
    $CI->load->database();
    $CI->load->model('mview');
    return $CI->mview->get($viewname);
}

function GetSetting($settingname){
    $CI =& get_instance();
    $CI->load->database();
    $CI->load->model('msetting');
    return $CI->msetting->get($settingname);
}

function SetSetting($settingname,$settingvalue){
    $CI =& get_instance();
    $CI->load->database();
    $res = $CI->db->where(array('SettingName'=>$settingname))->get('settings')->row();
    if(empty($res)){
        $data = array('SettingName'=>$settingname,'SettingValue'=>$settingvalue);
        $CI->db->insert('settings',$data);
    }else{
        $data = array('SettingValue'=>$settingvalue);
        $CI->db->where(array('SettingName'=>$settingname));
        $CI->db->update('settings',$data);
    }
}

function GetMedia($id){
    $CI =& get_instance();
    $CI->load->database();
    $cek = $CI->db->where('MediaID',$id)->get('media')->row();
    if(empty($cek)){
        return FALSE;
    }else{
        return media_url().$cek -> MediaPath;
    }
}

function GetMediaPath($id){
    $CI =& get_instance();
    $CI->load->database();
    $cek = $CI->db->where('MediaID',$id)->get('media')->row();
    if(empty($cek)){
        return "";
    }else{
        return $cek->MediaFullPath;
    }
}

function GetContentSetting($settingname){
    $CI =& get_instance();
    $CI->load->database();
    $res = $CI->db->where(array('ContentSettingName'=>$settingname))->get('contentsettings')->row();
    if(empty($res)){
        return "";
    }else{
        return $res->ContentSettingValue;
    }
}

function SetContentSetting($settingname,$settingvalue){
    $CI =& get_instance();
    $CI->load->database();
    $res = $CI->db->where(array('ContentSettingName'=>$settingname))->get('contentsettings')->row();
    if(empty($res)){
        $data = array('ContentSettingName'=>$settingname,'ContentSettingValue'=>$settingvalue);
        $CI->db->insert('contentsettings',$data);
    }else{
        $data = array('ContentSettingValue'=>$settingvalue);
        $CI->db->where(array('ContentSettingName'=>$settingname));
        $CI->db->update('contentsettings',$data);
    }
}

function GetChild($parent,$menu){
    $CI =& get_instance();
    $CI->load->database();
    $CI->db->order_by('OrderNo','asc');
    $childs = $CI->db->where(array('ParentID'=>$parent,'MenuID'=>$menu))->get('menudetails');

    echo "<ul>";

    if($childs->num_rows() > 0){
        foreach ($childs->result() as $child){
            $id = $child->JQueryID;
            ?>
            <li id="list_<?=$id?>">
                <div>
                    <span class="menuTitle"><?=strip_tags($child->MenuName)?></span>
                    <span class="edit"><a class="editMenu" href="#">edit</a> | <a class="hapusmenu" href="#">hapus</a>
                        <input type="hidden" class="MenuNames" value="<?=$child->MenuName?>" name="MenuName[]">
                        <input type="hidden" class="MenuID" value="<?=$id?>" name="MenuID[]">
                        <input type="hidden" class="ParentID" value="<?=$child->ParentID?>" name="ParentID[]">
                        <input type="hidden" class="LinkTypes" value="<?=$child->LinkTypeID?>" name="LinkType[]">
                        <input type="hidden" class="MenuURLs" value="<?=$child->URL?>" name="MenuURL[]">
                        <input type="hidden" class="CustomSubMenus" value="<?=$child->CustomSubMenu?>" name="CustomSubMenu[]">
                    </span>
                </div>
                <?php
                GetChild($id,$menu);
                ?>
            </li>
            <?php
        }
    }
    echo "</ul>";
}

function PrintChild($parent,$menu){
    $CI =& get_instance();
    $CI->load->database();
    $CI->db->order_by('OrderNo','asc');
    $childs = $CI->db->where(array('ParentID'=>$parent,'MenuID'=>$menu))->get('menudetails');

    if($childs->num_rows() > 0){
        echo "<ul>";
        foreach ($childs->result() as $child){
            $id = $child->JQueryID;
            ?>
            <li id="menu_<?=$id?>">
                <?php if($child->LinkTypeID == LINKTYPEOPENNEWTAB){ ?>
                <?=anchor($child->URL,'<span>'.$child->MenuName.'</span>',array('target'=>'_blank'))?>
                <?php }else if($child->LinkTypeID == LINKTYPEOPENPOPUP){ ?>
                <?=anchor_popup($child->URL,'<span>'.$child->MenuName.'</span>',array())?>
                <?php }else{ ?>
                <?=anchor($child->URL,'<span>'.$child->MenuName.'</span>')?>
                <?php } ?>
                <?php
                PrintChild($id,$menu);
                ?>
            </li>
            <?php
        }
        echo "</ul>";
    }
}


function PrintMenu(){
    $CI =& get_instance();
    $CI->load->database();
    $CI->load->library('shortcodes');
    $menuid = GetSetting("MainMenuID");
    $CI->db->order_by('OrderNo','asc');
    $CI->db->where(array('ParentID'=>0,'MenuID'=>$menuid));
    $menus = $CI->db->get('menudetails');

    foreach ($menus->result() as $menu){
        ?>
        <li id="menu_<?=$menu->MenuID?>">

            <?php
            $add = "";
            if(!empty($menu->MenuBlink)){
                $add .= '<sup class="blink">'.$menu->MenuBlink.'</sup>';
            }
            $img = "";
            if(!empty($menu->IconID)){
                $media = GetMedia($menu->IconID);
                $mediaurl = empty($media) ? "" : media_url().$media->MediaPath;
                $img .= '<img src="'.$mediaurl.'" class="menu-icon" />';
            }
            ?>
            <?php if($menu->LinkTypeID == LINKTYPEOPENNEWTAB){ ?>
            <?=anchor($menu->URL,'<span>'.$img.$menu->MenuName.$add.'</span>',array('target'=>'_blank'))?>
            <?php }else if($menu->LinkTypeID == LINKTYPEOPENPOPUP){ ?>
            <?=anchor_popup($menu->URL,'<span>'.$img.$menu->MenuName.$add.'</span>',array())?>
            <?php }else{ ?>
            <?=anchor($menu->URL,'<span>'.$img.$menu->MenuName.$add.'</span>')?>
            <?php } ?>
            <?php
            if(!empty($menu->CustomSubMenu)){
                ?>
                <ul class="customsubmenu">
                    <div class="customcontent">
                        <?php
                        $content = parse_form($menu->CustomSubMenu);
                        $content = $CI->shortcodes->parse($content);
                        echo $content;
                        ?>
                    </div>
                </ul>
                <?php
            }else{
                PrintChild($menu->JQueryID,$menuid);
            }
            ?>
        </li>
        <?php
    }
    ?>
    <script type="text/javascript">
        $(document).ready(function(){
            $('a[href="<?=site_url('#')?>"]').click(function(){
                return false;
            });
        });
    </script>
    <?php
}

function PrintCustomMenu($id,$vertical=1){
    $CI =& get_instance();
    $CI->load->database();
    $CI->db->order_by('OrderNo','asc');
    $CI->db->where(array('ParentID'=>0,'MenuID'=>$id));
    $menus = $CI->db->get('menudetails');
    if($vertical==1){
        $ver = 'sf-vertical';
    }else{
        $ver = "";
    }
    $str = "";
    $str .= "<div class='sidebar-collapse'>
    <ul id='side-menu' class='nav sf-menu ".$ver."'>";
        $now=0;
        $img = "";
        foreach ($menus->result() as $menu){
            $now++;
            if($now == 1){
                $add = 'first ';
            }else{
                $add = "";
            }
            $addArrow = '';
            if($menu->JQueryID){
             $addArrow =  '<span><a href="#"><span class="fa arrow"></span></a></span>';
         }else{
             $addArrow = '';
         }

         $ico = '<i class="fa fa-fw fa-tags"></i> ';

         $str .= '<li class="'.$add.'" id="menu_';
         $str .= $menu->MenuDetailID.'">';
         if($menu->LinkTypeID == LINKTYPEOPENNEWTAB){
            $str .= anchor($menu->URL,$ico.' <span>'.$img.$menu->MenuName.'</span>',array('target'=>'_blank'));
        }else if($menu->LinkTypeID == LINKTYPEOPENPOPUP){
            $str .= anchor_popup($menu->URL,$ico.' <span>'.$img.$menu->MenuName.'</span>',array());
        }else{
            $str .= anchor($menu->URL,$ico.' <span>'.$img.$menu->MenuName.'</span>');
        }
        $str .= PrintCustomChild($menu->JQueryID,$id);
        $str .= '</li>';
    }
    $str .= "<div class='clear'></div>";
    $str .= "</ul></div>";
    return $str;
}
#<div class="sidebar-collapse">
#    <ul id="side-menu" class="nav">
#        <li class="active">
#           <a href="#"><i class="fa fa-sitemap fa-fw"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
#            <ul class="nav nav-second-level collapse in" style="height: auto;">
#                <li>
#                    <a href="#">Second Level Item</a>
#                </li>
#                <li>
#                    <a href="#">Second Level Item</a>
#                </li>
#                <li class="active">
#                    <a href="#">Third Level <span class="fa arrow"></span></a>
#                    <ul class="nav nav-third-level collapse in" style="height: auto;">
#                        <li>
#                            <a href="#">Third Level Item</a>
#                        </li>
#                        <li>
#                            <a href="#">Third Level Item</a>
#                        </li>
#                        <li>
#                            <a href="#">Third Level Item</a>
#                        </li>
#                        <li>
#                            <a href="#">Third Level Item</a>
#                        </li>
#                    </ul>
#                    <!-- /.nav-third-level -->
#                </li>
#            </ul>
#            <!-- /.nav-second-level -->
#        </li>
#    </ul>
#    <!-- /#side-menu -->
#</div>

function PrintCustomChild($parent,$menu){
    $CI =& get_instance();
    $CI->load->database();
    $CI->db->order_by('OrderNo','asc');
    $childs = $CI->db->where(array('ParentID'=>$parent,'MenuID'=>$menu))->get('menudetails');
    #$childs = $CI->db->where(array('ParentID'=>$parent))->get('menudetails');
    #echo $CI->db->last_query();
    #return $menu;

    $ico = '<i class="fa fa-fw fa-tag"></i> ';
    $str = "";

    if($childs->num_rows() > 0){
        $str .= '<ul class="nav nav-second-level collapse">';
        foreach ($childs->result() as $child){
            $id = $child->JQueryID;

            $str .= '<li id="menu_'.$id.'">';
            if($child->LinkTypeID == LINKTYPEOPENNEWTAB){
                $str .= anchor($child->URL,$ico.'<span>'.$child->MenuName.'</span>',array('target'=>'_blank'));
            }else if($child->LinkTypeID == LINKTYPEOPENPOPUP){
                $str .= anchor_popup($child->URL,$ico.'<span>'.$child->MenuName.'</span>',array());
            }else{
                $str .= anchor($child->URL,$ico.'<span>'.$child->MenuName.'</span>');
            }
            $str .= PrintCustomChild($id,$menu);
            $str .= '</li>';
        }
        $str .= "</ul>";
    }
    return $str;
}


function ActiveTheme(){
    $CI =& get_instance();
    $CI->load->helper('url');
    if($CI->input->get('previewtheme')!=""){
        return $CI->input->get('previewtheme');
    }else{
        return ACTIVETHEME;
    }
}



function ActiveThemePath(){
    #if(IsMobileActive()){
        #return MOBILETHEMEPATH.MobileActiveTheme();
    #}else if(IsTabletActive()){
        #return TABLETTHEMEPATH.TabletActiveTheme();
    #}else{
    return THEMEPATH.ActiveTheme();
    #}
}



function Do_Shortcode($string){
    $CI = & get_instance();
    $CI->load->library('shortcodes');
    return $CI->shortcodes->parse($string);
}

function strip_shortcode($string){
    $find1 = "[";
    $find2 = "]";
    $pos1 = strpos($string, $find1);
    $pos2 = strpos($string, $find2);

    if($pos1 === FALSE || $pos2===FALSE){
        return $string;
    }

    $newstring = "";
    $newstring .= substr($string, 0,$pos1);
    $newstring .= substr($string, $pos2+1);
    return $newstring;
}


function parse_form($str){
    $CI =& get_instance();
    $CI->load->helper('captcha');
    $str = str_replace(array('{%','%}'), array('<','>'), $str);
    $str = str_replace(array('*action*','*base_url*','*ref*'), array(site_url('form/execute'),base_url(),$CI->input->get('ref')), $str);

    $rand = rand(000000,999999);

    $vals = array(
        'word' => $rand,
        'img_path' => './assets/images/captcha/',
        'img_url' => base_url().'assets/images/captcha/',
        'font_path' => './assets/fonts/Quartz.ttf',
        'img_width' => 150,
        'img_height' => 30,
        'expiration' => 7200
        );

    $cap = create_captcha($vals);
    $CI->load->library('session');
    $CI->session->set_userdata(array('Captcha'=>$rand));

    $str = str_replace(array('*captcha*'), $cap['image'], $str);
    return $str;
}

function GetArrDirection(){
    $arr_slidedirection = array('top','bottom','left','right','fade');
    return $arr_slidedirection;
}

function Komakan($array){
    $i = 0;
    $string = "";
    foreach ($array as $val) {
        if($i > 0){
            $string .= ",";
        }
        $string .= $val;
        $i++;
    }
    return $string;
}

function GetSlider($ids,$width,$height){
    $ids = explode(' ',$ids);
    $ids = Komakan($ids);
    $CI = & get_instance();
    $CI->load->database();
    $CI->load->model('mslider');
    $a = $width;
    $width = ($width == '640px') ? "100%" : $width.'px';
    $layersliders = $CI->db->query("SELECT * FROM sliders LEFT JOIN media on media.MediaID = sliders.MediaID where SliderID IN (".$ids.") ORDER BY FIELD(SliderID,".$ids.")");
    $content = '<div class="clear"></div>';
    $content .= '<div id="layerslider" style="height: '.$height.'px; width:'.$width.';margin-bottom:43px">';
    foreach ($layersliders->result() as $slider){
                #$details = $CI->mlayerslider->GetDetail($slider->LayerSliderID);
        $content .= '<div class="ls-layer" rel="';
        if($slider->SliderDelay)
            $content .= 'slidedelay: '.$slider->SliderDelay.';';
        if($slider->SliderDirection){
            $content .= 'slidedirection: '.$slider->SliderDirection.';';
        }
        $content .= '">';
        $content .= '<img  style="height: 100%; width:100%" class="ls-bg" src="'.base_url().'assets/images/media/'.$slider->MediaPath.'"  alt="'.$slider->MediaName.'" title="'.$slider->SliderText.'">';
        $content .= '</div>';
    }
    $content .= '</div>';
    $content .= '<div class="clear"></div>
    <div class="clearfix"></div>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#layerslider").layerSlider({
                skin : "defaultskin",
                skinsPath : "'.base_url().'assets/ls/skins/",
                autoStart           : true,
                pauseOnHover        : true,
                firstLayer          : 1,
                animateFirstLayer   : true,
                twoWaySlideshow     : true,
                keybNav             : true,
                touchNav            : true,
                imgPreload          : true,
                navPrevNext         : true,
                navStartStop        : false,
                navButtons          : true,
                autoPauseSlideshow  : "auto",

                cbInit              : function() { },
                cbStart             : function() { },
                cbStop              : function() { },
                cbPause             : function() { },
                cbAnimStart         : function() { },
                cbAnimStop          : function() { },
                cbPrev              : function() { },
                cbNext              : function() { }
            });
});

</script>';

return $content;
}


function PrintPagination($page,$pagenum,$url,$type=1){
    $CI =& get_instance();
    $content = '';

    $mulai = 1;
    $sampai = $pagenum;
    $startfake = "";
    $fake = "";

    if($page > 4){
        $startfake = '<a data-role="button" data-inline="true" title="1" class="page" href="'.$url.'?page=1&orderby='.$CI->input->get('orderby').'&order='.$CI->input->get('order').'"><span>1</span></a>'."...";
    }

    if($page >= 3){
        if($page == 4){
            $mulai = 1;
        }else{
            $mulai = $page - 2;
        }

        if($page + 2 <= $pagenum){
            $sampai = $page + 2;
        }else{
            $sampai = $pagenum;
        }
    }

    if($pagenum > 5){
        if($page < 3){
            $sampai = 5;
        }
    }

    if($sampai < $pagenum){
        if($pagenum - $sampai > 1){
            $fake = "...".'<a data-role="button" data-inline="true" title="'.$pagenum.'" class="page" href="'.$url.'?page='.$pagenum.'&orderby='.$CI->input->get('orderby').'&order='.$CI->input->get('order').'"><span>'.$pagenum.'</span></a>';
        }else{
            $sampai = $pagenum;
        }
    }

    if($type == 1){
        $content .= '<div class="paginationc">
        <span class="pages">Page '.$page.' of '.$pagenum.'</span>';
        if($page > 1){
            $prev = $page-1;
            $content .= '<a data-role="button" data-inline="true" href="'.$url.'?page='.$prev.'&orderby='.$CI->input->get('orderby').'&order='.$CI->input->get('order').'"><span>&laquo;</span></a>';
        }else{
            $content .= '<span data-role="button" data-inline="true" class="ui-disabled">&laquo;</span>';
        }
        $content.=$startfake;
        for ($i=$mulai; $i <= $sampai; $i++) {
           if($i == $page){
            $content .= '<span data-role="button" data-inline="true" class="current ui-btn-active">'.$i.'</span>';
        }else{
            $content .= '<a data-role="button" data-inline="true" title="'.$i.'" class="page" href="'.$url.'?page='.$i.'&orderby='.$CI->input->get('orderby').'&order='.$CI->input->get('order').'"><span>'.$i.'</span></a>';
        }
    }
    $content .= $fake;
    if($page < $pagenum){
        $next = $page+1;
        $content .= '<a data-role="button" data-inline="true" href="'.$url.'?page='.$next.'&orderby='.$CI->input->get('orderby').'&order='.$CI->input->get('order').'"><span>&raquo;</span></a>';
    }else{
        $content .= '<span data-role="button" data-inline="true" class="ui-disabled">&raquo;</span>';
    }
    $content .= '</div>';
}else if($type == 2){
    $content .= '<div class="">
    <ul class="pagination">';
        if($page > 1){
            $prev = $page-1;
            $content .= '<li><a href="'.$url.'?page='.$prev.'&orderby='.$CI->input->get('orderby').'&order='.$CI->input->get('order').'"><span>&laquo;</span></a></li>';
        }else{
            $content .= '<li><span class="disabled">&laquo;</span></li>';
        }
        $content.=$startfake;
        for ($i=$mulai; $i <= $sampai; $i++) {
           if($i == $page){
            $content .= '<li class="active"><span class="current">'.$i.'</span></li>';
        }else{
            $content .= '<li><a title="'.$i.'" class="page" href="'.$url.'?page='.$i.'&orderby='.$CI->input->get('orderby').'&order='.$CI->input->get('order').'"><span>'.$i.'</span></a></li>';
        }
    }
    $content .= $fake;
    if($page < $pagenum){
        $next = $page+1;
        $content .= '<li><a href="'.$url.'?page='.$next.'&orderby='.$CI->input->get('orderby').'&order='.$CI->input->get('order').'"><span>&raquo;</span></a></li>';
    }else{
        $content .= '<li><span class="disabled">&raquo;</span></li></ul>';
    }
    $content .= '</div>';
}

return $content;
}




function GetWidget($id){
    $CI = & get_instance();
    $CI->load->database();
    $CI->load->library('shortcodes');
    $r = $CI->db->where('WidgetID',$id)->order_by('Order','asc')->get('widgetdetails');
    $ret = "";
    #$ret = '<div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">';
    $ret .= "<ul class='contentsidebar' id='Widget-".$id."' >";
    foreach ($r->result() as $side) {
        $content = $CI->shortcodes->parse($side->WidgetDetailHTML);
        $ret .= '<li>';
        $ret .= '<h3>'.$side->WidgetDetailName.'</h3>';
        $content = $CI->shortcodes->parse($content);
        $ret .= $content;
        $ret .= '</li>';
        $ret .= "<div class='clear'></div><div class='clearfix'></div>";
    }
    $ret .= "</ul>";
    #$ret .= '</div>';
    return $ret;
}

function GetNewWidget($id){
    $CI = & get_instance();
    $CI->load->database();
    $CI->load->library('shortcodes');
    $r = $CI->db->where('WidgetID',$id)->order_by('Order','asc')->get('widgetdetails');
    $ret = "";
    $ret = '<div class="sidebar-collapse">';
    $ret .= "<ul class='contentsidebar nav' id='side-menu Widget-".$id."' >";
    foreach ($r->result() as $side) {
        $content = $CI->shortcodes->parse($side->WidgetDetailHTML);
        $ret .= '<li>';
        $ret .= '<h3>'.$side->WidgetDetailName.'</h3>';
        $content = $CI->shortcodes->parse($content);
        $ret .= $content;
        $ret .= '</li>';
        $ret .= "<div class='clear'></div><div class='clearfix'></div>";
    }
    $ret .= "</ul>";
    $ret .= '</div>';
    return $ret;
}


function NewGetFooterColumn($classy=''){
    $CI = & get_instance();
    $CI->load->database();
    $CI->load->library('shortcodes');
    #$langid = ActiveLangID();

    $footers = $CI->db->where(array('IsShow'=>1))->order_by('Order','asc')->get('footers');

    foreach ($footers->result() as $footer) {

        $columnname = $footer->TotalColumn;

        if(empty($classy)){
            $classy = "footercol";
        }
        for ($i=0; $i < $columnname; $i++) {
            $class = $classy;
            if($i == ($columnname-1)){
                $class .= ' last';
            }
            if($i == 0){
                $class .= ' first';
            }
            $width = floor(100/$columnname);
            ?>
            <div class="<?=$class?>" style="width: <?=$width?>%">
                <div class="in">
                    <?php
                    $r = $CI->db->where('Index',$i)->where('FooterID',$footer->FooterID)->order_by('Order','asc')->get('footerdetails');
                    echo "<ul>";
                    foreach ($r->result() as $side) {
                        $content = $CI->shortcodes->parse($side->HTMLFooter);
                        ?>
                        <li>
                            <h2><?=$side->FooterDetailName?></h2>
                            <?=$content?>
                        </li>
                        <?php
                    }
                    echo "</ul>";
                    ?>
                </div>
            </div>
            <?php
        }
        echo '<div class="clear"></div>';
    }
}

function PrintTopMenu(){
    $CI =& get_instance();
    $CI->load->database();
    $menuid = GetSetting("TopMenuID");
    $CI->db->order_by('OrderNo','asc');
    $CI->db->where(array('ParentID'=>0,'MenuID'=>$menuid));
    $menus = $CI->db->get('menudetails');

    foreach ($menus->result() as $menu){
        ?>
        <?=anchor($menu->URL,'<span>'.$menu->MenuName.'</span>')?>
        <?php
    }
}

function PrintFooterMenu(){
    $CI =& get_instance();
    $CI->load->database();
    $menuid = GetSetting("FooterMenuID");
    $CI->db->order_by('OrderNo','asc');
    $CI->db->where(array('ParentID'=>0,'MenuID'=>$menuid));
    $menus = $CI->db->get('menudetails');

    foreach ($menus->result() as $menu){
        ?>
        <?=anchor($menu->URL,'<span>'.$menu->MenuName.'</span>')?>
        <?php
    }
}



function IsAllowInsert($modul,$role=""){
    $CI =& get_instance();
    $CI->load->database();

    if($role == ""){
        $role = GetAdminLogin('RoleID');
    }

    if($role == ADMINROLE){
        return TRUE;
    }

    $cek = $CI->db->where(array('RoleID'=>$role,'ModuleID'=>$modul,'Insert'=>1))->get('roleaccess');
    if($cek->num_rows() > 0){
        return TRUE;
    }else{
        return FALSE;
    }
}

function IsAllowUpdate($modul,$role=""){
    $CI =& get_instance();
    $CI->load->database();
    if($role==""){
        $role = GetAdminLogin('RoleID');
    }

    if($role == ADMINROLE){
        return TRUE;
    }

    $cek = $CI->db->where(array('RoleID'=>$role,'ModuleID'=>$modul,'Update'=>1))->get('roleaccess');
    if($cek->num_rows() > 0){
        return TRUE;
    }else{
        return FALSE;
    }
}

function IsAllowDelete($modul,$role=""){
    $CI =& get_instance();
    $CI->load->database();
    if($role==""){
        $role = GetAdminLogin('RoleID');
    }

    if($role == ADMINROLE){
        return TRUE;
    }

    $cek = $CI->db->where(array('RoleID'=>$role,'ModuleID'=>$modul,'Delete'=>1))->get('roleaccess');
    if($cek->num_rows() > 0){
        return TRUE;
    }else{
        return FALSE;
    }
}

function IsAllowView($modul,$role=""){
    $CI =& get_instance();
    $CI->load->database();

    if($role==""){
        $role = GetAdminLogin('RoleID');
    }

    if($role == ADMINROLE){
        return TRUE;
    }

    $cek = $CI->db->where(array('RoleID'=>$role,'ModuleID'=>$modul,'View'=>1))->get('roleaccess');
    if($cek->num_rows() > 0){
        return TRUE;
    }else{
        return FALSE;
    }
}






function FontName($name){
    switch ($name) {
        case 'ARIAL.TTF':
        $ret = "Arial";
        break;
        case 'CALIBRI.TTF':
        $ret = "Calibri";
        break;
        case 'COMIC.ttf':
        $ret = "Comic Sans MS";
        break;
        case 'Quartz.ttf':
        $ret = "Quartz";
        break;
        case 'TIMES.TTF':
        $ret = "Times New Roman";
        break;
        case 'VERDANA.ttf':
        $ret = "Verdana";
        break;
        default:
        $ret = substr($name, 0, -4);
        break;
    }
    return $ret;
}



function PrintChildBoos($parent,$menu){
    $CI =& get_instance();
    $CI->load->database();
    $CI->db->order_by('OrderNo','asc');
    $childs = $CI->db->where(array('ParentID'=>$parent,'MenuID'=>$menu))->get('menudetails');

    if($childs->num_rows() > 0){
        echo "<ul class='dropdown-menu'>";
        foreach ($childs->result() as $child){
            $id = $child->JQueryID;
            ?>
            <li id="menu_<?=$id?>">
                <?php if($child->LinkTypeID == LINKTYPEOPENNEWTAB){ ?>
                <?=anchor($child->URL,'<span>'.$child->MenuName.'</span>',array('target'=>'_blank'))?>
                <?php }else if($child->LinkTypeID == LINKTYPEOPENPOPUP){ ?>
                <?=anchor_popup($child->URL,'<span>'.$child->MenuName.'</span>',array())?>
                <?php }else{ ?>
                <?=anchor($child->URL,'<span>'.$child->MenuName.'</span>')?>
                <?php } ?>
                <?php
                PrintChildBoos($id,$menu);
                ?>
            </li>
            <?php
        }
        echo "</ul>";
    }
}


function PrintMenuBoos(){
    $CI =& get_instance();
    $CI->load->database();
    $CI->load->library('shortcodes');
    $menuid = GetSetting("MainMenuID");
    $CI->db->order_by('OrderNo','asc');
    $CI->db->where(array('ParentID'=>0,'MenuID'=>$menuid));
    $menus = $CI->db->get('menudetails');
    $drop="";$drops="";$b="";

    foreach ($menus->result() as $menu){
    	$childz = $CI->db->where(array('ParentID'=>$menu->JQueryID,'MenuID'=>$menuid))->get('menudetails');
      if($childz->num_rows() > 0){
         $drop="dropdown";
         $drops="dropdown-toggle";
         $b="<b class='caret'></b>";
     }else{
         $drop="";
         $drops="";
         $b="";
     }
     ?>
     <li id="menu_<?=$menu->MenuID?>" class=<?=$drop?> >
       <?php
       $add = "";
       if(!empty($menu->MenuBlink)){
        $add .= '<sup class="blink">'.$menu->MenuBlink.'</sup>';
    }
    $img = "";
    if(!empty($menu->IconID)){
        $media = GetMedia($menu->IconID);
        $mediaurl = empty($media) ? "" : media_url().$media->MediaPath;
        $img .= '<img src="'.$mediaurl.'" class="menu-icon" />';
    }
    ?>
    <?php if($menu->LinkTypeID == LINKTYPEOPENNEWTAB){ ?>
    <?=anchor($menu->URL,$img.$menu->MenuName.$add,array('target'=>'_blank'))?>
    <?php }else if($menu->LinkTypeID == LINKTYPEOPENPOPUP){ ?>
    <?=anchor_popup($menu->URL,$img.$menu->MenuName.$add,array())?>
    <?php }else{ ?>
    <?=$menu->URL=='#'? '<a class="'.$drops.'" data-toggle="'.$drop.'" href="'.$menu->URL.'">'.$menu->MenuName.$add.$b.'</a>':anchor($menu->URL,$img.$menu->MenuName.$add.$b,array('data-toggle'=>$drop,'class' => $drops)) ?>
    <?php } ?>
    <?php
    if(!empty($menu->CustomSubMenu)){
        ?>
        <ul class="customsubmenu">
            <div class="customcontent">
                <?php
                $content = parse_form($menu->CustomSubMenu);
                $content = $CI->shortcodes->parse($content);
                echo $content;
                ?>
            </div>
        </ul>
        <?php
    }else{
        PrintChildBoos($menu->JQueryID,$menuid);
    }
    ?>
</li>
<?php
}
?>
<script type="text/javascript">
    $(document).ready(function(){
        $('a[href="<?=site_url('#')?>"]').click(function(){
            return false;
        });
    });
</script>
<?php
}


function NewGetFooterColumnBoos($classy=''){
    $CI = & get_instance();
    $CI->load->database();
    $CI->load->library('shortcodes');
    #$langid = ActiveLangID();

    $footers = $CI->db->where(array('IsShow'=>1))->order_by('Order','asc')->get('footers');

    foreach ($footers->result() as $footer) {

        $columnname = $footer->TotalColumn;

        if(empty($classy)){

         if($columnname==1){
            $classy = "col-sm-12";
        }else if($columnname==2){
            $classy = "col-sm-6";
        }else if($columnname==3){
            $classy = "col-sm-4";
        }else if($columnname==4){
            $classy = "col-sm-3";
        }else{
            $classy = "col-sm-12";
        }
    }
    for ($i=0; $i < $columnname; $i++) {
        $class = $classy;
        if($i == ($columnname-1)){
            $class .= ' last';
        }
        if($i == 0){
            $class .= ' first';
        }
        $width = floor(100/$columnname);
        ?>
        <div class="<?=$class?>" >
            <div class="in">
                <?php
                $r = $CI->db->where('Index',$i)->where('FooterID',$footer->FooterID)->order_by('Order','asc')->get('footerdetails');
                echo "<ul class='list-unstyled'>";
                foreach ($r->result() as $side) {
                    $content = $CI->shortcodes->parse($side->HTMLFooter);
                    ?>
                    <li>
                        <h2><?=$side->FooterDetailName?></h2>
                        <?=$content?>
                    </li>
                    <?php
                }
                echo "</ul>";
                ?>
            </div>
        </div>
        <?php
    }
    echo '<div class="clearfix"></div>';
}
}

function GetCategoryURL($slug=''){
	$CI = & get_instance();
    $CI->load->database();
    $cat = $CI -> db -> where('CategoryID',0) -> get('categories') -> row_array();
    if(empty($slug)){
      $slug = $cat['CategorySlug'];
  }
  $hal = base_url().'post/category/'.$slug.'.html';
  return $hal;
}
