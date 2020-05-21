<?php

namespace app\model;

use PDO;
use Exception;
use PDOException;
use TypeError;
use PDOStatement;

$DAO_LINK = null;
$DAO_QUERY_COUNTER = 0;

abstract class DAO
{    
    private ?Utils $_Utils = null;

    public function SetUtils(Utils $Utils) : void
    {
        $this->_Utils = $Utils;
    }

    public function GetUtils() : ?Utils
    {
        return $this->_Utils;
    }

    private function checkConnection() : ?PDO
    {
        global $DAO_LINK;

        if($DAO_LINK === null)
        {
            return self::getConnection();
        }
        return $DAO_LINK;
    }

    private function getConnection() : ?PDO
    {
        global $DAO_LINK;
        global $CONFIGS;

        try
        {
            $DAO_LINK = new PDO($CONFIGS->host, $CONFIGS->username, $CONFIGS->password);
            $DAO_LINK->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $DAO_LINK;
        }
        catch(Exception|PDOException|TypeError $ex)
        {
            $this->GetUtils()->Die('SQL error :'.$ex->getMessage());
        }
    }

    protected function createQuery(string $sql, array $parameters = null) : ?PDOStatement
    {
        global $DAO_QUERY_COUNTER;
        $DAO_QUERY_COUNTER++;

        try
        {
            if($parameters)
            {
                $result = self::checkConnection()->prepare($sql);
                $result->setFetchMode(PDO::FETCH_CLASS, static::class);
                $result->execute($parameters);
                return $result;
            }
            $result = self::checkConnection()->query($sql);
            $result->setFetchMode(PDO::FETCH_CLASS, static::class);
            return $result;
        }
        catch(Exception|PDOException|TypeError $ex)
        {
            $this->GetUtils()->Die('SQL error :'.$ex->getMessage());
        }
    }
}

?>