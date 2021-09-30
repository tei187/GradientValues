<?php
    /**
     * Class used to generate gradient for intensification display purposes (ticks per hour, hits by day, etc).
     * @author Piotr Bonk <bonk.piotr@gmail.com>
     * @license MIT
     */
    Class GradientValues {
        /**
         * Holds input values for processing.
         *
         * @var array
         */
        private $values = [];
        /**
         * Holds processed values.
         *
         * @var array
         */
        public $valuesRGB = [];
        /**
         * Holds full gradient data.
         *
         * @var array
         */
        public $range = [];
        /**
         * Some counter.
         *
         * @var integer
         */
        private $stopsCount = 0;
        /**
         * Some other counter.
         *
         * @var integer
         */
        private $divider = 0;

        /**
         * Holds preset gradients
         * @todo Expand on standard gradients.
         *
         * @var array
         */
        private $default = [
            'heatmap'   => ["000", "00f", "0ff", "0f0", "ff0", "f00", "fff"],
            'rgb'       => ["f00", "f80", "ff0", "8f0", "0f0", "0f8", '0ff', '08f', "00f", "80f", "f0f", "f08", "f00"],
            'b/w'       => ["fff", "000"],
            'gray'      => ['fff', 'aaa'],
            'red'       => ["fff", "f00"],
            'green'     => ["fff", "0f0"],
            'blue'      => ["fff", "00f"],
            'orange'    => ["fff", "ffa600"],
            'violet'    => ["fff", "8000ff"],
            'lime'      => ['fff', 'c7fe00'],
            'cyan'      => ["fff", "00c8ff"],
            'aqua'      => ["fff", "00c8c8"],
            'magenta'   => ["fff", "c800c8"],
            'yellow'    => ["fff", "fe0"],
            'blue-gray' => ["fff", "062c4a"],
            'opb'       => ['ff8e44', 'f91362', '35126a'],
            'ovb'       => ['f6bf75', 'd77185', '8766ac', '4150b1'],
            'r/g'       => ["f00", "0f0"]
        ];
        
        /**
         * Class constructor.
         *
         * @param Array|null $values
         */
        public function __construct($values = null) {
            if(is_string($values)) {
                if(key_exists($values, $this->default)) {
                    $this->assignValues($this->default[$values]);
                } else {
                    return false;
                }
            }
            elseif(is_array($values)) {
                if($this->assignValues($values) !== false) {
                    $this->calculateConfig();
                    $this->calculateTableArray();
                } else {
                    return false;
                }
            }
            return;
        }
        /**
         * Start calulation block.
         *
         * @return GardientValues|Boolean
         */
        private function calculateConfig() {
            $this->stopsCount = count($this->values);
            $this->divider = $this->stopsCount - 1;

            foreach($this->values as $value) {
                $this->checkValue($value);
            }

            if(count($this->values) != count($this->valuesRGB)) {
                return false;
            }
            return $this;
        }

        /**
         * Calculates entire table for the full gradient.
         *
         * @return Array
         */
        private function calculateTableArray() {
            $a = range(0, 100, 100 / $this->divider);
            $b = array_map(fn($value): int => round($value), $a);
            $i = count($b) - 1;

            $full_range = [];
            $j = 0;
            foreach($b as $key => $value) {
                if($key < $i) {
                    $percentage_diff = $b[$key + 1] - $b[$key]; // qty of steps between values
                    $temp = []; // huh? w...
                    
                    $actual = $this->valuesRGB[$key]; // starting value
                    $next = $this->valuesRGB[$key+1]; // following value
                    
                    $channel_step = [
                        'r' => abs($next['r'] - $actual['r']) / $percentage_diff,
                        'g' => abs($next['g'] - $actual['g']) / $percentage_diff,
                        'b' => abs($next['b'] - $actual['b']) / $percentage_diff,
                        'a' => abs($next['a'] - $actual['a']) / $percentage_diff
                    ]; // difference of values between channels (per step)
                    
                    foreach($channel_step as $channel => $step) {
                        if($step == 0) {
                            $channel_step[$channel] = 1;
                        }
                    } // account for lacking steps if channel value stays the same

                    $range = [];
                    $range = [
                        'r' => range($actual['r'], $next['r'], $channel_step['r']),
                        'g' => range($actual['g'], $next['g'], $channel_step['g']),
                        'b' => range($actual['b'], $next['b'], $channel_step['b']),
                        'a' => range($actual['a'], $next['a'], $channel_step['a'])
                    ]; // generating table with range of values between steps (per step)

                    foreach($range as $channel => $values) {
                        if(count($range[$channel]) == 1) {
                            for($k = 0; $k <= $percentage_diff; $k++) {
                                $range[$channel][$k] = $range[$channel][0];
                            }
                        }else{
                            $c = count($range[$channel]);
                            if($c != $percentage_diff + 1) {
                                $dif = abs($percentage_diff - $c);
                                for($k = $c; $k <= $percentage_diff; $k++) {
                                    $range[$channel][$k] = $range[$channel][array_key_last($range[$channel])];
                                }
                            } // ...and this is some fix without which it just won't work properly on occassion... just don't know why or where the issue happens (probably range rounding)...
                        }
                    } // account for lacking steps when $channel_step == 0

                    $range_merged = [];
                    foreach($range['r'] as $rKey => $doesntMatter) {
                        $range_merged[$rKey] = [
                            'r' => round($range['r'][$rKey]),
                            'g' => round($range['g'][$rKey]),
                            'b' => round($range['b'][$rKey]),
                            'a' => $range['a'][$rKey]
                        ];
                    } // merging channels for each step

                    if($j > 0) {
                        unset($range_merged[0]);
                    } // removing first key if iteration is higher than 0 (to avoid doubling of values)
                    
                    $full_range = array_merge($full_range, $range_merged); // final output merger
                } else {
                    $full_range[100] = array(
                        'r' => round($this->valuesRGB[$i]['r']),
                        'g' => round($this->valuesRGB[$i]['g']),
                        'b' => round($this->valuesRGB[$i]['b']),
                        'a' => $this->valuesRGB[$i]['a']
                    );
                }
                $j++; // iteration count increase
            }
            $this->range = $full_range;
            return $full_range;
        }

        /**
         * Assign values.
         *
         * @param Array $values
         * @return GradientValues|Boolean
         */
        public function assignValues($values) {
            $this->zeroVariables();
            if(is_string($values)) {
                if(key_exists($values, $this->default)) {
                    $this->assignValues($this->default[$values]);
                    $this->calculateConfig();
                    $this->calculateTableArray();
                return $this;
                } else {
                    return false;
                }
            }
            elseif(is_array($values)) {
                $this->values = $values;
                $this->calculateConfig();
                $this->calculateTableArray();
                return $this;
            } else {
                $this->zeroVariables();
            }
            return false;
        }

        /**
         * Null properties.
         *
         * @return GradientValues
         */
        private function zeroVariables() {
            // zero arrays
            $this->values = []; 
            $this->valuesRGB = []; 
            $this->range = []; 
            // zero counts
            $this->stopsCount = 0;
            $this->divider = 0;
            return $this;
        }

        /**
         * Check values validity.
         *
         * @param String $value
         * @return Boolean
         */
        private function checkValue(String $value) {
            $value = str_replace("#", "", $value);
            $value = str_replace(" ", "", $value);

            // if hex
            if(ctype_xdigit($value)) {
                // rrggbbaa === rgba
                $len = strlen($value);
                if($len == 3 OR $len == 4) {
                    // rgb(a)
                    if($len == 3) {
                        $value .= "f";
                    }
                    $temp1 = str_split($value, 1);
                    $value_parts = array_map(array($this, 'hexSingleToDouble'), $temp1);
                    $temp1 = null;
                    unset($temp1);
                } elseif ($len == 6 or $len == 8) {
                    if($len == 6) {
                        $value .= "ff";
                    }
                    $value_parts = str_split($value, 2);
                } else {
                    // not proper transcription: must be 3/4 chars or 6/8 chars
                    return false;
                }

                // convert hex to decimal for r, g, b
                $value_parts[0] = hexdec($value_parts[0]);
                $value_parts[1] = hexdec($value_parts[1]);
                $value_parts[2] = hexdec($value_parts[2]);

                // check for alpha, process if found, substitute with 1 if missing
                if(isset($value_parts[3])) {
                    $value_parts[3] = $this->hexProportion($value_parts[3]);
                    if($value_parts[3] > 100) { 
                        $value_parts[3] = 100;
                    }
                    $alpha = $value_parts[3] / 100;
                } else {
                    $alpha = 1;
                }
            } else {
                // if decimal
                $value_parts = explode(",", $value);
                if(count($value_parts) >= 3 and count($value_parts) <= 4) {
                    // check if alpha
                    if(isset($value_parts[3])) {
                        $alpha = $value_parts[3];
                        if(strpos($alpha, "%")) {
                            // if percentage transcription
                            $alpha = str_replace("%", "", $alpha) / 100;
                        } else {
                            // if dotted transcription
                            if(strpos($alpha, ".")) {
                                if(floatval($alpha) > 1) {
                                    $alpha = 1;
                                }
                            } else {
                                // if neither then must be wrong, so use no transparency (a = 1)
                                $alpha = 1;
                            }
                        }
                    }
                } else {
                    // not hex, nor decimal
                    return false;
                }
            }

            // min max correction
            $temp = [ $value_parts[0], $value_parts[1], $value_parts[2] ];
            $value_parts = []; // empty parts for rebuilding
            $value_parts = array_map(array($this, 'correctDecimal'), $temp);
            $rgba = [ 
                'r' => $value_parts[0],
                'g' => $value_parts[1],
                'b' => $value_parts[2],
                'a' => 1 
            ];
            $temp = null;
            unset($temp);

            if(isset($alpha)) {
                //$value_parts[3] = $alpha;
                $rgba['a'] = $alpha;
            } else {
                $rgba['a'] = 1;
            }
            
            //return $value_parts;
            $this->valuesRGB[] = $rgba;
            return true;
        }

        /**
         * Proportion calulation for hex (conversion to %, by 255 = 100%, 0 = 0%).
         *
         * @param String $v
         * @return Integer
         */
        private function hexProportion(String $v) {
            $v = hexdec($v);
            return ceil(($v * 100 ) / 255);
        }

        /**
         * Change single char value to double char value.
         *
         * @param String $v
         * @return String
         */
        private function hexSingleToDouble(String $v) {
            return $v.$v;
        }

        /**
         * Value correction (lower than 0, higher than 255, float).
         *
         * @param String|Float|Integer $v
         * @return void
         */
        private function correctDecimal($v) {
            $v = intval($v);
            if($v < 0) {
                $v = 0;
            } elseif ($v > 255) {
                $v = 255;
            }
            return $v;
        }

        /**
         * Returns RGBA by input percentage.
         *
         * @param Integer $percent
         * @param Boolean $returnAsArray Returns array instead of string if TRUE.
         * @return Array|String By default a string of RGBA(), array if 2nd param is TRUE.
         */
        public function result(Int $percent, Bool $returnAsArray = false) {
            $percent = str_replace("%", "", $percent);
            $percent = intval($percent);
            $index = $percent;
                if($percent < 1)   { $index = 0;   } 
            elseif($percent > 100) { $index = 100; }

            if($returnAsArray) {
                return $this->range[$index];
            } else {
                return "rgba(".implode(",", $this->range[$index]).")";
            }
        }

        /**
         * Renders entire gradient bar.
         *
         * @param Array $containerAttributes Array with container attributes.
         * @param Array $cellAttributes Array with cell attributes.
         * @param Boolean $echo Flag. If true, echoes returning void or if false returns HTML. Default false.
         * @return void|String HTML or echo.
         */
        public function renderBar(Array $containerAttributes, Array $cellAttributes, Bool $echo = false) {
            $contAttr = null;
            foreach($containerAttributes as $attribute => $value) {
                $contAttr .= " {$attribute}='{$value}'";
            }

            $cellAttr = null;
            foreach($cellAttributes as $attribute => $value) {
                $cellAttr .= " {$attribute}='{$value}'";
            }

            $html = null;
            $html .= "<div {$contAttr}>";
            for($i = 0; $i <= 100; $i++) {
                $html .= $this->renderCell($i, "div", $cellAttr);
            }
            $html .= "</div>";

            if($echo) {
                echo $html;
                return;
            }
            return $html;
        }

        /**
         * Renders single cell / object.
         *
         * @param Float $percent Specifies which percent to represent (rounds to Decimal).
         * @param String $tag Specifies which tag to render.
         * @param String|Array $cellAttributes Specifies which attributes should the tag have.
         * @param String|null $content Specifies content inside the tag.
         * @return String HTML.
         */
        public function renderCell(Float $percent, String $tag = "div", $cellAttributes = null, String $content = null) {
            $percentRnd = round($percent);
            $cellAttr = null;
            if(is_array($cellAttributes)) {
                foreach($cellAttributes as $attribute => $value) {
                    $cellAttr .= " {$attribute}='{$value}'";
                }
            } elseif (is_string($cellAttributes)) {
                $cellAttr = " ".$cellAttributes;
            }
            return "<{$tag} {$cellAttr} style='background-color: {$this->result($percentRnd)}'>{$content}</{$tag}>";
        }
    }
?>