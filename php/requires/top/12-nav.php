<!-- ***** 12-NAV.PHP : START ***** -->
<?php
	if(isset($_GET['lang']))
	{$sLang=$_GET['lang'];}
	else{$sLang='fr';}

	// funEcho(-1,'<br>CO_HTTP_PUBLIC = '.CO_HTTP_PUBLIC.'<br>lang = '.$sLang.'<br><br>');
?>

<body>
	<!-- *** ** HEADER ** *** -->
	<header ><!-- id="DivNav"> -->
		<!-- <div class="d-flex flex-column" id="DivNav"> -->
			<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="color:white;">
				<!-- <nav class="navbar navbar-expand-lg navbar-light bg-light"> -->
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
					<div class="navbar-nav">
						<a id="NavHome" class="nav-link" href="<?=CO_HTTP_PUBLIC.'index.php?lang='.$sLang?>" onclick="location.reload()"><!--  active -->
							<?php if($sLang==='fr'){echo'Accueil';}else{echo'Home';};?>
							<span class="sr-only">(current)</span>
						</a>
						<a id="NavProfile" class="nav-link" href="<?=CO_HTTP_PUBLIC.'index.php?lang='.$sLang.'#MyProfile'?>" onclick="location.reload()"><?php if($sLang==='fr'){echo'Mon profil';}else{echo'My profile';}; ?></a>
						<a id="NavFormation" class="nav-link" href="<?=CO_HTTP_PUBLIC.'index.php?lang='.$sLang.'#MyFormation'?>" onclick="location.reload()"><?php if($sLang==='fr'){echo'Ma formation';}else{echo'My formation';}; ?></a>
						<!-- <a id="NavCV" class="nav-link" href="../CV/CV Hervé BIROLINI-Stagiaire Développeur WEB.html" target="_blank"><?php /*if($sLang==='fr'){echo'Mon Curriculum Vitae';}else{echo'My Curriculum Vitae';};*/ ?></a>
						<a id="NavContact" class="nav-link" href="#ContactMe"><?php /*if($sLang==='fr'){echo'Me contacter';}else{echo'Contact me';};*/ ?></a> -->
						<!-- <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a> -->
						<p>__</p>
						<!-- <li class="nav-item"> -->
						<?php 
							if(isset($_SESSION['admin']) ){ /* and $_SESSION['admin']=='1'){ */
						?>
							<!-- Si ROLE Admin -->
							<a id="NavAdmin" class="nav-link" href="<?=CO_HTTP_ADMIN.'?lang='.$sLang?>">Administration</a>

						<?php 
							}
							if(isset($_SESSION['email'])){ 
						?>
							<!-- Quelque soit le ROLE -->
							<a class="nav-link" href="<?=CO_HTTP_USERS.'logout.php?lang='.$sLang?>"><?php if($sLang==='fr'){echo'Se déconnecter';}else{echo'Log Out';}; ?></a><!--  class="nav-link btn btn-secondary" style="background:#cecece;margin:2px;"-->
						<!-- </li> -->
						<?php 
							}else{
						?>
						<!-- Quelque soit le ROLE -->
						<a class="nav-link" href="<?=CO_HTTP_USERS.'login.php?lang='.$sLang?>"><?php if($sLang==='fr'){echo'Se connecter';}else{echo'Log In';}; ?></a><!--  class="nav-link btn btn-secondary" style="background:#cecece;margin:2px;"-->
						<?php } ?>
									<!-- <p></p> -->
									<!-- <span></span> -->
									<!-- <li class="nav-item">
										<a class="nav-link" href="<?=CO_HTTP_USERS.'update.php?lang='.$sLang?>"><?php if($sLang==='fr'){echo'Modifier votre mot de passe';}else{echo'Change Password';}; ?></a>
									</li> -->
					</div>
				</div>

				<!-- Message au visiteur -->
				<span class="mx-3">
				<?php
					if(isset($_SESSION['email'])){
						if(!isset($_GET['lang']) or (isset($_GET['lang']) and $_GET['lang']=='fr')){
				?>
				Bienvenue <?=$_SESSION['email']?>
				<?php // funEcho(99,'<p>Bienvenue '.$_SESSION['email'].'</p>');
						}
						else{
				?>
				Welcome <?=$_SESSION['email']?>
				<?php // funEcho(99,'<p>Welcome '.$_SESSION['email'].'</p>');
						}
					}
					else{
						if(!isset($_GET['lang']) or (isset($_GET['lang']) and $_GET['lang']=='fr')){
				?>
				Bienvenue, visiteur non-identifié...
				<?php // funEcho(99,'<p>Bienvenue '.$_SESSION['email'].'</p>');
						}
						else{
				?>
				Welcome, unknown visitor...
				<?php
						}
					}
				?>
				</span>

				<div class="d-flex flex-row mr-2">
					<!-- bouton English -->
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
							<div class="DivImgFlag ImgFlagEn" style="background-image: url(<?=CO_HTTP_SRC.'flag_en.png';?>);"></div>
							<p>En<!--glish--></p>
						</div>
					</a>
					<!-- bouton Français -->
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
							<div class="DivImgFlag ImgFlagFr" style="background-image: url(<?=CO_HTTP_SRC.'flag_fr.png';?>);"></div>
							<p>Fr<!--ançais--></p>
						</div>
					</a>
				</div>

			</nav>
		<!-- </div> -->
	</header>
	<!-- zone de marge = hauteur du ruban de menu HEAD -->
	<div style="height:3.5em;"></div>
<!-- ***** 12-NAV.PHP : END ***** -->
