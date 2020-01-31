<?php
/**
 *  Projet: fonctions du modèle de WspChatConverter
 *  Filename: ChatsArchiver
 *  Author: Samuel Roland
 *  Creation date: 20.12.2019
 */
function getChatText($fileTmpName)
{
    $data = file_get_contents("model/tempfiles/" . $fileTmpName);
    return $data;
}

function getChatContent($chatid, $username)
{
    if (file_exists("model/data/" . $username . "/chat-" . $chatid . ".json")) {
        $data = json_decode(file_get_contents("model/data/" . $username . "/chat-" . $chatid . ".json"), true);
    }
    return $data;
}

//Sauver les données du chat converties.
function savechata($chatdata)
{
    var_dump($chatdata);
    $nextchatid = count(getlistchat($_SESSION['user'])) + 1;
    file_put_contents("model/data/" . $_SESSION['user'] . "/chat-" . $nextchatid . ".json", json_encode($chatdata));
}

function addChatToList($reffichier) //add the chat to the list of chats
{
    if (file_exists("model/john99/chat.json"))
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

function getlistchat($username) //get the list of the chats of the user. return a collection of filename of type 'chat-x.json'
{
    //$chatinjson = array();   //collection with names of the json.
    $datarootpath = "/model/data/" . $username . "/";
    $collection = scandir($_SERVER['DOCUMENT_ROOT'] . $datarootpath);
    $j = 0; //index of the result table. init to 0.
    foreach ($collection as $i => $element) {
        if (is_file($datarootpath . $element) == false) {
            if (strpos($element, "chat-") == 0 && strpos($element, ".json") != false) { //if start with 'chat-' and contain '.json'
                $idOfElement = substr($element, 5, strpos($element, ".json") - 5);  //substring 'x' de 'chat-x.json'
                $chatinjson[$j] = $idOfElement + 0; //save the id after converted her in int.
                $j++;
            }
        }
    }
    return $chatinjson;
}

?>