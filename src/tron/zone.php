<?php
if (!defined("__ROOT__"))
    return;

class Zone
{
    var $id;            //  zone's id
    var $name;          //  zone's name
    
    var $owner;         //  the owner of the zone (applies for shots, zombies, etc...)
    
    var $type = 0;      //  the type of a zone it is. Details are below:
                        //  0 - Default     (indates that this type of zone kills players)
                        //  1 - Shot        (shooting after holdind and releasing brakes)
                        //  2 - Death Shot  (shooting after dying)

    function __construct($id, $name, $type, $owner = null)
    {
        global $game;

        $this->id       = $id;
        $this->name     = $name;
        $this->type     = $type;
        $this->owner    = $owner;
        
        //  add new zone to list
        $game->zones[] = $this;
    }
}

//  all spawn data get erased
function clearZones()
{
    global $game;
    
    if (count($game->zones) > 0)
    {
        unset($game->zones);
        $game->zones = array();
    }
}

//	function sends command to server, which will cause zones (under that name) to collapse smoothly
function collapseZone($name)
{
    echo "COLLAPSE_ZONE ".$name."\n";
}

//  function sends command to server, which will cause zones (under that name) vanish instantly
function destroyZone($name)
{
    echo "DESTROY_ZONE ".$name."\n";
}

//  function sends command to server, which will cause zones (under that id) to collapse smoothly
function collapseZoneId($id)
{
    echo "COLLAPSE_ZONE_ID ".$id."\n";
}

//  function sends command to server, which will cause zones (under that id) vanish instantly
function destroyZoneId($id)
{
    echo "DESTROY_ZONE_ID ".$id."\n";
}
?>