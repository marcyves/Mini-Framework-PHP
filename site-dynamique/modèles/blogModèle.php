<?php


class Blog
{
    private $db;

    function __construct($db_host = "localhost", $db_user = "blog", $db_pass = "top_secret", $db_name = "blog")
    {

        // Connexion à la base de données
        $this->db = false;
        try{
           $this->db = new PDO('mysql:host='.$db_host.';dbname='.$db_name, $db_user, $db_pass);
        } catch (PDOException $e) {
            echo "Erreur de connexion SQL : " . $e->getMessage() . "<br/>";
            //die();
        }
    }

    function getArticles()
    {
       // SELECT * FROM articles;
       $sql = "SELECT titre, texte AS description , date_creation AS date FROM articles";

       $result = $this->db->query($sql);
       $lignes = $result->fetchAll(PDO::FETCH_ASSOC);

       return $lignes;
    }
   
}