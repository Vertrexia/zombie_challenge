<?php
if (!defined("__ROOT__"))
    return;

function center($message)
{
    echo "CENTER_MESSAGE ".$message."\n";
}

function con($message)
{
    echo "CONSOLE_MESSAGE ".$message."\n";
}	

function pm($player, $message)
{
    echo "PLAYER_MESSAGE ".$message."\n";
}

//  custom player message - sends a custom message to that selected player (if they exist)
//  $langauge_command is the langauge string command in language files to load
function cpm($player, $langauge_command, $params = array())
{
    if (count($params) == 0)
        echo "CUSTOM_PLAYER_MESSAGE ".$player." ".$langauge_command."\n";
    else
    {
        $extras = "";
        foreach($params as $param)
        {
            $extras .= $param." ";
        }
        echo "CUSTOM_PLAYER_MESSAGE ".$player." ".$langauge_command." ".$extras."\n";
    }
}

//  custom message - sends a custom message to all clients, public message to simplify
//  $langauge_command is the langauge string command in language files to load
function cm($langauge_command, $params = array())
{
    if (count($params) == 0)
        echo "CUSTOM_MESSAGE ".$player." ".$langauge_command."\n";
    else
    {
        $extras = "";
        foreach($params as $param)
        {
            $extras .= $param." ";
        }
        echo "CUSTOM_MESSAGE ".$player." ".$langauge_command." ".$extras."\n";
    }
}

function roundBegan()
{
	global $game;
	
	$game->timer->reset();
	$game->timer->start();
	
	$game->roundFinished = false;
	
    //  set new spawn time for zones
	$game->newSpawnTime = $game->timer->gameTimer() + $game->spawn_delay;
	
	loadRecords();	//	load records
}

function roundEnded()
{
    global $game;

    $game->timer->stop();
    $game->roundFinished = true;

    clearCycles();
    clearZones();
    $game->map->clearSpawns();

    saveRecords();	//	save records
}

function declareRoundWinner($name)
{
    echo "DECLARE_ROUND_WINNER ".$name."\n";
}

//	function that syncs with the server
function gameSync()
{
    global $game;
	
    //	do not sync if round has already finished
    if ($game->roundFinished)
        return;
	
    if ($game->timer->gameTimer() >= $game->newSpawnTime)
    {
        
        
        //	set the next spawn time
        $game->newSpawnTime += $game->spawn_delay;
    }
}
?>