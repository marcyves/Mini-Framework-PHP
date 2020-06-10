<?php

class Page {

var $page;

function __construct($template="generic")
{
    $fichier = "template/".$template.".temp.html";
    if (!file_exists($fichier)){
        $fichier = "template/generic.temp.html";
    }
    $this->page = file_get_contents($fichier);
}

function setTitre($titre)
{
    $this->prepare_page("titre", $titre);
}

function setDate($date)
{
    $this->prepare_page("date", $date);
}

function setMenu($page)
{

    $dossier_contenu = "contenu";

    $menu = "<ul class='links'>";
    if($d = opendir($dossier_contenu)){
        while($fichier = readdir($d))
        {
            if ($fichier[0] != "."){
        //            $fichier =str_replace(".html","",$fichier);
                $pos = strpos($fichier,".");
                $fichier = substr($fichier,0, $pos);
                if($fichier == $page){
                    $menu .= '<li class="active">';
                }else{
                    $menu .= '<li>';
                }
                $menu .= '<a href="exemple-framework.php?page='.$fichier.'">'.ucfirst(strtolower($fichier)).'</a></li>';
            }
        }
        closedir($d);
    }
    $menu .= "</ul>";

    $this->prepare_page("liens", $menu);
}

function setContenu()
{

    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }else{
        $page = "hoMe";
    }

    $fichier = "contenu/".$page.".html";

    $this->setMenu($page);

    if (file_exists($fichier)){
        $contenu = file_get_contents($fichier);
    }else{
        $contenu = "<h1>Erreur 404</h1>
        <p>La page $page n'existe pas, si vous pensez que c'est une erreur, merci de contacter l'administrateur.</p>";
    }

    $this->prepare_page("contenu", $contenu);

}

function prepare_page($label, $texte){

    $this->page = str_replace("{{ $label }}", $texte, $this->page);
}

function affiche_page()
{
    echo $this->page;
}
}