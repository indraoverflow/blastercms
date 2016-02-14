<?php

try{
    if(is_file(ActiveThemePath()."/header.php")){
        include(ActiveThemePath()."/header.php");
    }
}catch(Exception $e){
    echo "File Header Not Found";
}