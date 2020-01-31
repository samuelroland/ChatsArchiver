<?php
/**
 *  Projet: controler de WspChatConverter
 *  Filename: ChatsArchiver
 *  Author: Samuel Roland
 *  Creation date: 20.12.2019
 */
require_once 'model/model.php';  //importer fonction des données pour toutes les pages.
require_once 'view/helpers/helpers.php';    //get the helpers functions

function viewchat($chatid)
{

    if (isset($_SESSION['user'], $chatid)) {
        $thechatinfos = getChatContent($chatid, $_SESSION['user']);

    }
    //display the viewchat even if data are not loaded.
    require_once 'view/viewchat.php';   //display by default the view of chat, even if chat content or list of chats are not generated.
}

function sendchat($username)
{
    //Uploader l'image et déplacer vers dossier image:
    /************************************************************
     * Script realise par Emacs
     * Crée le 19/12/2004
     * Maj : 23/06/2008
     * Licence GNU / GPL
     * webmaster@apprendre-php.com
     * http://www.apprendre-php.com
     * http://www.hugohamon.com
     *
     * Changelog:
     *
     * 2008-06-24 : suppression d'une boucle foreach() inutile
     * qui posait problème. Merci à Clément Robert pour ce bug.
     *
     *************************************************************/

    /************************************************************
     * Definition des constantes / tableaux et variables
     *************************************************************/

// Constantes
    define('TARGET', $_SERVER['DOCUMENT_ROOT'] . "/model/tempfiles/");    // Repertoire cible
    define('MAX_SIZE', 10000000);    // Taille max en octets du fichier
    define('WIDTH_MAX', 3000);    // Largeur max de l'image en pixels
    define('HEIGHT_MAX', 3000);    // Hfauteur max de l'image en pixels
    define('NOMUPLOAD', "fichier");    //nom de l'upload. nom entrée dans $_FILES
// Tableaux de donnees
    $tabExt = array('txt', 'md', 'json');    // Extensions autorisees
    $infosImg = array();

// Variables
    $extension = 'txt';
    $message = '';
    $nomFichier = '';
    $nomFichier = "chat-" . uniqid() . "." . $extension;
    /************************************************************
     * Creation du repertoire cible si inexistant
     *************************************************************/
    if (!is_dir(TARGET)) {
        if (!mkdir(TARGET, 0755)) {
            exit('Erreur : le répertoire cible ne peut-être créé ! Vérifiez que vous diposiez des droits suffisants pour le faire ou créez le manuellement !');
        }
    }
    /************************************************************
     * Script d'upload
     *************************************************************/
    //if (!empty($_FILES[NOMUPLOAD]['name'])) {
    //    // Recuperation de l'extension du fichier
    //    $extension = pathinfo($_FILES[NOMUPLOAD]['name'], PATHINFO_EXTENSION);

    //    // On verifie l'extension du fichier
    //    if (in_array(strtolower($extension), $tabExt)) {
    //        // On recupere les dimensions du fichier
    //        $infosImg = getimagesize($_FILES[NOMUPLOAD]['tmp_name']);

    //        // On verifie le type de l'image
    //        if ($infosImg[2] >= 1 && $infosImg[2] <= 14) {
    //            // On verifie les dimensions et taille de l'image
    //            if (($infosImg[0] <= WIDTH_MAX) && ($infosImg[1] <= HEIGHT_MAX) && (filesize($_FILES[NOMUPLOAD]['tmp_name']) <= MAX_SIZE)) {
    //                // Parcours du tableau d'erreurs
    //                if (isset($_FILES[NOMUPLOAD]['error'])
    //                    && UPLOAD_ERR_OK === $_FILES[NOMUPLOAD]['error']) {
    //                    // On renomme le fichier
    //                    $nomFichier = "chat." . $extension;
    //                    if (file_exists(TARGET . $nomFichier) == false) {
    //                        if (move_uploaded_file($_FILES[NOMUPLOAD]['tmp_name'], TARGET . $nomFichier)) {
    //                            $message = 'Upload réussi !';
    //                            //unset($_FILES[NOMUPLOAD]);  //ce fichier on en a plus besoin.
    //                        } else {
    //                            // Sinon on affiche une erreur systeme
    //                            $message = 'Problème lors de l\'upload !';
    //                        }
    //                    } else {
    //                        $message = "Une photo du même nom se trouve déjà dans le dossier de destination... Le modèle est déjà existant.";
    //                    }
    //                    // Si c'est OK, on teste l'upload
    //                } else {
    //                    $message = 'Une erreur interne a empêché l\'uplaod de l\'image';
    //                }
    //            } else {
    //                // Sinon erreur sur les dimensions et taille de l'image
    //                $message = 'Erreur dans les dimensions de l\'image !';
    //            }
    //        } else {
    //            // Sinon erreur sur le type de l'image
    //            $message = 'Le fichier à uploader n\'est pas une image !';
    //        }
    //    } else {
    //        // Sinon on affiche une erreur pour l'extension
    //        $message = 'L\'extension du fichier est incorrecte !';
    //    }

    //}
    move_uploaded_file($_FILES[NOMUPLOAD]['tmp_name'], TARGET . $nomFichier);

    //Convert the txt file in json file.
    $data = getChatText($nomFichier); //get the raw content of the file txt
    $data = utf8_decode($data);  //test for chars errors

    //Start to substring and extract informations about every message.
    $lastposition = 0;
    //Compter le nombres de lignes dans $data:
    $nblignes = substr_count($data, "[");   //on compte le nombre de msgs (chaque ligne de msg commence par '[')
    for ($i = 1; $i <= $nblignes; $i++) {   //pour toutes les lignes
        if ($i != $nblignes) {
            $ligne = substr($data, $lastposition, stripos($data, "[", $lastposition + 1) - $lastposition); //extrait la chaine entre les deux '['
        } else {    //si c'est la dernière ligne
            $ligne = substr($data, $lastposition); //extrait la chaine entre le dernier '[' et jusqu'à la fin,.
        }
        $lastposition = stripos($data, "[", $lastposition + 1);   //lastposition prend la position suivante
        //Séparer les données de la ligne:
        $time = substr($ligne, 1, 17);   //pour avoir le contenu entre [ et ] --> "01.12.19 09:37:48"
        $posstartauthor = 19 + 1;  //position départ de author
        $posstartmsg = stripos($ligne, ":", 19) + 2;
        $author = substr($ligne, $posstartauthor, $posstartmsg - $posstartauthor - 2);   //auteur du msg
        $msg = substr($ligne, $posstartmsg, strlen($ligne) - 2 - $posstartmsg);    //pos début du msg jusqu'à fin de la ligne. //contenu du msg
        //Définir le type:
        $msg = utf8_decode($msg);   //decode for compare with phrases with accents.
        $type = "msg";  //by default it's a simple message
        if (stripos($msg, "Les messages que vous envoyez dans ce groupe sont protégés avec le chiffrement de bout en bout.") != false) {
            $type = "SystemJaune";
        }
        if (stripos($msg, " intégré le groupe via un lien d'invitation") != false) {
            $type = "SystemBleu";
        }
        if (stripos($msg, "+41 ** *** ** ** a ajouté +41 ** *** ** **") != false && strlen($msg) == 42) {
            $type = "SystemBleu";
        }
        $filename = "";
        if (stripos($msg, "< pièce jointe : ") == 0 && substr($msg, strlen($msg) - 1) == ">") {
            $type = "file";
            $posfilename = stripos($msg, ":") + 2;
            $filename = substr($msg, $posfilename, stripos($msg, " ", $posfilename) - $posfilename);

            $filename .= ":" . getFilesTypewithext($filename);
        }

        $time = utf8_encode($time);   //reencode before save value in the table.
        $author = utf8_encode($author);   //reencode before save value in the table.
        $msg = utf8_encode($msg);   //reencode before save value in the table.
        $type = utf8_encode($type);   //reencode before save value in the table.
        $filename = utf8_encode($filename);   //reencode before save value in the table.

        //On enregistre les valeurs dans le tableau
        $chatdata[$i - 1]['time'] = $time;
        $chatdata[$i - 1]['author'] = $author;
        $chatdata[$i - 1]['msg'] = $msg;
        $chatdata[$i - 1]['type'] = $type;
        $chatdata[$i - 1]['fileinfo'] = $filename;

    }
    $chatformatedinfos = $chatdata; //infos of the chat extracted
    if (empty($chatformatedinfos) == false) {
        savechata($chatformatedinfos);   //save the chatcontent associative table in json
        unlink("model/tempfiles/" . $nomFichier);    //delete the temp file.
    }

    addChatToList("fichier");   //rajouter le chat à la liste de chat pour savoir quels chats sont disponibles.
    $_SESSION['flashmessage'] .= "Chat importé et transformé.";
    viewchat(1);
}

function login($username, $password)
{
    if (isset($username, $password)) {   //si envoit les infos alors tente de connecter
        $TheUser = getOneUser($username);
        if ($TheUser != "") {
            //si le mot de passe haché correspond au mot de passe donné:
            if (password_verify($password, $TheUser['password'])) {   //si le mot de passe correspond à l'adresse email
                $_SESSION['user'] = $username; //save session in $_SESSION
                $_SESSION['name'] = $TheUser['firstname'] . " " . $TheUser['lastname']; //take the full name
            }
        }

        if (isset($_SESSION['user']) == false) { //si pas connecté
            $_SESSION['flashmessage'] = 1;  //message identifiants invalides
            login("", "");  //login sans info = retour à la page de login.
        } else {
            home(); //back to home
        }
    } else {
        home();
    }

}

function disconnect()
{
    unset($_SESSION['user']);
    unset($_SESSION['name']);
    home(); //back to home
}

function home()
{
    $title = "Home";
    require_once 'view/gabarit.php';
}

function getFilesTypewithext($filename) //get the file type with the extension of the file extract of the filename
{
    $filesext = [
        $audiofiles = ["mp3, flac", "opus", "ogg", "m4a", "aiff", "wav", "pcm"], //listes fichiers audios
        $picturefiles = ["jpg", "png", "gif", "svg", "tiff", "raw"],
        $videofiles = ["mp4", "mov", "avi", "mpg", "mpa"]
    ];

    $extension = substr(strripos($filename, ".") + 1, count_chars($filename));  //extension du fichier sans le point
    foreach ($filesext as $i => $typesfilepossible) {
        foreach ($typesfilepossible as $typeinrun) {
            if ($extension == $typeinrun) {
                switch ($i) {    //selon la collection d'extension c'est audio, images ou vidéos
                    case 0:
                        $typefile = "audio";
                        break;
                    case 1:
                        $typefile = "image";
                        break;
                    case 2:
                        $typefile = "video";
                        break;
                    default:
                        $typefile = "unknown";
                        break;
                }
            }
        }
    }

    return $typefile;
}

?>