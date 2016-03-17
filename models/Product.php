<?php

namespace app\models;

use Yii;

/**
 * This is the model class for collection "product".
 *
 * @property \MongoId|string $_id
 * @property mixed $category_id
 * @property mixed $item_number
 * @property mixed $brand_id
 * @property mixed $name
 * @property mixed $alias
 * @property mixed $price_wholesale
 * @property mixed $not_produced
 * @property mixed $site_status
 * @property array $eav
 */
class Product extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return ['yii2test', 'product'];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'category_id',
            'item_number',
            'brand_id',
            'name',
            'alias',
            'price_wholesale',
            'not_produced',
            'site_status',
            '_eav',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'item_number', 'brand_id', 'name', 'alias', 'price_wholesale', 'not_produced', 'site_status'], 'safe'],
            [['eav'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'category_id' => 'Category ID',
            'item_number' => 'Item Number',
            'brand_id' => 'Brand ID',
            'name' => 'Name',
            'alias' => 'Alias',
            'price_wholesale' => 'Price Wholesale',
            'not_produced' => 'Not Produced',
            'site_status' => 'Site Status',
            'eav' => 'Eav',
        ];
    }
    public function behaviors() {
        return [
            'eav' => [
                'class' => \consultnn\embedded\EmbedsManyBehavior::className(),
                'attribute' => '_eav',
                'embedded' => \app\models\EAV::className()
            ],    
        ];
    }
    public function getEAVtoString() {
        $ret = '';
        foreach( $this->eav as $item ) {
            $ret .= "id=[{$item->id}],label=[{$item->label}],value=[".implode(';',$item->value)."]<br/>";
                    
        }
        return $ret;
    }
    /**
     * Реализовать метод в модели для коллекции product, который отберёт товары, у которых разнится один атрибут (то есть товары идентичны, за исключением одного параметра-атрибута из объекта 'eav')
     */
    static public function getHalfEqualItems() {
        $ret = [];
        $arrProducts = static::find()->all();
        Yii::info("getHalfEqualItems count arrProducts=[".count( $arrProducts )."]");
        $arr = [];
        // наполнение аналогом GROUP BY
        foreach( $arrProducts as $k => $Product ) {
            $hash = $Product->HashOfProduct;
            if ( ! isset( $arr[ $hash ] ) ) {
                $arr[ $hash ] = [ $k ];
            } else {
                $arr[ $hash ][] = $k;
            }
        }
        // По результатам обработка только если совпадений > 1
        foreach( $arr as $k => $v ) {
            $countV = count( $v );
            if ( 1 == $countV ) {
                // если дублей нет, то удаляем из массива, чтобы память не использовал
                unset( $arr[ $k ] );
            } else if ( $countV > 1 ){
                // найти совпадения eav
                $countHalf = floor( $countV / 2 );
                for( $i = 0 ; $i < $countHalf ; ++$i ) {
                    for( $j = $i + 1 ; $j < $countV ; ++$j ) {
                        if ( ! static::isEAVEqual($arrProducts[ $v[$i] ], $arrProducts[ $v[$j] ]) ) {

                            $ret[] = $arrProducts[ $v[$i] ];
                            $ret[] = $arrProducts[ $v[$j] ];
                        }
                    }
                }
            }
        }
        Yii::info("getHalfEqualItems count ret=[".count( $ret )."]");
        return $ret;
    }
    /**
     * Метод для уникализации объекта Product, сделано по хешу от полей
     * @return type Хеш от значений полей, кроме eav
     */
    protected function getHashOfProduct() {
        $ret = $this->name.$this->alias.$this->brand_id.$this->category_id.$this->price_wholesale.$this->item_number.$this->not_produced.$this->site_status;
        $ret = md5( $ret );
        return $ret;
    }
    /**
     * Сравнение атррибута eav для product, сейчас сравнивает только по кол-ву элементов в массиве. Если надо по содержимому, то сделаю по нему.
     * @param \app\models\Product $product1 Продукт 1
     * @param \app\models\Product $product2 Продукт 2
     * @return boolean true - совпадают, false - есть различия
     */
    static protected function isEAVEqual( \app\models\Product $product1 , \app\models\Product $product2 ) {
        $ret = true;
        $count1 = count( $product1->eav );
        $count2 = count( $product2->eav );
        if ( $count1 != $count2 ) { $ret = false; }
        
        return $ret;
    }
}
