<?php
if (!defined("__ROOT__"))
    return;

class Wall
{
    var $positions = array();   //  holds the list of points
    
    function __construct()
    {
        global $game;
        
        $game->map->walls[] = $this;
    }
    
    function pushCoord($pos)
    {
        $this->positions[] = $pos;
    }
}
?>