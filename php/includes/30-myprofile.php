
<!-- ***** 30-MYPROFILE.PHP : START ***** -->
<!-- -->
<div id="MyProfile">
    <img class="mt-5" src="<?=CO_HTTP_SRC.'portrait.jpg'?>" alt="portrait Hervé Birolini" style="height:100px;" />
    <p class="p--title-form" id="PMyProfile"><?php if($sLang==='fr'){echo"Mon profil :";}else{echo"My profile :";}?></p>

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
                J'ai donc commencé par digitaliser les plans sur calques de nos clients, sous AutoCAD.
                Rapidement, l'intérêt de créer des macros prenant en charge les actions répétitives s'est fait
                sentir, ce furent mes 1ères armes en programmation...
                Salarié d'une société de services, les quelques années qui suivent m'ont permis d'élargir mes
                compétences et d'approfondir mes connaissances, passant de l'assemblage et l’installation de postes de DAO,
                à une mission de formation, ou bien encore le développement d'applicatifs.
                Au cours d'une mission en délégation, j'ai accepté la proposition du client de prendre la responsabilité
                de son parc DAO, matériels, logiciels et applicatifs en surcouche développés par mes soins
                ; parc constitué de 15 postes en France, et 5 en Inde.";
            }else{
                echo"I took advantage of the 1st digital revolution to train myself in IT professions.
                In the early 90s, computers were democratized in companies, and after workstations
                office automation of the secretariats, comes the turn of the design offices. To the
                cupboards the boards drawings !
                <br>At the time, without any training, I jumped on the digital revolution train.
                So I started by digitizing the drawingss on layers of our customers, in AutoCAD.
                Quickly, the interest in creating macros supporting repetitive actions was felt,
                these were my first weapons in programming ...
                As an employee of a service company, the following few years allowed me to broaden
                my skills and deepen my knowledge, moving from assembly and installation of CAD workstations,
                to training missions, or even to an application development mission.
                During a delegation mission, I accepted the client's proposal to take responsibility for
                his DAO fleet, hardware, software and overlay applications developed by myself
                ; fleet made up of 15 stations in France and 5 in India.";
            }
        ?>
    </span><br><br>
    <span class="SpanMyProfile">
        <?php
            if($sLang==='fr')
            {echo"Après une vingtaine d'années d'expériences à toutes les étapes de la gestion du matériel,
                du développement de programmes et autres applications numériques, un plan social m'a conduit
                à réfléchir à une nouvelle orientation pour ma carrière et un nouvel usage de mes compétences.
                Au cours de ma réflexion, j'ai réalisé que de toutes les actions que j'ai menées, c'est dans
                la création de programmes, et la résolution de problématiques que je m'épanouis le plus.
                C'est pourquoi j'ai fait le choix de suivre une formation de Développeur Web et Web Mobile au format Bootcamp.
                <br>
                Aujourd’hui, diplômé d’un Titre Professionnel DWWM, la formation m’a fait découvrir une partie du métier
                qui ne m’exalte guère : la conception dans un CMS. Confronté à la difficulté de trouvé emploi de développeur
                sans expérience en entreprise, et devant les enjeux liés au contrôle et à la protection des données qui font
                régulièrement l’actualité, mon intérêt pour la cybersécurité va croissant.
                C’est pourquoi j’ai décidé de suivre une formation en alternance avec l’Ecole Européenne de CyberSécurité (EECS)
                de Versailles, préparant aux deux métiers que sont, Technicien de Systèmes et Réseaux, et Opérateur en Cybersécurité.
                Pour concrétiser ce projet, je suis à la recherche de l’entreprise à laquelle faire profiter de
                mes différentes compétences transverses, tout en montant en compétence dans les métiers précités.

                <br>
                ";
            }else{
                echo"After around twenty years of experiences at all steps of hardware management, program development and other
                digital applications, a social plan led me to think about a new direction for my career
                and a new use of my skills. 
                During my reflection, I realized that of all the actions that I have taken, it is in
                creating programs, and solving problems that I thrive the most.
                This is why I made the chose to follow a Web and Mobile Web Developer training in Bootcamp format.
                <br>
                Today, graduate of a DWWM Professional Title, the training made me discover a part of the profession
                that does not exalt me: design in a CMS. Faced with the difficulty of finding a job as a developer without
                business experience, and faced with the issues related to data control and protection that are regularly in the news,
                my interest in cybersecurity is growing. This is why I decided to follow a work-study training with EECS of Versailles,
                preparing for the two professions which are, Systems and Networks Technician, and Cybersecurity Operator.
                To make this project a reality, I am looking for the company to benefit from my various cross-functional skills,
                while increasing my skills in the aforementioned professions.
                ";
            }
        ?>
        <br>
        <a href="/src/EECS/eecs_plaquette_entreprise_v7_web.pdf" target="blank" >
            <b><font COLOR="black" >-> 
            <?php
                if($sLang==='fr')
                {echo"Se renseigner sur la formation en alternance avec EECS";
                }else{
                echo"Find out about work-study training with EECS";}
            ?>
            <-</font></b>
        </a>
    </span>
</div>
<!-- ***** 30-MYPROFILE.PHP : END ***** -->