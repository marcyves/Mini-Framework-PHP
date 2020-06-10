<?php

require_once("classes/framework.php");

$ma_page = new Page("base");

$ma_page->setTitre("Vive le GRETA");

$ma_page->setDate("10 juin 2020");

$ma_page->setContenu();

$ma_page->affiche_page();