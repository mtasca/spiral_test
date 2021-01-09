<?php


namespace mtasca\Qudio\Application\Service;


class SpiralService
{
    const LEFT_RIGHT = 1;
    const UP_BOTTOM = 2;
    const RIGHT_LEFT = 3;
    const BOTTOM_UP = 4;

    // TODO: these two attributes should be part of one class called Spiral
    private $spiral_size;
    private $spiral;

    public function __construct($size)
    {
        $this->spiral_size = $size;
        $this->spiral = [];
    }

    public function createSquareSpiral(bool $verbose = false) : array
    {
        $this->spiral = [];
        // set blank matrix
        for($i = 0; $i < $this->spiral_size; $i++) {
            for($j = 0; $j < $this->spiral_size; $j++) {
                $this->spiral[$i][$j] = ' ';
            }
        }

        // start from left to right
        $direction = self::LEFT_RIGHT;
        $i = 0;
        $j = 0;
        $max_steps = $this->spiral_size;
        $steps_count = 0;
        do {
            $this->spiral[$i][$j] = '*';

            $next_node = $this->getNextNode($i, $j, $direction);
            $next_i = $next_node['next_i'];
            $next_j = $next_node['next_j'];

            ++$steps_count;

            if($steps_count >= $max_steps) {
                --$max_steps;
                $steps_count = 1;
                $direction = $this->getNextDirection($direction);
                $next_node = $this->getNextNode($i, $j, $direction);
                $next_i = $next_node['next_i'];
                $next_j = $next_node['next_j'];
            }

            $i = $next_i;
            $j = $next_j;

            if($verbose) {
                system("clear");
                printf(
                    "\nCurrent i:%d j:%d Next i:%d j:%d Steps:%d Max Steps: %d Direction:%d\n",
                    $i, $j, $next_i, $next_j, $steps_count, $max_steps, $direction
                );
                $this->printSpiral();
            }
        } while($max_steps > 1);

        return $this->spiral;
    }

    private function getNextDirection($current_direction)
    {
        if($current_direction == self::BOTTOM_UP) {
            $current_direction = self::LEFT_RIGHT;
        }else{
            ++$current_direction;
        }
        return $current_direction;
    }

    private function getNextNode(int $i, int $j, int $direction)
    {
        $next_i = $i;
        $next_j = $j;
        switch ($direction) {
            case self::LEFT_RIGHT:
                ++$next_j;
                break;
            case self::UP_BOTTOM:
                ++$next_i;
                break;
            case self::RIGHT_LEFT:
                --$next_j;
                break;
            case self::BOTTOM_UP:
                --$next_i;
                break;
        }

        // TODO: this should a class SpiralNode
        return [
            'next_i' => $next_i,
            'next_j' => $next_j,
        ];
    }

    public function printSpiral()
    {
        $print = '';
        for($i = 0; $i < $this->spiral_size; $i++) {
            $print .= "|" . implode($this->spiral[$i], "|") . "|\n";
        }
        echo $print;
    }
}