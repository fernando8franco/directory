<?php

/**
 * Simple PDO MySQL Database Connection Class
 * 
 * This class provides basic functionality to connect to a MySQL database using PDO,
 * execute queries, and properly close the connection.
 */
class Database {
    private $host;
    private $port;
    private $username;
    private $password;
    private $database;
    private $connection;
    private $options;
    private $error;
    private $showErrors;

    // Type mapping from string to PDO constants
    private $typeMap = [
        'i' => PDO::PARAM_INT,
        's' => PDO::PARAM_STR,
        'b' => PDO::PARAM_LOB,
        'n' => PDO::PARAM_NULL,
        'bool' => PDO::PARAM_BOOL
    ];

    /**
     * Constructor - initializes database connection parameters
     * 
     * @param string $host     Database host address
     * @param string $username Database username
     * @param string $password Database password
     * @param string $database Database name
     * @param array  $options  PDO options
     */
    public function __construct($host, $port, $username, $password, $database, $showErrors = true, $options = []) {
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->showErrors = $showErrors;
        
        // Default PDO options if none provided
        $this->options = $options ?: [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        
        $this->connect();
    }

    /**
     * Establishes connection to the database using PDO
     */
    private function connect() {
        try {
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->database};charset=utf8mb4";
            $this->connection = new PDO($dsn, $this->username, $this->password, $this->options);
        } catch (PDOException $e) {
            $this->handleError("Database connection error", $e->getMessage());
            return false;
        }
    }

    /**
     * Handles errors based on showErrors setting
     * 
     * @param string $type    Error type or title
     * @param string $message Detailed error message
     */
    private function handleError($type, $message) {
        $this->error = "$type: $message";
        error_log($this->error);
    }

        /**
     * Get the last error message
     * 
     * @return string The last error message
     */
    public function getLastError() {
        return $this->error;
    }
    
    /**
     * Check if an error has occurred
     * 
     * @return bool True if an error occurred, false otherwise
     */
    public function hasError() {
        return !empty($this->error);
    }

    /**
     * Executes a query and returns the result
     * 
     * @param string $query SQL query to execute
     * @return PDOStatement PDO statement object
     */
    public function query($query) {
        try {
            return $this->connection->query($query);
        } catch (PDOException $e) {
            $this->handleError("Query failed", $e->getMessage());
            return false;
        }
    }

    /**
     * Prepares and executes a query with parameters to prevent SQL injection
     * 
     * @param string $query  SQL query with placeholders
     * @param array  $params Array of parameters to bind
     * @return PDOStatement PDO statement object
     */
    public function execute($query, $params = []) {
        try {
            $stmt = $this->connection->prepare($query);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            $this->handleError("Query execution failed", $e->getMessage());
            return false;
        }
    }
    
    /**
     * Prepares and executes a query with explicit parameter types
     * Similar to MySQLi's bind_param functionality
     * 
     * @param string $query SQL query with placeholders
     * @param string $types Types of parameters (i for integer, s for string, b for blob, etc.)
     * @param array $params Array of parameters to bind
     * @return PDOStatement PDO statement object
     */
    public function preparedQuery($query, $types, $params) {
        try {
            $stmt = $this->connection->prepare($query);
            
            // Bind each parameter with its specific type
            for ($i = 0; $i < strlen($types); $i++) {
                $type = $types[$i];
                $pdoType = isset($this->typeMap[$type]) ? $this->typeMap[$type] : PDO::PARAM_STR;
                
                // PDO parameters are 1-indexed
                $stmt->bindValue($i + 1, $params[$i], $pdoType);
            }
            
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            $this->handleError("Prepared query failed", $e->getMessage());
            return false;
        }
    }

    /**
     * Fetch a single row from the database
     * 
     * @param string $query  SQL query with placeholders
     * @param array  $params Array of parameters to bind
     * @param int    $mode   PDO fetch mode
     * @return mixed Single row result or false if no row found
     */
    public function fetchOne($query, $params = [], $mode = PDO::FETCH_ASSOC) {
        $stmt = $this->execute($query, $params);
        return $stmt->fetch($mode);
    }
    
    /**
     * Fetch a single row with explicit parameter types
     * 
     * @param string $query  SQL query with placeholders
     * @param string $types  Types of parameters
     * @param array  $params Array of parameters to bind
     * @param int    $mode   PDO fetch mode
     * @return mixed Single row result or false if no row found
     */
    public function fetchOneWithTypes($query, $types, $params, $mode = PDO::FETCH_ASSOC) {
        $stmt = $this->preparedQuery($query, $types, $params);
        return $stmt->fetch($mode);
    }

    /**
     * Fetch all rows from the database
     * 
     * @param string $query  SQL query with placeholders
     * @param array  $params Array of parameters to bind
     * @param int    $mode   PDO fetch mode
     * @return array Array of result rows
     */
    public function fetchAll($query, $params = [], $mode = PDO::FETCH_ASSOC) {
        $stmt = $this->execute($query, $params);
        return $stmt->fetchAll($mode);
    }
    
    /**
     * Fetch all rows with explicit parameter types
     * 
     * @param string $query  SQL query with placeholders
     * @param string $types  Types of parameters
     * @param array  $params Array of parameters to bind
     * @param int    $mode   PDO fetch mode
     * @return array Array of result rows
     */
    public function fetchAllWithTypes($query, $types, $params, $mode = PDO::FETCH_ASSOC) {
        $stmt = $this->preparedQuery($query, $types, $params);
        return $stmt->fetchAll($mode);
    }

    /**
     * Begin a transaction
     * 
     * @return bool True on success, false on failure
     */
    public function beginTransaction() {
        return $this->connection->beginTransaction();
    }

    /**
     * Commit a transaction
     * 
     * @return bool True on success, false on failure
     */
    public function commit() {
        return $this->connection->commit();
    }

    /**
     * Rollback a transaction
     * 
     * @return bool True on success, false on failure
     */
    public function rollback() {
        return $this->connection->rollBack();
    }

    /**
     * Gets the ID generated by the last INSERT query
     * 
     * @return string The last ID generated
     */
    public function lastInsertId() {
        return $this->connection->lastInsertId();
    }

    /**
     * Closes the database connection
     */
    public function close() {
        $this->connection = null;
    }

    /**
     * Destructor - ensures connection is closed when object is destroyed
     */
    public function __destruct() {
        $this->close();
    }
}