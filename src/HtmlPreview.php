<?php
namespace tei187\IntensificationGradient;
use tei187\IntensificationGradient\Generator as Generator;

Class HtmlPreview {
    /** @var string Document title. */
    private $title = null;
    /** @var array Processed Generator::range. */
    private $range = [];

    /**
     * Constructor.
     *
     * @param string|null $title
     * @param Generator|array|string|null $range
     */
    function __construct(string $title = null, $range = null) {
        if(!is_null($range)) $this->setRange($range);
        if(!is_null($title)) $this->setTitle($title);
    }

    private function checkJSON(string $v) : bool {
        $test = json_decode($v);
        if(json_last_error() === JSON_ERROR_NONE) {
            return true;
        }
        return false;
    }

    /**
     * Sets range on data based of Generator class object, Generator class exported JSON or Generator class exported array. Otherwise FALSE.
     *
     * @param Generator|array|null $range
     * @return HtmlPreview|boolean
     */
    public function setRange($range = null) {
        if(is_null($range)) {
            return false;
        } else {
            if(is_a($range, "tei187\IntensificationGradient\Generator")) {
                $this->setRangeFromObject($range);
                return $this;
            } elseif(is_array($range)) {
                $this->setRangeFromArray($range);
                return $this;
            } elseif(is_string($range)) {
                if($this->checkJSON($range)) {
                    $this->setRangeFromJSON($range);
                    return $this;
                }
            }
        }
        return false;
    }

    /**
     * Sets range from passed Generator object.
     *
     * @param Generator $v
     * @return void
     */
    private function setRangeFromObject(Generator $v) : void {
        $this->range = $v->returnArray(true);
    }

    /**
     * Sets range from JSON exported from Generator::returnJSON().
     *
     * @param string $v
     * @return void
     */
    private function setRangeFromJSON(string $v) : void {
        $decoded = json_decode($v);
        $check = $this->checkRangeTranscription($decoded);
        $this->range = $this->parseRangeArray($decoded, $check);
    }

    /**
     * Sets range from output array of Generator::returnArray().
     *
     * @param array $v
     * @return void
     */
    private function setRangeFromArray(array $v) : void {
        $check = $this->checkRangeTranscription($v);
        $this->range = $this->parseRangeArray($v, $check);
    }

    /**
     * Checks transcription type of input array.
     *
     * @param array $v
     * @return string|bool
     */
    private function checkRangeTranscription(array $v) {
        if(is_string($v[0])) {
            $matched = [];
            preg_match_all("/[a-z0-9.]{1,4}/", $v[0], $matched);
            if(count($matched) == 1 && count($matched[0]) == 5) {
                return "string";
            }
        } elseif(is_array($v[0])) {
            if(count($v[0]) == 4 && isset($v[0]['r']) && isset($v[0]['g']) && isset($v[0]['b']) && isset($v[0]['a'])) {
                return "array";
            }
        }
        return false;
    }

    /**
     * Parses input range for output.
     *
     * @param array $v
     * @param string|boolean $type String of values "string" or "array" or bool FALSE.
     * @return array
     */
    private function parseRangeArray(array $v, string $type) : array {
        $output = [];
        if(is_string($type)) {
            if($type == "string") {
                $output = $v;
            } else {
                foreach($v as $key => $value) {
                    $output[$key] = "rgba({$value['r']},{$value['g']},{$value['b']},{$value['a']})";
                }
            }
        }
        return $output;
    }

    /**
     * Sets title for the document.
     *
     * @param string|null $title
     * @return HtmlPreview
     */
    public function setTitle(string $title = null) : HtmlPreview {
        $this->title = strlen(trim($title)) > 0 && !is_null($title) ? trim($title) : null;
        return $this;
    }

    /**
     * Builds HTML page.
     *
     * @return string HTML structure.
     */
    public function buildPage() : string {
        $html  = $this->buildStart();
        $html .= $this->buildStyles();
        $html .= "<div class='container mx-auto'>";
        $html .= $this->buildHeading();
        
        $cells = null;
        foreach($this->range as $key => $value) {
            $cells .= $this->buildCell($key);
        }
        
        $html .= "<div class='flex flex-wrap -mx-3 overflow-hidden'>\r\n";
        $html .= $cells;
        $html .= "</div>";
        $html .= "</div>";
        $html .= $this->buildEnd();
        
        return $html;
    }

    /**
     * Builds single HTML component for given step in $this->range.
     *
     * @param integer $id Key of index from $this->range.
     * @return string HTML.
     */
    private function buildCell(int $id) : string {
        $class = "py-3 px-3 w-full overflow-hidden sm:w-1/2 md:w-1/4 lg:w-1/6";

        $html  = "<div class='{$class}' id='cell-{$id}'>\r\n";
        $html .= "<div>";
        $html .= "\t<div><span>#{$id}</span>{$this->range[$id]}</div>\r\n";
        $html .= "\t<div style='background-color: {$this->range[$id]}'></div>\r\n";
        $html .= "</div>";
        $html .= "</div>\r\n";

        return $html;
    }

    private function buildHeading() : string {
        return "<h1>{$this->title}</h1>";
    }

    private function buildStyles() : string {
        $html  = "<style>\r\n";
        $html .= "body { background-color: #e8e8e8 }\r\n";
        $html .= "footer { color: #ccc; }\r\n";
        $html .= "footer a:hover { color: #999; }\r\n";
        $html .= "h1 { font-weight: bold; font-size: xxx-large; padding-top: 1em; margin-bottom: .5em; border-bottom: 2px solid black; }\r\n";
        $html .= "div[id*='cell'] > div { background-color: #fafafa; box-shadow: 0 3px 10px 1px #00000018; text-align: center; padding: 1em }\r\n";
        $html .= "div[id*='cell'] > div > div:first-child { font-size: smaller; color: #aaa }\r\n";
        $html .= "div[id*='cell'] > div > div > span { display: block; font-size: larger; font-weight: bold; color: black }\r\n";
        $html .= "div[id*='cell'] > div > div:last-child { height: 33vh; max-height: 150px; min-height: 50px; }\r\n";
        $html .= "</style>\r\n";

        return $html;
    }

    private function buildStart() : string {
        return "<!DOCTYPE html><html><head><title>{$this->title} - colors</title><link href='https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css' rel='stylesheet'></head><body>";
    }

    private function buildEnd() : string {
        return "<footer class='bg-gray-100 flex justify-center mt-5 p-3 w-full'><span>Generated with <a href='https://github.com/tei187/IntensificationGradient' target='_blank'>Intensification Gradient</a></span></footer></body></html>";
    }

}

?>