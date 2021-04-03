<?php

    use App\DBTools;

	/**** LOADING OF 'PARTS' OF MAIN PHP PAGE ****/
	/** ... STRICLY REQUIRED PARTS (PHP codes mainly) **/
	require_once __DIR__."/../Requires/00-PHP_Init.php";
	//
	foreach(funDirFiles(CO_PATH_REQUIRES_TOP,'') as $sFile){
		if(ctype_digit(substr($sFile,0,2))){
			require_once CO_PATH_REQUIRES_TOP.$sFile;
		}
	}
    
    // Si poursuite du programme...
    // ... définie les variables en rapport avec la table à lire
    $sTable='wf3';
    // ... récupération des projets WF3, par la présence d'une image pour chaque
    $arWF3=fundirfiles(CO_PATH_SRC_WF3,'png');
    //
    
    // récupère la liste des champs de la table à lire
    $obPDO=new Requires\DBTools();
    $obPDO->init();

    $arItem=$obPDO->execSqlQuery("select * from $sTable where ".$sTable."_id=:".$sTable."_id",
                                    [$sTable."_id"=>$_GET['id']]
                                );
    $arItem=$arItem[0];
?>

<style type="text/css">
    .DivProductView{
        padding-top: 25px;
        width:95vw;
        height:82vh;
        background:#cecece;
        /**/
        position:fixed;
        left:2.5vw;
        bottom:7vh;
        /**/
        filter: drop-shadow(0px 2px 5px black);
        /**/
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .DivSizingIFrame{
        height:20px;
    }
    .ifProductView{
        margin-top:25px;
        width:375px;
        height:50%;
    }
    .fas,.far{
        margin-left:10px;
        margin-right:10px;
    }
    /**/
    .fas:hover,.far:hover{
        cursor:pointer;
        color:blue;
    }
    /**/
    .close{
        position:absolute;
        top:0.5em;
        right:0;
    }
    .fa-window-close{
        color:red;
    }
    .fa-window-close:hover{
        cursor:pointer;
        color:#FF0000;
    }
</style>
<!-- -->
<script type="text/javascript">
    //
    $(document).ready(function(){
        /* affichage : taille Mobile */
        $('body').on('click','.fa-mobile-alt',function(){
            if(window.innerWidth>425){
                $('.fa-mobile-alt').css('color','#2E8B57');
                $('.fa-tablet-alt').css('color','');
                $('.fa-laptop').css('color','');
                $('.fa-desktop').css('color','');
                $('.ifProductView').css('width','425px');
                $('.DivProductView').css('minwidth','425px');
            }
        });
        /* affichage : taille Tablette */
        $('body').on('click','.fa-tablet-alt',function(){
            if(window.innerWidth>768){
                $('.fa-mobile-alt').css('color','');
                $('.fa-tablet-alt').css('color','#2E8B57');
                $('.fa-laptop').css('color','');
                $('.fa-desktop').css('color','');
                $('.ifProductView').css('width','768px');
                $('.DivProductView').css('minwidth','768px');
            }
        });
        /* affichage : taille Laptop */
        $('body').on('click','.fa-laptop',function(){
            console.log(window.innerWidth);
            if(window.innerWidth>1100){
                $('.fa-mobile-alt').css('color','');
                $('.fa-tablet-alt').css('color','');
                $('.fa-laptop').css('color','#2E8B57');
                $('.fa-desktop').css('color','');
                $('.ifProductView').css('width','1040px');
                $('.DivProductView').css('minwidth','1040px');
            }
        });
        /* affichage : taille Desktop */
        $('body').on('click','.fa-desktop',function(){
            if(window.innerWidth>1500){
                $('.fa-mobile-alt').css('color','');
                $('.fa-tablet-alt').css('color','');
                $('.fa-laptop').css('color','');
                $('.fa-desktop').css('color','#2E8B57');
                $('.ifProductView').css('width','1440px');
                $('.DivProductView').css('minwidth','1440px');
            }
        });
        /**/
        /* affichage : taille Desktop */
        $('body').on('click','.fa-window-maximize',function(){
            window.open($('.ifProductView').attr('src'));
        });
        /**/
        /* retour vers la page index */
        $('body').on('click','.close',function(){
            var sPathName=window.location.pathname;
            sPathName=sPathName.split('/');
            //
            sPathName=sPathName[1];
            window.location.href='/'+sPathName+'/index.php?lang='+$sLang+'#MyFormation';
        });
    })
</script>

<div class="DivProductView"> <!-- style="visibility: hidden;"-->
    <div class="close">
        <i class="far fa-window-maximize"></i>
        <i class="fas fa-window-close"></i>
    </div>
    <div><h4><?php if($sLang=='fr'){echo'Contrôle du ResponsiveDesign';}else{echo'ResponsiveDesign control';}?></h4></div>
    </br>
    <div class='DivSizingContent'>
        <i class="fas fa-mobile-alt" style='color:#2E8B57;'></i>
        <i class="fas fa-tablet-alt"></i>
        <i class="fas fa-laptop"></i>
        <i class="fas fa-desktop"></i>
        <!-- <div class='DivSizingIFrame' id='2560px'><div class='DivSizingIFrame' id='1440px'><div class='DivSizingIFrame' id='768px'><div class='DivSizingIFrame' id='375px'><div class='DivSizingIFrame' id='320px'><p id='PSizeIFrame'></p></div></div></div></div></div></div></div> -->
    </div>
    <iframe class="ifProductView" title="Title"
        src="<?=$arItem['url']?>" style='width:425px;'>
    </iframe>
    </br>
    <a href="<?=$arItem['url']?>"></a>
    <h4 class="H4ProductView"><?=$arItem['title_'.$sLang]?></h4>
    </br>
    <h6 class="H6ProductView"><?=$arItem['subject_'.$sLang]?></h6>
    <p class="PProductView"><?=$arItem['comments_'.$sLang]?></p>
</div>


<?php
	//
	foreach(funDirFiles(CO_PATH_REQUIRES_BOTTOM,'') as $sFile){
		if(ctype_digit(substr($sFile,0,2))){
			require_once CO_PATH_REQUIRES_BOTTOM.$sFile;
		}
	}
?>