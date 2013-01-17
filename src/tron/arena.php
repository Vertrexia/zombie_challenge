<?php
if (!defined("__ROOT__"))
    return;

class Arena
{
    var $maxCoord;
    var $minCoord;
    
    /*  get the random position. Follows the $factor details:
     *  0  - get the position that is in the middle of the map
     *  1  - get random positions inside the map
     *  >1 - values greater than 1, get positions that sometimes end up outside the map's boundary (not good)
     */
    function getRandomPos($factor = 1)
    {
        global $game;
        
        if (count($game->map->walls) > 0)
        {
            $x = rand() / $game->rand_max;
            $y = rand() / $game->rand_max;
            $loadCoord = new Coord($x * $factor + 0.5 * (1 - $factor), $y * $factor + 0.5 * (1 - $factor));
            
            if (($this->maxCoord instanceof Coord) && ($this->minCoord instanceof Coord))
            {
                $diff = $this->maxCoord->minus($this->minCoord);
                if ($diff instanceof Coord)
                {
                    $addCoord = new Coord($diff->x * $loadCoord->x, $diff->y * $loadCoord->y);
                    $newCoord = null;
                    
                    if ($addCoord instanceof Coord)
                        $newCoord = $this->minCoord->plus($addCoord);
                    
                    if ($newCoord instanceof Coord)
                        return $newCoord;
                }
            }
        }
        return false;
    }
}
?>