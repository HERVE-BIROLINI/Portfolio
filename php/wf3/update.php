<?php

    /**** LOADING OF 'PARTS' OF MAIN PHP PAGE ****/
    /** ... STRICLY REQUIRED PARTS (PHP codes mainly) **/
    require_once "../Requires/00-PHP_Init.php";
    $arFiles=funDirFiles(CO_PATH_REQUIRES_TOP,'*');
    foreach($arFiles as $sFile){
        if(ctype_digit(substr($sFile,0,2))){
            require_once CO_PATH_REQUIRES_TOP.$sFile;
        }
    }

    // Si 1er passage, ENTREE sur le formulaire, mais pas d'ID à modifier...
    if(!isset($_GET['id'])){
        header('location:'.CO_HTTP_ADMIN.'index.php?lang='.$sLang);
    }

    // Si poursuite du programme...
    // ... définie les variables en rapport avec la table à lire
    $sTable='wf3';
    // ... récupère la liste des champs de la table à Editer
    $obPDO=new Requires\DBTools();
    $obPDO->init();
    $arFieldNames=$obPDO->funGetNameOfColumns($sTable);
    // Vérifie qu'il y a bien un enregistrement pour l'ID dans la table WF3...
    $arRow=$obPDO->execSqlQuery("select * from $sTable where ".$sTable."_id=".$_GET['id']);
    // ... si pas d'enregistrement pour l'ID transmis, retour à la page précédente
    if(!isset($arRow) or count($arRow)==0){
        funEcho(-1,'Aucun enregistrement pour l\'ID "'.$_GET['id'].'" dans la table '.$sTable.'...');
        header('location:'.$_SERVER['HTTP_REFERER']);
    }
    // Récupère la ligne de l'enregistrement à modifier
    else{$arRow=$arRow[0];}

    // Si à l'entrée, la SESSION n'est pas ADMIN, ni 'propriétaire', renvoi à la page LogIn
    if((isset($_SESSION['admin']) and $_SESSION['admin']!='1')
        and (in_array('owner',$arFieldNames) and $_SESSION['email']!==$arRow['owner'])
        ){
        header('location:../users/login.php?lang='.$sLang);
    }

    //
    // Au 2nd passage, suite à SUBMIT...
    // ... vérifie que le $_FILES disponible est bien celui attendu
    if(isset($_FILES)){
        foreach($arFieldNames as $sFieldName){
            if(isset($_FILES[$sFieldName])){
                $sFieldFileName=$sFieldName;
            }
        }
    }
    if(isset($_POST['submit'])){
        // ... met à jour dans la BD
        $sEcho='';
        // ** File - SSI l'utilisateur en a choisi un nouveau **
        if($_FILES[$sFieldFileName]['error']==0){
            //    - Déclare les extensions acceptées
            // déclaration du dossier destination du fichier image
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
            //
            // Si l'ancien fichier et le nouveau sont différents...
            if($arRow[$sFieldFileName]!=$sFileName){
                // ... vérifie déjà si le nouveau respecte les attentes...
                $arExtensions=array('jpg','jpeg','png','webp','ico');
                if(!in_array($sFileExtension, $arExtensions)){
                    $bError=true;
                    $sEcho=$sEcho.'Vous devez choisir un fichier du type autorisé :';
                    foreach($arExtensions as $sExtension){
                        $sEcho=$sEcho.' '.$sExtension.',';
                    }
                    $sEcho=substr($sEcho,0,-1).'.</br>';
                }
                // si oui, le choix du nouveau fichier peut-être considéré comme définitif...
                if(!isset($bError)){
                    // ... vérifie si l'ancien est partagé avant de le supprimer...
                    $arImg=$obPDO->execSqlQuery("select * from $sTable where $sFieldFileName=? and ".$sTable."_id!=?",[$arRow[$sFieldFileName],$_GET['id']]);
                    // ... si pas utilisé, le supprime
                    if(isset($arImg) and count($arImg)==0){
                        unlink($sFolder.$arRow[$sFieldFileName]);
                        $sEcho=$sEcho.'Le fichier image n\'étant pas utilisé par un autre article, a été supprimé.</br>';
                    }
                    else{$sEcho=$sEcho.'Le fichier image étant aussi utilisé par un autre article, n\'a pas été supprimé.</br>';}
                    // Parce que l'outil AURA DEJA copié le fichier dans une zone tampon...
                    // ... récupère le chemin de cette zone tampon
                    $sFileTmp=$_FILES[$sFieldFileName]['tmp_name'];
                    $sFileFullDestination=$sFolder.$sFileName.'.'.$sFileExtension;
                    if(!isset($bError) and move_uploaded_file($sFileTmp,$sFileFullDestination)){
                        // puisque nouveau fichier, au bon format, lève un drapeau pour la requête de Mise à jour.
                        $bNewFileChoosen=true;
                    }
                }
            }
            // * L'utilisateur a RE-choisi le même fichier, comportement identique à non-choix... *
            else{}
        }// => fin : L'utilisateur a choisi un fichier
        // ** L'utilsateur n'avait pas choisi de nouveau fichier **
        else{}
        
        // ** Si pas rencontré de problème avec le fichier, crée la chaîne pour la requête **
        if(!isset($bError)){

            $sPrepare='';
            $arNewValues=[];
            foreach($arFieldNames as $sFieldName){
                // cas particulier de la clé primaire, ne peut-être écrite
                if(strstr($sFieldName,'id_') or strstr($sFieldName,'_id')){
                    $sPrimaryKey=$sFieldName;
                }
                // cas particulier du OWNER, pour la gestion des accès au données par 'propriétaire'
                elseif(!isset($_POST[$sFieldName]) and $sFieldName=='owner'){
                    $sPrepare.=' owner=?,';
                    // array_merge($arNewValues,[$_SESSION['email']]);
                    array_push($arNewValues,$_SESSION['email']);
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
            //
            $obPDO->execSqlQuery('update '.$sTable.' set '.$sPrepare.' where '.$sPrimaryKey.'='.$_GET['id'],$arNewValues);
            header('location:'.CO_HTTP_ADMIN.'index.php?lang='.$sLang);
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
        style="padding-top:50px;padding-bottom:50px;border:5px solid black;align-self:centered;"
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
                    if(isset($_POST[$sValue])){$sDefaultValue= $_POST[$sValue];}
                    elseif(isset($arRow[$sValue])){$sDefaultValue=$arRow[$sValue];}
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