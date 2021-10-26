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
    // MAIS !! Si la SESSION n'est pas autorisée, (pas ADMIN, ni 'propriétaire'),
    // renvoi à la page LogIn
    if(!(isset($_SESSION['admin']) and $_SESSION['admin']=='1')){
        header('location:../users/login.php?lang='.$sLang);
    }
    // ... et 1er passage, ENTREE sur le formulaire, mais pas d'ID à modifier...
    if(!isset($_GET['id'])){
        header('location:../admin/index.php?lang='.$sLang);
    }
    
    // Si poursuite du programme...
    // ... définie les variables en rapport avec la table à lire
    $sTable='language';
    // ... récupère la liste des champs de la table à Editer
    $obPDO=new App\DBTools();
    $obPDO->init();
    $arFieldNames=$obPDO->funGetNameOfColumns($sTable);
    $arRow=$obPDO->execSqlQuery("select * from $sTable where ".$sTable."_id=?",[$_GET['id']]);

    // - Si poursuite du programme...
    // ... supprime l'enregistrement de la BD
    var_dump("delete from $sTable where id=?");
    var_dump([$_GET['id']]);
    $obPDO->execSqlQuery("delete from $sTable where id=?",[$_GET['id']]);
    header('location:'.CO_HTTP_ADMIN.'index.php?lang='.$sLang);
    // exit();
?>
<!-- ***** Delete.PHP (WF3) : END ***** -->