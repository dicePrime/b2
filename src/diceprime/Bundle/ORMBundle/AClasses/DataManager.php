<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace diceprime\Bundle\ORMBundle\AClasses;

use diceprime\Bundle\ORMBundle\Classes\DBConfig;

/**
 * Description of AbstractEntity
 *
 * @author BMHB8456
 */
class DataManager {

    //put your code here


    protected $entityName;
    protected $connection;

    public function __construct($entityClass, $connection) {
        $this->connection = $connection;
        $this->entityName = $entityClass;
        
        //print_r($this->entityName);
    }

    public function find($id) {
        $sql = "SELECT " . implode(',', DBConfig::$db[$this->entityName]['fields'])
                . " FROM " . DBConfig::$db['table']
                . " WHERE " . DBConfig::$db['table']['pk'] . " = :id";

        $stm = $this->connection->prepare($sql);
        $stm->bindValue('id', $id);
        $results = $stm->fetchAll();
        if (count($results) > 0) {
            return $this->entityArrayToObject($results[0]);
        } else {
            return null;
        }
    }

    public function entityArrayToObject($array) {
        $entityClass = DBConfig::$db[$this->entityName]['class'];
        $object = new $entityClass();
        //print_r($array);
        $object->setData($array);
        return $object;
    }

    public function findBy($fields = array()) {
        $sql = "SELECT " . implode(",", DBConfig::$db[$this->entityName]['fields'])
                . " FROM " . DBConfig::$db[$this->entityName]['table'];
        if (count($fields) > 0) {
            $sql .= " WHERE ";
            $i = 0;
            $taille = count($fields);
            foreach ($fields as $fieldname) {
                $sql .= $fieldname['champ'] . " ".$fieldname['condition']['condition']." ".$this->quoteValue($fieldname['condition']['valeur']). " ";
                if($i < $taille -1)
                {
                    $sql .= " AND ";
                }
                
                $i++;
                
            }
        }
        $stm = $this->connection->prepare($sql);
        $stm->execute();
        $results = $stm->fetchAll();
        $output = array();
        if (count($results) > 0) {
            foreach ($results as $row) {
                $output[] = $this->entityArrayToObject($row);
            }
        }
        return $output;
    }
    
    public function quoteValue($value) {
        if ($value === null) {
            $value = 'NULL';
        } else if (!is_numeric($value)) {
            $value = $this->connection->quote($value);
        }

        return $value;
    }

    
    public function findAll($indexedBy = "") {
        $sql = "SELECT " . implode(",", DBConfig::$db[$this->entityName]['fields'])
                . " FROM " . DBConfig::$db[$this->entityName]['table'];
        $stm = $this->connection->prepare($sql);
        $stm->execute();
        $results = $stm->fetchAll();
        
        $output = array();
        if (count($results) > 0) {
            if ($indexedBy !== "") {
                foreach ($results as $row) {
                    
                    $output[$row[$indexedBy]] = $this->entityArrayToObject($row);
                }
            } else {
                foreach ($results as $row) {
                   
                    $output[] = $this->entityArrayToObject($row);
                }
            }
        }
        return $output;
    }

    public function persist($entity) {
        $params = array();
        $getId = "get" . ucfirst(DataManager::intoVarNamingForm(DBConfig::$db[$this->entityName]['pk']));
        if ($entity->$getId()) {
            $fields = array();
            foreach (DBConfig::$db[$this->entityName]['fields'] as $field) {
                $fields[] = $field . " = :" . $field;
            }
            $sql = "UPDATE " . DBConfig::$db[$this->entityName]['table']
                    . " SET " . implode(",", $fields) . " WHERE " . DBConfig::$db[$this->entityName]['pk'] . " = :id ";
            $params['id'] = $entity->$getId();
        } else {
            $sql = "INSERT INTO " . DBConfig::$db[$this->entityName]['table'] . "(" . implode(",", DBConfig::$db[$this->entityName]['fields']) . ") "
                    . "VALUES (:" . implode(",:", DBConfig::$db[$this->entityName]['fields']) . ")";
        }
        foreach (DBConfig::$db[$this->entityName]['fields'] as $field) {
            $functionName = "get" . ucfirst(DataManager::intoVarNamingForm(DBConfig::$db['fields_mapping'][$field]));
            $params[$field] = $entity->$functionName();
        }
        
        $stm = $this->connection->prepare($sql);
        $stm->execute($params);
        return $this->connection->lastInsertId();
    }

    public function lastInsertId() {
        return $this->connection->lastInsertId();
    }

    public static function intoVarNamingForm($string) {
        $fieldNameWithSpace = str_replace("_", " ", $string);
        $ucFieldNameWithSpace = ucwords($fieldNameWithSpace);
        $varName = str_replace(" ", "", $ucFieldNameWithSpace);
        return lcfirst($varName);
    }

    //Cette fonction permet de se déconnecter de la base de données
    public function disconnect() {

        if ($this->connection === null) {
            return false;
        }

        msqli_free_result($this->connection);

        return true;
    }

    

}
