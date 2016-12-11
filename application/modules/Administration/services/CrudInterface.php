<?php

/**
 * @author Voß
 */
interface Administration_Services_CrudInterface {
    
    
    public function create(Administration_Model_CrudObject $object);
    
    public function read($id);
    
    public function edit(Administration_Model_CrudObject $object);
    
    public function delete(Administration_Model_CrudObject $object);
    
}
