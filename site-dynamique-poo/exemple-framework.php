<?php

require_once("classes/framework.php");

$ma_page = new Page("base", "content");

$ma_page->setTitre("Le site utilisant notre framework maison");

$ma_page->setDate("10 juin 2020");

$ma_page->setContenu();

$ma_page->affiche_page();
