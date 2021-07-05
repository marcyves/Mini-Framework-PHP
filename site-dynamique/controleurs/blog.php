<?php

function controleur($db)
{

    $sql = "SELECT id, titre, texte, date_creation FROM articles";
    $contenu = "";

    if ($result = $db->query($sql)){
        $contenu .= "<h3>avec fetch_row</h3>";
        
        $contenu .= "<ul>";
        while(list($id, $titre, $texte, $date_creation) = $result->fetch_row()){
            $contenu .= "<li>($id) $titre, $texte</li>";
        }
        $contenu .= "</ul>";

        $contenu .= "<h3>avec fetch_array 1</h3>";

        $result->data_seek(0);
            
        $contenu .= "<ul>";
        while($type = $result->fetch_array()){
            $contenu .= "<li>(".$type[0].") ".$type[1]."</li>";
        }
        $contenu .= "</ul>";

        $contenu .= "<h3>avec fetch_array 2</h3>";

        $result->data_seek(0);
            
        $contenu .= "<ul>";
        while($type = $result->fetch_array()){
            $contenu .= "<li>(".$type['titre'].") ".$type['texte']."</li>";
        }
        $contenu .= "</ul>";

    }else{
        $contenu .= "<h2>Erreur sur la requête</h2>";
        $contenu .= $sql;
        $contenu .= "<br>Erreur : ".$db->error." code (".$db->errno.")";
    }

    return [
        'titre' => "Le Blog",
        'sous-titre' => "Les derniers articles",
        'titre-court' => $page->db,
        'contenu' => $contenu,
        'pied-de-page' => "Bientôt les archives ici"
    ];
}
