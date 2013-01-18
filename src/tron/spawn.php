<?php
if (!defined("__ROOT__"))
    return;

class Spawn
{
    var $pos;
    
    function Spawn()
    {
        global $game;

        $game->map->spawns[] = $this;
    }
}
?>