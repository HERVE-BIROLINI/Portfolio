
<!-- ***** 11-JS_JQUERY_BOOTSTRAP.PHP : START ***** -->
<?php
	// $sLang=$_GET['lang']; !!!! DEJA INITILISEE EN REQUIRE !!!!
	// echo"- arGET = $arGET";
?>
	<!-- Utilisation de BootStrap en JavaScript (ou simplement pour les animations)
		(doit impérativement se trouver avant la fin du BODY,
		et pour des raisons "lourdeur", les placer au plus profond,
		SAUF si comme ici, du JQUERY est imbriqué dans le HTML...)
	-->
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
	
	<!-- Si utilisation de JavaScript PERSO, peut-être placé
		aussi bien ici qu'à la fin de la balise HEAD
	<script type="module"(=> "module" pour utiliser plusieurs fichiers JS ensemble) src="" integrity="" crossorigin=""></script>
	!!! ATTENTION !!! Si utilisation de JQuery, placer sa ligne de chargement avant le JS perso !!!
	-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- INCLUSION BOOTSTRAP : Getbootstrap.com / JQUERY (CDN=LIEN EN LIGNE)-->
<!-- <script src="js/bootstrap.js"></script> -->

	<script type="text/javascript">
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
		var $arGET=$_GET();
		if($arGET['lang']){var $sLang=$arGET['lang'];}else{var $sLang='fr';}
		/**/
		$(document).ready(function(){
			//
			document.contextmenu=funNoClick();
		});
	</script>

<!-- ***** 11-JS_JQUERY_BOOTSTRAP.PHP : END ***** -->

