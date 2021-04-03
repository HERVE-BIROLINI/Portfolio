
<!-- ***** 40-MYFORMATION.PHP : START ***** -->

<?php
    // Si poursuite du programme...
    // ... définie les variables en rapport avec la table à lire
    $sTableWf3='wf3';
    // ... récupération des projets WF3, par la présence d'une image pour chaque
    // $arWF3=fundirfiles(CO_PATH_SRC_WF3,'png');
    // var_dump($arWF3);
    $obPDO=new Requires\DBTools;
    $obPDO->init();

    //
    require_once CO_PATH_ADMIN.'htmlgenerator.php';
    use Admin\htmlGenerator;

?>
<!-- -->
<style type="text/css">
    #MyFormation{
        background-color:#cecece;
        padding:3em;
    }
    .PMyFormation{
        font-size:2.5em;
        font-family:'barlow';
    }
    .DivFormationIMG{
        margin:2.5px;
        margin-bottom:50px;
        height:35vh;
        width:45%;
        background-repeat: no-repeat;
        background-size: cover;
        background-position: top center ;
        filter: drop-shadow(0px 5px 10px black);
    }
    @media only screen and (max-width: 860px) {
        .DivFormationIMG{width:100%;}
    }
    .DivFormationIMG:hover{
        cursor:pointer;
    }
    .DivFormationIMG:active{
        filter: none;
    }
    .DivTitle{
        background-color:white;
        height:35px;
        width:100%;
        position:absolute;
        bottom:0em;
        left:0em;
        text-align:center;
        align-items:center;
        filter: drop-shadow(0px 2px 5px black);
    }
    .title{
        padding-top:5px;
    }
</style>
<!-- -->
<script type="text/javascript">
    // Fait tourner l'image dans le Carousel, et afficher le bon texte...
    // function funRotateImage(vImage){
    //     var sClassArrow=vImage.children('Img').attr('class').toUpperCase();
    //     //
    //     var sFileName=vImage.parent().children('.ImgVehicle').attr(`src`).substr(15,1);
    //     if(sFileName===`0`){
    //         sFileName=vImage.parent().children('.ImgVehicle').attr(`src`).slice(0,15)+'1.png'
    //     }
    //     else{
    //         sFileName=vImage.parent().children('.ImgVehicle').attr(`src`).slice(0,15)+'0.png'
    //     }
    //     // vImage.parent().children('.ImgVehicle').attr(`src`,sFileName);
    //     funChangeImageWithFade(vImage.parent().children('.ImgVehicle'),sFileName);
    // }
    //
    // function funChangeImageWithFade(htmlImage,sFileImage){
    //     var iDelay=150;
    //     htmlImage.fadeOut(iDelay);
    //     // - Méthode JQuery :
    //     setTimeout(function(){htmlImage.attr(`src`,sFileImage);},iDelay);
    //     /**/
    //     htmlImage.fadeIn(iDelay);
    // }
    //
    $(document).ready(function(){
        //
        $('body').on('change','#select',function(){
            // stock la valeur choisi pour le filtre d'affichage des réalisations
            var sNewOption=this.value;
            // boucle sur les options proposées par la liste déroulantes
			for(var iCount=0; iCount<this.options.length;iCount++){
                var sCurOption=this.options[iCount].value;
            //     //
                if(sNewOption=='*' || sCurOption==sNewOption){
                    if(sCurOption!=='*'){
                        $('.'+sCurOption).each(function(){
                            $(this).fadeIn();
                        });
                    }
                }
                else if(sCurOption!=='*'){
                    $('.'+sCurOption).each(function(){
                        $(this).fadeOut();
                    });
                }
                else{console.log('  => Ne traite pas * !');}
			}
        })
        //
        $('body').on('click','.DivFormationIMG',function(){
            window.location.href='php/wf3/responsivecontrol.php?lang='+$sLang+'&id='+$(this).find('.PId').text();
        })
    })
</script>


<div id="MyFormation"> <!--class="SecMyFormationColumn"-->

    <div class="row align-items-center">
        <p class="PMyFormation" style="margin-right:150px;"><?php if($sLang==='fr'){echo"Ma Formation, avec WebForce3 :";}else{echo"My Training, with WebForce3 :";};?></p>
        <div class="row align-items-center justify-content-between" style="margin-bottom:10px;"><!--width:25%">-->
            <label for="language"><?php if($sLang==='fr'){echo"Langages : ";}else{echo"Languages : ";}?></label>
            <?php echo htmlGenerator::getHtmlInput4Class($obPDO->getLanguages());?>
        </div>
        
    </div>

    <div class="d-flex flex-row col-12 flex-wrap"style="justify-content:space-evenly;">
        <?php
            // récupère la liste des champs de la table à lire
            $arFieldNames=$obPDO->funGetNameOfColumns($sTableWf3);
            // vérifie si existe un champs pour le tri
            if(in_array('priority',$arFieldNames))
            {$arItems=$obPDO->execSqlQuery("SELECT * from $sTableWf3 order by priority");}
            else{$arItems=$obPDO->execSqlQuery("SELECT * from $sTableWf3");}
            //
            foreach($arItems as $arItem){
        ?>
        <div class="DivFormationIMG <?=$arItem['language']?>" style="background-image:url('<?=CO_HTTP_SRC_WF3.$arItem['picture_name']?>');">
            <div class="DivTitle"><h5 class="title"><?=$arItem['title_'.$sLang]?></h5></div>
            <p class="PId" style="visibility:hidden;"><?=$arItem[$sTableWf3.'_id']?></p>
        </div>
        <?php }?>
    </div>
</div>

<!-- ***** 40-MYFORMATION.PHP : END ***** -->