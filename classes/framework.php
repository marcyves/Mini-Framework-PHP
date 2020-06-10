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

function setContenu()
{

    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }else{
        $page = "home";
    }

    $fichier = "contenu/".$page.".html";

    if (file_exists($fichier)){
        $contenu = file_get_contents($fichier);
    }else{
        $contenu = "<h1>Erreur 404</h1>";
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