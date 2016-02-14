<?=$this->load->view('header')?>

<section id="main">
   <table width="100%">
        <tr>
            <?php if($sidebarleft){ ?>
            <td class="sidebar" id="SidebarLeft" style="max-width: 200px">
                <?php echo Do_Shortcode("[ai:widget id=".$sidebarleft."]"); ?>
            </td>
            <?php } ?>
            <td id="main_postcontent" <?php if($sidebarleft){ echo 'padding-left:10px;'; } ?> <?php if($sidebarright){ echo 'padding-right:10px;'; } ?>">
                <?php $this->load->view($loadview)?>
            </td>
            <?php if($sidebarright){ ?>
            <td class="sidebar" id="SidebarRight" style="max-width: 200px">
                <?php echo Do_Shortcode("[ai:widget id=".$sidebarright."]"); ?>
            </td>
            <?php } ?>
        </tr>
    </table>
</section>

<?=$this->load->view('footer')?>
