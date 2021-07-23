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

function creationVignette($dossier, $fichier, $extension, $largeur, $hauteur)
{
    $fichier_source = $dossier."/".$fichier;
    $fichier_sortie = $dossier."/mini_".$fichier;

    // Lecture du fichier dans un objet image PHP en fonction du type
    switch ($extension) {
        case "jpg":
        case "jpeg":
            $image_source = imagecreatefromjpeg($fichier_source);
        break;
        case "png":
            $image_source = imagecreatefrompng($fichier_source);
        break;
        case "gif":
            $image_source = imagecreatefromgif($fichier_source);
        break;
        default:
            return false;
    }

    // Retaille l'image

    $largeur_init = imageSX($image_source);
    if ($largeur_init < $largeur) {
        return false;
    }
    $hauteur_init = imageSY($image_source);
    if ($hauteur_init < $hauteur) {
        return false;
    }

    $ratio = $largeur/$hauteur;
    $ratio_init = $largeur_init/$hauteur_init;

    $image_destination = ImageCreateTrueColor($largeur, $hauteur);

    if ($ratio == $ratio_init) {
        $largeur_dest = $largeur;
        $hauteur_dest = $hauteur;
        $dest_x = 0;
        $dest_y = 0;
    } elseif ($ratio > $ratio_init) {
        $largeur_dest = $hauteur*$ratio_init;
        $hauteur_dest = $hauteur;
        $dest_x = $largeur/2 - $largeur_dest/2;
        $dest_y = 0;
    } elseif ($ratio < $ratio_init) {
        $largeur_dest = $largeur;
        $hauteur_dest = $largeur/$ratio_init;
        $dest_x = 0;
        $dest_y = $hauteur/2 - $hauteur_dest/2;
    }

    imagecopyresampled($image_destination, $image_source, $dest_x, $dest_y, 0, 0, $largeur_dest, $hauteur_dest, $largeur_init, $hauteur_init);
    // Ecriture du fichier à partir de l'objet image PHP et en fonction du type
    switch ($extension) {
        case "jpg":
        case "jpeg":
            imagejpeg($image_destination, $fichier_sortie);
        break;
        case "png":
            imagepng($image_destination, $fichier_sortie);
        break;
        case "gif":
            imagegif($image_destination, $fichier_sortie);
        break;
        default:
            return false;
    }

    return true;
}


function controleur()
{
    $extension_valide = array("jpg", "jpeg", "png", "gif");

    $tableau = "<ul class='features'>";

    $dossier_produits = "images/produits";

    if (is_dir($dossier_produits)) {
        if ($d = opendir($dossier_produits)) {
            while ($image = readdir($d)) {
                if ($image[0] != "." && substr_compare($image, "mini_", 0, 4)) {
                    $extension = explode('.', $image);
                    $e = strtolower($extension[1]);

                    if (in_array($e, $extension_valide)) {
                        $vignette = "<img width='300' height='180' src='".$dossier_produits."/mini_".$image."'>";

                        if (!file_exists($dossier_produits."/mini_".$image)) {
                            if (!creationVignette($dossier_produits, $image, $e, 300, 180)) {
                                $vignette = '<svg xmlns="http://www.w3.org/2000/svg" width="300" height="180" viewBox="0 0 300 180">
                                <rec fill="#ddd" width="300" heigh="180"/>
                                <text fill="rgba(0,0,0,0.5)" font-family="sans-serif" font-size="30" dy="10.53" font-weight="bold" x="50%" y="50%" text-anchor="middle">300x180</text>
                                </svg>';
                            }
                        }
                        $tableau .= "<li>$vignette<h3>$image</h3></li>";
                    }
                }
            }
        }
    } else {
        $tableau .= "<li>Pas de produit à afficher</li>";
    }

    $tableau .= "</ul>";

    return [
        'template' => 'catalogue',
        'titre' => "Le catalogue de nos produits",
        'sous-titre' => "Tout est fait main",
        'titre-court' => "Catalogue",
        'tableau' => $tableau,
        'contenu' => "Merci de votre visite.",
        'pied-de-page' => "Voici la fin de la page"
    ];
}
