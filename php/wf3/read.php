<!-- ***** Read.PHP (WF3) : START ***** -->
<?php

    // /!\ SESSION DEJA DEMARRER (dans Admin/Index.php) /!\
    //------------------------------------------------------
    // session_start();
    //------------------------------------------------------

    // Si poursuite du programme...
    // ... définie les variables en rapport avec la table à lire
    $sTable='wf3';
    // ... récupère la liste des champs de la table à Editer
    $obPDO=new App\DBTools();
    $obPDO->init();
    $arFieldNames=$obPDO->funGetNameOfColumns($sTable);
    
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
    
<form class="form--crud block--tabtype" id="form--realisations" parent_id="btn--tabtype--realisations">
<!-- <div class="d-flex flex-column mx-5 pt-3"> -->


    <div class="align-items-center" id="DivTitleRow"><!--  w-100 -->
        <p class="p--title-form" id="PMyFormation">
            <?php 
                if($sLang==='fr')
                {echo"Liste des réalisations :";}
                else{echo"Works lists :";};
            ?>
        </p>
        <a class="btn btn-primary" href="<?= CO_HTTP_WF3.'create.php?lang='.$sLang;?>">
        <?php if($sLang==='fr'){echo'Ajouter';}else{echo'Add';}?>
        </a>
    </div>
    

    <!--  -->
    <table class="table table-hover table-striped" ><!-- id="TableProductions" style='width:80%;text-align:center;'> -->
        <thead class="thead-dark" id="TableHead"><!-- class="thead-dark"> -->
            <tr>
                <?php
                    $arDejavuFields=[];
                    $arOtherFields=[];
                    foreach($arFieldNames as $sFieldName){
                        // si champs doublé pour lang...
                        if($sFieldName!==$sTable.'_id' and
                            (substr($sFieldName,-3,1)!=="_" or !in_array(substr($sFieldName,0,-3),$arDejavuFields))
                        ){
                            if(in_array($sFieldName ,['title_fr','title_en','priority','owner'])){
                ?>
                <th width='<?=floor(90/count($arFieldNames));?>%'>
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
                    }
                ?>
                <th width='<?=floor(100/count($arFieldNames));?>%'>Actions</th>
            </tr>
        </thead>
        <!-- -->
        <tbody id="TableBody">
            <?php
                $arAllRows=$obPDO->execSqlQuery("select $sTable"."_id,".join('_'.$sLang.',',$arDejavuFields).'_'.$sLang.','.join(',',$arOtherFields)." from $sTable");//PDO::FETCH_ASSOC); => valeur par défaut pour un TABLEAU ASSOCIATIF
                // $arAllRows=$obPDO->execSqlQuery("select $sFields4Request from $sTable");//PDO::FETCH_ASSOC); => valeur par défaut pour un TABLEAU ASSOCIATIF
                //
                if(isset($arAllRows)){
                    foreach($arAllRows as $arRow){
            ?>
            <tr>
                <?php
                        foreach($arRow as $iKey => $sValue){
                            if(!is_numeric($iKey) and in_array($iKey ,['title_fr','title_en','priority','owner'])){
                            // if(is_numeric($iKey) and $iKey!==0){
                ?>
                <td width='<?=floor(100/count($arFieldNames));?>%'><?=$arRow[$iKey];?></td>
                <?php
                            }
                        }
                ?>
                <td>
                    <div class='d-flex flex-row flex-nowrap'>
                    <?php
                        if(!in_array('owner',$arFieldNames)
                            or $_SESSION['admin']=='1'
                            or strtolower($_SESSION['email'])===strtolower($arRow['owner'])
                        ){
                    ?>
                    <a href=<?= CO_HTTP_WF3.'update.php?id='.$arRow[$sTable.'_id'].'&amp;lang='.$sLang;?> class="btn btn-primary"><?php if($sLang==='fr'){echo'Modifier';}else{echo'Edit';}?></a>
                    <a href=<?= CO_HTTP_WF3.'delete.php?id='.$arRow[$sTable.'_id'].'&amp;lang='.$sLang;?> class="btn btn-danger"><?php if($sLang==='fr'){echo'Supprimer';}else{echo'Delete';}?></a>
                    <?php 
                        }else{
                    ?>
                    <i class="fas fa-lock"></i>
                    <?php
                        }
                    ?>
                    </div>
                </td>
            </tr>
            <?php
                    }
                }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="99">
                    <a href="<?= CO_HTTP_WF3.'create.php?lang='.$sLang;?>" class="btn btn-primary"><?php if($sLang==='fr'){echo'Ajouter';}else{echo'Add';}?></a>
                </td>
            </tr>
        </tfoot>
    </table>
</form>

<?php
    }
	// DEJA FAIT DANS INDEX.PHP !!!!
    //-------------------------------
	// foreach(funDirFiles(CO_PATH_REQUIRES_BOTTOM,'') as $sFile){
	// 	if(ctype_digit(substr($sFile,0,2))){
	// 		require_once CO_PATH_REQUIRES_BOTTOM.$sFile;
	// 	}
	// }
    //-------------------------------
?>
<!-- ***** Read.PHP (WF3) : END ***** -->