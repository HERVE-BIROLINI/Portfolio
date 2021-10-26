<!-- ***** Create.PHP (WF3) : START ***** -->
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
    $sTable='language';
    // ... récupère la liste des champs de la table à Editer
    $obPDO=new App\DBTools();
    $obPDO->init();
    $arFieldNames=$obPDO->funGetNameOfColumns($sTable);
    
    // Au 2nd passage, suite à SUBMIT...
    if(isset($_POST['submit'])){
        // ... crée la chaîne pour la requête, sur l'architecture "détectée" dans la base de données
        $sFields='';
        $sValues='';
        $arNewValues=[];
        foreach($arFieldNames as $sFieldName){
            // cas particulier de la clé primaire, ne peut-être écrite
            if(strstr($sFieldName,'id_') or strstr($sFieldName,'_id') or $sFieldName=='id'){
                $sPrimaryKey=$sFieldName;
            }
            // tous les autres cas...
            elseif(isset($_POST[$sFieldName]) ){//or $_FILES[$sFieldName]['name']!==''){
                $sFields.=$sFieldName.',';
                $sValues.='?,';
                if(isset($_POST[$sFieldName]) and $_POST[$sFieldName]!=''){array_push($arNewValues,$_POST[$sFieldName]);}
                // elseif(isset($_POST[$sFieldName])){$sFocus=$sFieldName;}
                else{array_push($arNewValues,strtolower($_FILES[$sFieldName]['name']));}
            }
        }
        //
        $sFields=substr($sFields,0,-1);
        $sValues=substr($sValues,0,-1);
        //
        $obPDO->execSqlQuery('insert into '.$sTable.' ('.$sFields.') values('.$sValues.')',$arNewValues);
        header('location:'.CO_HTTP_ADMIN.'index.php?lang='.$sLang);
    }

    require_once CO_PATH_ADMIN.'htmlgenerator.php';
    use Admin\htmlGenerator;

    // Si au moins 2 champs ont été trouvé, construit le formulaire de type LISTE
    if(isset($arFieldNames) and count($arFieldNames)>1){

        // Supprime le champs ID de la liste
        $arFieldNames=array_diff($arFieldNames,array('id'));
?>
    

<div class="d-flex flex-column mx-5 pt-3">
    <div class="d-flex flex-row align-items-center w-100 pr-5" id="DivTitleRow">
        <p class="PMyFormation"><?php if($sLang==='fr'){echo"Ajout d'un langage :";}else{echo"Add a language :";}; ?></p>
    </div>
</div>

<div class="d-flex flex-row pb-5 mb-5 justify-content-center">
    <form class="py-3 col-10" method="post" enctype="multipart/form-data"
        style="border:5px solid black;align-self:centered;" novalidate
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
                    // calcule de la valeur par défaut
                    if(isset($_POST[$sValue])){$sDefaultValue=$_POST[$sValue];}
                    else{$sDefaultValue='';}
                    // génération des éléments HTML
                    echo htmlGenerator::getHtmlInput($sValue,'',$sDefaultValue,true);
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
<!-- ***** Create.PHP (WF3) : END ***** -->