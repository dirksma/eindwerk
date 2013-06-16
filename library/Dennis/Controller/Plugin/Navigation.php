<?php


class Dennis_Controller_Plugin_Navigation extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(\Zend_Controller_Request_Abstract $request)
    {        
        $locale = Zend_Registry::get('Zend_Locale');
        $model = new Application_Model_Page();
        
        $pages = $model->getMenu($locale);
        
        $navigation = new Zend_Navigation();
        
        // vast item, index
        
        $menu = new Zend_Navigation_Page_Mvc(
                    array(            
                        'label' => 'Index ',
                        'controller' => 'Index',
                        'action' => 'index',
                        //'route' => 'page',
                        'params' => array('lang' => $locale)));
                        
        $navigation->addPage($menu);
        
        foreach($pages as $page)
        {
            $menu = new Zend_Navigation_Page_Mvc(
                    array(            
                        'label' => $page['title'],
                        'controller' => 'Page',
                        'action' => 'view',
                        
                        //'route' => 'page',
                        'params' => array('lang' => $locale,
                                          'id' => $page['pageId'])
            ));            
         
            $navigation->addPage($menu);
            
        }
        
        
        
        Zend_Registry::set('Zend_Navigation', $navigation);
    }
            
}

?>
