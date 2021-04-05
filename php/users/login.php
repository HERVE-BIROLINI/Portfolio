<?php
    // session_start();
    //
	require_once __DIR__."/../requires/00-php_init.php";

    $_SESSION['email']='guest';
    $_SESSION['admin']='0';
    // Si est déjà connecté, renvoie à la page Index ()=> Read WF3)
    if(isset($_SESSION['email'])){header('Location: ../admin/index.php');}

    $arFiles=funDirFiles(CO_PATH_REQUIRES_TOP,'*');
    foreach($arFiles as $sFile){
        if(ctype_digit(substr($sFile,0,2))){
            require_once CO_PATH_REQUIRES_TOP.$sFile;
        }
    }
    if(isset($_POST['submit']) and $_POST['email']!=='' and $_POST['pwd']!==''){

        $obPDO=new Requires\DBTools();
        $obPDO->init();
        $arUsers=$obPDO->execSqlQuery('select * from user where email=?',[$_POST['email']]);
        if(isset($arUsers)){$arUsers=$arUsers[0];}
        //
        if(!isset($arUsers) or count($arUsers)==0){
            funEcho(-1,'<br><br>Connection impossible.</br>Votre eMail n\'est associé à aucun compte.');
        }
        elseif(password_verify($_POST['pwd'],$arUsers['password'])){
            funEcho(2,'<br><br>Vous êtes maintenant connecté.');
if(!isset($_SESSION)){
    funEcho(-1,'<br><br> MAIS POURQUOI LA SESSION N\'ETAIT PAS DEMARREE ????');
    // session_start();
}
            $_SESSION['admin']=$arUsers['admin'];
            $_SESSION['email']=$arUsers['email'];
            //
            if($arUsers['admin']==1){funEcho(1,'Vous avez ouvert une session avec un compte administrateur...');}
            else{funEcho(-1,'Vous avez ouvert une session avec un compte utilisateur \'classique\'...');}
            //
        var_dump($_SESSION);
        var_dump(headers_sent());
            header('Location: '.CO_HTTP_ROOT.'?lang='.$sLang);
            // exit();
        }
        else{
            funEcho(-1,'<br><br>Connection impossible.</br>Votre mot de passe est incorrect.');
        }
    }
    elseif(isset($_POST['submit']) and $_POST['email']==''){
        funEcho(-1,'<br><br>Vous devez renseigner votre adresse eMail.');
    }
    elseif(isset($_POST['submit']) and $_POST['pwd']==''){
        funEcho(-1,'<br><br>Vous devez indiquer votre mot de passe.');
    }
?>

<div class='container' style="padding-top:150px;">
    <form action="<?=$_SERVER['PHP_SELF']?>" method='post'>
        <div class='form-group'>
            <label for="email"><?php if($sLang==='fr'){echo'Courriel';}else{echo'eMail';}?></label>
            <input type="text" class='form-control' id="email" name="email">
        </div>
        <div class='form-group'>
            <label for="pwd"><?php if($sLang==='fr'){echo'Mot de passe';}else{echo'Password';}?></label>
            <input type="password" class='form-control' id="pwd" name="pwd">
        </div>
        <button type='submit' name="submit" class='btn btn-primary'><?php if($sLang==='fr'){echo'Se connecter';}else{echo'Connect';}?></button>
    </form>
</div>

<?php
	foreach(funDirFiles(CO_PATH_REQUIRES_BOTTOM,'') as $sFile){
		if(ctype_digit(substr($sFile,0,2))){
			require_once CO_PATH_REQUIRES_BOTTOM.$sFile;
		}
	}
?>