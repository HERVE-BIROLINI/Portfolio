<?php

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

    $_SESSION['email']='guest';
    $_SESSION['admin']='0';
    // Si à l'entrée, la SESSION n'est pas ADMIN, renvoi à la page LogIn
    if(!isset($_SESSION['email'])){
        header('location:../users/login.php?lang='.$sLang);
    }

    // Si poursuite du programme...
    // ... définie les variables en rapport avec la table à lire
    $sTable='wf3';
    // ... récupère la liste des champs de la table à Editer
    $obPDO=new Requires\DBTools();
    $obPDO->init();
    $arFieldNames=$obPDO->funGetNameOfColumns($sTable);

    //
    // Au 2nd passage, suite à SUBMIT...
    // ... vérifie que le $_FILES disponible est bien celui attendu
    if(isset($_FILES)){
        foreach ($arFieldNames as $sFieldName){
            if(isset($_FILES[$sFieldName])){
                $sFieldFileName=$sFieldName;
            }
        }
    }
    if(isset($_POST['submit']) and isset($sFieldFileName)){
        // ... ENREGISTRE dans la BD
        //  * File *
        //    - Déclare les extensions acceptées
        $sEcho='';
        //    - déclaration du dossier destination
        $sFolder=CO_PATH_SRC_WF3;
        //
        // récupère le nom (sans le chemin) de l'image dans la super globale
        // ... récupère les informations sur le fichier...
        $sFilePathInfo=pathinfo($_FILES[$sFieldFileName]['name']);
        // $sFileName=$_FILES[$sFieldFileName]['name'];
        // ... ... en déduit le nom (sans l'extension)
        $sFileName=$sFilePathInfo['filename'];
        // ... ... en déduit son extension
        $sFileExtension=strtolower($sFilePathInfo['extension']);
        // Parce que l'outil AURA DEJA copié le fichier dans une zone tampon...
        // ... récupère le chemin de cette zone tampon
        $sFileTmp=$_FILES[$sFieldFileName]['tmp_name'];
        $arExtensions=array('jpg','jpeg','png','webp','ico');
        if(!in_array($sFileExtension, $arExtensions)){
            $bError=true;
            $sEcho=$sEcho.'Vous devez choisir un fichier du type autorisé :';
            foreach($arExtensions as $sExtension){
                $sEcho=$sEcho.' '.$sExtension.',';
            }
            $sEcho=substr($sEcho,0,-1).'.</br>';
        }
        //
        $sFileFullDestination=$sFolder.$sFileName.'.'.$sFileExtension;
        if(!isset($bError) and move_uploaded_file($sFileTmp,$sFileFullDestination)){
            // crée la chaîne pour la requête
            $sFields='';
            $sValues='';
            $arNewValues=[];
            foreach($arFieldNames as $sFieldName){
                // cas particulier de la clé primaire, ne peut-être écrite
                if(strstr($sFieldName,'id_') or strstr($sFieldName,'_id')){
                    $sPrimaryKey=$sFieldName;
                }
                // cas particulier du OWNER, pour la gestion des accès au données par 'propriétaire'
                elseif(!isset($_POST[$sFieldName]) and $sFieldName=='owner'){
                    $sFields.='owner,';
                    $sValues.='?,';
                    array_push($arNewValues,$_SESSION['email']);
                }
                // tous les autres cas...
                elseif(isset($_POST[$sFieldName]) or $_FILES[$sFieldName]['name']!==''){
                    $sFields.=$sFieldName.',';
                    $sValues.='?,';
                    if(isset($_POST[$sFieldName]))
                    {array_push($arNewValues,$_POST[$sFieldName]);}
                    else{array_push($arNewValues,$_FILES[$sFieldName]['name']);}
                }
            }
            $sFields=substr($sFields,0,-1);
            $sValues=substr($sValues,0,-1);
            //
            $obPDO->execSqlQuery('insert into '.$sTable.' ('.$sFields.') values('.$sValues.')',$arNewValues);
            header('location:'.CO_HTTP_ADMIN.'index.php?lang='.$sLang);
        }
        elseif(!isset($bError)){
            $sEcho=$sEcho.'L\'Upload NE s\'est PAS déroulé correctement (???)...</br>';
        }
        else{$sEcho=$sEcho.'</br>... AU MOINS UNE INFORMATION EST MANQUANTE OU ERRONEE...</br></br>';}
        
        // **** AFFICHE LE 'RAPPORT' ****
        // ******************************
        if($sEcho!==''){funEcho(-1,$sEcho);};
    }

    require_once CO_PATH_ADMIN.'htmlgenerator.php';
    use Admin\htmlGenerator;

    // Si au moins 2 champs ont été trouvé,
    // construit le formulaire de type LISTE
    if(isset($arFieldNames) and count($arFieldNames)>1){

        // Supprime le champs ID de la liste
        $arFieldNames=array_diff($arFieldNames,array($sTable.'_id'));
?>

<style type="text/css">
    .PMyFormation{
        padding-left:1em;
        font-size:2.5em;
        font-family:'barlow';
        align-self:flex-start;
    }
</style>
    
<p class="PMyFormation" style="padding-top:100px;"><?php if($sLang==='fr'){echo"Modification d'une réalisation avec 'WebForce3' :";}else{echo"My Training, with WebForce3 :";}; ?></p>
<div class="d-flex flex-row justify-content-center">
    <form class="d-flex flex-column col-10" method="post" enctype="multipart/form-data"
        style="padding-top:50px;padding-bottom:50px;margin-bottom:100px;border:5px solid black;align-self:centered;"
    >

        <?php
            foreach($arFieldNames as $sValue){
        ?>

        <div class="d-flex flex-row col-12"><!--style="border:2px solid red;">-->
            <div class="d-flex flex-column col-4">
                <?php echo htmlGenerator::getHtmlLabel($sValue,null,true);?>
            </div>
            <div class="d-flex flex-column col-8">
                <?php
                    $arClass=$obPDO->getClass4Field($sValue);
                    // calcule de la valeur par défaut
                    if(isset($_POST[$sValue])){$sDefaultValue=$_POST[$sValue];}
                    else{$sDefaultValue='';}
                    // génération des éléments HTML
                    if(strstr($sValue,"owner")){
                    ?>
                            <p><?=$_SESSION['email']?></p>
                    <?php
                        }
                    elseif(isset($arClass))
                        {echo htmlGenerator::getHtmlInput4Class($arClass,$sValue,$sDefaultValue,true);}
                    else{echo htmlGenerator::getHtmlInput4Class(null,$sValue,$sDefaultValue,true);}
                
                ?>
            </div>
        </div>
        </br>

        <?php
            }
        ?>

        <div class='d-flex flex-row justify-content-around'>
            <a  href=<?=CO_HTTP_ADMIN.'index.php?lang='.$sLang;?> class="btn btn-secondary"><?php if($sLang==='fr'){echo'Retour à la liste';}else{echo'Cancel';}?></a>

            <button type="submit" name="submit" class="btn btn-primary"><?php if($sLang==='fr'){echo'Enregistrer';}else{echo'Save';}?></button>
        </div>

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