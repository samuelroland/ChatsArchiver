<?php
/**
 *  Projet: page helpers.php for specials function of generating content
 *  Author: Samuel Roland
 *  Creation date: Janvier 2020.
 */

function flashMessage() //display the flashmessage
{
    if (isset($_SESSION["flashmessage"])) { //si il existe un message flash à afficher
        $content = "<div id='flashmessage' class='alert alert-danger'>" . $_SESSION["flashmessage"] . "</div>";
    }
    unset($_SESSION["flashmessage"]);   //unset the msg because we don't want that he appear later again.
    return $content;    //return the content even if it's empty
}

?>

