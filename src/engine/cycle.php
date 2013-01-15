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

	function __construct($player, $pos, $dir)
	{
		global $game;
		
		$this->player = $player;
		
		$this->spawnPos = $this->pos = $pos;
		$this->spawnDir = $this->dir = $dir;
		
		$this->spawnTime = $game->timer->gameTimer();
		
		$game->cycles[] = $this;
	}
}
?>