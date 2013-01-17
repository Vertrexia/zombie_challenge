<?php
define("__ROOT__", dirname(__FILE__));

if (!defined("__ROOT__"))
    return;

require "base.php";

//  load default settings and class data
$game = new Base;
$tick = -1;

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
    elseif (startswith($line, "CURRENT_MAP"))
    {
        $pieces = explode(" ", $line);
        
        //  load map data and store it
        $game->map->load($pieces[1]);
    }
    elseif (startswith($line, "CYCLE_CREATED"))
    {
        $pieces = explode(" ", $line);

        $cycle = new Cycle($pieces[1], Coord($pieces[2], $pieces[3]), Coord($pieces[4], $pieces[5]));
    }
    elseif (startswith($line, "CYCLE_DESTROYED"))
    {
        $pieces = explode(" ", $line);
    }
    elseif (startswith($line, "ZONE_SHOT_RELEASED"))
    {
        $pieces = explode(" ", $line);

        $zone = new Zone($pieces[2], $pieces[3], $pieces[1], $pieces[4]);
    }
    elseif (startswith($line, "OBJECTZONE_SPAWNED"))
    {
        $pieces = explode(" ", $line);

        $zone = new Zone($pieces[1], $pieces[2], 2);
    }
    elseif ((startswith($line, "ZONE_CREATED")) || startswith($line, "ZONE_SPAWNED"))
    {
        $pieces = explode(" ", $line);
        
        //  get rid of these zones, they are not allowed!
        destroyZoneId($pieces[1]);
    }

    //	sync server and client events
    gameSync();
}
?>