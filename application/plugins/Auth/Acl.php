<?php


/**
 * Description of ACL
 *
 * @author Vosser
 */
class Plugin_Auth_Acl extends Zend_Acl{
    //put your code here
    public function __construct() {
        $this->add(new Zend_Acl_Resource('Admin'));
        
    }
}
