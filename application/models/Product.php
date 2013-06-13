<?php

class Application_Model_Product extends Zend_Db_Table_Abstract
{
    protected $_primary =   'productId';
    protected $_name    =   'product';
    
    CONST STATUS    =   'ONLINE';
    
    
    public function getAllProducts($limit, $locale)
    {
        $select = $this->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
                ->setIntegrityCheck(false)
                ->joinLeft(array('l' => 'productLocale'),
                        'l.productId = product.productId',
                        array('product.productId AS productId', 'l.title AS productTitle'))
                ->where('l.locale = ?', $locale)
                ->limit($limit);
        
        
        
        return $this->fetchAll($select);
    }


}

