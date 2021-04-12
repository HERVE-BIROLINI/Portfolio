<?php
    session_start();
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

// $_SESSION['email']='guest';
// $_SESSION['admin']='0';
    // Si session administrateur, charge LES "modules" Read des sujet administrables
    if(isset($_SESSION['email'])){
    // if($_SESSION['admin']=='1'){
    
        // les travaux WF3
        require_once CO_PATH_WF3."read.php";
?>


<?php
        // Puis, ce qui pourrait venir derrière :...
        //....
    }
    else{
        funEcho(2,'<br><br> - CO_PATH_USERS = '.CO_PATH_USERS);
        require_once CO_PATH_USERS.'login.php';
        // header('location:'.CO_HTTP_USERS.'login.php?lang='.$sLang);
    }

	//
	foreach(funDirFiles(CO_PATH_REQUIRES_BOTTOM,'') as $sFile){
		if(ctype_digit(substr($sFile,0,2))){
			require_once CO_PATH_REQUIRES_BOTTOM.$sFile;
		}
	}
?>