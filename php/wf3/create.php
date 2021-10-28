<!-- ***** Create.PHP (language) : START ***** -->
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
    // ... définie les variables en rapport avec la table à lire
    $sTable='wf3';
    // ... récupère la liste des champs de la table à Editer
    $obPDO=new App\DBTools();
    $obPDO->init();
    $arFieldNames=$obPDO->funGetNameOfColumns($sTable);
    //
    $bError=false;
    $sFocus='';
    
    // Au 2nd passage, suite à SUBMIT...
    // ... vérifie que le $_FILES est "renseigné" et bien l'élément HTML attendu
    if(isset($_FILES['picture_name']) and $_FILES['picture_name']['error']==0){
        
        foreach ($arFieldNames as $sFieldName){
            if(isset($_FILES[$sFieldName])){
                $sFieldFileName=$sFieldName;
            }
        }
        
        // ... si Submit, ET... 1 fichier désigné...
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
            // SI et Seulement Si ! l'extension n'est pas autorisée, interrompt la suite programme
            if(!in_array($sFileExtension, $arExtensions)){
                $bError=true;
                $sEcho=$sEcho.'Vous devez choisir un fichier du type autorisé :';
                foreach($arExtensions as $sExtension){
                    $sEcho=$sEcho.' '.$sExtension.',';
                }
                $sEcho=substr($sEcho,0,-1).'.<br>';
            }
            //  * TOUS les champs du formaulaire *
            // ... crée la chaîne pour la requête, sur l'architecture "détectée" dans la base de données
            $sFields='';
            $sValues='';
            $arNewValues=[];
            foreach($arFieldNames as $sFieldName){
                // astuce pour retenir le premier élément du formulaire mal-renseigné
                if($sFocus==''){
                    // cas particulier de la clé primaire, ne peut-être écrite
                    if(strstr($sFieldName,'id_') or strstr($sFieldName,'_id') or $sFieldName=='id'){
                        $sPrimaryKey=$sFieldName;
                    }
                    // cas particulier du OWNER, pour la gestion des accès au données par 'propriétaire'
                    elseif(!isset($_POST[$sFieldName]) and $sFieldName=='owner'){
                        $sFields.='owner,';
                        $sValues.='?,';
                        array_push($arNewValues,$_SESSION['email']);
                    }
                    // cas particulier du PRIORITY, pour la gestion des accès au données par 'propriétaire'
                    elseif($sFieldName=='priority'){
                        $sFields.='priority,';
                        $sValues.='?,';
                        if(is_numeric($_POST[$sFieldName])){
                            array_push($arNewValues,$_POST[$sFieldName]);
                        }else{
                            array_push($arNewValues,'99');
                        }
                    }
                    // tous les autres cas...
                    elseif(isset($_POST[$sFieldName]) or $_FILES[$sFieldName]['name']!==''){
                        $sFields.=$sFieldName.',';
                        $sValues.='?,';
                        if(isset($_POST[$sFieldName]) and $_POST[$sFieldName]!=''){array_push($arNewValues,$_POST[$sFieldName]);}
                        elseif(isset($_POST[$sFieldName])){$sFocus=$sFieldName;}
                        else{array_push($arNewValues,strtolower($_FILES[$sFieldName]['name']));}
                    }
                }
            }
            //
            $sFileFullDestination=strtolower($sFolder.$sFileName.'.'.$sFileExtension);
            if((!isset($bError) or $bError==false) and move_uploaded_file($sFileTmp,$sFileFullDestination)){
                $sFields=substr($sFields,0,-1);
                $sValues=substr($sValues,0,-1);
                //
                $obPDO->execSqlQuery('insert into '.$sTable.' ('.$sFields.') values('.$sValues.')',$arNewValues);
                header('location:'.CO_HTTP_ADMIN.'index.php?lang='.$sLang);
            }
            elseif(!isset($bError)){
                $sEcho=$sEcho.'L\'Upload NE s\'est PAS déroulé correctement (???)...<br>';
            }
            else{$sEcho=$sEcho.'<br>... AU MOINS UNE INFORMATION EST MANQUANTE OU ERRONEE...<br><br>';}
            
            // **** AFFICHE LE 'RAPPORT' ****
            // ******************************
            if($sEcho!==''){funEcho(-1,$sEcho);};
        }elseif(!isset($_POST['submit'])){
            funEcho(-1,'Vous devez renseigner le formulaire...');
        }
    // ... si les autres Input sont renseignés, mais pas le fichier...
    }elseif(isset($_POST['submit'])){
        funEcho(-1,'Vous devez choisir une image pour la présentation sur la page d\'accueil.');
    // Dans le cas du 1er passage, entrée dans le contrôleur
    }else{
        funEcho(2,'Pensez à choisir un fichier image pour la présentation sur la page d\'accueil.');
    }
    // ... 

    require_once CO_PATH_ADMIN.'htmlgenerator.php';
    use Admin\htmlGenerator;

    // Si au moins 2 champs ont été trouvé,
    // construit le formulaire de type LISTE
    if(isset($arFieldNames) and count($arFieldNames)>1){

        // Supprime le champs ID de la liste
        $arFieldNames=array_diff($arFieldNames,array($sTable.'_id'));
?>
    

<!-- <div class="d-flex flex-column mx-5 pt-3"> -->
    <div class="align-items-center" id="DivTitleRow">
        <p class="p--title-form" id="PMyFormation">
            <?php
                if($sLang==='fr')
                {echo"Ajout d'une réalisation :";}
                else{echo"Add a production :";};
            ?>
        </p>
    </div>
<!-- </div> -->

<div class="d-flex flex-row pb-5 mb-5 justify-content-center">
    <form class="py-3 col-10" method="post" enctype="multipart/form-data"
        style="border:5px solid black;align-self:centered;" novalidate
    >

        <?php
        
            // 20211025 - Source langage BdD (1/3)
            //-------------------------------------
            $arLanguages=$obPDO->execSqlQuery("select label from language");
            //-------------------------------------

            foreach($arFieldNames as $sValue){
        ?>

        <div class="div--form-row">
            <div class="d-flex flex-column col-12 col-md-4">
                <?php echo htmlGenerator::getHtmlLabel($sValue,null,true);?>
            </div>
            <div class="d-flex flex-column col-12 col-lg-8">
                <?php

                    // 20211025 - Source langage BdD (2/3)
                    //-------------------------------------
                    // $arLanguages=$obPDO->getClass4Field($sValue);
                    //-------------------------------------

                    // calcule de la valeur par défaut
                    if(isset($_POST[$sValue])){$sDefaultValue=$_POST[$sValue];}
                    else{$sDefaultValue='';}
                    // génération des éléments HTML
                    if(strstr($sValue,"owner")){
                ?>
                <p><?=$_SESSION['email']?></p>
                <?php
                    }

                    // 20211025 - Source langage BdD (3/3)
                    //-------------------------------------
                    elseif(gettype(strpos($sValue,"lang"))=='integer' and strpos($sValue,"lang")==0){
                        echo htmlGenerator::getHtmlInput4Class(['select'=>$arLanguages],$sValue,$sDefaultValue,true,$sFocus);
                    }elseif($sValue=='picture_name'){
                        echo htmlGenerator::getHtmlInput4Class(['file',''],$sValue,$sDefaultValue,true,$sFocus);
                    // elseif(isset($arLanguages)){
                    //     echo htmlGenerator::getHtmlInput4Class($arLanguages,$sValue,$sDefaultValue,true,$sFocus);
                    //-------------------------------------

                    }else{
                        echo htmlGenerator::getHtmlInput4Class(null,$sValue,$sDefaultValue,true,$sFocus);
                    }
                ?>
            </div>
        </div>
        <br>

        <?php
            }
        ?>

        <div class='d-flex flex-row justify-content-around'>
            <a href=<?=CO_HTTP_ADMIN.'index.php?lang='.$sLang;?> class="btn btn-secondary"><?php if($sLang==='fr'){echo'Retour à la liste';}else{echo'Cancel';}?></a>
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
<!-- ***** Create.PHP (language) : END ***** -->