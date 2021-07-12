<?php

/**
 * 
 * Mini Framework PHP
 * -----------------------------
 * 
 * Vous aimez ?
 * Pourquoi pas me remercier en m'offrant un café ?
 * https://www.buymeacoffee.com/marcyves 
 * 
 * (c) 2020 Marc Augier
 * 
 */

function afficheProblemeInstallation($msg)
{
    ?>
    <h1>Erreur d'installation</h1>
    <?php
    echo $msg;
    die();
}

function connectionDataBase()
{
    // Connexion à la base de données
    $db_host = "localhost";
    $db_user = "blog";
    $db_pass = "top_secret";
    $db_name = "blog";

    $db = "rien";

    try{
       $db = new PDO('mysql:host='.$db_host.';dbname='.$db_name, $db_user, $db_pass);
    } catch (PDOException $e) {
        echo "Erreur de connexion SQL : " . $e->getMessage() . "<br/>";
        //die();
    }

    return $db;
}
class Page
{
    private $code_page = "";
    private $page      = "";
    private $theme     = "";
    private $template  = "";
    private $db        = "";
    private $dossier_controleurs = "";
    private $dossier_themes      = "";

    function __construct($page = "home", $theme = "html5up-massively", $template= "index", $dossier_controleurs = "controleurs", $dossier_themes = "themes")
    {
        $this->theme               = $theme;
        $this->template            = $template;
        if(is_dir($dossier_controleurs)){
            $this->dossier_controleurs = $dossier_controleurs;
        }else{
            afficheProblemeInstallation("Dossier controleur");
        }
        if(is_dir($dossier_themes)){
            $this->dossier_themes      = $dossier_themes;
        }else{
            afficheProblemeInstallation("Dossier themes");
        }
        
        if (isset($_GET['page']))
        {
            $page = $_GET['page'];
        }
        $this->page = $page;

        $this->db = connectionDataBase();
    }

    function setTheme($theme)
    {
        $this->theme    = $theme;
    }

    function setTemplate($template)
    {
        $this->template = $template;        
    }

    function setDossierControleurs($dossier_controleurs)
    {
        $this->dossier_controleurs = $dossier_controleurs;
    }

    function __toString()
    {
      return $this->code_page;  
    }

    function remplaceLabel($label, $texte)
    {
        $this->code_page = str_replace("{{ $label }}",$texte, $this->code_page);
    }

    function prepare()
    {
        if(!is_file($this->dossier_controleurs."/".$this->page.".php")){
            afficheProblemeInstallation("Le contrôleur ".$this->page.".php"." n'existe pas");
        }
        include_once $this->dossier_controleurs."/".$this->page.".php";
        // On exécute le contrôleur et récupère le tableau des valeurs à intégrer dans le template pour préparer la page
        $textes = controleur($this->db);

        // On change de la template par défaut
        if (isset($textes['template']))
        {
            $this->template = $textes['template'];
            unset($textes['template']);
        }

        // On charge la template à utiliser pour préparer la page
        $dossier = $this->dossier_themes."/".$this->theme;
        if(!is_file($dossier."/".$this->template.".twig"))
        {
            afficheProblemeInstallation("Template ".$this->template.".twig"." inexistante");
        }
        $this->code_page = file_get_contents($dossier."/".$this->template.".twig");

        /* 
            Décodage du template pour intègrer les valeurs renvoyées par le contrôleur
        */ 
        // On vérifie si ce template hérite d'un parent pour développer le code si besoin
        preg_match('/\{%\s*extends\s*\"([^%\}]*)\"\s*%\}/', $this->code_page, $extends);
        if(isset($extends[1])){
            // Le code par défaut est sauvegardé
            $code_blocks = $this->code_page;
            // Le code par défaut devient le parent
            $this->code_page = file_get_contents($dossier."/".$extends[1]);

            // On extrait les blocks dans le code enfant
            preg_match_all('/\{%\s*block\s*([^%\}]*)\s*%\}/', $code_blocks, $blocks);
            // Pour les remplacer dans le code par défaut (parent)
            foreach ($blocks[1] as $block)
            {
                $block = trim($block);
                preg_match('/{%\h*block\h*'.$block.'\h*%}\R((?:(?!{%\h*endblock\h*%}).*\R)*){%\h*endblock\h*%}/', $code_blocks, $block_content);
                if(isset($block_content[1]))
                {
                    $this->remplaceLabel($block, $block_content[1]);
                }
            }
        }

        // Remplacement des variables système du template : theme puis menu
        $this->remplaceLabel("theme", $dossier);

        // Construction du menu principal
        $menu = "";
        if($d = opendir($this->dossier_controleurs))
        {
            while($fichier=readdir($d))
            {
                if ($fichier[0] != ".")
                {
                    $page = substr($fichier,0,-4);
                    $label = str_replace("_"," ", $page);
                    $label = ucfirst(strtolower($label));

                    if ($page == $this->page){
                        $t = " class='active'";
                    }else{
                        $t= "";
                    }
                    $menu .='<li'.$t.'><a href="index.php?page='.$page.'">'.$label.'</a></li>';
                }
            }
        }
        $this->remplaceLabel("menu", $menu);

        // Remplacement des variables renvoyées par le contrôleur
        // traitement des boucles
        preg_match('/\{%\s*for\s*([^%\}]*)\s*%\}/', $this->code_page, $boucle);
        if(isset($boucle[1]))
        {
            $vars = explode(" in ",$boucle[1]);
            $label          = trim($vars[0]);            
            $var_controleur = trim($vars[1]);            
            if(isset($textes[$var_controleur]))
            {
                // Extraire le code entre for et end for
                preg_match('/{%\h*for \h*'.$boucle[1].'\h*%}\R((?:(?!{%\h*endfor\h*%}).*\R)*){%\h*endfor\h*%}/', $this->code_page, $boucle_content);
                
                $code_boucle_total = "";
                foreach ($textes[$var_controleur] as $ligne) {
                    $code_boucle = $boucle_content[1];
                    foreach ($ligne as $clef => $valeur) {
                        $code_boucle = str_replace("{{ $label.$clef }}",$valeur, $code_boucle);
                    }
                    $code_boucle_total .= $code_boucle;
                }
                $this->code_page = str_replace($boucle_content[0],$code_boucle_total, $this->code_page);
                unset($textes[$var_controleur]);
            } else {
                echo "Erreur twig: variable absente pour boucle ".$boucle[0];
            }
        }
        // traitement des variables simples
        foreach ($textes as $label => $texte)
        {
            if(!is_array($texte))
            {
                $this->remplaceLabel($label, $texte);
            }else {
                echo "Erreur twig: boucle for absente pour $label";
            }
        }
    }

}