<?php

date_default_timezone_set('Europe/Paris');
session_start();
if (isset($_SESSION["loggued_on_user"]) === false || $_SESSION["loggued_on_user"] === "")
    echo "ERROR\n";
else
{
    if (file_exists("../private/chat") === true)
    {
        $chat = unserialize(file_get_contents("../private/chat"));
        foreach ($chat as $infos)
        {
            $time = date("H:i", $infos["time"]);
            echo "[" . $time . "]";
            echo " <b>" . $infos["login"] . "</b>: ";
            echo $infos["msg"];
            echo "<br \>\n";
        }
    }
}
