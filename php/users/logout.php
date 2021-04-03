<?php
    // session_start();
    //
    // if(isset($_SESSION['user_id'])){header('location:../../index.php');}
    //
    require_once "../Requires/00-PHP_Init.php";
    // funEcho(2,'- Entrée dans /Admin/Index.php...');
    $arFiles=funDirFiles(CO_PATH_REQUIRES,'*');
    foreach($arFiles as $sFile){
        if(ctype_digit(substr($sFile,0,2))){
            require_once CO_PATH_REQUIRES.$sFile;
        }
    }
    //
    include_once CO_PATH_INCLUDES."10-head.PHP";
    include_once CO_PATH_INCLUDES."11-JS_JQUERY_BOOTSTRAP.PHP";
    include_once CO_PATH_INCLUDES."12-NAV.PHP";

    session_destroy();
    header('location:login.php');
?>