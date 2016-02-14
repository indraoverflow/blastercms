<?php
try{
    if(is_file(ActiveThemePath()."/other/user/login.php")){
        include(ActiveThemePath()."/other/user/login.php");
    }
}catch(Exception $e){
    echo "File User Not Found";
}