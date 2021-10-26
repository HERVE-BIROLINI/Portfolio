<!-- ***** New.PHP (USERS) : START ***** -->
<?php
    // session_start();
    //
    // if(isset($_SESSION['user_id'])){header('location:../../index.php');}
    //
	require_once "00-php_init.php";
	//require_once __DIR__;

    //
    if(isset($_POST['email'])){
        if(strlen($_POST['email'])>7 and strlen($_POST['email'])){
            // Test l'existance du compte
            $stRequest=$dbPDOConnect->prepare('select email from user where email=?');
            $stRequest->execute([$_POST['email']]);
            $arUsers=$stRequest->fetch(PDO::FETCH_ASSOC);
            if($stRequest->rowcount()>0){
                funEcho(-1,'Un compte utilisant l\'adresse "'.$_POST['email'].'" existe déjà.');
            }
            else{
                //
                $stRequest=$dbPDOConnect->prepare('insert into user (email,password) values(?,?)');
                $stRequest->execute([$_POST['email'],password_hash($_POST['password'],PASSWORD_DEFAULT)]);
                $arUsers=$stRequest->fetch(PDO::FETCH_ASSOC);
                if($stRequest->rowcount()>0){
                    funEcho(2,'Merci de vous connecter');
                    // header('location:../../LogIn.php');
                }
                else{
                    funEcho(-1,'Erreur !...');
                }
            }
        }
    }

// SQL : INSERT INTO tableName (email, password) VALUES ('a@b.fr',PASSWORD('abcde12345'))
// -----
// PHP :
// $stRequest=$dbPDOConnect->prepare('insert into user (email,password) values (?,?)');
// $stRequest->execute(['birolini.herve@gmail.com',password_hash('Pwd@2021',PASSWORD_DEFAULT)]);
?>

<main role="main">
    <div class="container">
        <form action="" method="post">
            <div>
                <label for="email"></label>
                <input type="text" class="form-control" id="email" name="email" minlength="8" required>
            </div>
            <div>
                <label for="password"></label>
                <input type="password" class="form-control" id="password" name="password" minlength="8" required>
            </div>
            <p></p>
            <button type="submit" class="btn btn-primary">Valider</button>
        </form>
    </div>
</main>

<?php
    require_once CO_PATH_INCLUDES.'footer.php';
?>
<!-- ***** New.PHP (USERS) : START ***** -->