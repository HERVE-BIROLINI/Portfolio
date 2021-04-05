

<!-- ***** 95-FOOTER.PHP : START ***** -->

<?php
// echo'</br> - Chargement (include) du    FOOTer.PHP...';
?>


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
		.Div-ShortCuts_Row{
			display:flex;
			flex-direction:row;
			justify-content:space-evenly;
		}
		.ShortCuts{
			margin:10px;
			color:white;
		}
        footer > p{
            color:white;
			font-style:italic;
        }
    </style>

	<!-- Incorporation du Javascript spécifiques à cette section du HTML,
	pour éviter les dissociation/désactivation de l'utilisateur : -->
    <script type="text/javascript">
		$(document).ready(function(){
			// Si besoin...
		});
    </script>
	
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
			<img class="fab ShortCuts" src="<?=CO_HTTP_SRC.'curriculum vitae.png'?>" style="height:17px;filter:invert(100%);padding-bottom:3px;"></i>
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