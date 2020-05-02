<?php

namespace app\DAO;

$DAO_LINK = null;
$DAO_QUERY_COUNTER = 0;

abstract class DAO
{
    const DB_HOST = 'mysql:host=localhost;dbname=blog;charset=utf8';
    const DB_USER = 'root';
    const DB_PASS = '';

    private function checkConnection()
    {
        global $DAO_LINK;

        if($DAO_LINK === null)
        {
            return $this->getConnection();
        }
        return $DAO_LINK;
    }

    private function getConnection()
    {
        global $DAO_LINK;

        try
        {
            $DAO_LINK = new PDO(self::DB_HOST, self::DB_USER, self::DB_PASS);
            $DAO_LINK->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $DAO_LINK;
        }
        catch(Exception $errorConnection)
        {
            die ('Connection fail :'.$errorConnection->getMessage());
        }

    }

    protected function createQuery($sql, $parameters = null)
    {
        global $DAO_QUERY_COUNTER;
        $DAO_QUERY_COUNTER++;

        if($parameters)
        {
            $result = $this->checkConnection()->prepare($sql);
            $result->setFetchMode(PDO::FETCH_CLASS, static::class);
            $result->execute($parameters);
            return $result;
        }
        $result = $this->checkConnection()->query($sql);
        $result->setFetchMode(PDO::FETCH_CLASS, static::class);
        return $result;
    }
}

?>