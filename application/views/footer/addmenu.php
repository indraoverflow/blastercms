<?=form_open('menu/added')?>
<h3><?php echo $title?></h3>
<input type="text" size="30" id="SidebarName" value="Nama Menu" />
<h3>Menu</h3>
<select id="MenuID">
    <?php $menu = $this -> db -> order_by('MenuID', 'desc') -> get('menus')?>
    <?=GetCombobox($menu, "MenuID", "MenuTitle")?>
</select>
<?=form_close()?>