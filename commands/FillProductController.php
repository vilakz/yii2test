<?php

namespace app\commands;

use yii\console\Controller;
use app\models\Product;
use app\models\EAV;

class FillProductController extends Controller {
    
    /**
     * Создать в mongo тестовые записи для product. запуск php yii fill-product
     */
    public function actionIndex() {
        $arr = [
            2 => "Хитрый аттрибут для теста",
            15 => "Изображение" ,
            16 => "Климатическое исполнение" ,
            17 => "Тип корпуса" ,
            18 => "Разрешение видеокамеры",
            19 => "Тип объектива" ,
            20 => "Фокусное расстояние объектива",
        ];
        for( $i = 0 ; $i < 10000 ; ++$i ) {
            $Product = new Product;
            $Product->category_id = mt_rand(1, 10 );
            $Product->item_number = "255";
            $Product->brand_id = 1;
            $Product->name = $this->mtRandStr(11);
            $Product->alias = $Product->name;
            $Product->price_wholesale = (float)mt_rand(1000, 50000 );
            $Product->not_produced = 1;
            $Product->site_status = 0;
            
            $countArr = count( $arr );
            $currentCountEAV = mt_rand(0, $countArr );
            if ( $currentCountEAV ) {
                $itemsToAdd = $this->getEAVRandomItems( $currentCountEAV , $arr );
                foreach( $itemsToAdd as $kItemToAdd => $vItemToAdd ) {
                    $eav = new EAV;
                    $eav->id = $kItemToAdd;
                    $eav->label = $vItemToAdd;
                    $eav->value = [ $kItemToAdd ];
                    // записать для теста аттрибут 2 , значения 255 256
                    if ( 2 == $eav->id ) {
                        $randVal = mt_rand(1 , 100 );
                        if ( $randVal % 3 ) {
                            $eav->value[] = 255;
                        }
                        if ( $randVal % 4 ) {
                            $eav->value[] = 256;
                        }
                    }
                    $Product->eav[] = $eav;
                }
            }
            $Product->save();
        }
        
        // теперь одинаковые товары, но у некоторых будет разный eav
        $arrEqual = [
            'eq1' => [ 'category_id' => 3 , 'item_number' => 255 , 'brand_id' => 1 , 'name' => 'Equal1' , 'alias' => 'Equal1' , 'price_wholesale' => 1000 , 'not_produced' => 1 , 'site_status' => 0 ],
            'eq2' => [ 'category_id' => 4 , 'item_number' => 255 , 'brand_id' => 1 , 'name' => 'Equal2' , 'alias' => 'Equal2' , 'price_wholesale' => 3000 , 'not_produced' => 1 , 'site_status' => 0 ],
        ];
        foreach( $arrEqual as $keq => $veq ) {
            $itemsToAdd = $this->getEAVRandomItems( 4 , $arr );
            for( $i = 0 ; $i < 2 ; ++$i ) {
                $Product = new Product;
                foreach( $veq as $keqItems => $veqItems ) {
                    $Product->$keqItems = $veqItems;
                }
                foreach( $itemsToAdd as $kItemToAdd => $vItemToAdd ) {
                    $eav = new EAV;
                    $eav->id = $kItemToAdd;
                    $eav->label = $vItemToAdd;
                    $eav->value = [ $kItemToAdd ];
                    $Product->eav[] = $eav;
                }
                if ( 'eq1' == $keq ) {
                    // одинаковые и разные eav
                    if ( 0 == $i ) { array_pop( $itemsToAdd ); };
                }
                $Product->save();
            }
        }
    }
    // http://php.net/manual/en/function.mt-rand.php#112889
    protected function mtRandStr ($l, $c = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890') {
        for ($s = '', $cl = strlen($c)-1, $i = 0; $i < $l; $s .= $c[mt_rand(0, $cl)], ++$i);
        return $s;
    }
    /**
     * Получить массив из $countItems элементов, которые случайно взять из массива $arr
     * @param number $countItems Сколько элементов брать из $arr
     * @param array $arr Массив ключ-значение, ключи не от нуля и  с "дырками"
     * @return array 
     */
    protected function getEAVRandomItems( $countItems , $arr ) {
        $ret = [];
        $count = count( $arr );
        if ( $countItems ) {
            for( $j = 0 ; $j < $countItems ; ++$j ) {
                $cur = mt_rand(0, $count);

                $i = 0;
                $found = false;
                foreach( $arr as $k => $v ) {
                    if ( $cur == $i ) {
                        $ret[$k] = $v;
                        unset( $arr[$k] );
                        $found = true;
                    }
                    ++$i;
                }
                if ( ! $found ) {
                    $ret[$k] = $v;
                    unset( $arr[$k] );
                }
            }
        }
        return $ret;
    }
    
}
