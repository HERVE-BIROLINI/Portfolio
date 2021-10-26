<!-- ***** LogOut.PHP (USERS) : START ***** -->
<?php
    session_start();
	// require_once __DIR__."/../../00-php_init.php";
	// require_once __DIR__."/../requires/00-php_init.php";
// Echo'<br><br> CO_HTTP_ROOT = '.CO_HTTP_ROOT;
    
// session_destroy();
    unset($_SESSION['email']);
    unset($_SESSION['admin']);

// Echo'<br><br> CO_HTTP_ROOT = '.CO_HTTP_ROOT;
header('location: ../../?lang='.$sLang);
// header('location:'.CO_HTTP_ROOT.'?lang='.$sLang);
?>
<!-- ***** LogOut.PHP (USERS) : END ***** -->