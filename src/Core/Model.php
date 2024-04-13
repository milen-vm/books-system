<?php
namespace BooksSystem\Core;

abstract class Model
{
    protected static Database $db;
    protected string $table;

    public function __construct()
    {
        self::$db = Database::getInstance();
    }

    protected function insert($params)
    {
        $columns = array_keys($params);
        $values = array_values($params);

        $placeholders = str_repeat('?,', count($values));
        $placeholders = rtrim($placeholders, ',');

        $stmt = 'INSERT INTO ' . $this->table . ' (' .
            implode(',', $columns) . ') ' . 'VALUES(' . $placeholders . ')';

        $result = self::$db->prepare($stmt);
        $result->execute($values);

        if ($result->rowCount() > 0) {
            return self::$db->lastId();
        }

        throw new \Exception('Database error.');
    }
}