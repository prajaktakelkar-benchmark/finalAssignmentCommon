<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%addresses}}".
 *
 * @property int $address_id
 * @property string $city
 * @property string $state
 * @property string $country
 *
 * @property Person[] $persons
 */
class Addresses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'addresses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city', 'state', 'country'], 'required'],
            [['city', 'state', 'country'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'address_id' => 'Address ID',
            'city' => 'City',
            'state' => 'State',
            'country' => 'Country',
        ];
    }

    /**
     * Gets query for [[Persons]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Persons::className(), ['person_id' => 'person_id']);
    }
}
