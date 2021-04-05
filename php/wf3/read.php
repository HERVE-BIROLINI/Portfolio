<?php

    use App\DBTools;

    /**** LOADING OF 'PARTS' OF MAIN PHP PAGE ****/
    /** ... STRICLY REQUIRED PARTS (PHP codes mainly) **/
    /* ICI, c'est juste pour Bootstrap ! */
	require_once __DIR__."/../requires/00-php_init.php";
    // require_once "../Requires/00-PHP_Init.php";
    $arFiles=funDirFiles(CO_PATH_REQUIRES_TOP,'*');
    foreach($arFiles as $sFile){
        if(ctype_digit(substr($sFile,0,2))){
            require_once CO_PATH_REQUIRES_TOP.$sFile;
        }
    }

    $_SESSION['email']='guest';
    $_SESSION['admin']='0';
    // Si à l'entrée, la SESSION n'est pas ADMIN, renvoi à la page LogIn
    if(!isset($_SESSION['email'])){
        // if(!isset($_SESSION['admin']) or $_SESSION['admin']!=='1'){
        header('location:../users/login.php?lang='.$sLang);
    }

    // Si poursuite du programme...
    // ... définie les variables en rapport avec la table à lire
    $sTable='wf3';
    // ... récupère la liste des champs de la table à Editer
    $obPDO=new Requires\DBTools();
    $obPDO->init();
    $arFieldNames=$obPDO->funGetNameOfColumns($sTable);
    // $arFieldNames=$obPDO::funGetNameOfColumns($sTable);
    // $arFieldNames=funGetNameOfColumns($sTable);
    
    // Si la table comporte bien des enregistrements
    if(isset($arFieldNames)){
        // $arFieldNames=array_diff($arFieldNames,array($sTable.'_id'));
        $sFields4Request='';
        foreach($arFieldNames as $sFieldName){
            // if($sFieldName!==$sTable.'_id'){
                $sFields4Request=$sFields4Request.','.$sFieldName;
            // }
        }
        $sFields4Request=substr($sFields4Request,1);
?>

<style type="text/css">
    #DivTableColumn{
        width:105vw;
        background-color:#cecece;
        padding-top:100px;
        /**/
        align-items: center;
        padding-bottom:25px;
        /* margin-bottom:0px; */
    }
    .PMyFormation{
        padding-left:1.5em;
        font-size:2.5em;
        font-family:'barlow';
        align-self:flex-start;
    }
    #DivProductions{
        /* width:80%; */
        justify-content:center;
    }
    #TableProductions{
        width:25%;
        font-size:0.85em;
    }
</style>
    
<div class="d-flex flex-column" id="DivTableColumn"><!--style="padding-top:150px;" > -->
    <!-- <div class="d-flex flex-row" style="width:50%;border:2px solid red;align-self:flex-start;justify-content:space-between;"> -->
        <p class="PMyFormation">
            <?php 
                if($sLang==='fr')
                {echo"Liste des réalisations avec 'WebForce3' :";}
                else{echo"Works done with WebForce3 :";};
            ?>
        </p>
        <a href="<?= CO_HTTP_WF3.'create.php?lang='.$sLang;?>" class="btn btn-primary mb-2"><?php if($sLang==='fr'){echo'Ajouter';}else{echo'Add';}?></a>
    <!-- </div> -->
    <div class="d-flex flex-row col-11" id="DivProductions" style='justify-content:center;'>
        <table class="table table-striped" id="TableProductions" style='width:80%;text-align:center;'>
            <thead class="thead-dark">
                <tr>
                <?php
                    $arDejavuFields=[];
                    $arOtherFields=[];
                    foreach($arFieldNames as $sFieldName){
                        // si champs doublé pour lang
                        if($sFieldName!==$sTable.'_id' and
                            (substr($sFieldName,-3,1)!=="_" or !in_array(substr($sFieldName,0,-3),$arDejavuFields))
                            ){
                ?>
                    <th scope="col" width='<?=floor(100/count($arFieldNames));?>%'>
                <?php 
                            if(substr($sFieldName,-3,1)=="_"){
                                array_push($arDejavuFields,substr($sFieldName,0,-3));
                                echo substr($sFieldName,0,-3);
                            }
                            else{
                                array_push($arOtherFields,$sFieldName);
                                echo $sFieldName;
                            }
                ?>
                    </th>
                <?php
                        }
                    }
                ?>
                    <th scope="col" width='<?=floor(100/count($arFieldNames));?>%'>Actions</th>
                </tr>
            </thead>
            <!-- -->
            <tbody>
                <?php
                    $arAllRows=$obPDO->execSqlQuery("select $sTable"."_id,".join('_'.$sLang.',',$arDejavuFields).'_'.$sLang.','.join(',',$arOtherFields)." from $sTable");//PDO::FETCH_ASSOC); => valeur par défaut pour un TABLEAU ASSOCIATIF
                    // $arAllRows=$obPDO->execSqlQuery("select $sFields4Request from $sTable");//PDO::FETCH_ASSOC); => valeur par défaut pour un TABLEAU ASSOCIATIF
                    //
                    if(isset($arAllRows)){
                        foreach($arAllRows as $iKey => $arRow){
                ?>
                <tr>
                    <?php
                        foreach($arRow as $iKey => $sValue){
                            // funEcho(2,'$sValue = '.$sValue);
                            // echo'$iKey = '.$iKey;
                            if(is_numeric($iKey)){
                                if( $iKey!==0){
                    ?>
                                    <td scope="row" width='<?=floor(100/count($arFieldNames));?>%'><?=$arRow[$iKey];?></td>
                    <?php
                                }
                            }
                        }
                    ?>
                    <td scope="row">
                        <?php if(!in_array('owner',$arFieldNames)
                                or $_SESSION['admin']=='1'
                                or $_SESSION['email']==$arRow['owner']
                                ){
                        ?>
                                <a href=<?= CO_HTTP_WF3.'update.php?id='.$arRow[$sTable.'_id'].'&amp;lang='.$sLang;?> class="btn btn-primary"><?php if($sLang==='fr'){echo'Modifier';}else{echo'Edit';}?></a>
                                <a href=<?= CO_HTTP_WF3.'delete.php?id='.$arRow[$sTable.'_id'].'&amp;lang='.$sLang;?> class="btn btn-danger"><?php if($sLang==='fr'){echo'Supprimer';}else{echo'Delete';}?></a>
                        <?php }else{?>
                            <i class="fas fa-lock"></i>
                        <?php }?>
                    </td>
                </tr>
                <?php
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
    <a href="<?= CO_HTTP_WF3.'create.php?lang='.$sLang;?>" class="btn btn-primary"><?php if($sLang==='fr'){echo'Ajouter';}else{echo'Add';}?></a>
</div>
<?php
    }
	//
	foreach(funDirFiles(CO_PATH_REQUIRES_BOTTOM,'') as $sFile){
		if(ctype_digit(substr($sFile,0,2))){
			require_once CO_PATH_REQUIRES_BOTTOM.$sFile;
		}
	}
?>