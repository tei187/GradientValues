<?php

/**
 * Class designed to find percentage of a value based on start and end points (with these points being lower and upper limits).
 * @author Piotr Bonk <bonk.piotr@gmail.com>
 * @license MIT
 */
Class RangeBasedPercentage {
    /** @var Int Start point / lower limit. */
    private $start = 0;
    /** @var Int End point / upper limit. */
    private $end   = 100;
    /** @var Int Difference between start and end points. */
    private $span  = 100;

    /**
     * Class constructor.
     *
     * @param Int|Float $start Start point / lower limit.
     * @param Int|Float $end  End point / upper limit.
     */
    function __construct($start = 0, $end = 100) {
        $this->setRange($start, $end);
    }

    /**
     * Set min and max range.
     *
     * @param Int|Float $x Range start.
     * @param Int|Float $y Range end.
     * @return void
     */
    public function setRange($x, $y) {
        $this->checkValues($x, $y);
        $this->calculateSpan();
        return $this;
    }

    /**
     * Calculates and assigns span/difference betweeen start and end points (used for proportionate calc further on).
     *
     * @return void
     */
    private function calculateSpan() {
        $this->span = $this->end - $this->start;
        return;
    }

    /**
     * Returns percentage, based on input value and start/end points.
     *
     * @param Int|Float $x Value between start/end points to ascertain.
     * @return Int|Float Percentage
     */
    public function getPercentage($x) {
        if ($x >= $this->end) {
            $x = $this->end;
        } elseif ($x <= $this->start) {
            $x = $this->start;
        }

        //$v = $x - $this->span;
        $v = $x - $this->start;
        $o = ($v * 100) / $this->span;

    // debug start
    
        echo "<pre>";
        print_r([
            "start" => $this->start, 
            "end" => $this->end, 
            "span" => $this->span,
            "get" => $x, 
            "relative" => $v, 
            "output" => $o
        ]);
        echo "</pre>";
    
    // debug end

        return $o;
    }

    /**
     * Verifies if set values are correct. Forces left-lower value assignment.
     *
     * @param Int|Float $x Range start.
     * @param Int|Float $y Range end.
     * @return Bool
     */
    private function checkValues($x, $y) {
        $this->start = is_numeric($x) ? $x : 0;
        $this->end = is_numeric($y) ? $y : 100;

        // check if start > end
        $check = $this->start > $this->end ? [ $this->end, $this->start ] : null;
        if(is_array($check)) {
            $this->start = $check[0];
            $this->end = $check[1];
        }

        if(!is_numeric($x) && !is_numeric($y)) {
            return false;
        }
        return true;
    }
}
?>