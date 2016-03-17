<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 *
 * @property Categories $parent
 * @property Categories[] $categories
 */
class Categories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Categories::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildrenCategories()
    {
        return $this->hasMany(Categories::className(), ['parent_id' => 'id']);
    }
    /**
     * 
     */
    static public function getChildrens( $id ) {
        /*
        $ret = Categories::find()
                ->from( Categories::tableName().' lev0' )
                ->select(['lev0.*', 'lev1.*' , 'lev2.*' , 'lev3.*'])
                ->leftJoin( Categories::tableName().' lev1' , 'lev1.parent_id = lev0.id' )
                ->leftJoin( Categories::tableName().' lev2' , 'lev2.parent_id = lev1.id' )
                ->leftJoin( Categories::tableName().' lev3' , 'lev3.parent_id = lev2.id' )
                ->where('lev0.id = :id' , ['id' => $id])
                ->all();
        return $ret;
         * 
         */
        $Category = Categories::findOne(['id' => $id]);
        $Childrens = $Category->getChildrenCategories()->all();
        // это способ менее производителен, чем используя leftjoin описанный выше, т.к. будет много запросов в БД
        return $Childrens;
    }
}
