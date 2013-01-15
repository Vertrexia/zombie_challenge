<?php
define("__ROOT__", dirname(__FILE__));

if (!defined("__ROOT__"))
    return;

$game = new Base;

while(1)
{
	$line = rtrim(fgets(STDIN, 1024));
	if (startswith($line, "ROUND_STARTED"))
	{
		roundBegan();
	}
	elseif (startswith($line, "ROUND_ENDED"))
	{
		roundEnded();
	}
	elseif (startswith($line, "PLAYER_ENTNERED_"))
	{
		playerEntered($line);
	}
	elseif (startswith($line, "PLAYER_RENAMED"))
	{
		playerRenamed($line);
	}
	elseif (startswith($line, "PLAYER_LEFT"))
	{
		playerLeft($line);
	}
	
	//	sync server and client events
	gameSync();
}
?>