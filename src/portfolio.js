
document.addEventListener("DOMContentLoaded", function(event){
    // POURQUOI CA NE PASSE PAS LA-DEDANS ????
    let arHtmlSelect=document.querySelectorAll('.html--select');
    console.log(arHtmlSelect);
    if(arHtmlSelect){
        // alert("yes");
    }
});

$(document).ready(function(){


    // DEBUT 12-NAV //
    //--------------//
    if(!$sLang){
        var $arGET=$_GET();
        if($arGET['lang']){var $sLang=$arGET['lang'];}else{var $sLang='fr';}
    }
    //
    funToggleEffect4Lang($sLang);
    //
    function funToggleEffect4Lang(sCurLang){
        // /* récupération du "niveau de lecture" sur la page */
        /* changement d'affichage */
        if(sCurLang.toUpperCase()==='FR'){
            $('.DivLangFr').css(`box-shadow`,`inset 2px 2px 6px black`);
            $('.DivLangFr>p').css({"font-size":"1.1em","font-weight":"bolder"});
            $('.DivLangEn').css(`box-shadow`,`2px 2px 6px white`);
        }
        else//if(sCurLang.toUpperCase()==='en')
        {
            $('.DivLangEn').css(`box-shadow`,`inset 2px 2px 6px black`);
            $('.DivLangEn>p').css({"font-size":"1.1em","font-weight":"bolder"});
            $('.DivLangFr').css(`box-shadow`,`2px 2px 6px white`);
        }
        // alert('entre ici');
    }
    //------------//
    // FIN 12-NAV //






    // DEBUT 40-MyFormation //
    //----------------------//
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
    $('body').on('change','.html--select',function(){
        // stock la valeur choisi pour le filtre d'affichage des réalisations
        var sNewOption=this.value;
        // boucle sur les options proposées par la liste déroulantes
        for(var iCount=0; iCount<this.options.length;iCount++){
            var sCurOption=this.options[iCount].value;
            //
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
    });
    //
    $('body').on('click','.DivFormationIMG',function(){
        window.location.href='../wf3/responsivecontrol.php?lang='+$sLang+'&id='+$(this).find('.PId').text();
        // window.location.href='php/wf3/responsivecontrol.php?lang='+$sLang+'&id='+$(this).find('.PId').text();
    });
    //--------------------//
    // FIN 40-MyFormation //




    // DEBUT Footer //
    //--------------//
    // *** Gestion du scroll ***
    // -- ... Récupère la hauteur par l'appel d'une fonction,car a besoin d'être dynamique,
    // -- => grandi avec l'ajout de nouveaux éléments...
    function getHeight(){return document.documentElement.scrollHeight;};
    function getInnerHeight(){return window.innerHeight?window.innerHeight:document.documentElement.clientHeight;};
    function getScrollTop(){return Math.max(document.body.scrollTop,document.documentElement.scrollTop);};
    // -- Fonction d'analyse de la progression du scroll et de création des nouveaux éléments
    function waitForBottom() {
        // alert('au boulot !');
        var htmlIShortCuts=document.getElementsByClassName("ShortCuts");
        var htmlImgCV=document.getElementById("ImgCV");
        if(Math.round(getScrollTop()+getInnerHeight())===Math.round(getHeight())){
            for(var htmlItem of htmlIShortCuts){
                htmlItem.style.fontSize="2.5em";
            }
            htmlImgCV.style.height="36px";
        }
        else{
            for(var htmlItem of htmlIShortCuts){
                htmlItem.style.fontSize="1em";
            }
            htmlImgCV.style.height="16px";
        }
    };
    // *** Pose de l'espion du mouvement de scrolling ***
    window.addEventListener('scroll',waitForBottom);
    //------------//
    // FIN Footer //

    



    // DEBUT Responsivecontrol //
    //-------------------------//
    /* affichage : taille Mobile */
    $('body').on('click','.fa-mobile-alt',function(){
        if(window.innerWidth>425){
            $('.screen-mobile').css('color','#2E8B57');
            $('.screen-tablet').css('color','');
            $('.screen-laptop').css('color','');
            $('.screen-desktop').css('color','');
            $('.ifProductView').css('width','425px');
            $('.DivProductView').css('minwidth','425px');
        }
    });
    /* affichage : taille Tablette */
    $('body').on('click','.fa-tablet-alt',function(){
        if(window.innerWidth>768){
            $('.screen-mobile').css('color','');
            $('.screen-tablet').css('color','#2E8B57');
            $('.screen-laptop').css('color','');
            $('.screen-desktop').css('color','');
            $('.ifProductView').css('width','768px');
            $('.DivProductView').css('minwidth','768px');
        }
    });
    /* affichage : taille Laptop */
    $('body').on('click','.fa-laptop',function(){
        console.log(window.innerWidth);
        if(window.innerWidth>1100){
            $('.screen-mobile').css('color','');
            $('.screen-tablet').css('color','');
            $('.screen-laptop').css('color','#2E8B57');
            $('.screen-desktop').css('color','');
            $('.ifProductView').css('width','1040px');
            $('.DivProductView').css('minwidth','1040px');
        }
    });
    /* affichage : taille Desktop */
    $('body').on('click','.fa-desktop',function(){
        if(window.innerWidth>1500){
            $('.screen-mobile').css('color','');
            $('.screen-tablet').css('color','');
            $('.screen-laptop').css('color','');
            $('.screen-desktop').css('color','#2E8B57');
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
    //-----------------------//
    // FIN Responsivecontrol //

});