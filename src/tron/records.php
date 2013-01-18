<?php
if (!defined("__ROOT__"))
    return;

class Record
{
    var $name;		//	owner of the record
    var $time;		//	their survival time
    var $points;	//	number of points gained for destroying zones
    
    function Record($name, $time, $points)
    {
        global $game;
        
        $this->name 	= $name;
        $this->time 	= $time;
        $this->points 	= $points;
        
        $game->records[] = $this;
    }
    
    static function compare(Record $a, Record $b)
    {
        return ($a->time < $b->time);
    }
}

function recordExists($name)
{
    global $game;

    if (count($game->records) > 0)
    {
        foreach ($game->records as $record)
        {
            if ($record && ($record->name == $name))
                return true;
        }
    }
    return false;
}

function getRecord($name)
{
    global $game;

    if (count($game->records) > 0)
    {
        foreach ($game->records as $record)
        {
            if ($record && ($record->name == $name))
                return $record;
        }
    }
    return false;
}

//  function that performs the actions to recording player's stats
function adjustRecords()
{
    global $game;
    
    //  sort out the cycles survival time (highest to lowest)
    usort($game->cycles, array("Cycle", "compare"));
    
    foreach ($game->cycles as $cycle)
    {
        if ($cycle)
        {
            if (recordExists($cycle->player->log_name))
            {
                $record = getRecord($cycle->player->log_name);
                if ($record)
                {
                    if ($record->time < $cycle->survivalTime)
                    {
                        //  tell the player that they have improved their timing
                        cpm($cycle->player->screen_name, "zombie_challenge_improved_time", array($cycle->survivalTime, ($cycle->survivalTime - $record->time)));

                        $record->time = $cycle->survivalTime;
                    }
                    else
                    {
                        //  tell the player the number of seconds before crossing the old time
                        cpm($cycle->player->screen_name, "zombie_challenge_reaching_time", array($cycle->survivalTime, ($record->time - $cycle->survivalTime)));
                    }
                    
                    if ($record->points < $cycle->$currentPoint)
                    {
                        $record->points = $cycle->$currentPoint;
                    }
                }
            }
            else
            {
                $record = new Record($cycle->player->log_name, $cycle->survivalTime, $cycle->$currentPoint);
                
                //  tell the player they have just got themselves a rank
                cpm($cycle->player->screen_name, "zombie_challenge_new_record", array($cycle->survivalTime));
            }
        }
    }

    //  finally, sort out the records (highest to lowest)
    usort($game->records, array("Record", "compare"));
}

//  show ranks to players at beginning and ending of round
function showLadder()
{
    global $game;
    
    if ($game->roundFinished)
    {
        if (count($game->records) > 0)
        {
            for($i = 0; $i < count($game->records); $i++)
            {
                $prev = $next = null;
                $current = $game->records[$i];
                $player = getPlayer($current->name);
                
                //  check if a record exists before the current one
                if (($i - 1) >= 0)
                {
                    $prev = $game->records[$i - 1];
                    if ($prev && $player)
                    {
                        cpm($player->screen_name, "zombie_challenge_prev_rank");
                    }
                }
                
                if ($current && $player)
                {
                    cpm($player->screen_name, "zombie_challenge_current_rank");
                }
                
                //  check if a record exists after the current one
                if (($i + 1) < count($game->records))
                {
                    $next = $game->records[$i - 1];
                    if ($next && $player)
                    {
                        cpm($player->screen_name, "zombie_challenge_next_rank");
                    }
                }
            }
        }
    }
    else
    {
        
    }
}

function loadRecords()
{
    global $game;

    if (count($game->records) > 0)
    {
        unset($game->records);
        $game->records = array();
    }
    
    $fpath = __ROOT__.$game->recordsFile;
    if (file_exists($fpath))
    {
        $fcontents = file_get_contents($fpath);
        $fcontents = explode("\n", $fcontents);

        foreach ($fcontents as $fdata)
        {
            $rData = explode(" ", $fdata);
            $record = new Record($rData[0], $rData[1], $rData[2]);
        }
    }
}

function saveRecords()
{
    global $game;

    if (count($game->records) > 0)
    {
    	$fpath = __ROOT__.$game->recordsFile;
    	$file = fopen($fpath, "w+");
        if ($file)
        {
            foreach ($game->records as $record)
            {
                if ($record)
                {
                    fwrite($file, $record->name." ".$record->time." ".$record->points."\n");
                }
            }
        }
    	fclose($file);
    }
}
?>