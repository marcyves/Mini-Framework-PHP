<?php

function controleur($db)
{
   
    // SELECT * FROM articles;
    $sql = "SELECT id, titre, texte, date_creation FROM articles";

    $result = $db->query($sql);
    $lignes = $result->fetchAll();

    foreach ($lignes as list($id, $titre, $desc, $date)) {
        $contenu .= "+ $titre <i>$desc</i> ($date)<br>";
    }

    return [
        'template' => 'blog',
        'titre' => "Le blog",
        'sous-titre' => "En direct du Web",
        'titre-court' => "Les deniers articles",
        'titre' => $titre,
        'texte' => $desc,
        'date'  => $date,
        'pied-de-page' => "Voici la fin de la page"
    ];
}
