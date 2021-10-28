<!-- ***** Responsivecontrol.PHP (WF3) : START ***** -->
<?php
    session_start();

	/**** LOADING OF 'PARTS' OF MAIN PHP PAGE ****/
	/** ... STRICLY REQUIRED PARTS (PHP codes mainly) **/
	require_once __DIR__."/../requires/00-php_init.php";
	//
	foreach(funDirFiles(CO_PATH_REQUIRES_TOP,'') as $sFile){
		if(ctype_digit(substr($sFile,0,2))){
			require_once CO_PATH_REQUIRES_TOP.$sFile;
		}
	}
    
// $_SESSION['email']='guest';
// $_SESSION['admin']='0';
    // Si poursuite du programme...
    // ... définie les variables en rapport avec la table à lire
    $sTable='wf3';
    // ... récupération des projets WF3, par la présence d'une image pour chaque
    $arWF3=fundirfiles(CO_PATH_SRC_WF3,'png');
    //
    
    // récupère la liste des champs de la table à lire
    $obPDO=new App\DBTools();
    $obPDO->init();

    $arItem=$obPDO->execSqlQuery("select * from $sTable where ".$sTable."_id=:".$sTable."_id",
                                    [$sTable."_id"=>$_GET['id']]
                                );
    $arItem=$arItem[0];
?>

<div class="DivProductView " id="blk--2hide-if-phonescreen">
    <div class="close">
        <i class="far fa-window-maximize"
            title="<?php if($sLang=='fr'){echo'Ouvrir dans une nouvelle fenêtre';}else{echo'Open un a new window';}?>"
        ></i>
        <i class="fas fa-window-close"
            title="<?php if($sLang=='fr'){echo'Retour à la page d\'accueil';}else{echo'Back to home page';}?>"
        ></i>
    </div>
    <div><h4><?php if($sLang=='fr'){echo'Contrôle du ResponsiveDesign';}else{echo'ResponsiveDesign control';}?></h4></div>
    <br>
    <div class='DivSizingContent'>
        <i class="fas fa-mobile-alt screen-mobile" style='color:#2E8B57;'
            title="<?php if($sLang=='fr'){echo'Emulation smartphone';}else{echo'Smartphone emulation';}?>"
        ></i>
        <i class="fas fa-tablet-alt screen-tablet"
            title="<?php if($sLang=='fr'){echo'Emulation tablette';}else{echo'Tablet emulation';}?>"
        ></i>
        <i class="fas fa-laptop screen-laptop"
            title="<?php if($sLang=='fr'){echo'Emulation PC portable';}else{echo'Laptop emulation';}?>"
        ></i>
        <i class="fas fa-desktop screen-desktop"
            title="<?php if($sLang=='fr'){echo'Emulation PC de bureau';}else{echo'Desktop emulation';}?>"
        ></i>
    </div>
    <iframe class="ifProductView" title="Title"
        src="<?=$arItem['url']?>" style='width:425px;'>
    </iframe>
    <br>
    <a href="<?=$arItem['url']?>"></a>
    <h4 class="H4ProductView"><?=$arItem['title_'.$sLang]?></h4>
    <br>
    <h6 class="H6ProductView"><?=$arItem['subject_'.$sLang]?></h6>
    <p class="PProductView"><?=$arItem['comments_'.$sLang]?></p>
</div>

<div class="" id="blk--2show-if-phonescreen" style="display:none;">
    <span>
        <?php
            if($sLang=='fr'){echo"L'outil de comparaison du ResponsiveDesign sur un écran de petite taille ne peut-être exécuté...";}
            else{echo"The ResponsiveDesign comparison tool on a little size screen cannot be run...";}
        ?>
    </span>
</div>


<?php
	//
	foreach(funDirFiles(CO_PATH_REQUIRES_BOTTOM,'') as $sFile){
		if(ctype_digit(substr($sFile,0,2))){
			require_once CO_PATH_REQUIRES_BOTTOM.$sFile;
		}
	}
?>
<!-- ***** Responsivecontrol.PHP (WF3) : END ***** -->