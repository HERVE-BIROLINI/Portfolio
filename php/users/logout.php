<?php
	require_once __DIR__."/../requires/00-php_init.php";

    session_destroy();
    header('location:'.CO_HTTP_ROOT.'?lang='.$sLang);
?>