<?php
namespace BooksSystem\Core;

class Database
{
    /**
     *
     * @var \PDO
     */
    private static $db = null;
    private static $instance = null;
    
    private function __construct()
    {
        try {
            $dsn = 'mysql:host=localhost;dbname=books_system;charset=utf8';
            self::$db = new \PDO($dsn, 'homestead', 'secret', [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);

        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            exit();
        }
    }
    
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function prepare(string $statement, array $driverOptions = []): Statement
    {
        $statement = self::$db->prepare($statement, $driverOptions);
        
        return new Statement($statement);
    }
    
    public function query($query)
    {
        self::$db->query($query);
    }
    
    public function lastId($name = null)
    {
        return self::$db->lastInsertId($name);
    }
}

class Statement
{
    /**
     *
     * @var \PDOStatement
     */
    private $stmt;

    public function __construct(\PDOStatement $statement)
    {
        $this->stmt = $statement;
    }

    public function fetch($fetchStyle = \PDO::FETCH_ASSOC): mixed
    {
        return $this->stmt->fetch($fetchStyle);
    }

    public function fetchAll($fetchStyle = \PDO::FETCH_ASSOC): mixed
    {
        return $this->stmt->fetchAll($fetchStyle);
    }

    public function bindParam(
        $parameter,
        &$variable,
        $dataType = \PDO::PARAM_STR,
        $length = null,
        $driverOptions = null
    ) {
        return $this->stmt->bindParam($parameter, $variable, $dataType, $length, $driverOptions);
    }

    public function execute(array|null $inputParameters = null): bool
    {
        return $this->stmt->execute($inputParameters);
    }

    public function rowCount(): int
    {
        return $this->stmt->rowCount();
    }
}