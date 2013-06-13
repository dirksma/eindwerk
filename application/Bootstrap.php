<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initRegisterControllerPlugins()
    {
        $this->bootstrap('frontcontroller');
        $front = $this->getresource('frontcontroller');
        
        //$front->registerPlugin(new Dennis_Controller_Plugin_Translate());
        //$front->registerPlugin(new Syntra_Controller_Plugin_Navigation());
        //$front->registerPlugin(new Dennis_Auth_Acl());
        //$front->registerPlugin(new Dennis_Auth_Auth());
    }
    
    protected function _initMyActionHelpers()
    {
        $this->bootstrap('frontController');
        $search = Zend_Controller_Action_HelperBroker::getStaticHelper('Search');
        Zend_Controller_Action_HelperBroker::addHelper($search);
    }
    
    public function _initDbAdapter()
    {
        $this->bootstrap('db');
        $db = $this->getResource('db');
        //Maak een soort van globale variabele
        Zend_Registry::set('db', $db);
    }

}

