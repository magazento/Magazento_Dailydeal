<?php

/*
 *  Created on Dec 6, 2012
 *  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
 *  Copyright Proskuryakov Ivan. Magazento.com © 2011. All Rights Reserved.
 *  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
 */
?>
<?php

class Magazento_Dailydeal_Helper_Data extends Mage_Core_Helper_Abstract {

    
    public function getWordLimit($words) {
            $limit = Mage::getStoreConfig('dailydeal/options/descriptionlimit');
            
            $wordArray = explode(' ', $words);
            if ($limit > count($wordArray)) $limit = count($wordArray);
            $summary = array();
            for($i = 0; $i < $limit; $i++){
               $summary[] = $wordArray[$i];
            }
            
            $summary = implode(' ', $summary);
            if ($limit > count($wordArray)) $summary = $summary.' ...';
            return $summary;
    }
    public function getTypes() {
        
        $type = array();
        $type['bestseller'] = 'Best Sellers';
        $type['toprated'] = 'Top Rated';
        $type['review'] = 'Reviews';
        $type['popular'] = 'Popular';
        $type['new'] = 'New products';
        return $type; 
    }
    public function getLayoutTypes() {
        
        $type = array();
        $type['left'] = 'Left column';
        $type['right'] = 'Right column';
        $type['content'] = 'Content';
        return $type; 
    }
    public function getLayoutOrder() {
        
        $type = array();
        $type['before'] = 'Top';
        $type['after'] = 'Bottom';
        return $type; 
    }
    public function versionUseAdminTitle() {
        $info = explode('.', Mage::getVersion());
        if ($info[0] > 1) {
            return true;
        }
        if ($info[1] > 3) {
            return true;
        }
        return false;
    }

    public function versionUseWysiwig() {
        $info = explode('.', Mage::getVersion());
        if ($info[0] > 1) {
            return true;
        }
        if ($info[1] > 3) {
            return true;
        }
        return false;
    }
    
    public function numberArray($max,$text) {

        $items = array();
        for ($index = 1; $index <= $max; $index++) {
            $items[$index]=$text.' '.$index;
        }
        return $items;
    }
    
    public function formatTime($time) {
       $time =  strtotime($time);
       return date('F d, Y h:i:s',$time);
    }
    
        
    
}