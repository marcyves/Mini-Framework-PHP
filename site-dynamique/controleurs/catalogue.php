<?php

function controleur()
{
    $dossier_produits = "images/produits";

      if(is_dir($dossier_produits)){

        $tableau = "<tr>";
        $compte  =  0;
        if($d = opendir($dossier_produits))
        {
            while($image=readdir($d))
            {
                if ($image[0] != ".")
                {
                    $tableau .='<td><img width="300" src="'.$dossier_produits."/".$image.'"></td>';
                    $compte++;
                    if ($compte >= 3){
                        $compte = 0;
                        $tableau .= "</tr><tr>";
                    }
                }
            }
        }

        $tableau = "<table>$tableau</table>";
    }else{
        $tableau = "<table><tr><td>pas de produits</tr></table>";
    }
    return [
        'template' => 'catalogue',
        'titre' => "Le catalogue de nos produits",
        'sous-titre' => "Tout est fait main",
        'titre-court' => "Catalogue",
        'tableau' => $tableau,
        'contenu' => "Lorem ipsum toujours même pour le catalogue ...",
        'pied-de-page' => "Voici la fin de la page"
    ];
}