<?php
if (!defined("__ROOT__"))
    return;

class Record
{
    var $name;		//	owner of the record
    var $time;		//	their survival time
    var $points;	//	number of points gained for destroying zones
    
    function __construct($name, $time, $points)
    {
        global $game;
        
        $this->name 	= $name;
        $this->time 	= $time;
        $this->points 	= $points;
        
        $game->records[] = $this;
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