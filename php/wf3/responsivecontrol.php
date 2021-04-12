<?php

    use App\DBTools;

	/**** LOADING OF 'PARTS' OF MAIN PHP PAGE ****/
	/** ... STRICLY REQUIRED PARTS (PHP codes mainly) **/
	// require_once __DIR__."/../../00-php_init.php";
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
    $obPDO=new Requires\DBTools();
    $obPDO->init();

    $arItem=$obPDO->execSqlQuery("select * from $sTable where ".$sTable."_id=:".$sTable."_id",
                                    [$sTable."_id"=>$_GET['id']]
                                );
    $arItem=$arItem[0];
?>

<style type="text/css">
    .DivProductView{
        background:#cecece;
        padding-top: 25px;
        padding-bottom: 25px;
        width:95vw;
        height:80vh;
        border-radius:10px;
        /**/
        position:fixed;
        left:2.5vw;
        bottom:11vh;
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
        /* affichage : Nouvelle fenêtre d'explorateur */
        $('body').on('click','.fa-window-maximize',function(){
            window.open($('.ifProductView').attr('src'));
        });
        /**/
        /* retour vers la page index */
        $('body').on('click','.close',function(){
            //
            if(window.location.port.length==0)
            {sPathName=window.location.protocol+'//'+window.location.hostname;}
            else{sPathName=window.location.protocol+'//'+window.location.hostname+':'+window.location.port+'/portfolio';}
            window.location.href=sPathName+'/?lang='+$sLang+'#MyFormation';
        });
    })
</script>

<div class="DivProductView">
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