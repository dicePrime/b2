<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace diceprime\Bundle\ORMBundle\Interfaces;
/**
 * Description of MapperInterface
 *
 * @author BMHB8456
 */
interface MapperInterface {
    //put your code here
    
    public function findByid($id);
    
    public function find($criteria ="");
    
    public function insert($entity);
    
    public function update($entity);
    
    public function delete($entity);
    
}
