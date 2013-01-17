<?php
if (!defined("__ROOT__"))
    return;

class Map
{
    var $spawns = array();      //  holds the list of spawns for the currently loaded map
    var $walls  = array();      //  holds the list of walls and their points (x1, y1, x2, y2, ...)
    
    //  loads data from the selected map file
    function load($map_file)
    {
        global $game;
        
        //  before loading map data, old data must be removed
        $this->clearSpawns();
        $this->clearWalls();
        
        $map_path = addslashes($game->resourceDir."/".$map_file);
        
        //  set this variable up to store x and y values and then find the min and max
        $xList = $yList = array();  
        
        //  ensure that map file exists
        if (file_exists($map_path))
        {
            $map = new DOMDocument;
            $map->load($map_path);
            
            //  let's read the data for the walls
            $walls = $map->getElementsByTagName('Wall');
            if (!is_null($walls))
            {
                //  let's load individual wall data
                foreach ($walls as $wall)
                {
                    $newWall = new Wall;
                    
                    //  let's get hold of the points
                    $points = $wall->getElementsByTagName('Point');
                    if (!is_null($points))
                    {
                        //  load each point
                        foreach($points as $point)
                        {
                            $x = $y = 0;

                            $x = $point->getAttribute("x");
                            $y = $point->getAttribute("y");
                            
                            $newCoord = new Coord($x, $y);
                            
                            //  store points in array of wall
                            $newWall->pushCoord($newCoord);
                            
                            $xList[] = $x;
                            $yList[] = $y;
                        }
                    }
                }
            }

            if ((count($xList) > 0) && (count($yList) > 0))
            {
                $game->arena->maxCoord = new Coord(max($xList), max($yList));   //  set the max coodinates
                $game->arena->minCoord = new Coord(min($xList), min($yList));   //  set the min coodinates
            }

            //  let's read the data on the spawns
            $spawns = $map->getElementsByTagName('Spawn');
            if (!is_null($spawns))
            {
                foreach($spawns as $spawn)
                {
                    $newSpawn = new Spawn;

                    $x = $y = 0;

                    $x = $spawn->getAttribute("x");
                    $y = $spawn->getAttribute("y");
                    
                    //  store spawn position
                    $newSpawn->pos = new Coord($x, $y);
                }
            }
        }
    }

    //  all spawn data get erased
    function clearSpawns()
    {
        global $game;
        
        if (count($this->spawns) > 0)
        {
            unset($this->spawns);
            $this->spawns = array();
        }
    }
    
    //  every wall data get erased
    function clearWalls()
    {
        global $game;
        
        if (count($this->walls) > 0)
        {
            unset($this->walls);
            $this->walls = array();
        }
    }    
}
?>