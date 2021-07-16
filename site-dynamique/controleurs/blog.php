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

include "modèles/blogModèle.php";

function controleur()
{

    $db = new Blog();
    $lignes = $db->getArticles();

    return [
        'template' => 'blog',
        'titre' => "Le blog",
        'sous-titre' => "En direct du Web",
        'titre-court' => "Les derniers articles",
        'articles' => $lignes,
        'pied-de-page' => "Voici la fin de la page"
    ];
}
