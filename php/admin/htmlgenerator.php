<?php
namespace Admin;
?>
<!-- ***** Class htmlGenerator.PHP : START ***** -->
<?php

// echo'<br>    ---  Passage dans htmlGenerator.PHP  ---';

class htmlGenerator{
    
    static function getHtmlInput4Class(array $vArgument=null,string $sName4Element=null,string $sDefault4Element=null,bool $bIsRequired=null,string $sFocus=null):string{
        $sType=gettype($vArgument);
        if($sType=='array'){
            if(count($vArgument)==1){
                // !!! array_key_first() n'existe pas sur le serveur Webhost !!!
                foreach($vArgument as $vKey => $vValue){$sClass=$vKey;}
                // $sClass=array_key_first($vArgument);
            }
            else{$sClass=$vArgument[0];}
            //
            if(gettype($sClass)=='string'){
                //
                if(!isset($sName4Element) or gettype($sName4Element)!=='string')
                {$sName4Element=$sClass;}
                //
                switch($sClass){
                    case'select':
                        $sEcho=htmlGenerator::getHtmlSelect($vArgument[$sClass],$sName4Element,$sDefault4Element,$bIsRequired);
                        break;
                    case'file':
                        $sEcho=htmlGenerator::getHtmlFile($sName4Element,$bIsRequired);
                        break;
                    // Reste à venir en fonction des évolutions....
                    // default:
                    //     $sEcho='';
                    //     break;
                }
            }else{
                $sEcho='';
            }
        }
        // 1er argument NULL => "retourne" un Input Text tout simple...
        else{
            $sEcho=htmlGenerator::getHtmlInput($sName4Element,$sDefault4Element,isset($bIsRequired),$sFocus);
        }
        //
        return $sEcho;
    }

    //
    static public function getHtmlSelect(array $arSelectDatas,string $sName4Element,$vDefault4Element=null,bool $bIsRequired=null):string{
        $sEcho="<select class='form-control html--select"."' id='".$sName4Element."' name='".$sName4Element."' title='".$sName4Element."'>";
        foreach($arSelectDatas as $iIndex => $sOption){
            // si source de lecture d'une table dans la base de données
            if(gettype($sOption)=='array'){
                if(isset($sOption['label'])){$sOption=$sOption['label'];
                }elseif(isset($sOption['libellé'])){$sOption=$sOption['libellé'];
                }elseif(isset($sOption['libelle'])){$sOption=$sOption['libelle'];
                }elseif(isset($sOption['nom'])){$sOption=$sOption['nom'];
                }elseif(isset($sOption['name'])){$sOption=$sOption['name'];
                }else{$sOption=$sOption[0];}
            }
            //
            if(!($iIndex==0 and $sOption=='*' and $bIsRequired)){
                // construction de la chaîne pour le fichier de VUE (HTML)
                if(gettype($sOption)=='string' or is_numeric($sOption)){
                    $sEcho.="<option value='".$sOption."'";
                    if($sOption==$vDefault4Element){$sEcho.=" selected>".$sOption."</option>";}
                    else{$sEcho.=">".$sOption."</option>";}
                }
            }
        }
        //
        return $sEcho."</select>";
    }

    static public function getHtmlFile(string $sName4Element,bool $bIsRequired=null):string{
        $sEcho="<input type='file' id='$sName4Element' class='form-control html--file' name='$sName4Element'";
        // si la page d'appel est UPDATE, ne 'TAG' pas la recherche de fichier requise...
        if($bIsRequired and !stristr($_SERVER['PHP_SELF'],'update.'))
        {$sEcho.=' required>';}
        else{$sEcho.='>';}
        return $sEcho;
    }

    static public function getHtmlInput(string $sName4Element,string $sDefault4Element=null,bool $bIsRequired=null,string $sFocus=null):string{
        $sEcho="<input type='text' id='$sName4Element' class='form-control html--text' name='$sName4Element'";
        // si valeur par défaut
        if(isset($sDefault4Element) and strlen($sDefault4Element)>0){
            $sEcho.=" value='$sDefault4Element'";
        }
        // s'il y a bien correspondance entre l'élément en cours de construction et le FOCUS mémorisé.
        if($sFocus==$sName4Element){$sEcho.=' autofocus';}
        // si requis.
        if($bIsRequired)
        {$sEcho.=' required />';}
        else{$sEcho.='>';}
        return $sEcho;
    }

    static public function getHtmlLabel(string $sName4Element,string $sLabel4Element=null,bool $bIsRequired=null):string{
        if(gettype($sLabel4Element)=="NULL"){$sLabel4Element=$sName4Element;}
        //
        $sEcho="<label for='$sName4Element'";
        // $sEcho="<label for='$sName4Element'>$sLabel4Element";
        // si requis, MAIS PAS UN TYPE FILE
        if(strstr($sName4Element,"file")
            or strstr($sName4Element,"fichier")
            or strstr($sName4Element,"image")
            or strstr($sName4Element,"picture")
            or strstr($sName4Element,"photo")
            or strstr($sName4Element,"src")
            or strstr($sName4Element,"owner")
            )
        {$bIsRequired=false;}
        //
        if($bIsRequired)
        {$sEcho.="class='required'>$sLabel4Element</label>";}
        else{$sEcho.=">$sLabel4Element</label>";}
        return $sEcho;
    }
}

?>
<!-- ***** Class htmlGenerator.PHP : END ***** -->