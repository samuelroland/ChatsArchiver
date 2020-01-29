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

function viewlistchat($username)
{
    $chatinjson = getlistchat($username);
    ob_start();
    foreach ($chatinjson as $onechat) {
        ?>
        <div class="X7YrQ"
             style="z-index: 8; transition: none 0s ease 0s; height: 72px; transform: translateY(0px);">
            <div tabindex="-1">
                <div class="_2UaNq _3mMX1">
                    <div class="_3vpWv"><!-- image of the chat -->
                        <div class="_3RWII" style="height: 49px; width: 49px;"><img
                                    src="<?= $image ?>"
                                    draggable="false" class="jZhyM _13Xdg _F7Vk"
                                    style="visibility: visible;">
                            <div class="B9BIa"><span data-icon="default-group" class=""><svg
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 212 212" width="212"
                                            height="212"><path fill="#DFE5E7"
                                                               d="M105.946.25C164.318.25 211.64 47.596 211.64 106s-47.322 105.75-105.695 105.75C47.571 211.75.25 164.404.25 106S47.571.25 105.946.25z"></path><path
                                                fill="#FFF"
                                                d="M61.543 100.988c8.073 0 14.246-6.174 14.246-14.246s-6.173-14.246-14.246-14.246-14.246 6.173-14.246 14.246 6.174 14.246 14.246 14.246zm8.159 17.541a48.192 48.192 0 0 1 8.545-6.062c-4.174-2.217-9.641-3.859-16.704-3.859-21.844 0-28.492 15.67-28.492 15.67v8.073h26.181l.105-.248c.303-.713 3.164-7.151 10.365-13.574zm80.755-9.921c-6.854 0-12.21 1.543-16.336 3.661a48.223 48.223 0 0 1 8.903 6.26c7.201 6.422 10.061 12.861 10.364 13.574l.105.248h25.456v-8.073c-.001 0-6.649-15.67-28.492-15.67zm0-7.62c8.073 0 14.246-6.174 14.246-14.246s-6.173-14.246-14.246-14.246-14.246 6.173-14.246 14.246 6.173 14.246 14.246 14.246zm-44.093 3.21a23.21 23.21 0 0 0 4.464-.428c.717-.14 1.419-.315 2.106-.521 1.03-.309 2.023-.69 2.976-1.138a21.099 21.099 0 0 0 3.574-2.133 20.872 20.872 0 0 0 5.515-6.091 21.283 21.283 0 0 0 2.121-4.823 22.16 22.16 0 0 0 .706-3.193c.16-1.097.242-2.224.242-3.377s-.083-2.281-.242-3.377a22.778 22.778 0 0 0-.706-3.193 21.283 21.283 0 0 0-3.272-6.55 20.848 20.848 0 0 0-4.364-4.364 21.099 21.099 0 0 0-3.574-2.133 21.488 21.488 0 0 0-2.976-1.138 22.33 22.33 0 0 0-2.106-.521 23.202 23.202 0 0 0-4.464-.428c-12.299 0-21.705 9.405-21.705 21.704 0 12.299 9.406 21.704 21.705 21.704zM145.629 131a36.739 36.739 0 0 0-1.2-1.718 39.804 39.804 0 0 0-3.367-3.967 41.481 41.481 0 0 0-3.442-3.179 42.078 42.078 0 0 0-5.931-4.083 43.725 43.725 0 0 0-3.476-1.776c-.036-.016-.069-.034-.104-.05-5.692-2.581-12.849-4.376-21.746-4.376-8.898 0-16.055 1.795-21.746 4.376-.196.089-.379.185-.572.276a43.316 43.316 0 0 0-3.62 1.917 42.32 42.32 0 0 0-5.318 3.716 41.501 41.501 0 0 0-3.443 3.179 40.632 40.632 0 0 0-3.366 3.967c-.452.61-.851 1.186-1.2 1.718-.324.493-.6.943-.841 1.351l-.061.101a27.96 27.96 0 0 0-.622 1.119c-.325.621-.475.975-.475.975v11.692h82.53v-11.692s-.36-.842-1.158-2.195a35.417 35.417 0 0 0-.842-1.351z"></path></svg></span>
                            </div>
                        </div>
                    </div>
                    <div class="_2WP9Q">
                        <div class="KgevS"><!-- name of the chat -->
                            <div class="_3H4MS"><span dir="auto" title="<?= $person ?><?= $onechat ?>mister xx"
                                                      class="_19RFN _1ovWX _F7Vk"><img
                                            crossorigin="anonymous"
                                            src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
                                            alt="🏐" draggable="false" style="background-position: 0px -40px;"
                                            class="b30 emoji apple _F7Vk"><?= $person ?><img
                                            crossorigin="anonymous"
                                            src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
                                            alt="🏐" draggable="false" style="background-position: 0px -40px;"
                                            class="b30 emoji apple _F7Vk"></span></div>
                            <div class="_0LqQ">18:41</div>
                        </div>
                        <div class="xD91K"><!-- last message info of the chat -->
                            <div class="_2Bw3Q"><span class="_1Wn_k"
                                                      title="‪Heureux d ...‬"><span
                                            dir="auto"
                                            class="_1ovWX _F7Vk">+41 00 00 00 00</span><span>:&nbsp;</span><span
                                            dir="ltr" class="_19RFN _1ovWX _F7Vk">Heureux d ...</span></span>
                            </div>
                            <div class="_0LqQ"><span><div class="_1ZMSM"><span data-icon="muted"
                                                                               class=""><svg
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 18" width="16"
                                                    height="18"><path fill="#263238" fill-opacity=".29"
                                                                      d="M11.52 9.206c0-1.4-.778-2.567-1.944-3.111v1.711L11.52 9.75v-.544zm1.945 0c0 .7-.156 1.4-.389 2.022l1.167 1.167c.544-.933.778-2.1.778-3.267 0-3.344-2.333-6.144-5.444-6.844v1.633c2.255.778 3.888 2.8 3.888 5.289zm-11.433-7L1.02 3.217l3.656 3.656H1.02v4.667h3.111l3.889 3.889v-5.211l3.344 3.344c-.544.389-1.089.7-1.789.933v1.633a6.64 6.64 0 0 0 2.878-1.4l1.556 1.556 1.011-1.011-7-7-5.988-6.067zm5.988.778L6.387 4.617 8.02 6.25V2.984z"></path></svg></span></div></span><span></span><span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    $listofchats = ob_get_clean();
    return $listofchats;
}

?>

