<?php
	
	/**** LOADING OF 'PARTS' OF MAIN PHP PAGE ****/
	/** ... STRICLY REQUIRED PARTS (PHP codes mainly) **/
	require_once "PHP/Requires/00-PHP_Init.php";
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