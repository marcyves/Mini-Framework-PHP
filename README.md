# Mini-Framework-PHP

Ces fichiers peuvent être utilisés tels quels, toutefois ils ont été prévus comme support pour le cours : [Créer un site Web dynamique de A à Z avec PHP](https://www.udemy.com/course/votre-site-web-en-php/?referralCode=6052B85326FD5DDC78EC) qui se trouve chez Udemy.

## Construction d'un mini Framework PHP en 2 étapes :

1. Le premier dossier "basique" contient une première expérimentation nous fait passer d'un template HTML à un site PHP dynamique de base. L'expérience peut être poussée plus loin mais le but est de montrer la faisabilité sans aller jusqu'au bout des possibilités (pour l'instant...).
2. Le second dossier contient le mini framework codé en Programmation Orienté Objet. Il reprend l'idée de template avec une syntaxe "à la Twig" et la mise en œuvre du modèle de conception MVC.

## Mise en place

Le template Massively provient du site [HTML5up](https://html5up.net/).

En plus des dossiers du template Massively, il y a 3 dossiers spécifiques à notre framework :

- classes contient la librairie de base.
- contenu contient la partie de contenu spécifique à chaque page du site.
- template contient les templates de pages.

## Utilisation du framework

Le dossier themes contient les dossiers du ou des thèmes utilisés par le site. Chaque thème est constitué des ressources habituelles : images, fichiers css, javascript, etc. Et au moins d'un template HTML, sous la forme d'un fichier avec l'extension `twig`.
Les templates HTML sont écrits avec une syntaxe TWIG (très) simplifiée, il faut en créer au minimum un qui sera utilisé par défaut pour toutes les pages du site. Chaque page peut toutefois appeler un template spécifique.
Un template peut hériter d'un autre (1 seul niveau d'héritage).

Le pages du site doivent être créées dans le dossier `controleur` sous la forme d'une fonction `controleur` qui retourne dans un tableau les différentes variables du template.

## Liens utiles

### PHP

- [PHP Standard Recommandation](https://www.php-fig.org/psr/)
- [Composer](https://getcomposer.org/) pour gérer les dépendances d'un projet et les installer automatiquement.
- [PHPUnit](https://phpunit.de/)
- [Symfony](https://symfony.com/)
- [Laravel](https://laravel.com/)

### HTML et CSS

- [Bootstrap](https://getbootstrap.com/)
- [Bootswatch](https://bootswatch.com/)
- [Shards](https://designrevision.com/downloads/shards/), Bootstrap, en mieux.

### Javascript

- [JQuery](https://jquery.com/)

- [Web developer Roadmap](https://github.com/kamranahmedse/developer-roadmap)
- [Javascript from scratch](https://github.com/naomihauret/js-stack-from-scratch/)
- [Tutoriel Angular](https://www.dropbox.com/s/ad1va8ia9blf9mi/Capture%20d%27%C3%A9cran%202019-07-11%2020.44.57.png?dl=0)

## Notice

<p align="center"><img src="https://licensebuttons.net/l/by-sa/3.0/fr/88x31.png" alt="Licence"></p>

Ces scripts sont mis à disposition selon les termes de la [Licence Creative Commons Attribution - Partage dans les Mêmes Conditions 3.0 France](https://creativecommons.org/licenses/by-sa/3.0/fr/).
