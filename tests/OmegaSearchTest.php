<?php

namespace JordJD\OmegaSearch\Tests;

use JordJD\OmegaSearch\OmegaSearch;
use PHPUnit\Framework\TestCase;

class OmegaSearchTest extends TestCase
{
    private function search()
    {
        $pdo = new \PDO('sqlite::memory:');
        $pdo->exec('CREATE TABLE products (id INTEGER PRIMARY KEY, name TEXT, description TEXT, live INTEGER)');
        $pdo->exec("INSERT INTO products VALUES (1, 'Red bicycle', 'Fast city bike', 1)");
        $pdo->exec("INSERT INTO products VALUES (2, 'Blue helmet', 'Bicycle safety equipment', 1)");
        $pdo->exec("INSERT INTO products VALUES (3, 'Hidden bicycle', 'Not live', 0)");

        return (new OmegaSearch())
            ->setDatabaseConnection($pdo)
            ->setTable('products')
            ->setPrimaryKey('id')
            ->setFieldsToSearch(['name', 'description'])
            ->setConditions(['live' => 1]);
    }

    public function testSearchWorksWithCurrentUxdmTransformerApi()
    {
        $results = $this->search()->query('bicycle');

        $this->assertCount(2, $results);
        $this->assertSame(1, $results->results[0]->id);
        $this->assertNotFalse(json_encode($results));
    }

    public function testBlankSearchReturnsNoResults()
    {
        $this->assertCount(0, $this->search()->query('   '));
        $this->assertCount(0, $this->search()->query('no-match-at-all'));
    }
}
