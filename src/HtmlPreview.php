<?php
namespace tei187\IntensificationGradient;

Class HtmlPreview {
    /** @var string Document title. */
    private $title = null;
    /** @var Generator|array|string Processed Generator class object. */
    private $range;

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
     * @param Generator|null $range
     * @return HtmlPreview
     */
    public function setRange(Generator $range = null) : HtmlPreview {
        if(is_null($range)) {
            return false;
        } else {
            if(is_object($range) and is_a($range, "Generator")) {
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
            if(count($matched) == 5) {
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
     * @param string|boolean $type "string" or "array" or FALSE.
     * @return array
     */
    private function parseRangeArray(array $v, string $type) : array {
        $output = [];
        if(is_string($type)) {
            if($type == "string") {
                $this->output = $v;
            } else {
                foreach($v as $key => $value) {
                    $this->output[$key] = "rgba({$value[1]},{$value[2]},{$value[3]},{$value[4]})";
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
}

?>