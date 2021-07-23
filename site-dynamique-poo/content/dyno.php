<?php

function controleur()
{
    $t = "<h1>Ceci est une page dynamique</h1>";

    $t .= "<ul>";
    for ($i=1;$i<10;$i++) {
        $t.= "<li>$i</li>";
    }
    $t .= "</ul>";

    return $t;
}
