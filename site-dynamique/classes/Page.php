<?php

function afficheProblemeInstallation($msg)
{
    ?>
    <h1>Erreur d'installation</h1>
    <?php
    echo $msg;
    die();
}

function connectionDatabase(){
    // Connexion à la base de données
    $db_host = "localhost";
    $db_user = "blog";
    $db_pass = "top_secret";
    $db_name = "blog";

    // modele.inc.php
   $db = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($db->connect_errno){
        afficheProblemeInstallation("Erreur de connexion à la base de données<br>".
            "Erreur : ".$db->connect_error.
            " code (".$db->connect_errno.")"
        );
    }

    return $db;
}

class Page
{
    private $code_page = "";
    private $page      = "";
    private $theme     = "";
    private $template  = "";
    private $dossier_controleurs = "";
    private $dossier_themes      = "";
    private $db = "";

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

        $this->db = connectionDataBase();
        
        if (isset($_GET['page']))
        {
            $page = $_GET['page'];
        }
        $this->page = $page;
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

        $textes = controleur($this->db);

        if (isset($textes['template']))
        {
            $this->template = $textes['template'];
            unset($textes['template']);
        }

        $dossier = $this->dossier_themes."/".$this->theme;

        if(!is_file($dossier."/".$this->template.".twig"))
        {
            afficheProblemeInstallation("Template ".$this->template.".twig"." inexistante");
        }
        $this->code_page = file_get_contents($dossier."/".$this->template.".twig");

        // On vérifie si ce template hérite d'un parent
        preg_match('/\{%\s*extends\s*\"([^%\}]*)\"\s*%\}/', $this->code_page, $extends);
        if(isset($extends[1])){
            $code_blocks = $this->code_page;
            $this->code_page = file_get_contents($dossier."/".$extends[1]);

            preg_match_all('/\{%\s*block\s*([^%\}]*)\s*%\}/', $code_blocks, $blocks);

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
        $this->remplaceLabel("theme", $dossier);

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

        foreach ($textes as $label => $texte)
        {
            $this->remplaceLabel($label, $texte);
        }
    }

}