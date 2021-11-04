<!-- ***** Index.PHP (ADMIN) : START ***** -->
<?php

    session_start();

    // Si à l'entrée, le visiteur n'est pas connecté, renvoi à la page LogIn
    if(!isset($_SESSION['email'])){
        // if(!isset($_SESSION['admin']) or $_SESSION['admin']!=='1'){
        header('location:../users/login.php?lang='.$sLang);
    }
    
	// require_once __DIR__."/../../00-php_init.php";
	require_once __DIR__."/../requires/00-php_init.php";
    //
    /**** LOADING OF 'PARTS' OF MAIN PHP PAGE ****/
    /** ... STRICLY REQUIRED PARTS (PHP codes mainly) **/
    /* ICI, c'est juste pour Bootstrap ! */
    $arFiles=funDirFiles(CO_PATH_REQUIRES_TOP,'*');
    foreach($arFiles as $sFile){
        if(ctype_digit(substr($sFile,0,2))){
            require_once CO_PATH_REQUIRES_TOP.$sFile;
        }
    }
?>

<div class="work--sheet">
    <!-- * Les onglets de sélection du block affiché * -->
    <div class="row--tabtype" id="row--tabtype--admin">
        <div class="btn--tabtype" id="btn--tabtype--realisations" parent_id="row--tabtype--admin" default>
            <i class="ri-chat-upload-line"></i>
            <?php 
                if($sLang==='fr')
                {echo"Réalisations";}
                else{echo"Works";};
            ?>
        </div>
        <div class="btn--tabtype" id="btn--tabtype--languages" parent_id="row--tabtype--admin">
            <i class="ri-mail-download-line"></i>
            <?php 
                if($sLang==='fr')
                {echo"Langages (CRUD réservé à l'Administrateur)";}
                else{echo"Languages (CRUD for Administrator only)";};
            ?>
        </div>
    </div>

    <div style="border-top:1px solid grey;border-left:3px solid black;border-right:3px solid black;border-bottom:3px solid black;">


<?php
    // les travaux WF3
    require_once CO_PATH_WF3."read.php";

    // Gestion/Administration des Langages
    // if($_SESSION['admin']==1 ){
        require_once CO_PATH_LANGUAGE."read.php";
    // }
?>


    </div>
</div>

<?php

	//
	foreach(funDirFiles(CO_PATH_REQUIRES_BOTTOM,'') as $sFile){
		if(ctype_digit(substr($sFile,0,2))){
			require_once CO_PATH_REQUIRES_BOTTOM.$sFile;
		}
	}
?>
<!-- ***** Index.PHP (ADMIN) : END ***** -->