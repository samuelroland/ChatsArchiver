<?php
/**
 *  Projet: index de WspChatConverter
 *  Filename: ChatsArchiver
 *  Author: Samuel Roland
 *  Creation date: 20.12.2019
 */

require_once "controler/controler.php";
$title = "Accueil";
$content = "Contenu de la page $title";
$action = "";
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action) {
    case "login":
        login($username, $password);
        break;
        $title = "view chat";
        viewchat();
    case "disconnect":
        disconnect();
        break;
    case "home":
        $title = "Home";
        break;
}
?>