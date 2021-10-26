<!-- ***** 95-FOOTER.PHP : START ***** -->
<?php
// echo'<br> - Chargement (include) du    FOOTer.PHP...';
?>

<div style="padding-top:4.5em"></div>

<footer class="d-flex flex-column">
	
	<div id="Div-ShortCuts_Row">
		<a href="mailto:birolini.herve@gmail.com" title="M'envoyer un courriel">
			<i class="fas fa-envelope ShortCuts"></i>
		</a>
		<a href="tel:0671100299" title="Me téléphoner">
			<i class="fas fa-mobile-alt ShortCuts"></i>
		</a>
		<a href="https://github.com/herve-birolini" target="blank" title="Consulter mon Github">
			<i class="fab fa-github-square ShortCuts"></i>
		</a>
		<a href="https://www.linkedin.com/in/herv%C3%A9-birolini-a09281148/" target="blank" title="Consulter mon Linked-In">
			<i class="fab fa-linkedin ShortCuts"></i>
		</a>
		<a href="http://birolini-herve-cv.infinityfreeapp.com" target="blank" title="Consulter mon CV">
			<img class="ShortCuts" id="ImgCV" src="<?=CO_HTTP_SRC.'curriculum vitae.png'?>" alt="lien vers mon CV"></i>
		</a>

	</div>
    <p>
		<?php
			if($sLang==='fr')
			{echo"© Novembre 2021 - Ce portfolio a été créé par Hervé BIROLINI (HTML5 / CSS3 / Javascript / JQuery / PHP)";}
			else{echo"© 2021 November - This portfolio was created by Hervé BIROLINI (HTML5 / CSS3 / Javascript / JQuery / PHP)";}
		?>
	</p>

</footer>
<!-- ***** 95-FOOTER.PHP : END ***** -->
