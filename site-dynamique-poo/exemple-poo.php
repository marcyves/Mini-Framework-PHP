<?php

/**
 * 
 * Exemple de Mini framework PHP
 * -----------------------------
 * 
 * (c) 2020 Marc Augier
 * 
 */

class Page {

    var $page;

    function __construct($template="generic.temp.html")
    {
        $this->page = file_get_contents($template);

    }

    function setTitre($titre)
    {
        $this->prepare_page("titre", $titre);
    }

    function setDate($date)
    {
        $this->prepare_page("date", $date);
    }

    function setContenu($fichier)
    {
        $contenu = file_get_contents($fichier);
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

$ma_page = new Page();

$ma_page->setTitre("Prototype POO");
$ma_page->setDate("10 juin 2020");
$ma_page->setContenu("contenu.html");

$ma_page->affiche_page();