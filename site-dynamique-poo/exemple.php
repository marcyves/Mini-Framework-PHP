<?php

function prepare_page($label, $texte, $page){

    return str_replace("{{ $label }}", $texte, $page);
}

$template = "generic.temp.html";
$fichier_contenu = "contenu.html";

$page = file_get_contents($template);

$page = prepare_page("titre","Bienvenue sur notre site", $page);
$page = prepare_page("date","10 juin 2020", $page);

$contenu = file_get_contents($fichier_contenu);
$page = prepare_page("contenu",$contenu, $page);

echo $page;