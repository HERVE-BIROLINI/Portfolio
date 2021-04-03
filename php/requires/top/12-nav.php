
<?php
// echo'<pre>';
// print_r($_GET);
// echo'</pre>';
	if(isset($_GET['lang']))
	{$sLang=$_GET['lang'];}
	else{$sLang='fr';}
?>

<!-- ***** 12-NAV.PHP : START ***** -->
<!-- ***      ** HEADER **      *** -->

<Header id="DivNav">
	<!-- Déclaration liaison avec une "feuille" de style : -->
	<!-- <link rel="stylesheet" type="text/css" href="<?=CO_PATH_INCLUDES.'Header.css'?>"/> -->
	<style type="text/css">
		/* .nav-link{font-size:1.1em;color:red;} */
		#DivNav{
			width:100vw;
			position:fixed;
			/* top:0; */
			z-index: 1;
		}
		/**/
		.DivLang{
			width:80px;
			height:30px;
			/**/
			margin:0.35em;
			/**/
			/* background-color:  rgba(255,255,255,0.75); */
			/* background-color: rgba(0,0,0,0.5); */
			border:1px solid black;
			border-radius: 5px;
			/**/
			justify-content: space-evenly;
			align-items: center;
		}
		.DivLang:hover{
			cursor:pointer;
		}
		/**/
		.DivLang>p{
			font-size: 0.65x;;
			margin-top: 14px;
			color:black;
		}
		/**/
		.DivImgFlag{
			height:25px;
			width:25px;
			margin-top: 5px;
			/**/
			background-repeat: no-repeat;
			background-size: cover;
			background-position: center center;
		}
		/**/
		/* .DivH2Row{
			justify-content:center;
			text-align:center;
		}
		h2{
			font-size:2.5em;
			font-weight: bolder;
			color:white;
			text-shadow: 1px 1px 0.5em red, 2px 2px 0.01em grey, 5px 5px 0.1em black;
			font-weight: bolder;
		} */
	</style>
	<!-- -->
	<script type="text/javascript">
		$(document).ready(function(){
			//
			if(!$sLang){
				var $arGET=$_GET();
				if($arGET['lang']){var $sLang=$arGET['lang'];}else{var $sLang='fr';}
			}
			//
			funToggleEffect4Lang($sLang);
		});
	</script>

	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
			<div class="navbar-nav">
				<a id="NavHome" class="nav-link active" href=<?=CO_HTTP_ROOT.'Index.php?lang='.$sLang?>>
					<?php if($sLang==='fr'){echo'Accueil';}else{echo'Home';};?>
					<span class="sr-only">(current)</span>
				</a>
				<a id="NavProfile" class="nav-link" href=<?=CO_HTTP_ROOT.'Index.php?lang='.$sLang.'#MyProfile'?>><?php if($sLang==='fr'){echo'Mon profil';}else{echo'My profile';}; ?></a>
				<a id="NavFormation" class="nav-link" href=<?=CO_HTTP_ROOT.'Index.php?lang='.$sLang.'#MyFormation'?>><?php if($sLang==='fr'){echo'Ma formation';}else{echo'My formation';}; ?></a>
				<a id="NavCV" class="nav-link" href="../CV/CV Hervé BIROLINI-Stagiaire Développeur WEB.html" target="_blank"><?php if($sLang==='fr'){echo'Mon Curriculum Vitae';}else{echo'My Curriculum Vitae';}; ?></a>
				<a id="NavContact" class="nav-link" href="#ContactMe"><?php if($sLang==='fr'){echo'Me contacter';}else{echo'Contact me';}; ?></a>
				<!-- <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a> -->
				<p>__</p>

				<?php if(isset($_SESSION['email'])){ ?>
				<!-- <?php //if(isset($_SESSION['admin'])and $_SESSION['admin']=='1'){ ?> -->
							<a id="NavAdmin" class="nav-link" href=<?=CO_HTTP_ADMIN.'Index.php?lang='.$sLang?>>Administration</a>
							<li class="nav-item">
								<a class="nav-link" href="<?=CO_HTTP_USERS.'logout.php?lang='.$sLang?>"><?php if($sLang==='fr'){echo'Se déconnecter';}else{echo'Log Out';}; ?></a><!--  class="nav-link btn btn-secondary" style="background:#cecece;margin:2px;"-->
							</li>
							<!-- <p></p> -->
							<!-- <span></span> -->
							<!-- <li class="nav-item">
								<a class="nav-link" href="<?=CO_HTTP_USERS.'Update.php?lang='.$sLang?>"><?php if($sLang==='fr'){echo'Modifier votre mot de passe';}else{echo'Change Password';}; ?></a>
							</li> -->
        		<?php } else{ ?>
					<li class="nav-item">
						<a class="nav-link" href="<?=CO_HTTP_USERS.'login.php?lang='.$sLang?>"><?php if($sLang==='fr'){echo'Se connecter';}else{echo'Log In';}; ?></a>
					</li>
				<?php } ?>
			</div>
		</div>
<?php
	// if(isset($_SESSION['admin'])){
		// funEcho(2,'<p>'.$_SESSION['email'].'</p>');
		// funEcho(2,'<p>'.$_SESSION['admin'].'</p>');
	// }
	// if(isset($_GET)){
	// }
?>
		<div class="d-flex flex-row">
			<a href=<?php
						if(isset($_GET['lang'])){
							$sEcho="?";
							foreach($_GET as $sKey => $sValue){
								if($sKey=='lang'){$sEcho.='lang=en&amp;';}
								else{$sEcho.=$sKey.'='.$sValue.'&amp;';}
							}
							echo substr($sEcho,0,-5);
						}
						else{echo"?lang=en";}
					?>
			>
				<div class="d-flex flex-row DivLang DivLangEn">
					<div class="DivImgFlag ImgFlagEn" style="background-image: url(<?=CO_HTTP_SRC.'Flag_en.png';?>);"></div>
					<p>En<!--glish--></p>
				</div>
			</a>
			<!-- <div class="d-flex justify-content-center" style="width:25px;"><span> / </span></div> -->
			<a href=<?php 
						if(isset($_GET['lang'])){
							$sEcho="?";
							foreach($_GET as $sKey => $sValue){
								if($sKey=='lang'){$sEcho.='lang=fr&amp;';}
								else{$sEcho.=$sKey.'='.$sValue.'&amp;';}
							}
							echo substr($sEcho,0,-5);
						}
						else{echo"?lang=fr";}
					?>
			>
				<div class="d-flex flex-row DivLang DivLangFr">
					<div class="DivImgFlag ImgFlagFr" style="background-image: url(<?=CO_HTTP_SRC.'Flag_fr.png';?>);"></div>
					<p>Fr<!--ançais--></p>
				</div>
			</a>
			<!-- -->
			<!-- <div class="p-div flex-row DivH2Row col-8 col-md-10">
				<h2 class="mt-4">Web Developer or not Web Developer</h2>
			</div> -->
		</div>

	</nav>
</Header>

<!-- ***** 12-NAV.PHP : END ***** -->
