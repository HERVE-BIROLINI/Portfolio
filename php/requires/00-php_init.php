<!-- ***** 00-PHP_INIT.PHP : START ***** -->
<?php
    // Echo'<br><br><br><br> $_SESSION (dans php_init, AVANT session_start) = ';
    // echo'<br>';
    // var_dump($_SESSION);
    // session_start();
// Echo'<br><br><br><br> $_SESSION (dans php_init, APRES session_start) = ';
// echo'<br>';
// var_dump($_SESSION);
// echo'<br><br>APRES session_start, $_SESSION = ';
// print_r($_SESSION);
    ini_set("display_errors", 1);
    // JSON.parse() converti de l'objet au format JSON en ARRAY

    // Mes constantes :
    //*****************/
    defined('CO_FUNCTIONSUSER') or define('CO_FUNCTIONSUSER',(get_defined_functions()['user']));
    /* <?=CO_PATHCSS.'bootstrap.css';?> */
    // (pour hébergement : ftptonnomftp/www/tondossier/css/etc/etc/etc)
    
    // Pour serveur hébergeur :
    // defined('CO_PROJECTNAME') or define('CO_PROJECTNAME','/');
    // ... pour serveur LOCALHOST :
    defined('CO_PROJECTNAME') or define('CO_PROJECTNAME','portfolio');

    // Si le dernier dossier du chemin SCRIPT_FILENAME
    //   ==
    // le 1er dossier du chemin REQUEST_URI
    //  => alors le site (la page d'accueil du site)
    //     est dans un dossier 'intermédiaire' du serveur...
    $sAfterHTTPRoot=substr(stristr($_SERVER['SCRIPT_FILENAME'],substr($_SERVER['DOCUMENT_ROOT'],-3)),3);
    $sAfterHTTPRoot=substr(stristr($sAfterHTTPRoot,CO_PROJECTNAME,true),0,-1);
    
    //
    // Si serveur local => ajoute le nom du projet aux chemins...
    if(strlen(stristr($_SERVER['HTTP_HOST'],'localhost')) > 0){
        // defined('CO_HTTP_ROOT') or define('CO_HTTP_ROOT',$_SERVER['HTTP_HOST'].$sAfterHTTPRoot.'/'.CO_PROJECTNAME.'/');
        defined('CO_HTTP_ROOT') or define('CO_HTTP_ROOT',"http://".$_SERVER['HTTP_HOST'].$sAfterHTTPRoot.'/'.CO_PROJECTNAME.'/');
        defined('CO_DOCUMENT_ROOT') or define('CO_DOCUMENT_ROOT',stristr($_SERVER['SCRIPT_FILENAME'],CO_PROJECTNAME,true).CO_PROJECTNAME.'/');
    }
    // ... sinon, serveur distant (hébergeur), n'ajoute surtout pas le nom du projet
    else{
        defined('CO_HTTP_ROOT') or define('CO_HTTP_ROOT',"http://".$_SERVER['HTTP_HOST'].'/');
        defined('CO_DOCUMENT_ROOT') or define('CO_DOCUMENT_ROOT',$_SERVER['DOCUMENT_ROOT'].'/');
    }
    //
    // defined('CO_HTTP_PHP') or define('CO_HTTP_PHP','php/');
    defined('CO_HTTP_PHP') or define('CO_HTTP_PHP',CO_HTTP_ROOT.'php/');
    //
    defined('CO_PATH_PHP') or define('CO_PATH_PHP',CO_DOCUMENT_ROOT.'php/');
    //
    defined('CO_HTTP_REQUIRES_TOP') or define('CO_HTTP_REQUIRES_TOP',CO_HTTP_PHP.'requires/top/');
    defined('CO_PATH_REQUIRES_TOP') or define('CO_PATH_REQUIRES_TOP',CO_PATH_PHP.'requires/top/');
    defined('CO_HTTP_REQUIRES_BOTTOM') or define('CO_HTTP_REQUIRES_BOTTOM',CO_HTTP_PHP.'requires/bottom/');
    defined('CO_PATH_REQUIRES_BOTTOM') or define('CO_PATH_REQUIRES_BOTTOM',CO_PATH_PHP.'requires/bottom/');
    //
    defined('CO_HTTP_INCLUDES') or define('CO_HTTP_INCLUDES',CO_HTTP_PHP.'includes/');
    defined('CO_PATH_INCLUDES') or define('CO_PATH_INCLUDES',CO_PATH_PHP.'includes/');
    //
    defined('CO_HTTP_ADMIN') or define('CO_HTTP_ADMIN',CO_HTTP_PHP.'admin/');
    defined('CO_PATH_ADMIN') or define('CO_PATH_ADMIN',CO_PATH_PHP.'admin/');
    defined('CO_HTTP_PUBLIC') or define('CO_HTTP_PUBLIC',CO_HTTP_PHP.'public/');
    defined('CO_PATH_PUBLIC') or define('CO_PATH_PUBLIC',CO_PATH_PHP.'public/');
    defined('CO_HTTP_LANGUAGE') or define('CO_HTTP_LANGUAGE',CO_HTTP_PHP.'language/');
    defined('CO_PATH_LANGUAGE') or define('CO_PATH_LANGUAGE',CO_PATH_PHP.'language/');
    defined('CO_HTTP_LOGEMENTS') or define('CO_HTTP_LOGEMENTS',CO_HTTP_PHP.'logements/');
    defined('CO_PATH_LOGEMENTS') or define('CO_PATH_LOGEMENTS',CO_PATH_PHP.'logements/');
    defined('CO_HTTP_USERS') or define('CO_HTTP_USERS',CO_HTTP_PHP.'users/');
    defined('CO_PATH_USERS') or define('CO_PATH_USERS',CO_PATH_PHP.'users/');
    defined('CO_HTTP_WF3') or define('CO_HTTP_WF3',CO_HTTP_PHP.'wf3/');
    defined('CO_PATH_WF3') or define('CO_PATH_WF3',CO_PATH_PHP.'wf3/');
    defined('CO_HTTP_SRC') or define('CO_HTTP_SRC',CO_HTTP_ROOT.'src/');
    defined('CO_PATH_SRC') or define('CO_PATH_SRC',CO_DOCUMENT_ROOT.'src/');
    defined('CO_HTTP_SRC_WF3') or define('CO_HTTP_SRC_WF3',CO_HTTP_SRC.'wf3/');
    defined('CO_PATH_SRC_WF3') or define('CO_PATH_SRC_WF3',CO_PATH_SRC.'wf3/');
    // defined('CO_HTTP_CSS') or define('CO_HTTP_CSS',CO_HTTP_ROOT.'css/');
    // defined('CO_PATH_CSS') or define('CO_PATH_CSS',CO_DOCUMENT_ROOT.'css/');
    // defined('CO_HTTP_JS') or define('CO_HTTP_JS',CO_HTTP_ROOT.'js/');
    // defined('CO_PATH_JS') or define('CO_PATH_JS',CO_DOCUMENT_ROOT.'js/');
    // Initialise les paramètres de connexion à la base de donnée

    /* inutile si on n'utilise pas les NAMESPACE
    // (avec Composer, et l'autoload norme PSR-4)
    // use Requires\DBTools;
    // |--> utiliser Require ou Include fonctionne : */
    require_once "01-db.php";
    // require_once "php/requires/01-db.php";

    // $obPDO=new Requires\DBTools();
    // Mes variables :
    //****************/
    // Définit la langue courante pour l'ensemble du document (par opérateur ternaire)
    $sLang=isset($_REQUEST['lang'])?$_REQUEST['lang']:'fr';

    // Mes fonctions :
    //****************/
    // /!\ NE "CHARGE" LA FONCTION QUE SI ELLE N'EST PAS DEJA CHARGEE /!\
    /*  @param	$sTypeMsg	STRING or INT	Background color
     *      'info' or 2 (bleu ciel)     = #d1ecf1 / rgb(209, 236, 241) / hsl(189, 53%, 88%)
     *      'success' or 1 (vert pâle)  = #d4edda / rgb(212, 237, 218) / hsl(134, 41%, 88%)
     *      'warning' or 0 (paille)      = #fff3cd / rgb(209, 236, 241) / hsl(355, 70%, 91%)
     *      'danger' or -1 (rouge pâle) = #f8d7da / rgb(248, 215, 218) / hsl(355, 70%, 91%)
     *  @param	$sMessage	STRING      	Message to show
    */
    if(!in_array('funEcho',CO_FUNCTIONSUSER)){
        function funEcho($sTypeMsg, $sMessage){
            if(isset($sMessage) and gettype($sMessage)=='string'){
                switch($sTypeMsg){
                    case'warning':case'0':case 0:
                        $sStyle='background-color:#fff3cd;';
                    break;
                    case'danger':case'-1':case -1:
                        $sStyle='background-color:#f8d7da;';
                    break;
                    case'success':case'1':case 1:
                        $sStyle='background-color:#d4edda;';
                    break;
                    case'info':case'2':case 2:
                        $sStyle='background-color:#d1ecf1;';
                    break;
                    default:// pas de couleur de fond
                    break;
                }
                //
                echo'<div class="alert px-5" style="'.$sStyle.'padding:10px;">'.$sMessage.'</div>';
            }
        }
    }
    /*  @param	$sFolder	STRING	path to scan
     *  @param	$sExtension	STRING	extension to consider, could be '' for ALL
     *  @return	$arResult	ARRAY	containing founded files as STRING
    */
    if(!in_array('fundirfiles',CO_FUNCTIONSUSER)){
        function funDirFiles($sFolder, $sExtension){
            $bArgFolderIsString=is_string($sFolder);
            $bArgExtensionIsString=is_string($sExtension);
            if($bArgFolderIsString
                and $bArgExtensionIsString
                // and $bArgExtensionIsString=is_string($sExtension)
                )
            {
                switch($sExtension){
                    case '':case '*':
                        $sExtension='';
                        break;
                    default:
                        $sExtension=substr($sExtension,-3);
                        break;
                }
                $arScanDir=scandir($sFolder);
                if(is_array($arScanDir)){
                    if($sExtension==''){
                        // $arScanDir=array_diff($arScanDir,array('.'));
                        // $arScanDir=array_diff($arScanDir,array('..'));
                        unset($arScanDir[array_search('.',$arScanDir)]);
                        unset($arScanDir[array_search('..',$arScanDir)]);
                    }
                    else{
                        $iCount=0;
                        foreach($arScanDir as $sFileFounded){
                            if(substr($sFileFounded,-3)!==$sExtension){
                                unset($arScanDir[$iCount]);
                            }
                            $iCount++;
                        }
                    }
                    return $arScanDir;
                }
            }
        }
    }

    /*  @param	$sWord2Analyze	STRING	sentence to scan
     *  @return					BOOLEAN
    */
    if(!in_array('isalphaonly',CO_FUNCTIONSUSER)){
        function isAlphaOnly($sWord2Analyze){
            foreach(str_split($sWord2Analyze,1) as $sLetter){
                $iAsciiCode=ord($sLetter);
                if(!(($iAsciiCode > 64 and $iAsciiCode < 91)
                    or($iAsciiCode > 96 and $iAsciiCode < 123)
                    or $iAsciiCode==195
                    )
                )
                {return false;}
            }
            return true;
        }
    }
    
    $bInitLoaded=true;
// funEcho(2,'<br><br> $_SESSION (dans php_init) = ');
// echo'<br>';
// var_dump($_SESSION);
// funEcho(2,'PHP_Init chargé...');
?>
<!-- ***** 00-PHP_INIT.PHP : END ***** -->
