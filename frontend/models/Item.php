<?php

namespace frontend\models;

use Yii;


/**
 * This is the model class for table "item".
 *
 * @property int $id
 * @property string $name
 * @property int $price
 * @property int $category_id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $updated_by
 *
 * @property ItemCategory $category
 */
class Item extends \yii\db\ActiveRecord
{
    public $upload;
    public function behaviors() 
    { 
        return [ 
            \yii\behaviors\BlameableBehavior::className(), 
            \yii\behaviors\TimestampBehavior::className() 
        ]; 
    } 
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price', 'category_id'], 'required'],
            [['price', 'category_id', 'created_at', 'updated_at', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['upload'], 'file', 'extensions' => ['png', 'jpg']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ItemCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'price' => 'Price',
            'category_id' => 'Category ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',   
            'updated_by' => 'Updated By',
            'upload' => 'Item Preview',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ItemCategory::className(), ['id' => 'category_id']);
    }

    public function getPriceRupiah(){
        return 'Rp'.number_format($this->price, 2, ',', '.');
    }

    public function getImagePre(){
        if(!$pic = $this->picture){
            $pic = 'uploads/no_pic.jpg'; 
        }
        return Yii::$app->request->hostInfo.'/TokoBaruGede/frontend/web/'.$pic;
    }

    
}
