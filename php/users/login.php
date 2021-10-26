<!-- ***** LogIn.PHP (USERS) : START ***** -->
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
?>

<div ><!-- class='mt-5 pt-5' style="padding-top:150px;"> -->

<?php
    // Si retour du formulaire
    if(isset($_POST['submit']) and $_POST['email']!=='' and $_POST['pwd']!==''){

        $obPDO=new App\DBTools();
        $obPDO->init();
        $arUsers=$obPDO->execSqlQuery('select * from user where email=?',[$_POST['email']]);
        funEcho(-1,'requête lancée...');
        if(isset($arUsers)){$arUsers=$arUsers[0];}
        //
        if(!isset($arUsers) or count($arUsers)==0){
            funEcho(-1,'<br><br>Connection impossible.<br>Votre eMail n\'est associé à aucun compte.');
        }
        elseif(password_verify($_POST['pwd'],$arUsers['password'])){
            funEcho(2,'<br><br>Vous êtes maintenant connecté.');
            $_SESSION['admin']=$arUsers['admin'];
            $_SESSION['email']=$arUsers['email'];
            //
            if($arUsers['admin']==1){funEcho(1,'Vous avez ouvert une session avec un compte administrateur...');}
            else{funEcho(-1,'Vous avez ouvert une session avec un compte utilisateur \'classique\'...');}
            
            // var_dump($_SESSION);
            // var_dump(headers_sent());

            //
            // switch ($_POST['goto']) {
            //     case 'admin':
            //         header('Location: ../admin/?lang='.$sLang);
            //         // header('location:'.CO_HTTP_ADMIN.'index.php?lang='.$sLang);
            //         break;
            //     default:
                    header('Location: ../../?lang='.$sLang);
            //         break;
            // }
            // // header('Location: '.CO_HTTP_ROOT.'?lang='.$sLang);
            // // exit();
        }
        else{
            funEcho(-1,'<br><br>Connection impossible.<br>Votre mot de passe est incorrect.');
        }
    }
    elseif(isset($_POST['submit']) and $_POST['email']==''){
        funEcho(-1,'<br><br>Vous devez renseigner votre adresse eMail.');
    }
    elseif(isset($_POST['submit']) and $_POST['pwd']==''){
        funEcho(-1,'<br><br>Vous devez indiquer votre mot de passe.');
    }
    elseif(isset($_SESSION['email']) and isset($_SESSION['admin']) and $_SESSION['admin']=='0'){
        $goto="admin";
        funEcho(0,"Vous êtes connecté avec le compte ".$_SESSION['email'].", et n'avez pas les droits d'Administration, ou n'êtes pas propriétaire de cette donnée...");
    }
    else{
        funEcho(2, "Pour expérimenter la gestion des données, connectez-vous en tant qu'invité :<br>Courriel: guest<br>Mot de passe: guest2021");
    }
?>
    <div class='container my-5' ><!-- style="padding-top:150px;"> -->
        <form class="mt-5" action="<?=$_SERVER['PHP_SELF']?>" method='post'>
        <input type="hidden" id="goto" name="goto"
            value=<?php if(isset($goto)){echo $goto;}?>
        >
            <div class='form-group'>
                <label for="email"><?php if($sLang==='fr'){echo'Courriel';}else{echo'eMail';}?></label>
                <input type="text" class='form-control' id="email" name="email">
            </div>
            <div class='form-group'>
                <label for="pwd"><?php if($sLang==='fr'){echo'Mot de passe';}else{echo'Password';}?></label>
                <input type="password" class='form-control' id="pwd" name="pwd">
            </div>
            <button type='submit' name="submit" class='btn btn-primary mb-5'><?php if($sLang==='fr'){echo'Se connecter';}else{echo'Connect';}?></button>
        </form>
    </div>

</div>


<?php
	foreach(funDirFiles(CO_PATH_REQUIRES_BOTTOM,'') as $sFile){
		if(ctype_digit(substr($sFile,0,2))){
			require_once CO_PATH_REQUIRES_BOTTOM.$sFile;
		}
	}
?>
<!-- ***** LogIn.PHP (USERS) : END ***** -->