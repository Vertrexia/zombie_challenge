<?php
if (!defined("__ROOT__"))
    return;

require __ROOT__."/src/engine/cycle.php";
require __ROOT__."/src/engine/player.php";
require __ROOT__."/src/engine/timer.php";

require __ROOT__."/src/game/game.php";
require __ROOT__."/src/game/records.php";
require __ROOT__."/src/game/spawn.php";
require __ROOT__."/src/game/zone.php";

require __ROOT__."/src/tools/coord.php";
require __ROOT__."/src/tools/map.php";
require __ROOT__."/src/tools/string.php";

class Base
{
    var $spawn_delay 	= 8;		//	time between each zone spawn
    var $newSpawnTime 	= -1;		//	the estimated time the new zone will be spawned in
    
    var $timer;						//	holds the timer's class
    var $map;                       //  holds the map's class
    
    var $records 	= array();		//	holds the list of records
    var $cycles 	= array();		//	holds the list of cycles currently playing on the grid
    var $players	= array();		//	holds the lsit of players currently playing in the server
    var $zones      = array();      //  holds the list of zones spawned on the grid
    
    var $roundFinished = true;		//	flag for checking if round has finished or not
    
    var $resourceDir = "";						//	folder where the maps are stored
    var $recordsFile = "/data/records.txt";		//	the file that stores player's records
    
    function __construct()
    {
        $this->timer    = new Timer;
        $this->map      = new Map;
    }
}
?>