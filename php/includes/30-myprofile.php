
<!-- ***** 30-MYPROFILE.PHP : START ***** -->
<!-- -->
<div id="MyProfile">
    <img src="<?=CO_HTTP_SRC.'portrait.jpg'?>" alt="portrait Hervé Birolini" style="height:100px;" />
    <p class="PMyProfile"><?php if($sLang==='fr'){echo"Mon profil :";}else{echo"My profile :";}?></p>

    <span class="SpanMyProfile col-10">
        <?php
            if($sLang==='fr')
            {echo"Je me nomme Hervé BIROLINI, et j'ai créé ce portfolio pour me présenter à vous,
                afin de vous convaincre que mes compétences peuvent vous être utiles, ainsi qu'à vos clients.";
            }else{
                echo"My name is Hervé BIROLINI, and I created this portfolio to introduce myself to you,
                to convince you that my skills can be useful to you and your clients.";
            }
        ?>
    </span><br><br>

    <span class="SpanMyProfile">
        <?php
            if($sLang==='fr')
            {echo"J'ai profité de la 1ère révolution numérique pour me former aux métiers de l'informatique.
                Au début des années 90, les ordinateurs se démocratisent dans les entreprises, et après les postes
                bureautiques des secrétariats, vient le tour des bureaux d'études. Aux placards les planches à
                dessins !
                <br>À l'époque, sans formation aucune, j'ai sauté dans le train de la révolution numérique.
                J'ai donc commencé par digitaliser les plans sur calques, de nos clients, sous AutoCAD.
                Rapidement, l'intérêt de créer des macros prenant en charge les actions répétitives s'est fait
                ressentir, ce furent mes 1ères armes en programmation...
                Salarié d'une société de service, les quelques années qui suivent m'ont permis d'élargir mes
                compétences et d'approfondir mes connaissances, passant d'une mission de formation à une mission
                de développement d'applicatifs.
                Au cours d'une mission en délégation, j'ai accepté la proposition du client de prendre la responsabilité
                de son parc DAO ; matériels, logiciels et applicatifs en surcouche développés par mes soins...";
            }else{
                echo"I took advantage of the 1st digital revolution to train myself in IT professions.
                In the early 90s, computers were democratized in companies, and after workstations
                office automation of the secretariats, comes the turn of the design offices. In the
                cupboards the boards drawings !    
                <br>At the time, without any training, I jumped on the digital revolution train.
                So I started by digitizing the drawingss on layers, of our customers, in AutoCAD.
                Quickly, the interest in creating macros supporting repetitive actions was felt,
                these were my first weapons in programming ... 
                As an employee of a service company, the following few years allowed me to broaden
                my skills and deepen my knowledge, moving from a training mission to an application
                development mission.
                During a delegation mission, I accepted the client's proposal to take responsibility for
                his DAO fleet ; hardware, software and overlay applications developed by myself ...";
            }
        ?>
    </span><br><br>
    <span class="SpanMyProfile">
        <?php
            if($sLang==='fr')
            {echo"Après une vingtaine d'années d'expériences à toutes les étapes du développement de programmes
                et autres applications numériques, un plan social m'a conduit à réfléchir à une nouvelle orientation
                pour ma carrière et un nouvel usage de mes compétences.
                Au cours de mon introspection, j'ai réalisé que de toutes les actions que j'ai menées, c'est dans
                la création de programmes, et la résolution de problématiques par le code que je m'épanouis le plus.
                C'est pourquoi j'ai fait le choix de cette formation, le choix de rester un développeur, en apprenant
                les langages du moment...";
            }else{
                echo"After around twenty years of experiences at all steps of program development and other
                digital applications, a social plan led me to think about a new direction for my career
                and a new usage of my skills. 
                During my introspection, I realized that of all the actions that I have taken, it is in
                creating programs, and solving problems through code that I thrive the most.
                This is why I made the choice of this training, the choice to remain a developer,
                by learning the languages of the moment...";
            }
        ?>
    </span>
</div>
<!-- ***** 30-MYPROFILE.PHP : END ***** -->