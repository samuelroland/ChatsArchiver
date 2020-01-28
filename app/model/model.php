<?php
/**
 *  Projet: fonctions du modèle de WspChatConverter
 *  Filename: ICT-133-SRD
 *  Author: Samuel Roland
 *  Creation date: 20.12.2019
 */
function getChatText()
{
    $data = file_get_contents("model/chat.txt");
    return $data;
}

function getUsers()
{
    return json_decode(file_get_contents("model/users/Users.json"), true);//recevoir la liste des utilisateurs
}

function getOneUser($username)
{
    $listUsers = getUsers();
    foreach ($listUsers as $OneUser) {
        if ($OneUser['username'] == $username) {
            return $OneUser;
        }
    }
    return "";  //si rien trouvé retourne vide.
}

?>