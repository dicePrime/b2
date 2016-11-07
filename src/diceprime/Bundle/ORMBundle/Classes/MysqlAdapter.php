<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace diceprime\Bundle\ORMBundle\Classes;

/**
 * Description of MysqlAdapter
 *
 * @author BMHB8456
 */
use diceprime\Bundle\ORMBundle\Interfaces\DatabaseAdapterInterface;

class MysqlAdapter implements DatabaseAdapterInterface {

    //put your code here

    protected $_config = array();
    protected $_link;
    protected $_result;

    /**
     * 
     */
    public function __construct(array $config) {

        if (count($config) !== 4) {
            throw new \InvalidArgumentException('Invalid number of connection parameters');
        }

        $this->_config = $config;
    }

    /**
     * Connection to Mysql
     */
    public function connect() {
        //Connect only once

        if ($this->_link === null) {
            list($host, $user, $password, $database, $port) = $this->_config;

            if (!$this->_link = @mysqli_connect($host, $user, $password, $database, $port)) {
                throw new \RuntimeException('Error connecting to the server: ' . mysqli_connect_errno());
            }
            unset($host, $user, $password, $database, $port);
        }

        return $this->_link;
    }

    /**
     * Execute the specified query
     * @param type $query
     */
    public function query($query) {
        if (!is_string($query) || empty($query)) {
            throw new \InvalidArgumentException('The specified query is not valid');
        }

        //lazy connect to MySQL
        $this->connect();

        if (!$this->_result = mysqli_query($this->_link, $query)) {
            throw new \RuntimeException('Error executing the specified query', $query . mysqli_error($this->_link));
        }

        return $this->_result;
    }

    public function select($table, $where = "", $fields = "*", $order = "", $limit = null, $offset = null) {
        $query = 'SELECT' . $fields . 'FROM' . $table
                . (($where) ? 'WHERE' . $where : "")
                . (($limit) ? 'LIMIT' . $limit : "")
                . (($offset && $limit) ? 'OFFSET' . $offset : "")
                . (($order) ? 'ORDER BY' . $order : "");

        $this->query($query);

        return $this->countRows();
    }

    /**
     * 
     * @param type $table
     * @param array $data
     */
    public function insert($table, array $data) {
        $fields = implode(',', array_keys($data));

        /**
         *  array_map ( callable $callback , array $array1 [, array $... ] )
         *  array_map returns an array containing all the elements of array1 after applying the callback
         *  function to each one. The number of parameters that the callback function accepts should 
         *  match the number of arrays passed to the array_map()
         * 
         *  array_map will return an array containing all values of data imploded
         */
        $values = implode(',', array_map(array($this, 'quoteValue'), array_values($data)));

        $query = 'INSERT INTO' . $table . '(' . $fields . ')' . ' VALUES(' . $values . ')';

        $this->query($query);

        return $this->getInsertId();
    }

    public function update($table, array $data, $where = "") {
        $set = array();

        foreach ($data as $field => $value) {
            $set[] = $field . '=' . $this->quoteValue($value);
        }

        $set = implode(',', $set);

        $query = 'UPDATE ' . $table . ' SET ' . $set . (($where) ? 'WHERE ' . $where : "");

        $this->query($query);

        return $this->getAffectedRows();
    }

    public function delete($id, $col = 'id') {
        $query = 'DELETE FROM ' . $table .
                (($where) ? 'WHERE ' . $where : "");
        $this->query($query);

        return $this->getAffectedRows();
    }

    public function quoteValue($value) {
        $this->connect();

        if ($value === null) {
            $value = 'NULL';
        } else if (!is_numeric($value)) {
            $value = "'" . mysqli_real_escape_string($this->_link, $value) . "'";
        }

        return $value;
    }

    public function fetch() {
        if ($this->_result !== null) {
            if (($row = mysqli_fetch_array($this->_result, MYSQLI_ASSOC)) === false) {
                $this->freeResult();
            }
            return $row;
        }

        return false;
    }

    public function getInsertId() {

        return $this->_link !== null ? mysqli_insert_id($this->_link) : null;
    }

    public function countRows() {
        return $this->_result !== null ? mysqli_num_rows($this->_result) : 0;
    }

    public function getAffectedRows() {

        return $this->_link !== null ? mysqli_affected_rows($this->_link) : 0;
    }

    public function freeResult() {
        if ($this->_result === null) {
            return false;
        }
        mysqli_free_result($this->_result);

        return true;
    }
    
    public function disconnect() {
        
        if($this->_result === null)
        {
            return false;
        }
        
        msqli_free_result($this->_result);
        
        return true;
    }
    
    public function __desctruct() {
        $this->disconnect();
    }

}
