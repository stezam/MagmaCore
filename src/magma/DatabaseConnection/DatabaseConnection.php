<?php

declare(strict_types=1);

namespace Magma\DatabaseConnection;

// use PDOException;
// use Magma\DatabaseConnection\Exception\DatabaseConnectionException;
use PDO;
use Exception;
use Magma\DatabaseConnection\Exception\DatabaseConnectionException;

class DatabaseConnection implements DatabaseConnectionInterface
{
    /**
     * @var PDO
     */
    protected PDO $dbh;

    /**
     * @var array
     */
    protected array $credentials;

    /**
     * Main Constructor class
     * 
     * @return void
     */
    public function __construct(array $credentials)
    {
        $this->credentials = $credentials;
    }

    /**
     * @inheritDoc
     */
    public function open() : PDO{
        try{
            $params = [
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];
            $this->dbh = new PDO(
            $this->credentials['dsn'],
            $this->credentials['username'],
            $this->credentials['password'],
            $params
        );

        }catch(Exception $exception) {
            throw new DatabaseConnectionException($exception->getMEssage(), (int)$exception->getCode());
        }
        return $this->dbh;
    }

    /**
     * @inheritDoc
     */
    public function close() : void{
        $this->dbh = null;
    }

}

