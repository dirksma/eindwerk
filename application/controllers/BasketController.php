<?php

class BasketController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // Check if there is any basket stored in session (or db)
        $sessionDennis = new Zend_Session_NameSpace('sessionDennis'); // Session must be unique on each server.
        
        if(isset($sessionDennis->basket))
        {
            // Yes, there is a basket, throw the whole damn thing to the view.
            $this->view->basket = $sessionDennis->basket; 
        }
        else
        {
            // No basket :(
            $this->view->basket = false;
        }
    }

    public function additemAction()
    {
        $lang = Zend_Registry::get('Zend_Locale');
        
        if( (int) $id = $this->getParam('id'))
        {
            $m_product = new Application_Model_Product();
            if(null !== $product = $m_product->getProductById($id, $lang))
            {
                $m_basket = new Application_Model_Basket();

                $sessionDennis = new Zend_Session_NameSpace('sessionDennis'); // Session must be unique on each server.
                
                $title   =   $product['title'];
                $price  =   $product['price'];

                // @Xavier -> I don't think Zend_Registry is of any use with this basket? 
                // This basket is available for everyone. Even guests. Even though I prefer paying customers.
                
                
                // First check if there is any current basket in session
                if (null === $sessionDennis->basket)
                {            
                    $basket[$id] = array();
                    
                    // There is no basket. It's like there is no spoon? But is there?
                    $basket[$id]['count']   =  1; // Create array $basket with key $id and set value to 1.
                    $basket[$id]['title']   =  $title;
                    $basket[$id]['price']   =  $price;
                    $sessionDennis->basket  =  $basket;
                }
                else
                {                   
                   // There is a basket ? Yihaa ! :-) 
                   $basket = $sessionDennis->basket;

                   // Check if item with $id exists. If true -> update with 1. If not, create it! 
                   if(key_exists($id, $basket))
                   {                       
                       $basket[$id]['count']   = $basket[$id]['count']+1;                       
                       $basket[$id]['price']   =  $price*$basket[$id]['count'];
                   }
                   else
                   {
                       $basket[$id] = array();

                       // There is no basket. It's like there is no spoon? But is there?
                       $basket[$id]['count']   =  1; // Create array $basket with key $id and set value to 1.
                       $basket[$id]['title']   =  $title;
                       $basket[$id]['price']   =  $price;
                   }
                   

                   $sessionDennis->basket = $basket;
                }

                // Ok, item added, lets go to the basket itself. 
                $this->_redirect($this->view->url(array('controller' => 'basket', 'action' => 'index', 'params' => array())));
            }
            else
            {
                die("Product bestaat niet");
            }
        }
        else
        {
            DIE("ERROR");
        }
    }

    public function emptybasketAction()
    {
        // Empty basket
        $sessionDennis = new Zend_Session_NameSpace('sessionDennis');
        unset($sessionDennis->basket);
        
        $this->_redirect($this->view->url(array('controller' => 'index', 'action' => 'index', 'params' => array())));
    }


}





