<!-- ***** Read.PHP (WF3) : START ***** -->
<?php

    // /!\ SESSION DEJA DEMARRER (dans Admin/Index.php) /!\
    //------------------------------------------------------
    // session_start();
    //------------------------------------------------------

    // Si poursuite du programme...
    // ... définie les variables en rapport avec la table à lire
    $sTable='language';
    // ... récupère la liste des champs de la table à Editer
    $obPDO=new App\DBTools();
    $obPDO->init();
    $arFieldNames=$obPDO->funGetNameOfColumns($sTable);
    $arLanguages=$obPDO->execSqlQuery("select * from language");
    
    // Si la table comporte bien des enregistrements
    if(isset($arLanguages)){
?>
    
<form class="d-flex flex-column mx-5 pt-3 mb-5" id="form--languages">
<!-- <div class="d-flex flex-column mx-5 pt-3 mb-5"> -->
    <div class="d-flex flex-row align-items-center w-100 pr-5" id="DivTitleRow">
        <p class="PLanguages">
            <?php 
                if($sLang==='fr')
                {echo"Liste des langages :";}
                else{echo"Languages lists :";};
            ?>
        </p>
        <a href="<?= CO_HTTP_LANGUAGE.'create.php?lang='.$sLang;?>" class="btn btn-primary"><?php if($sLang==='fr'){echo'Ajouter';}else{echo'Add';}?></a>
    </div>
    <!--  -->
    <table class="table table-hover table-striped" id="TableProductions" ><!-- style='width:80%;text-align:center;'> -->
        <thead class="thead-dark" id="TableHead"><!-- class="thead-dark"> -->
            <tr>
                <th width='2%'></th>
                <?php
                    foreach($arFieldNames as $sFieldName){
                ?>
                <th width='<?php
                                if($sFieldName=='id'){echo'6';
                                }else{echo(floor(90/(count($arFieldNames)*3)));}
                            ?>%'
                >
                    <?php
                        if($sFieldName=='id'){echo'#';}else{echo $sFieldName;}
                    ?>
                </th>
                <?php
                    }
                ?>
                <th width='<?=floor(50/(count($arFieldNames)*3));?>%'>Actions</th>
            </tr>
        </thead>
        <!-- -->
        <tbody id="TableBody">
            <?php
                foreach($arLanguages as $arRow){
            ?>
            <tr>
                <td></td>
                <?php
                    foreach($arFieldNames as $sFieldName){
                ?>
                <td>
                    <?=$arRow[$sFieldName]?>
                </td>
                <?php
                    }
                ?>
                <td>
                    <!-- <?php //if($arRow[$arFieldNames[1]]=="*"){ ?> -->
                    <!-- <i class="fas fa-lock"></i> -->
                    <!-- <?php //}else{ ?> -->
                    <a href=<?= CO_HTTP_LANGUAGE.'update.php?id='.$arRow['id'].'&amp;lang='.$sLang;?> class="btn btn-primary"><?php if($sLang==='fr'){echo'Modifier';}else{echo'Edit';}?></a>
                    <a href=<?= CO_HTTP_LANGUAGE.'delete.php?id='.$arRow['id'].'&amp;lang='.$sLang;?> class="btn btn-danger"><?php if($sLang==='fr'){echo'Supprimer';}else{echo'Delete';}?></a>
                    <!-- <?php //} ?> -->
                </td>
            </tr>
            <?php
                }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="99">
                    <a href="<?= CO_HTTP_LANGUAGE.'create.php?lang='.$sLang;?>" class="btn btn-primary"><?php if($sLang==='fr'){echo'Ajouter';}else{echo'Add';}?></a>
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