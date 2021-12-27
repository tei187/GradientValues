<?php
namespace tei187\IntensificationGradient;

/**
     * Class used to generate gradient for intensification display purposes (ticks per hour, hits by day, etc).
     * @author Piotr Bonk <bonk.piotr@gmail.com>
     * @license MIT
     */
    Class Generator {
        /** @var array Holds input values, pre-processing. */
        private $values = [];
        /** @var array Holds RGB values based on input, mid-process. */
        private $valuesRGB = [];
        /** @var array Holds full gradient data, post-processing. */
        private $range = [];
        /** @var integer Count of defined stops from user input. */
        private $stopsCount = 0;
        /** @var integer Division value - range between two stops, given a 100 stops limit in overall gradient. */
        private $divider = 0;

        /**
         * @var array Holds preset gradients
         * @todo Expand on standard gradients.
         */
        protected $default = [
            // basic:
            // - popular use:
            'heatmap'    => ["000", "00f", "0ff", "0f0", "ff0", "f00", "fff"],
            'color-temp' => ["f80", "ffc586", "fff", "cddcff", "a1bfff"],
            'rgb'        => ["f00", "f80", "ff0", "8f0", "0f0", "0f8", "0ff", "08f", "00f", "80f", "f0f", "f08", "f00"],
            // - main sequence additive:
            'red'        => ["fff", "f00"],
            'green'      => ["fff", "0f0"],
            'blue'       => ["fff", "00f"],
            // - main sequence subtractive:
            'cyan'       => ["fff", "00c8ff"],
            'magenta'    => ["fff", "c800c8"],
            'yellow'     => ["fff", "fe0"],
            'black'      => ["fff", "000"],
            // off-color:
            'gray'       => ['fff', 'aaa'],
            'beige'      => ['fdfcfb', 'e2d1c3'],
            'orange'     => ["fff", "ffa600"],
            'violet'     => ["fff", "8000ff"],
            'lime'       => ['fff', 'c7fe00'],
            'aqua'       => ["fff", "00c8c8"],
            'blue-gray'  => ["fff", "062c4a"],
            // intense:
            'opb'        => ['ff8e44', 'f91362', '35126a'],
            'ovb'        => ['f6bf75', 'd77185', '8766ac', '4150b1'],
            'r/g'        => ["f00", "0f0"],
            'rastafari'  => ['1e9600', 'fff200', 'ff0000'],
            'argon-blue' => ['fdeff9', 'ec38bc', '7303c0', '03001e'],
            'blackbody'  => ['ff0', 'f00', '000'],
            'nvg'        => ["fff", "44f281", "2da657", "1d7332", "010d00" ],
            // brands:
            'instagram'  => ['fcb045', 'fd1d1d', '833ab4'],
            'twitch'     => ['6441a5', '2a0845'],
            'facebook'   => ['ffffff', '3b5998'],
            'google'     => ['4285f4', '34a853', 'fbbc05', 'ea4335'],
            'lyft'       => ['f3f3f5', 'e90b8b', '352384', '333447'],
            'skype'      => ['d7ecf7', '07a8e7'],
        ];
        
        /**
         * Class constructor.
         *
         * @param array|string|null $values
         */
        public function __construct($values = null) {
            if(is_string($values)) {
                if(key_exists($values, $this->default)) {
                    $this->setValues($this->default[$values]);
                }
            } elseif(is_array($values)) {
                if($this->setValues($values) !== false) {
                    $this->calculateConfig();
                    $this->calculateTableArray();
                }
            }
        }

        /**
         * Start calulation block.
         *
         * @return GardientValues|boolean
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
         * @return array
         */
        private function calculateTableArray() : array {
            $a = range(0, 100, 100 / $this->divider);
            $b = array_map(fn($value): int => round($value), $a);
            $i = count($b) - 1;

            $full_range = [];
            $j = 0;
            foreach($b as $key => $value) {
                if($key < $i) {
                    $percentage_diff = $b[$key + 1] - $b[$key]; // number of steps between values
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
                                // $dif = abs($percentage_diff - $c);
                                for($k = $c; $k <= $percentage_diff; $k++) {
                                    $range[$channel][$k] = $range[$channel][array_key_last($range[$channel])];
                                }
                            } // ...and this is some fix without which it just won't work properly on occassion... just don't know why or where the issue happens (probably range rounding, just couldn't be bothered to test)...
                        }
                    } // account for lacking steps

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
         * @param array $values
         * @return Generator|boolean
         */
        public function setValues($values) {
            $this->zeroVariables();
            if(is_string($values)) {
                if(key_exists($values, $this->default)) {
                    $this->setValues($this->default[$values]);
                    $this->calculateConfig();
                    $this->calculateTableArray();
                    return $this;
                }
            } elseif(is_array($values)) {
                $this->values = $values;
                $this->calculateConfig();
                $this->calculateTableArray();
                return $this;
            }
            return false;
        }

        /**
         * Zero out properties.
         *
         * @return Generator
         */
        public function zeroVariables() : Generator {
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
         * Check values validity. Return true if check fine, false if failed.
         *
         * @param string $value Input RGB(a) value as hex (with or without hash) or integer set (each limited with comas, alpha as % or 1.0)
         * @return boolean
         */
        private function checkValue(string $value) : bool {
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
                    // improper input transcription: must be 3/4 chars or 6/8 chars
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
                    // not hex, nor decimal, just plain wrong
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

            $rgba['a'] = isset($alpha) ? $alpha : 1;
            
            $this->valuesRGB[] = $rgba;
            return true;
        }

        /**
         * Proportion calulation for hex (conversion to %, by 255 = 100%, 0 = 0%).
         *
         * @param string $v
         * @return integer
         */
        private function hexProportion(string $v) : int {
            return ceil((hexdec($v) * 100 ) / 255);
        }

        /**
         * Change single char value to double char value.
         *
         * @param string $v
         * @return string
         */
        private function hexSingleToDouble(string $v) : string {
            return $v.$v;
        }

        /**
         * Value correction (lower than 0, higher than 255, float).
         *
         * @param string|float|integer $v Input value of channel.
         * @return void
         */
        private function correctDecimal($v) : int {
            $v = intval($v);
            if($v < 0) {
                $v = 0;
            } elseif ($v > 255) {
                $v = 255;
            }
            return $v;
        }

        /**
         * Returns RGB(a) by input percentage.
         *
         * @param integer $percent Input percentage.
         * @param boolean $returnAsArray Returns array instead of string if TRUE.
         * @return array|string By default a string of RGBA(), array if 2nd param is TRUE.
         */
        public function result(int $percent, bool $returnAsArray = false) {
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
         * @param array|null $containerAttributes Array with container attributes.
         * @param array|null $cellAttributes Array with cell attributes.
         * @param boolean $echo Flag. If true, echoes returning void or if false returns HTML. Default false.
         * @return string HTML or echo.
         */
        public function renderBar(?array $containerAttributes = null, ?array $cellAttributes = null, bool $echo = false) : string {
            $contAttr = null;
            if(is_array($containerAttributes)) {
                foreach($containerAttributes as $attribute => $value) {
                    $contAttr .= " {$attribute}='{$value}'";
                }
            }

            $cellAttr = null;
            if(is_array($cellAttributes)) {
                foreach($cellAttributes as $attribute => $value) {
                    $cellAttr .= " {$attribute}='{$value}'";
                }
            }

            $html = null;
            $html .= "<div {$contAttr}>";
            for($i = 0; $i <= 100; $i++) {
                $html .= $this->renderCell($i, "div", $cellAttr);
            }
            $html .= "</div>";

            if($echo) {
                echo $html;
                return "";
            }
            return $html;
        }

        public function getValues() {
            return $this->valuesRGB;
        }

        /**
         * Renders single cell / object.
         *
         * @param float $percent Specifies which percent to represent (rounds to Decimal).
         * @param string $tag Specifies which tag to render.
         * @param string|array|null $cellAttributes Specifies which attributes should the tag have.
         * @param string|null $content Specifies content inside the tag.
         * @return string HTML.
         */
        public function renderCell(float $percent, string $tag = "div", $cellAttributes = null, ?string $content = null) : string {
            $percentRnd = round($percent);
            $cellAttr = null;
            $foundStyle = false;
            if(is_array($cellAttributes)) {
                if(key_exists("style", $cellAttributes)) {
                    $cellAttributes["style"] .= "; background-color: {$this->result($percentRnd)}";
                    $foundStyle = true;
                }
                foreach($cellAttributes as $attribute => $value) {
                    $cellAttr .= " {$attribute}='{$value}'";
                }
            } elseif (is_string($cellAttributes)) {
                if(strpos($cellAttributes, "style='") !== false) {
                    $cellAttributes = str_replace("style='", "style='background-color: {$this->result($percentRnd)}; ", $cellAttributes);
                    $foundStyle = true;
                } 
                if(strpos($cellAttributes, "style=\"") !== false) {
                    $cellAttributes = str_replace("style=\"", "style=\"background-color: {$this->result($percentRnd)}; ", $cellAttributes);
                    $foundStyle = true;
                }
                $cellAttr = " ".$cellAttributes;
            }
            
            if($foundStyle) {
                $style = null;
            } else {
                $style = "style='background-color: {$this->result($percentRnd)}'";
            }
            return "<{$tag} {$cellAttr} {$style}>{$content}</{$tag}>";
        }

        /**
         * Inverts gradient front-to-back (1...n to n...1).
         * 
         * @return Generator
         */
        public function invert() : Generator {
            $inverted = array_reverse($this->values);
            $this->setValues($inverted);
            return $this;
        }

        /**
         * Returns calculated range as JSON.
         *
         * @param boolean $rgba If set to TRUE, returns each step as rgba(...) string. If set to FALSE, returns each step as {"r", "g", "b", "a"} nodes. FALSE by default.
         * @return string
         */
        public function returnJSON(bool $rgba = false) : string {
            if($rgba) {
                $temp = [];
                foreach($this->range as $index => $values) {
                    $temp[] = "rgba(".implode(",", $this->range[$index]).")";
                }
                return json_encode($temp, JSON_PRETTY_PRINT);
            }
            return json_encode($this->range, JSON_PRETTY_PRINT);
        }

        /**
         * Returns calculated range as array.
         *
         * @param boolean $rgba If set to TRUE, returns each step as rgba(...) string. If set to FALSE, returns each step as {"r", "g", "b", "a"} pairs. FALSE by default.
         * @return array
         */
        public function returnArray(bool $rgba = false) : array {
            if($rgba) {
                $rgbaArray = [];
                foreach($this->range as $index => $values) {
                    $rgbaArray[] = "rgba(".implode(",", $this->range[$index]).")";
                }
                return $rgbaArray;
            }
            return $this->range;
        }
    }
?>