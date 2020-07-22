<?php
/*
==============================================================================

 Ce script fait partie d'une série d'exemples de code mise à disposition
  sur https://github.com/marcyves/Mini-Framework-PHP 
  en support du cours https://www.udemy.com/course/votre-site-web-en-php/?referralCode=6052B85326FD5DDC78EC


 (c) 2020 Marc Augier

==============================================================================
*/

function debutPage($titre, $active){
    ?>
        <!DOCTYPE HTML>
        <!--
            Massively by HTML5 UP
            html5up.net | @ajlkn
            Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
        -->
        <html>
            <head>
                <title><?php echo $titre; ?></title>
                <meta charset="utf-8" />
                <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
                <link rel="stylesheet" href="assets/css/main.css" />
                <noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
            </head>
            <body class="is-preload">

                <!-- Wrapper -->
                    <div id="wrapper">

                        <!-- Header -->
                            <header id="header">
                                <a href="index.php" class="logo"><?php echo $titre; ?></a>
                            </header>

                        <!-- Nav -->
                            <nav id="nav">
                                <ul class="links">
    <?php
    if ($d = @opendir("pages/")){
        while($fichier = readdir($d)){
            if ($fichier[0] != "."){
                $page = substr($fichier, 0, -4);
                $label = str_replace("_"," ", $page);
                if ($page == $active){
                    $t = " class='active'";
                }else{
                    $t = "";
                }
                echo '<li'.$t.'><a href="generic.php?page='.$page.'">'.$label.'</a></li>';
            }
        }    
    }
        // echo '<li class="active"><a href="generic.php">Generic Page</a></li>';
    ?>                          </ul>
                                <ul class="icons">
                                    <li><a href="#" class="icon brands fa-twitter"><span class="label">Twitter</span></a></li>
                                    <li><a href="#" class="icon brands fa-facebook-f"><span class="label">Facebook</span></a></li>
                                    <li><a href="#" class="icon brands fa-instagram"><span class="label">Instagram</span></a></li>
                                    <li><a href="#" class="icon brands fa-github"><span class="label">GitHub</span></a></li>
                                </ul>
                            </nav>
            <?php
}

function contenuPage($titre, $soustitre, $image, $contenu){
    ?>
        <!-- Main -->
        <div id="main">

        <!-- Post -->
            <section class="post">
                <header class="major">
                    <span class="date">April 25, 2017</span>
                    <h1><?php echo $titre; ?></h1>
                    <p><?php echo $soustitre; ?></p>
                </header>
                <div class="image main"><img src="images/<?php echo $image; ?>.jpg" alt="" /></div>
                <p><?php echo $contenu; ?></p>
            </section>

        </div>
    <?php    
}

function finPage(){
    ?>
        <!-- Footer -->
        <footer id="footer">
            <section>
                <form method="post" action="#">
                    <div class="fields">
                        <div class="field">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" />
                        </div>
                        <div class="field">
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" />
                        </div>
                        <div class="field">
                            <label for="message">Message</label>
                            <textarea name="message" id="message" rows="3"></textarea>
                        </div>
                    </div>
                    <ul class="actions">
                        <li><input type="submit" value="Send Message" /></li>
                    </ul>
                </form>
            </section>
            <section class="split contact">
                <section class="alt">
                    <h3>Address</h3>
                    <p>1234 Somewhere Road #87257<br />
                    Nashville, TN 00000-0000</p>
                </section>
                <section>
                    <h3>Phone</h3>
                    <p><a href="#">(000) 000-0000</a></p>
                </section>
                <section>
                    <h3>Email</h3>
                    <p><a href="#">info@untitled.tld</a></p>
                </section>
                <section>
                    <h3>Social</h3>
                    <ul class="icons alt">
                        <li><a href="#" class="icon brands alt fa-twitter"><span class="label">Twitter</span></a></li>
                        <li><a href="#" class="icon brands alt fa-facebook-f"><span class="label">Facebook</span></a></li>
                        <li><a href="#" class="icon brands alt fa-instagram"><span class="label">Instagram</span></a></li>
                        <li><a href="#" class="icon brands alt fa-github"><span class="label">GitHub</span></a></li>
                    </ul>
                </section>
            </section>
        </footer>

        <!-- Copyright -->
            <div id="copyright">
                <ul><li>&copy; Untitled</li><li>Design: <a href="https://html5up.net">HTML5 UP</a></li></ul>
            </div>

        </div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

    	</body>
        </html>
    <?php
}
?>