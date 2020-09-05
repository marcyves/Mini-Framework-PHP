<?php

function creationVignette($fichier,$largeur,$hauteur){

    global $dossier_produits;

    $image_source = $dossier_produits."/".$fichier;
    $image_sortie = $dossier_produits."/mini_".$fichier;

	$system=explode('.',$image_source);
    
    switch ($system[1])
    {
        case 'jpeg':
        case 'jpg':
            $src_img = imagecreatefromjpeg($image_source);
            break;
        case 'gif':
            $src_img = imagecreatefromgif($image_source);
            break;
        case 'png':
            $src_img = imagecreatefrompng($image_source);
            break;
        default:
            return false;
    }
	
	$largeur_avant=imageSX($src_img);
    $hauteur_avant=imageSY($src_img);

    $ratio = $largeur_avant/$hauteur_avant;
    
	if ($largeur_avant > $hauteur_avant) {
		$thumb_w=$largeur;
		$thumb_h=$largeur/$ratio;
	}
	if ($largeur_avant < $hauteur_avant) {
		$thumb_w=$hauteur*$ratio;
		$thumb_h=$hauteur;
	}
	if ($largeur_avant == $hauteur_avant) {
		$thumb_w=$largeur;
		$thumb_h=$hauteur;
    }
    
    $dst_img=ImageCreateTrueColor($thumb_w,$thumb_h);
	imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$largeur_avant,$hauteur_avant); 
    
    switch ($system[1])
    {
        case 'jpeg':
        case 'jpg':
            imagejpeg($dst_img,$image_sortie); 
        break;
        case 'gif':
            imagegif($dst_img,$image_sortie); 
        break;
        case 'png':
            imagepng($dst_img,$image_sortie); 
        break;
        default:
            return false;
    }
   
	imagedestroy($dst_img); 
    imagedestroy($src_img);
    
    return true;	
}	

function controleur()
{
    global $dossier_produits;

    $dossier_produits = "images/produits";

      if(is_dir($dossier_produits)){

        $tableau = "<tr>";
        $compte  =  0;
        if($d = opendir($dossier_produits))
        {
            while($image=readdir($d))
            {
                if ($image[0] != "." && substr_compare($image, "mini_", 0,4))
                {
                    if (!file_exists($dossier_produits."/mini_".$image)){
                        creationVignette($image,300,180);
                    }

                    if (file_exists($dossier_produits."/mini_".$image)){
                        $vignette = '<td><img width="300" height="180" src="'.$dossier_produits."/mini_".$image.'"></td>';
                    }else{
                        $vignette = '<svg xmlns="http://www.w3.org/2000/svg" width="300" height="180" viewBox="0 0 300 180">
                        <rect fill="#ddd" width="300" height="180"/>
                        <text fill="rgba(0,0,0,0.5)" font-family="sans-serif" font-size="30" dy="10.5" font-weight="bold" x="50%" y="50%" text-anchor="middle">300×180</text>
                      </svg>
                      ';
                    }
                    
                    $tableau .='<td>'.$vignette.'</td>';
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