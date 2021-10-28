
<!-- ***** 40-MYFORMATION.PHP : START ***** -->
<?php
    // Si poursuite du programme...
    // ... définie les variables en rapport avec la table à lire
    $sTableWf3='wf3';
    // ... récupération des projets WF3, par la présence d'une image pour chaque
    $obPDO=new App\DBTools();
    $obPDO->init();
    // $arWF3=fundirfiles(CO_PATH_SRC_WF3,'png');
    // var_dump($arWF3);
    
    //
    require_once CO_PATH_ADMIN.'htmlgenerator.php';
    use Admin\htmlGenerator;

?>


<div id="MyFormation"> <!--class="SecMyFormationColumn"-->

    <div class="d-flex flex-row flex-wrap align-items-center justify-content-between">
        <p id="PMyFormation"><?php if($sLang==='fr'){echo"Ma Formation, mes réalisations :";}else{echo"My Training, my productions :";};?></p>
        <!-- <div class="d-flex flex-column pr-5" style="margin-bottom:10px;">
            <label for="language"><?php if($sLang==='fr'){echo"Langages : ";}else{echo"Languages : ";}?></label>
            <?php echo htmlGenerator::getHtmlSelect($obPDO->getLanguages()['select'],'select--language',null,false);?>
        </div> -->
    </div>

    <span class="SpanMyFormation">
        <?php
            if($sLang==='fr')
            {echo"Vous pouvez voir ci-dessous un échantillon de mes productions, que ce soit en formation, ou bien personnelles.
                Cette liste est évolutive, les données étant gérées en mode Administration. Connectez-vous en 'invité' pour jouer avec...";
            }else{
                echo"You can see below a sample of my productions, during the training, or even personal projects.
                This list is evolving, the data being managed in Administration mode. You can log in as a 'guest' to play with ...";
            }
        ?>
    </span>
    <div class="d-flex flex-row flex-wrap">
        <span class="SpanMyFormation">
            <?php
                if($sLang==='fr')
                {echo"La liste des langages pour le filtrage de l'affichage ci-dessous est gérée par l'Administrateur dans un CRUD :";
                }else{
                    echo"The list of languages for display filtering ​​is managed by the Administrator in a CRUD:";
                }
            ?>
        </span>
        <div class="d-flex flex-column justify-content-center" style="margin-bottom:10px;">
            <!-- <label for="language"><?php if($sLang==='fr'){echo"Langages : ";}else{echo"Languages : ";}?></label> -->
            
            <!--  20211025 - Source langage BdD -->
            <!-- ------------------------------------ -->
            <?php
                $arClass=$obPDO->execSqlQuery("select label from language");
                echo htmlGenerator::getHtmlSelect($arClass,'select--language',null,false);
            ?>
            <!-- <?php echo htmlGenerator::getHtmlSelect($obPDO->getLanguages()['select'],'select--language',null,false);?> -->
            <!-- ------------------------------------ -->

        </div>
    </div>
    <br>

    <div class="d-flex flex-row col-12 flex-wrap" style="justify-content:space-evenly;">
        <?php
            // récupère la liste des champs de la table à lire
            $arFieldNames=$obPDO->funGetNameOfColumns($sTableWf3);
            // vérifie si existe un champs pour le tri
            if(in_array('priority',$arFieldNames))
            {$arItems=$obPDO->execSqlQuery("SELECT * from $sTableWf3 order by priority");}
            else{$arItems=$obPDO->execSqlQuery("SELECT * from $sTableWf3");}
            //
            // var_dump('<pre>');
            // var_dump($arItems);
            foreach($arItems as $arItem){
        ?>
        <div class="DivFormationIMG <?=$arItem['language']?>"
            style="background-image:url('<?php echo strtolower(CO_HTTP_SRC_WF3.$arItem['picture_name']);?>');"
        >
            <div class="DivTitle"><h5 class="FormationIMG--title"><?=$arItem['title_'.$sLang]?></h5></div>

            <!-- <input type="hidden" id="default_item" name="default_item" 
                {% if default_item is defined and default_item != null %}value="{{ default_item }}"{% endif %}
            > -->
            <p class="PId" style="visibility:hidden;"><?=$arItem[$sTableWf3.'_id']?></p>
        </div>
        <?php }?>
    </div>
</div>
<!-- ***** 40-MYFORMATION.PHP : END ***** -->