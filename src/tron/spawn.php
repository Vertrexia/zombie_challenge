<?php
if (!defined("__ROOT__"))
    return;

class Spawn
{
    var $pos;
    
    function __construct()
    {
        global $game;

        $game->map->spawns[] = $this;
    }
}
?>