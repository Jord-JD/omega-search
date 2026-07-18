<?php

namespace JordJD\OmegaSearch;

use JordJD\OmegaSearch\SearchResult;

class SearchResults implements \Countable, \IteratorAggregate, \JsonSerializable {

    public $results = [];
    public $highestRelevance = null;
    public $lowestRelevance = null;
    public $averageRelevance = null;
    public $time = null;

    public function addSearchResult(SearchResult $searchResult) {
        $this->results[] = $searchResult;
    }
    
    public function calculateRelevances() {

        if (!$this->results) {
            return;
        }

        $this->lowestRelevance = PHP_INT_MAX;
        $this->highestRelevance = 0;

        $relevances = [];

        foreach($this->results as $result) {
            if ($result->relevance < $this->lowestRelevance) {
                $this->lowestRelevance = $result->relevance;
            }
            if ($result->relevance > $this->highestRelevance) {
                $this->highestRelevance = $result->relevance;
            }
            $relevances[] = $result->relevance;
        }

        $this->averageRelevance = array_sum($relevances) / count($this->results);
    }

    public function count(): int {
        return count($this->results);
    }

    public function getIterator(): \Traversable {
        return new \ArrayIterator($this->results);
    }

    public function jsonSerialize() {
        return [
            'results' => $this->results,
            'highestRelevance' => $this->highestRelevance,
            'lowestRelevance' => $this->lowestRelevance,
            'averageRelevance' => $this->averageRelevance,
            'time' => $this->time,
        ];
    }

}
