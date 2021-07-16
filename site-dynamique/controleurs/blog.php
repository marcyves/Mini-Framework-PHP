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

    $template = "blog";
    $db = new Blog();

    if(isset($_GET['cmd']))
    {
        switch($_GET['cmd'])
        {
            case "modifier":
                $titre_court = "Détails";
                $lignes = $db->getArticleById($_GET['id']);        
            break;
            case "effacer":
                $db->effaceArticle($_GET['id']);
                $titre_court = "Les derniers articles après effacement";
                $lignes = $db->getArticles();        
            break;
            case "insert":
                $db->insertArticle($_GET['titre'], $_GET['description']);
                $titre_court = "Les derniers articles après ajout";
                $lignes = $db->getArticles();        
            break;
            case "ajouter":
                $template = 'form_article';
                $titre_court = "Création nouvel article";
            break;
            }
    } else {
        $titre_court = "Les derniers articles";
        $lignes = $db->getArticles();
    }

    return [
        'template' => $template,
        'titre' => "Le blog",
        'sous-titre' => "En direct du Web",
        'titre-court' => $titre_court,
        'articles' => $lignes,
        'pied-de-page' => "Voici la fin de la page"
    ];
}
