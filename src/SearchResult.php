<?php

namespace JordJD\OmegaSearch;


class SearchResult implements \JsonSerializable {

    public $id;
    public $relevance;

    public function __construct($id, $relevance) {
        $this->id = $id;
        $this->relevance = $relevance;
    }

    public function jsonSerialize() {
        return ['id' => $this->id, 'relevance' => $this->relevance];
    }


}
