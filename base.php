<?php
if (!defined("__ROOT__"))
    return;

require __ROOT__."/src/engine/cycle.php";
require __ROOT__."/src/engine/player.php";
require __ROOT__."/src/engine/timer.php";

require __ROOT__."/src/tron/arena.php";
require __ROOT__."/src/tron/game.php";
require __ROOT__."/src/tron/records.php";
require __ROOT__."/src/tron/spawn.php";
require __ROOT__."/src/tron/wall.php";
require __ROOT__."/src/tron/zone.php";

require __ROOT__."/src/tools/coord.php";
require __ROOT__."/src/tools/map.php";
require __ROOT__."/src/tools/string.php";

class Base
{
    var $spawn_delay 	= 8;		//	time between each zone spawn
    var $newSpawnTime 	= -1;		//	the estimated time the new zone will be spawned in
    
    var $rand_max = "0x7FFF";

    var $timer;						//	holds the timer class
    var $map;                       //  holds the map class
    var $arena;                     //  holds the arena class

    var $records 	= array();		//	holds the list of records
    var $cycles 	= array();		//	holds the list of cycles currently playing on the grid
    var $players	= array();		//	holds the lsit of players currently playing in the server
    var $zones      = array();      //  holds the list of zones spawned on the grid

    var $roundFinished = true;		//	flag for checking if round has finished or not

    //  folder where the maps are stored
    var $resourceDir = 'C:\Users\Vertrex\Documents\Armagetronad\dist\resource\included';

    //  the file that stores player's records
    var $recordsFile = "/data/records.txt";

    function __construct()
    {
        $this->timer    = new Timer;
        $this->map      = new Map;
        $this->arena    = new Arena;
    }
}
?>