
<!-- ***** 20-ACCUEIL.PHP : START ***** -->

	<div class="d-flex flex-row DivMyAccueilRow ">
		<!-- -->
		<style type="text/css">
			.DivMyAccueilRow{
			background-image:url(<?=CO_HTTP_SRC.'BckGrd_Portfolio_Birolini_Herve.png';?>);
			/**/
			background-repeat: no-repeat;
			background-size: cover;
			background-attachment: fixed;
			background-position: center center ;
			/**/
				height:95vh;
				align-items:center;
			}
			.DivAccueilColumn{
				display:flex;
				flex-direction:column;
				align-items:center;
				/**/
				width:100%;
				background-color: rgba(0,0,0,0.60);
				/**/
				color:white;
				font-family:'Roboto','Barlow';
				text-align:center;
			}
			.DivAccueilRow{
			/* border:1px solid yellow; */
				text-shadow: 1px 1px 0.1em red, 2px 2px 0.01em grey, 5px 5px 0.1em black;
				/* text-shadow: 1px 1px 2px red, 0 0 1em grey, 0 0 0.2em black; */
			}
			.DivAccueilRow>.SpanTitleBig{
				font-size:2.8em;
				font-weight:bolder;
			}
			.DivAccueilRow>.SpanTitleLittle{
				font-size:1.8em;
				font-style:italic;
			}
			/**/
			@media only screen and (max-width: 900px){
				.DivAccueilRow > .SpanTitleBig{
					font-size:2.3em;
				}
				.DivAccueilRow > .SpanTitleLittle{
					font-size:1.5em;
				}
			}
			@media only screen and (max-width: 700px){
				.DivAccueilRow > .SpanTitleBig{
					font-size:2em;
				}
				.DivAccueilRow > .SpanTitleLittle{
					font-size:1.25em;
				}
			}
			@media only screen and (max-width: 550px){
				.DivAccueilRow > .SpanTitleBig{
					font-size:1.8em;
				}
				.DivAccueilRow > .SpanTitleLittle{
					font-size:1em;
				}
			}
			@media only screen and (max-width: 375px){
				.DivAccueilRow > .SpanTitleBig{
					font-size:1.4em;
				}
				.DivAccueilRow > .SpanTitleLittle{
					font-size:0.85em;
				}
			}
		</style>
		<!-- -->
		<script type="text/javascript">
			$(document).ready(function(){
				/* Si besoin d'utiliser $sLang,
				* il faudra copier la fonction dans ce fichier,
				* et instancier de nouveau la variable.
				* ==> les fonctions et variables JS ne sont pas "transmissibles"
				*	 d'un fichier à l'autre, contraire au PHP...
				*/
			});
		</script>

		<!-- -->
		<div class="DivAccueilColumn">
			<div class="DivAccueilRow col-10">
				<span class="SpanTitleBig"><?php if($sLang==='fr'){echo'BIENVENUE DANS MON PORTFOLIO ELECTRONIQUE';}else{echo'WELCOME TO MY ELECTRONIC PORTFOLIO';}; ?></Span>
			</div>
			<div class="DivAccueilRow col-10">
				<span class="SpanTitleLittle"><?php if($sLang==='fr'){echo'Laissez-vous guider dans mon univers...';}else{echo'Let youself be guided in my universe...';}; ?></Span>
			</div>
		</div>
	</div>

<!-- ***** 20-ACCUEIL.PHP : END ***** -->