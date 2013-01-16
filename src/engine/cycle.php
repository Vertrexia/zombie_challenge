<?php
if (!defined("__ROOT__"))
    return;

class Cycle
{
    var $player;	//	the player that contols this cycle
    
    var $spawnTime;	//	the time the cycle was spawned on the grid
    
    var $spawnPos;	//	initial spawn location
    var $spawnDir;	//	initial spawn direction
    
    var $pos;		//	current position of the cycle
    var $dir;		//	current tavelling direction of the cycle
    
    var $survivalTime;	//	how long has the cycle stayed alive for?
    var $currentPoint;	//	number of points acquired during the round
    
    function __construct($name, $pos, $dir)
    {
        global $game;
        
        $player = getPlayer($name);
        
        if ($player)
        {
            $this->player = $player;
            
            $this->spawnPos = $this->pos = $pos;
            $this->spawnDir = $this->dir = $dir;
            
            $this->spawnTime = $game->timer->gameTimer();
            
            //  add new cycle to list
            $game->cycles[] = $this;
        }
    }
}

//  all cycles on grid get destroyed
function clearCycles()
{
    global $game;
    
    echo "KILL_ALL\n";
    
    //  clear away all cycles
    if (count($game->cycles) > 0)
    {
        unset($game->cycles);
        $game->cycles = array();
    }
}

function respawnPlayer($name, $x, $y, $xdir, $ydir)
{
    echo "RESPAWN_PLAYER ".$name." ".$x." ".$y." ".$xdir." ".$ydir."\n";
}

function killPlayer($name)
{
    echo "KILL ".$name."\n";
}
?>