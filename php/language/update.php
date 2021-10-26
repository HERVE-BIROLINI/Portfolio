<!-- ***** Update.PHP (WF3) : START ***** -->
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
    
    // Si à l'entrée, le visiteur n'est pas connecté, renvoi à la page LogIn
    if(!isset($_SESSION['email'])){
        header('location:../users/login.php?lang='.$sLang);
    }
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
    
    // Si poursuite du programme...
    
    // ... et 1er passage, ENTREE sur le formulaire, mais pas d'ID à modifier...
    if(!isset($_GET['id'])){
        header('location:../admin/index.php?lang='.$sLang);
    }

    // ... définie les variables en rapport avec la table à lire
    $sTable='language';
    // ... récupère la liste des champs de la table à Editer
    $obPDO=new App\DBTools();
    $obPDO->init();
    $arFieldNames=$obPDO->funGetNameOfColumns($sTable);
    
    // Vérifie qu'il y a bien un enregistrement pour l'ID dans la table WF3...
    $arRow=$obPDO->execSqlQuery("select * from $sTable where id=".$_GET['id']);
    // ... si pas d'enregistrement pour l'ID transmis, retour à la page précédente
    if(!isset($arRow) or count($arRow)==0){
        funEcho(-1,'Aucun enregistrement pour l\'ID "'.$_GET['id'].'" dans la table '.$sTable.'...');
        header('location:../admin/index.php?lang='.$sLang);
    }
    // Récupère la ligne de l'enregistrement à modifier
    else{$arRow=$arRow[0];}

    //
    // Au 2nd passage, suite à SUBMIT...
    if(isset($_POST['submit'])){
        // ... met à jour dans la BD
        $sEcho='';
        
        // ** Si pas rencontré de problème avec le fichier, crée la chaîne pour la requête **
        if(!isset($bError)){

            $sPrepare='';
            $arNewValues=[];
            var_dump($arFieldNames);
            foreach($arFieldNames as $sFieldName){
                // cas particulier de la clé primaire, ne peut-être écrite
                if(strstr($sFieldName,'id_') or strstr($sFieldName,'_id') or $sFieldName=='id'){
                    $sPrimaryKey=$sFieldName;
                }
                // tous les autres cas...
                elseif(isset($_POST[$sFieldName]) or $_FILES[$sFieldName]['name']!==''){
                    $sPrepare.=' '.$sFieldName.'=?,';
                    if(isset($_POST[$sFieldName]))
                    // {array_merge($arNewValues,[$_POST[$sFieldName]]);}
                    // else{array_merge($arNewValues,[':'.$sFieldName=>$_FILES[$sFieldName]['name']]);}
                    {array_push($arNewValues,$_POST[$sFieldName]);}
                    else{array_push($arNewValues,$_FILES[$sFieldName]['name']);}
                }
            }
            $sPrepare=substr($sPrepare,0,-1);
            
            var_dump('update '.$sTable.' set '.$sPrepare.' where '.$sPrimaryKey.'='.$_GET['id']);
            var_dump($arNewValues);
            //
            $obPDO->execSqlQuery('update '.$sTable.' set '.$sPrepare.' where '.$sPrimaryKey.'='.$_GET['id'],$arNewValues);
            header('location:../admin/index.php?lang='.$sLang);
            // header('location:'.__DIR__.'/../admin/index.php?lang='.$sLang);
            // header('location:'.CO_HTTP_ADMIN.'index.php?lang='.$sLang);
        }
        
        // **** AFFICHE LE 'RAPPORT' ****
        // ******************************
        funEcho(-1,$sEcho);
    }
    
    require_once CO_PATH_ADMIN.'htmlgenerator.php';
    use Admin\htmlGenerator;

    // Si au moins 2 champs ont été trouvé,
    // construit le formulaire de type LISTE
    if(isset($arFieldNames) and count($arFieldNames)>1){

        // Supprime le champs ID de la liste
        $arFieldNames=array_diff($arFieldNames,array('id'));
?>

<div class="d-flex flex-column mx-5 pt-3">
    <div class="d-flex flex-row align-items-center w-100 pr-5" id="DivTitleRow">
        <p class="PLanguages"><?php if($sLang==='fr'){echo"Modification d'une réalisation :";}else{echo"Update a production :";}; ?></p>
    </div>
</div>

<div class="d-flex flex-row justify-content-center pb-5">
    <form class="py-3 col-10" method="post" enctype="multipart/form-data"
        style="border:5px solid black;align-self:centered;"
    >

        <?php
            foreach($arFieldNames as $sValue){
        ?>

        <div class="d-flex flex-row col-12">
            <div class="d-flex flex-column col-4">
                <?php echo htmlGenerator::getHtmlLabel($sValue,null,true);?>
            </div>
            <div class="d-flex flex-column col-8">
                <?php
                    $arClass=$obPDO->getClass4Field($sValue);
                    // calcule de la valeur par défaut
                    if(isset($_POST[$sValue])){$sDefaultValue=$_POST[$sValue];}
                    elseif(isset($arRow[$sValue])){$sDefaultValue=$arRow[$sValue];}
                    // génération des éléments HTML
                    if(strstr($sValue,"owner")){
                ?>
                <p><?=$_SESSION['email']?></p>
                <?php
                        }
                    elseif(isset($arClass)){
                        echo htmlGenerator::getHtmlInput4Class($arClass,$sValue,$sDefaultValue,true);
                    }else{
                        echo htmlGenerator::getHtmlInput4Class(null,$sValue,$sDefaultValue,true);
                    }
                ?>
            </div>
        </div>
        <br>

        <?php
            }
        ?>

        <div class='d-flex flex-row justify-content-around'>
            <a  href=<?=CO_HTTP_ADMIN.'index.php?lang='.$sLang;?> class="btn btn-secondary"><?php if($sLang==='fr'){echo'Retour à la liste';}else{echo'Cancel';}?></a>
            <button type="submit" name="submit" class="btn btn-primary"><?php if($sLang==='fr'){echo'Enregistrer';}else{echo'Save';}?></button>
        </div>
        
        <br>
        <small class="ml-2" style="color:red;font-weight:bolder;">(* champs obligatoire)</small>

    </form>
</div>

<?php
    }
    // Si moins de 2 champs dans la table, retour à la page précédente
    elseif(!count($arFieldNames)>1){
        funEcho(-1,'Cette table ne comporte pas de champs...');
    }

	//
	foreach(funDirFiles(CO_PATH_REQUIRES_BOTTOM,'') as $sFile){
		if(ctype_digit(substr($sFile,0,2))){
			require_once CO_PATH_REQUIRES_BOTTOM.$sFile;
		}
	}
?>
<!-- ***** Update.PHP (WF3) : END ***** -->