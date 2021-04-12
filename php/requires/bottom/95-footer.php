

<!-- ***** 95-FOOTER.PHP : START ***** -->

<?php
// echo'</br> - Chargement (include) du    FOOTer.PHP...';
?>

	<!-- Incorporation du Javascript spécifiques à cette section du HTML,
	pour éviter les dissociation/désactivation de l'utilisateur : -->
<script type="text/javascript">
	$(document).ready(function(){
		// *** Gestion du scroll ***
		// -- ... Récupère la hauteur par l'appel d'une fonction,car a besoin d'être dynamique,
		// -- => grandi avec l'ajout de nouveaux éléments...
		function getHeight(){return document.documentElement.scrollHeight;};
		function getInnerHeight(){return window.innerHeight?window.innerHeight:document.documentElement.clientHeight;};
		function getScrollTop(){return Math.max(document.body.scrollTop,document.documentElement.scrollTop);};
		// -- Fonction d'analyse de la progression du scroll et de création des nouveaux éléments
		function waitForBottom() {
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

	});
	//
</script>

<div style="padding-top:30px"></div>

<footer class="d-flex flex-column">
    <style type="text/css">
        footer{
			position:fixed;
			bottom:-0.75em;
			/* bottom:0; */
			width:100%;
			z-index: 1;
			/**/
			text-align:center;
            background-color:grey;
        }
		#Div-ShortCuts_Row{
			display:flex;
			flex-direction:row;
			justify-content:center;
		}
		.ShortCuts{
			margin:15px;
			color:white;
		}
		#ImgCV{
			filter:invert(100%);
			height:16px;
		}
        footer > p{
            color:white;
			font-style:italic;
        }
    </style>
	
	<div id="Div-ShortCuts_Row">
		<a href="mailto:birolini.herve@gmail.com" title="M'envoyer un courriel">
			<i class="fas fa-envelope ShortCuts"></i>
		<a href="tel:0671100299" title="Me téléphoner">
			<i class="fas fa-mobile-alt ShortCuts"></i>
		</a>
		<a href="https://github.com/herve-birolini" target="blank">
			<i class="fab fa-github-square ShortCuts"></i>
		</a>
		<a href="https://www.linkedin.com/in/herv%C3%A9-birolini-a09281148/" target="blank">
			<i class="fab fa-linkedin ShortCuts"></i>
		</a>
		<a href="<?=CO_HTTP_SRC.'cv/index.php'?>" target="blank">
			<img class="fab ShortCuts" id="ImgCV" src="<?=CO_HTTP_SRC.'curriculum vitae.png'?>"></i>
		</a>

	</div>
    <p>
		<?php
			if($sLang==='fr')
			{echo"© Mars 2021 - Ce portfolio a été créé par Hervé BIROLINI (HTML5 / CSS3 / Javascript / JQuery / PHP)";}
			else{echo"© 2021 March - This portfolio was created by Hervé BIROLINI (HTML5 / CSS3 / Javascript / JQuery / PHP)";}
		?>
	</p>

</footer>

<!-- ***** 95-FOOTER.PHP : END ***** -->