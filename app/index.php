<?php
/**
 *  Projet: index de WspChatConverter
 *  Filename: ChatsArchiver
 *  Author: Samuel Roland
 *  Creation date: 20.12.2019
 */
session_start();
require_once "controler/controler.php";
$title = "Accueil";
$content = "Contenu de la page $title";
$action = "";
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}
//id of the chat to display if action is viewchat
if (isset($_GET['chatid'])) {
    $chatid = $_GET['chatid'];
}
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];  //by default the value of $username is the username in the session
} else {
    extract($_POST);    //extract every vars in $_POST: $username, $password
}


switch ($action) {
    case "login":
        login($username, $password);
        break;
    case "viewchat":
        $title = "view chat " . $chatid;
        viewchat($chatid);
        break;
    case "convert":
        //convert();
        break;
    case "sendchat":
        sendchat($username);
        break;
    case "disconnect":
        disconnect();
        break;
    default:
        $title = "Home";
        home();
        break;
}
?>