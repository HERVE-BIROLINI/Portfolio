
document.addEventListener("DOMContentLoaded", function(event){
    // console.log("dans DOMContentLoaded...");
    // // POURQUOI CA NE PASSE PAS LA-DEDANS ????
    // let arHtmlSelect=document.querySelectorAll('.html--select');
    // // console.log(arHtmlSelect);
    // if(arHtmlSelect){
    //     // alert("yes");
    // }
});

$(document).ready(function(){
	// BIZARRE, ON DIRAIT QUE NON !!!
	//--------------------------------
		// /* Si besoin d'utiliser $sLang,
		// * il faudra copier la fonction dans ce fichier,
		// * et instancier de nouveau la variable.
		// * ==> les fonctions et variables JS ne sont pas "transmissibles"
		// *	 d'un fichier à l'autre, contraire au PHP...
		// * !!!! DONC $_GET NE SERT A RIEN ICI !!!!
		// */
		function $_GET(param){
			var aVars={};
			window.location.href.replace(location.hash,'').replace( 
				/[?&]+([^=&]+)=?([^&]*)?/gi,
				function(m,key,value){aVars[key]=value!==undefined?value:'';}
			);
			if(param){return aVars[param]?aVars[param]:null;}
			return aVars;
		}
		//
		function funNoClick(){
			// alert('Clic droit interdit');
			return(false);
		}
		/**/
		// var $arGET=$_GET();
		// if($arGET['lang']){var $sLang=$arGET['lang'];}else{var $sLang='fr';}
		// /**/
		// $(document).ready(function(){
		// 	//
		// 	document.contextmenu=funNoClick();
		// });

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
            // else{console.log('  => Ne traite pas * !');}
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
    function getHeight(){return document.documentElement.scrollHeight;};
    function getInnerHeight(){return window.innerHeight?window.innerHeight:document.documentElement.clientHeight;};
    function getScrollTop(){return Math.max(document.body.scrollTop,document.documentElement.scrollTop);};

    // *** à l'ouverture, si page moins haute que l'écran, fixe le Footer ***
    let htmlFooter=document.querySelector('footer');
    if(htmlFooter){
        // if(Math.round(document.body.clientHeight)<Math.round(getInnerHeight())){
            htmlFooter.setAttribute("style","position:fixed;bottom:-0.75em;");
        // }
    }
    
    // *** Gestion du scroll ***
    // -- ... Récupère la hauteur par l'appel d'une fonction,car a besoin d'être dynamique,
    // -- => grandi avec l'ajout de nouveaux éléments...
    // -- Fonction d'analyse de la progression du scroll et de création des nouveaux éléments
    function waitForBottom() {
        // alert('au boulot !');
        var htmlShortCuts=document.getElementsByClassName("ShortCuts");
        var htmlImgCV=document.getElementById("ImgCV");

        // ... pour ne pas "casser" le media query qui réduit les dimensions sur écran de téléphone...
        if(window.innerWidth>550){
            
        if(Math.round(getScrollTop()+getInnerHeight())===Math.round(getHeight())){
            for(var htmlItem of htmlShortCuts){
                htmlItem.style.fontSize="2.5em";
            }
            htmlImgCV.style.height="36px";
        }
        else{
            for(var htmlItem of htmlShortCuts){
                htmlItem.style.fontSize="1em";
            }
            htmlImgCV.style.height="16px";
        }
        
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

    //------------------------------------------------------------------
    // *** DEBUT - Gestion du centrage d'un élément dans son parent ***
    //------------------------------------------------------------------
    let arToCenterInto=document.querySelectorAll('.tocenterinto');
    if(arToCenterInto){
        arToCenterInto.forEach(htmlItem => {
            htmlItem.parentNode.style.position='relative';
            htmlItem.style.position='absolute';
        })
    }
    //----------------------------------------------------------------
    // *** FIN - Gestion du centrage d'un élément dans son parent ***
    //----------------------------------------------------------------


    
    let htmlBlk2HideIfPhone=document.querySelector('#blk--2hide-if-phonescreen');
    let htmlBlk2ShowIfPhone=document.querySelector('#blk--2show-if-phonescreen');
    if(htmlBlk2HideIfPhone){
        if(Math.round(document.body.clientWidth)<768){
            htmlBlk2HideIfPhone.style.display="none";
            //
            htmlBlk2ShowIfPhone.style.display="";
        }
    }
    // *** Pose de l'espion du mouvement de scrolling ***
    window.addEventListener('resize', function(event) {
        if(htmlBlk2HideIfPhone){
            if(Math.round(document.body.clientWidth)<768){
                htmlBlk2HideIfPhone.style.display="none";
                htmlBlk2ShowIfPhone.style.display="";
            }else{
                htmlBlk2HideIfPhone.style.display="";
                htmlBlk2ShowIfPhone.style.display="none";
            }
        }
    }, true);


    
    //------------------------------------------------------------------------
    // *** DEBUT - Gestion de l'affichage des pages relatives aux onglets ***
    //------------------------------------------------------------------------
    // ** Analyse le template et récupère toutes les rangées de Class "imitation classeur Excel" **
    let arRowTabtype=document.querySelectorAll('.row--tabtype');
    // ** Si au moins une rangée a été trouvée dans le Template **
    if(arRowTabtype.length>0){
        // * recherche l'existance d'un "drapeau" de mémorisation de l'onglet par défaut s'il existe *
        //     (usage "couplé" avec des traitement par requête(s) vers le serveur PHP)
        let htmlByDefault=document.querySelector('#default_item');
        // * Pour chaque "Block" multi-tab (rangée d'onglets) trouvé dans le Template... *
        arRowTabtype.forEach(rowTabtype => {
            // ... recherche le "jeu" d'onglets qui lui est associé
            let arBtnTabtype=document.querySelectorAll('.btn--tabtype[parent_id="'+rowTabtype.id+'"]');
            // pour chaque onglet trouvé...
            arBtnTabtype.forEach(btnTabType => {
                // ... lui "colle" une fonction de réaction (callback) associée à l'évènement Click
                btnTabType.onclick=showhideBlockForSelectedTab;
                //
                // pour initialisation à l'ouverture de la page...
                // ... selon qu'il existe un "drapeau" de mémorisation de l'état précédent
                //     (si retour après requête vers le serveur PHP)
                if(htmlByDefault!=null && htmlByDefault.value===btnTabType.id){
                    activeTabAndBlockOfSelectedTab(btnTabType);
                }
                // ... ou que l'onglet en cours de traitement est défini par défaut dans le Template
                else if(btnTabType.getAttribute('default')!=null){
                    activeTabAndBlockOfSelectedTab(btnTabType);
                }
            });
        });

        // * Gère l'affichage de la table et l'effet visuel de l'onglet *
        function showhideBlockForSelectedTab(){
            activeTabAndBlockOfSelectedTab(this);
        }
        function activeTabAndBlockOfSelectedTab(btnTab2Activate){
            // récupère tous les onglets ‘voisins’ ...
            let arBtnTabtype=document.querySelectorAll('.btn--tabtype[parent_id="'+btnTab2Activate.getAttribute('parent_id')+'"]');
            // ... gestion des effets visuels sur les onglets
            if(arBtnTabtype){
                arBtnTabtype.forEach(btnTabType => {
                    // si l’itération courante est l'onglet « cliqué » => à mettre en évidence...    
                    if(btnTabType==btnTab2Activate){
                        // ... text & background
                        btnTabType.style.color='black';
                        btnTabType.style.fontWeight ='bold';
                        btnTabType.style.backgroundColor='white';
                        // ... borders
                        btnTabType.style.borderBottom='0';
                        btnTabType.style.boxShadow='0 0 0 0, 0 -4px 4px 0 rgb(140, 140, 140)';
                        // affiche le « bloc » de données associé à l’onglet « cliqué »
                        let arChildren=document.querySelectorAll('.block--tabtype[parent_id="'+btnTab2Activate.id+'"]')
                        arChildren.forEach(blkChild => {
                            blkChild.style.display="";
                        });
                    }
                    // si l’itération courante N’est PAS l'onglet « cliqué » => à « banaliser »...    
                    else{
                        // ... text & background
                        btnTabType.style.color='black';
                        btnTabType.style.fontWeight ='normal';
                        btnTabType.style.backgroundColor="rgb(233, 236, 239)";
                        // ... borders
                        btnTabType.style.borderBottom='0.5px solid black';
                        btnTabType.style.boxShadow='0 0 0 0';
                        // ????????????
                        if(btnTabType.id==btnTab2Activate.id){
                            let arChildren=document.querySelectorAll('.block--tabtype[parent_id="'+btnTab2Activate.id+'"]')
                            arChildren.forEach(blkChild => {
                                blkChild.style.display="";
                            });
                        // cache le « bloc » associé à l’onglet de l’itération courante (n’étant pas celui « cliqué »)
                        }else{
                            let arChildren=document.querySelectorAll('.block--tabtype[parent_id="'+btnTabType.id+'"]');
                            arChildren.forEach(blkChild => {
                                blkChild.style.display="none";
                            });
                        }
                    }
                })
            }
            // "mémorise" l'onglet activé, pour le cas d'un aller/retour avec le serveur PHP
            if(htmlByDefault){
                htmlByDefault.value=btnTab2Activate.id;
            }
        }
    }
    //----------------------------------------------------------------------
    // *** FIN - Gestion de l'affichage des pages relatives aux onglets ***
    //----------------------------------------------------------------------

});