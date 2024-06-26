<?php
namespace BooksSystem\Core;

class Repository
{
    protected static Database $db;
    protected string $table;

    public function __construct(string $table)
    {
        $this->table = $table;
        self::$db = Database::getInstance();
    }

    public function insert($params)
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

        return false;
    }

    public function update($args, $params): bool
    {
        // $args = [
        //     'where' => 'id = ?',
        //     'values' => [2]
        // ];
        $columns = array_keys($params);
        $values = array_values($params);
        $stmt = 'UPDATE ' . $this->table . ' SET ';

        foreach ($columns as $column) {
            $stmt .= "{$column} = ?, ";
        }

        $stmt = trim($stmt, ', ');
        $stmt .= ' WHERE ' . $args['where'];

        $result = self::$db->prepare($stmt);
        $result->execute(array_merge($values, $args['values']));

        return $result->rowCount() > 0;
    }

    public function findAll($args = [], $params = [], $fetchStyle = \PDO::FETCH_ASSOC)
    {
        $result = $this->prepareFind($args, $params);

        return $result->fetchAll($fetchStyle);
    }

    public function find($args = [], $params = [], $fetchStyle = \PDO::FETCH_ASSOC)
    {
        $result = $this->prepareFind($args, $params);
        $arr = $result->fetch($fetchStyle);

        return  $arr !== false ? $arr : [];
    }

    private function prepareFind($args, $params)
    {
        $stmtArgs = array_merge([
            'select' => '*',
            'from' => $this->table,
            'join' => [],
            'where' => '',
            'orderby' => '',
            'limit' => 0
        ], $args);

        $stmt = $this->buildStmt($stmtArgs);
        $result = self::$db->prepare($stmt);
        $result->execute($params);

        return $result;
    }

    private function buildStmt($args)
    {
        $stmt = 'SELECT ' . $args['select'] .
            ' FROM ' . $args['from'];

        if (count($args['join']) > 0) {
            foreach ($args['join'] as $join) {
                $stmt .= ' LEFT JOIN ' . $join;
            }
        }

        if (!empty($args['where'])) {
            $stmt .= ' WHERE ' . $args['where'];
        }

        // ORDER BY column_name ASC|DESC, column_name ASC|DESC ...
        if (!empty($args['orderby'])) {
            $stmt .= ' ORDER BY ' . $args['orderby'];
        }

        if (!empty($args['limit'])) {
            $stmt .= ' LIMIT ' . $args['limit'];
        }

        return $stmt;
    }
}