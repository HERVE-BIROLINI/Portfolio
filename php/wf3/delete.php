<!-- ***** Delete.PHP (WF3) : START ***** -->
<?php

    session_start();
    
    /**** LOADING OF 'PARTS' OF MAIN PHP PAGE ****/
    /** ... STRICLY REQUIRED PARTS (PHP codes mainly) **/
	require_once __DIR__."/../requires/00-php_init.php";
    // require_once "../Requires/00-PHP_Init.php";
    $arFiles=funDirFiles(CO_PATH_REQUIRES_TOP,'*');
    foreach($arFiles as $sFile){
        if(ctype_digit(substr($sFile,0,2))){
            require_once CO_PATH_REQUIRES_TOP.$sFile;
        }
    }
    
    // Si à l'entrée, la SESSION n'est pas ADMIN, renvoi à la page LogIn
    if(!isset($_SESSION['email'])){
        header('location:../users/login.php?lang='.$sLang);
    }
    
    // Si poursuite du programme...
    
    // ... et 1er passage, ENTREE sur le formulaire, mais pas d'ID à modifier...
    if(!isset($_GET['id'])){
        header('location:../admin/index.php?lang='.$sLang);
    }

    // ... définie les variables en rapport avec la table à lire
    $sTable='wf3';
    // ... récupère la liste des champs de la table à Editer
    $obPDO=new App\DBTools();
    $obPDO->init();
    $arFieldNames=$obPDO->funGetNameOfColumns($sTable);
    $arRow=$obPDO->execSqlQuery("select * from $sTable where ".$sTable."_id=?",[$_GET['id']]);

    // MAIS !! Si la SESSION n'est pas autorisée, (pas ADMIN, ni 'propriétaire'),
    // renvoi à la page LogIn
    if(!((isset($_SESSION['admin']) and $_SESSION['admin']=='1')
            or (in_array('owner',$arFieldNames) and
                strtolower($_SESSION['email'])==strtolower($arRow['owner'])
                )
        )
        ){
        header('location:../users/login.php?lang='.$sLang);
    }
    // ce message ne devrait jamais être vu
    elseif(!isset($_SESSION)){funEcho(-1,'<br><br>La session n\'est pas démarrée....');}

    // - Si poursuite du programme...
    //... cherche le nom 'EXACTE' du champs image
    foreach($arFieldNames as $sValue){
        if(strstr($sValue,"file")
            or strstr($sValue,"fichier")
            or strstr($sValue,"image")
            or strstr($sValue,"picture")
            or strstr($sValue,"photo")
            or strstr($sValue,"src")
            ){
            $sFieldFileName=$sValue;
        }
    }
    // - suppression de l'ancien fichier SSI...
    // ... vérifie si le fichier image est partagé avant de le supprimer...
    $arRows=$obPDO->execSqlQuery("select * from $sTable where ".$sFieldFileName."=?",[$arRow[0][$sFieldFileName]]);
    if(isset($arRows) and count($arRows)==1){
        unlink(CO_PATH_SRC_WF3.$arRow[0][$sFieldFileName]);
    }
    else{funEcho(-1,'Fichier utilisé une seule fois => à supprimer');}
    // - supprime l'enregistrement de la BD
    $obPDO->execSqlQuery("delete from $sTable where ".$sTable."_id=?",[$_GET['id']]);
    header('location:'.CO_HTTP_ADMIN.'index.php?lang='.$sLang);
    // exit();
?>
<!-- ***** Delete.PHP (WF3) : END ***** -->