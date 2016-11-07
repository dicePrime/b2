<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace diceprime\Bundle\ORMBundle\AClasses;
/**
 * Description of AbstractMapper
 *
 * @author BMHB8456
 */
use diceprime\Bundle\ORMBundle\AClasses\AbstractEntity;
use diceprime\Bundle\ORMBundle\Interfaces\MapperInterface;
use diceprime\Bundle\ORMBundle\Interfaces\DatabaseAdapterInterface;

abstract class AbstractMapper implements MapperInterface {
    //put your code here
    
    protected $_adapter;
    
    protected $_entityTable;
    
    protected $_entityClass;
    
    /**
     * 
     */
    
    public function __construct(DatabaseAdapterInterface $adapter, array $entityOptions = array()) {
        
        $this->_adapter = $adapter;
        
        // set the entity table if the option has been specified
        
        if(isset($entityOptions['entityTable']))
        {
            $this->setEntityTable($entityOptions['entityTable']);
        }
        
        if(isset($entityOptions['entityClass']))
        {
            $this->setEntityClass($entityOptions['entityClass']);
        }
        
        $this->checkEntityOptions();
    }
    
    protected function _checkEntityOptions()
    {
        if(!isset($this->_entityTable))
        {
            throw new \RuntimeException('The entity table has not been set yet.');
                        
        }
        
        if(!isset($this->_entityClass))
        {
            throw new \RuntimeException('The entity class has not been set yet');
        }
    }
    
    public function getAdapter()
    {
        return $this->_adapter;
    }
    
    public function setEntityTable($entityTable)
    {
      if(!is_string($entityTable) || empty($entityTable))
      {
          throw new \InvalidArgumentException('The entity table is invalid.');
      }
      $this->_entityTable = $entityTable;
      
      return $this;
      
    }
    
    public function getEntityTable()
    {
        return $this->_entityTable;
    }
    
    function get_entityClass() {
        return $this->_entityClass;
    }

    function setEntityClass($entityClass) {
        
        if(!is_subclass_of($entityClass, 'AbstractEntity'));
        {
            throw new \InvalidArgumentException('The entity class is invalid.');
        }
    }
    
    public function findByid($id) {
        
        $this->_adapter->select($this->_entityTable, "id =$id");
        
        if($data = $this->_adapter->fetch())
        {
            return $this->_createEntity($data);
        }
        
        return null;
    }
    
    public function find($conditions = "")
    {
        $collection = new CollectionEntityCollection();
    }


    
    
}
