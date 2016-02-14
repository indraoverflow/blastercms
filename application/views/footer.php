<?php if($this->input->get('previewtheme') != ""){ ?>
<script type="text/javascript">
    $('a').each(function(){
        $(this).attr('href',$(this).attr('href')+"?&previewtheme=<?=$this->input->get('previewtheme')?>");
    });
</script>
<?php
}
?>
<?php
try{
    if(is_file(ActiveThemePath()."/footer.php")){
        include(ActiveThemePath()."/footer.php");
    }
}catch(Exception $e){
    echo "File Header Not Found";
}
#$this->load->view('themes/'.ACTIVETHEME.'/header');