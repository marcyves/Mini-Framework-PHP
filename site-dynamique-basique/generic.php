<?php
/*
==============================================================================

 Ce script fait partie d'une série d'exemples de code mise à disposition
  sur https://github.com/marcyves/Mini-Framework-PHP
  en support du cours https://www.udemy.com/course/votre-site-web-en-php/?referralCode=6052B85326FD5DDC78EC


 (c) 2020 Marc Augier

==============================================================================
*/

    include_once "inc/fonction.inc.php";

    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = "home";
    }
    include_once "pages/$page.php";

    debutPage($titre, $page);

    contenuPage($titre, $soustitre, $image, $contenu);

    finPage();
