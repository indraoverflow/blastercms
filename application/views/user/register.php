<?php
try{
    if(is_file(ActiveThemePath()."/other/user/register.php")){
        include(ActiveThemePath()."/other/user/register.php");
    }
}catch(Exception $e){
    echo "File User Not Found";
}