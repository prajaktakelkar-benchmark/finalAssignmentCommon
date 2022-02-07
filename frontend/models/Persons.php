<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%person}}".
 *
 * @property int $person_id
 * @property string $person_fname
 * @property string $person_lname
 * @property string $person_email
 * @property int $person_phone
 * @property string|null $updated_at
 * @property int $address_id
 * @property string|null $created_at
 *
 * @property Addresses $addresses
 * @property Lead[] $leads
 * @property Opportunity[] $opportunities
 */
class Persons extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%person}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['person_fname', 'person_lname', 'person_email', 'person_phone', 'address_id'], 'required'],
            [['person_phone', 'address_id'], 'integer'],
            [['updated_at', 'created_at'], 'safe'],
            [['person_email'], 'unique'],
            [['person_phone'], 'unique'],
            [['person_fname', 'person_lname', 'person_email'], 'string', 'max' => 255],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => Addresses::className(), 'targetAttribute' => ['address_id' => 'address_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'person_id' => 'Person ID',
            'person_fname' => 'Person Fname',
            'person_lname' => 'Person Lname',
            'person_email' => 'Person Email',
            'person_phone' => 'Person Phone',
            'updated_at' => 'Updated At',
            'address_id' => 'Address ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Addresses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasOne(Addresses::className(), ['address_id' => 'address_id']);
    }

    /**
     * Gets query for [[Leads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLeads()
    {
        return $this->hasMany(Lead::className(), ['person_id' => 'person_id']);
    }

    /**
     * Gets query for [[Opportunities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOpportunities()
    {
        return $this->hasMany(Opportunity::className(), ['person_id' => 'person_id']);
    }
}
