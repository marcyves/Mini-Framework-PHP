<?php
	include_once "inc/fonction.inc.php";

	if (isset($_GET['page'])){
		$page = $_GET['page'];
	} else {
		$page = "home";
	}
	include_once "pages/$page.php";

	debutPage($titre, $page);

	contenuPage($titre, $soustitre, $image, $contenu);

	finPage();
?>