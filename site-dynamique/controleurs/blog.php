<?php

function controleur($db)
{
   
    // SELECT * FROM articles;
    $sql = "SELECT titre, texte, date_creation FROM articles";

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
