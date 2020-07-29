<?php

class Page
{
    private $code_page = "";
    private $page      = "";
    private $theme     = "";
    private $template  = "";
    private $dossier_controleurs = "";
    private $dossier_themes = "";

    function __construct(
        $page = "home",
        $theme = "html5up-massively",
        $template= "index",
        $dossier_controleurs = "controleur/",
        $dossier_themes = "themes"
        )
    {
        $this->theme               = $theme;
        $this->template            = $template;
        $this->dossier_controleurs = $dossier_controleurs;
        $this->dossier_themes      = $dossier_themes;

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
        $this->code_page = str_replace("{{ ".trim($label)." }}",$texte, $this->code_page);
    }

    function prepare()
    {
        include_once $this->dossier_controleurs.$this->page.".php";
        $textes = controleur();

        if (isset($textes['template']))
        {
            $this->template = $textes['template'];
            unset($textes['template']);
        }

        $fichier = $this->dossier_themes."/".$this->theme."/".$this->template.".twig";
        $this->code_page = file_get_contents($fichier);

        // On vérifie si ce template hérite d'un parent
        preg_match('/\{\%\s*extends\s*\"([^\%\}]*)\"\s*\%\}/',$this->code_page, $extends);
        if (isset($extends[1])){
            $code_block = $this->code_page;
            $fichier_parent = $this->dossier_themes."/".$this->theme."/".$extends[1];
            $this->code_page = file_get_contents($fichier_parent);
            preg_match_all('/\{\%\s*block\s*([^\%\}]*)\s*\%\}/',$code_block, $blocks);

            foreach ($blocks[1] as $block) {
//                preg_match('/{% block '.trim($block).' %}(.+){% endblock %}/s',$code_block, $block_content);
                preg_match('/{%\h*block\h*'.trim($block).'\h*%}\R((?:(?!{%\h*endblock\h*%}).*\R)*){%\h*endblock\h*%}/',$code_block, $block_content);
                if (isset($block_content[1])){
                    $this->remplaceLabel($block, $block_content[1]);
                }
            }           
        }

        $this->remplaceLabel("theme", $this->dossier_themes."/".$this->theme);

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