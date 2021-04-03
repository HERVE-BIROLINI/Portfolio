<?php
    require_once "../Requires/00-php_init.php";
    //
    /**** LOADING OF 'PARTS' OF MAIN PHP PAGE ****/
    /** ... STRICLY REQUIRED PARTS (PHP codes mainly) **/
    /* ICI, c'est juste pour Bootstrap ! */
    require_once "../Requires/00-PHP_Init.php";
    $arFiles=funDirFiles(CO_PATH_REQUIRES_TOP,'*');
    foreach($arFiles as $sFile){
        if(ctype_digit(substr($sFile,0,2))){
            require_once CO_PATH_REQUIRES_TOP.$sFile;
        }
    }

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
        header('location:'.CO_HTTP_USERS.'login.php?lang='.$sLang);
    }

	//
	foreach(funDirFiles(CO_PATH_REQUIRES_BOTTOM,'') as $sFile){
		if(ctype_digit(substr($sFile,0,2))){
			require_once CO_PATH_REQUIRES_BOTTOM.$sFile;
		}
	}
?>