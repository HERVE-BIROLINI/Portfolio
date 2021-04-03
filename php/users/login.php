<?php
    // session_start();

    // Si est déjà connecté, renvoie à la page Index ()=> Read WF3)
    if(isset($_SESSION['email'])){header('location:../admin/index.php');}
    // if(isset($_SESSION['admin']) and $_SESSION['admin']==1){header('location:../admin/index.php');}
    //
    require_once "../Requires/00-PHP_Init.php";
    // funEcho(2,'- Entrée dans /Admin/Index.php...');
    $arFiles=funDirFiles(CO_PATH_REQUIRES_TOP,'*');
    foreach($arFiles as $sFile){
        if(ctype_digit(substr($sFile,0,2))){
            require_once CO_PATH_REQUIRES_TOP.$sFile;
        }
    }
    if(isset($_POST['submit']) and $_POST['email']!=='' and $_POST['pwd']!==''){
        $stRequest=$dbPDOConnect->prepare('select * from user where email=?');
        $stRequest->execute([$_POST['email']]);
        $arUsers=$stRequest->fetch(PDO::FETCH_ASSOC);
        // $arUsers=$stRequest->fetchall(PDO::FETCH_ASSOC); // parce qu'une seule rangée me suffit
        //
// funEcho(2,'- $stRequest ressort '.$stRequest->rowcount().' ligne(s)...');
// funEcho(2,'- $arUsers =');
// var_dump($arUsers);
        if($stRequest->rowcount()==0){
            funEcho(-1,'</br></br>Connection impossible.</br>Votre eMail n\'est associé à aucun compte.');
        }
        elseif(password_verify($_POST['pwd'],$arUsers['password'])){
            funEcho(-1,'Connecté !!');
            $_SESSION['admin']=$arUsers['admin'];
            $_SESSION['email']=$arUsers['email'];
            //
            if($arUsers['admin']==1){
                funEcho(1,'</br></br>Vous avez ouvert une session avec un compte administrateur...');
            }
            else{
                funEcho(-1,'</br></br>Vous avez ouvert une session avec un compte utilisateur \'classique\'...');
            }
            //
            header('location:'.CO_HTTP_ROOT.'index.php');
            // exit();
        }
        else{
            funEcho(-1,'</br></br>Connection impossible.</br>Votre mot de passe est incorrect.');
        }
    }
    elseif(isset($_POST['submit']) and $_POST['email']==''){
        funEcho(-1,'</br></br>Vous devez renseigner votre adresse eMail.');
    }
    elseif(isset($_POST['submit']) and $_POST['pwd']==''){
        funEcho(-1,'</br></br>Vous devez indiquer votre mot de passe.');
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