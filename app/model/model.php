<?php
/**
 *  Projet: fonctions du modèle de WspChatConverter
 *  Filename: ChatsArchiver
 *  Author: Samuel Roland
 *  Creation date: 20.12.2019
 */
function getChatText($reffile)
{
    $data = file_get_contents("model/tempfiles/chat.txt");
    return $data;
}

function getChatContent($chatid, $username)
{

    if (file_exists("model/data/" . $username . "/chat-" . $chatid . ".json")) {
        $data = json_decode(file_get_contents("/model/data/" . $username . "/chat-" . $chatid . ".json"), true);
    }
    var_dump($data);
    echo("model/data/" . $username . "/chat-" . $chatid . ".json");
    return $data;
}

//Sauver les données du chat converties.
function savechata($chatdata)
{
    file_put_contents("model/data/chat.json", json_encode($chatdata));
}

function addChatToList($reffichier) //add the chat to the list of chats
{
    if (file_exists("model/john/chat.json"))
        if (isset($_FILES[$reffichier])) {
            //WIP ici
        }
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

function getlistchat($username)
{
    $chatinjson = "";   //collection with names of the json.
    $datarootpath = "/model/data/" . $username . "/";
    $collection = scandir($datarootpath);
    var_dump($collection);
    foreach ($collection as $i => $element) {
        if (is_file($datarootpath . $element)) {
            if (strpos($element, "chat-*.json")) {
                $chatinjson[$i] = $element;
            }
        }
    }
    return $chatinjson;
}

?>