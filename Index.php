<!-- Index.PHP DEBUT -->
<?php
    // session_start();
	/**** LOADING OF 'PARTS' OF MAIN PHP PAGE ****/
	/** ... STRICLY REQUIRED PARTS (PHP codes mainly) **/
	require_once __DIR__."/php/requires/00-php_init.php";
	//
	foreach(funDirFiles(CO_PATH_REQUIRES_TOP,'') as $sFile){
		if(ctype_digit(substr($sFile,0,2))){
			require_once CO_PATH_REQUIRES_TOP.$sFile;
		}
	}
	/** ... NON-CRITICAL PARTS (CSS, JS and HTML codes mainly) **/
	foreach(funDirFiles(CO_PATH_INCLUDES,'') as $sFile){
		if(ctype_digit(substr($sFile,0,2))){
			include_once CO_PATH_INCLUDES.$sFile;
		}
	}
	//
	foreach(funDirFiles(CO_PATH_REQUIRES_BOTTOM,'') as $sFile){
		if(ctype_digit(substr($sFile,0,2))){
			require_once CO_PATH_REQUIRES_BOTTOM.$sFile;
		}
	}
?>
<!-- Index.PHP FIN -->