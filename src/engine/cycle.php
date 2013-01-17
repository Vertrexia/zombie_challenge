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
    
    var $alive = false; //  is the player alive?
    
    function __construct($name, Coord $pos, Coord $dir)
    {
        global $game;
        
        $player = getPlayer($name);
        
        if ($player)
        {
            //  code that checks if that cycle already exists in list
            if (count($game->cycles) > 0)
            {
                foreach ($game->cycles as $cycle)
                {
                    if ($cycle)
                    {
                        if ($cycle->player->log_name == $player->log_name)
                        {
                            if (!$cycle->alive)
                            {
                                //  remove them from the grid
                                killPlayer($player->screen_name);
                                
                                return;
                            }
                        }
                    }
                }
            }
            
            $this->player = $player;
            
            $this->spawnPos = $this->pos = $pos;
            $this->spawnDir = $this->dir = $dir;
            
            $this->spawnTime = $game->timer->gameTimer();
            
            $this->alive = true;
            
            //  add new cycle to list
            $game->cycles[] = $this;
        }
    }
}

//  function called when a cycle is destroyed
function cycleDestroyed($name)
{
    global $game;
    
    if (count($game->cycles) > 0)
    {
        foreach ($game->cycles as $cycle)
        {
            if ($cycle)
            {
                if ($cycle->player->log_name == $name)
                {
                    if ($cycle->alive)
                    {
                        //  give the cycle its survival time
                        $cycle->survivalTime = $game->timer->gameTimer();
                        
                        $cycle->alive = false;
                        
                        //  announce
                        cm("zombie_challenge_survival_time", array($cycle->player->screen_name, $cycle->survivalTime));
                    }
                    break;
                }
            }
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