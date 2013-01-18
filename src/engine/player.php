<?php
if (!defined("__ROOT__"))
    return;

class Player
{
    var $log_name;
    var $screen_name;

    function Player($name, $screen_name)
    {
    	global $game;

    	$this->log_name 	= $name;
    	$this->screen_name 	= $screen_name;
    	
        //  adding new player to list
    	$game->players[] = $this;
    }
}

//	function checks whether player already exists in the server
function playerExists($name)
{
    global $game;

    if (count($game->players) > 0)
    {
        foreach ($game->players as $p)
        {
            if ($p && ($p->log_name == $name))
                return true;
        }
    }
    return false;
}

//	gets the data of the existing player in the server
function getPlayer($name)
{
    global $game;

    if (count($game->players) > 0)
    {
        foreach ($game->players as $p)
        {
            if ($p && ($p->log_name == $name))
                return $p;
        }
    }
    return false;
}

//	function that handles player entering the server
function playerEntered($line)
{
    global $game;

    $pieces = explode($line);

    $log_name 		= $pieces[1];
    $screen_name	= substr($line, strlen($pieces[0]) + strlen($pieces[1]) + strlen($pieces[2]) + 3);

    $player = new Player($log_name, $screen_name);
}

//	function that handles player being renaming
function playerRenamed($line)
{
    global $game;

    $pieces = explode($line);

    $old_name = $pieces[1];
    $new_name = $pieces[2];
    $screen_name = substr($line, strlen($pieces[0]) + strlen($pieces[1]) + strlen($pieces[2]) + strlen($pieces[3]) + 3);

    if (playerExists($old_name))
    {
        $player = getPlayer($old_name);
        if ($player)
        {
            $player->log_name 		= $new_name;
            $player->screen_name 	= $screen_name;
        }
    }
}

//	function that handles player leaving the server
function playerLeft($line)
{
    global $game;

    $pieces = explode($line);

    if (playerExists($old_name))
    {
        for($i = 0; $i < count($game->players); $i++)
        {
            $player = $game->players[$i];
            if ($player && ($player->log_name == $pieces[1]))
            {
                unset($game->players[$i]);
                break;
            }
        }
    }
}
?>