<?=form_open('menu/added')?>

    <h4><?php echo $title?></h4>
    <input class="form-control" type="text" size="30" id="SidebarName" value="Nama Menu" />
    
    <h4>Menu</h4>
    <select class="form-control" id="MenuID">
        <?php $menu = $this -> db -> order_by('MenuID', 'desc') -> get('menus')?>
        <?=GetCombobox($menu, "MenuID", "MenuTitle")?>
    </select>
    
<?=form_close()?>