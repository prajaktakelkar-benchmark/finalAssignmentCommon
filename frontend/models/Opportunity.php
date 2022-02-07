<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%opportunity}}".
 *
 * @property int $op_id
 * @property string $notes
 * @property int $person_id
 * @property int $lead_id
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Customer[] $customers
 * @property Lead $lead
 * @property Persons $persons
 */
class Opportunity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%opportunity}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['notes', 'person_id', 'lead_id'], 'required'],
            [['person_id', 'lead_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['notes'], 'string', 'max' => 255],
            [['lead_id'], 'exist', 'skipOnError' => true, 'targetClass' => Leads::className(), 'targetAttribute' => ['lead_id' => 'lead_id']],
            [['person_id'], 'exist', 'skipOnError' => true, 'targetClass' => Persons::className(), 'targetAttribute' => ['person_id' => 'person_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'op_id' => 'Op ID',
            'notes' => 'Notes',
            'person_id' => 'Person ID',
            'lead_id' => 'Lead ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Customers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomers()
    {
        return $this->hasMany(Customer::className(), ['op_id' => 'op_id']);
    }

    /**
     * Gets query for [[Lead]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLead()
    {
        return $this->hasOne(Lead::className(), ['lead_id' => 'lead_id']);
    }

    /**
     * Gets query for [[Person]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPersons()
    {
        return $this->hasOne(Persons::className(), ['person_id' => 'person_id']);
    }
}
