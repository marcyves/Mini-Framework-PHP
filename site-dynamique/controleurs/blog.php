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

function controleur($db)
{
   
    // SELECT * FROM articles;
    $sql = "SELECT titre, texte AS description , date_creation AS date FROM articles";

    $result = $db->query($sql);
    $lignes = $result->fetchAll(PDO::FETCH_ASSOC);

    return [
        'template' => 'blog',
        'titre' => "Le blog",
        'sous-titre' => "En direct du Web",
        'titre-court' => "Les deniers articles",
        'articles' => $lignes,
        'pied-de-page' => "Voici la fin de la page"
    ];
}
