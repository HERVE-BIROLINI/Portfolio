

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
    <p>
		<?php
			if($sLang==='fr')
			{echo"© Mars 2021 - Ce portfolio a été créé par Hervé BIROLINI (HTML5 / CSS3 / Javascript / JQuery / PHP)";}
			else{echo"© 2021 March - This portfolio was created by Hervé BIROLINI (HTML5 / CSS3 / Javascript / JQuery / PHP)";}
		?>
	</p>

</footer>

<!-- ***** 95-FOOTER.PHP : END ***** -->