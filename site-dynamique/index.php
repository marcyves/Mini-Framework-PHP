<?php
/**
 * Mini Framework
 * 
 * (c) 2020 Marc Augier
 */

include_once "classes/Page.php";

$ma_page = new Page();

// $ma_page->setDossierControleurs("controleur2/");
//$ma_page->setTheme("html5up-massively2");
// $ma_page->setTemplate("catalogue");

$ma_page->prepare();

echo $ma_page;

?>