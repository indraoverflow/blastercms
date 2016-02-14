<?=form_open('menu/added')?>
<h3><?php echo $title?></h3>
<input type="text" size="30" id="SidebarName" />
<h3>HTML</h3>
<textarea style="width: 800px; height:350px;" id="SidebarHTML" class="ckeditor" name="MenuName" />
<?=form_close()?>