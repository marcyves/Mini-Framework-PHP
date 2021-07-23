<?php

/**
 *
 * Exemple de Mini framework PHP
 * -----------------------------
 *
 * (c) 2020 Marc Augier
 *
 */

class Page
{
    public $page;

    public function __construct($template="generic.temp.html")
    {
        $this->page = file_get_contents($template);
    }

    public function setTitre($titre)
    {
        $this->prepare_page("titre", $titre);
    }

    public function setDate($date)
    {
        $this->prepare_page("date", $date);
    }

    public function setContenu($fichier)
    {
        $contenu = file_get_contents($fichier);
        $this->prepare_page("contenu", $contenu);
    }
    public function prepare_page($label, $texte)
    {
        $this->page = str_replace("{{ $label }}", $texte, $this->page);
    }

    public function affiche_page()
    {
        echo $this->page;
    }
}

$ma_page = new Page();

$ma_page->setTitre("Prototype POO");
$ma_page->setDate("10 juin 2020");
$ma_page->setContenu("contenu.html");

$ma_page->affiche_page();
