<?php
try{
    if(is_file(ActiveThemePath()."/other/user/forgetpassword.php")){
        include(ActiveThemePath()."/other/user/forgetpassword.php");
    }
}catch(Exception $e){
    echo "File User Not Found";
}