<?php
define("__ROOT__", dirname(__FILE__));

if (!defined("__ROOT__"))
    return;

require "base.php";

//  load default settings and class data
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
    elseif (startswith($line, "CYCLE_CREATED"))
    {
        $pieces = explode(" ", $line);
    
        $cycle = new Cycle($pieces[1], Coord($pieces[2], $pieces[3]), Coord($pieces[4], $pieces[5]));
    }	
    
    //	sync server and client events
    gameSync();
}
?>