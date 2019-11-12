<?php

session_start();

if (isset($_SESSION["loggued_on_user"]) && $_SESSION["loggued_on_user"] !== "")
{
    if (isset($_POST["msg"]))
    {
        if (file_exists("../private/chat") === false)
        {
            $log[] = array("login" => $_SESSION["loggued_on_user"], "time" => time(), "msg" => $_POST["msg"]);
            file_put_contents("../private/chat", serialize($log));
        }
        else
        {
            $fd = fopen('../private/chat', "a+");
            if ($fd)
            {
                $log = array();
				$log = unserialize(file_get_contents("../private/chat"));
				$ret = flock($fd, LOCK_SH | LOCK_EX);
				if ($ret === false)
					return;
                $tmp[] = array("login" => $_SESSION["loggued_on_user"], "time" => time(), "msg" => $_POST["msg"]);
                array_push($log, $tmp[0]);
                $log = serialize($log);
				file_put_contents("../private/chat", $log, LOCK_EX);
				flock($fd, LOCK_UN);
                fclose($fd);
            }
        }
    }
}
else
{
    echo ("ERROR\n");
    return;
}
    ?>
     <html>
        <head>
        <script langage="javascript">top.frames['chat'].location = 'chat.php';</script>
        </head>
        <body>
            <form action="speak.php" method="POST">
                <input type="text" name="msg" value=""/><input type="submit" name="submit" value="OK"/>
                <script langage="javascript">top.frames['chat'].location = 'chat.php';<\script>
            </form>
				</body>
	</html>
