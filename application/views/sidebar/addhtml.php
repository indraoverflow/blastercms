<?=form_open('menu/added')?>

    <h4><?php echo $title?></h4>
    <input class="form-control" type="text" size="30" id="SidebarName" />
    
    <h4>HTML</h4>
    <textarea id="SidebarHTML" class="ckeditor" name="MenuName" />
    
<?=form_close()?>