<?php

// Echo'- Chargement (require) du fichier PHP d\'initialisation des outils de BdD ("01-DB.php")...';

namespace Requires;

use PDO;

class DBTools{
    // Le typage ici des variables génère des erreurs dans Webhost
    // protected string $sDB_NAME='id16523549_portfolio';
    // private string $stQuery="mysql:host=localhost;dbname=id16523549_portfolio";
    // private string $sUser='id16523549_herve';
    // private string $sPwd='Webhost@MdP2019';
    //
    protected string $sDB_NAME='portfolio';
    private string $stQuery="mysql:host=127.0.0.1:8889;dbname=portfolio";
    private string $sUser='root';
    private string $sPwd='root';
    //
    private PDO $obPDO;
    //
    private array $arClass4Field=['picture_name'=>  ['file',''],
                                    'language'  =>  ['select'=>['*','HTML','CSS','Javascript','PHP']]
                                ];
    public string $sLanguagesFieldName='language';


    public function init():PDO{
        return $this->obPDO=new PDO($this->stQuery,$this->sUser,$this->sPwd);
    }

    public function getClass4Field(string $sKey =null){
        if(isset($sKey) and isset($this->arClass4Field[$sKey]))
        {return $this->arClass4Field[$sKey];}
        elseif(!isset($sKey)){return $this->arClass4Field;}
    }
    public function getLanguages():array{
        $arLanguages=$this->getClass4Field($this->sLanguagesFieldName);
        return $arLanguages;
    }

    public function getPdo():PDO{
        return $this->obPDO;
    }

    public function execSqlQuery(string $sQuery,array $arDatas=null):array{
        $stQuery=$this->obPDO->prepare($sQuery);
        //
        if(isset($arDatas))
        {$vEcho=$stQuery->execute($arDatas);}
        else{$vEcho=$stQuery->execute();}
        //
        return $stQuery->fetchall();
    }

        
    /** @param	$sTable     STRING	Table to scan
     *  @return	$arFields	ARRAY	containing founded fields
    */
    public function funGetNameOfColumns($sTable):array{
        //
        // $stRequest=$this->execSqlQuery("SELECT * from wf3" 
        $stRequest=$this->execSqlQuery("SELECT column_name
                                        FROM information_schema.columns
                                        WHERE table_schema='".$this->sDB_NAME.
                                        "' AND table_name='$sTable'"
                                        );
        //
        if(isset($stRequest)and count($stRequest)>0){
            $arFields=[];
            foreach($stRequest as $fetch){
                $arFields[].= $fetch['column_name'];
            }
            return $arFields;
        }
        else{Echo'Pas d\'écriture dans la table '.$sTable.', ou elle n\'existe pas...';}
    }

}

?>
