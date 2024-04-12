<?php
namespace BooksSystem\Core;

class Database
{
    /**
     *
     * @var \PDO
     */
    private static $db = null;
    
    private function __construct()
    {}
    
    public static function getInstance()
    {
        try {
            if (self::$db === null) {
                $dsn = 'mysql:host=localhost;dbname=books_system;charset=utf8';
                self::$db = new \PDO($dsn, 'homestead', 'secret',
                        [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
            }
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            exit();
        }
        
        return self::$db;
    }
    
    /**
     * 
     * @param string $statement
     * @param array $driverOptions
     * @return Statement
     */
    public function prepare($statement, array $driverOptions = [])
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

    /**
     *
     * @param int $fetchStyle            
     * @return mixed
     */
    public function fetch($fetchStyle = \PDO::FETCH_ASSOC)
    {
        return $this->stmt->fetch($fetchStyle);
    }

    /**
     *
     * @param int $fetchStyle            
     * @return mixed
     */
    public function fetchAll($fetchStyle = \PDO::FETCH_ASSOC)
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

    /**
     *
     * @param array|null $inputParameters            
     * @return boolean
     */
    public function execute(array $inputParameters = null)
    {
        return $this->stmt->execute($inputParameters);
    }

    /**
     *
     * @return int
     */
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }
}