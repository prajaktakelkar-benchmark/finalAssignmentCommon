<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%lead}}".
 *
 * @property int $lead_id
 * @property string $notes
 * @property string|null $updated_at
 * @property int $person_id
 * @property string|null $created_at
 *
 * @property Opportunity[] $opportunities
 * @property Persons $persons
 */
class Leads extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%lead}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['notes'], 'required'],
            // [['updated_at', 'created_at'], 'safe'],
            [['person_id'], 'integer'],
            [['notes'], 'string', 'max' => 255],
            [['person_id'], 'exist', 'skipOnError' => true, 'targetClass' => Persons::className(), 'targetAttribute' => ['person_id' => 'person_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'lead_id' => 'Lead ID',
            'notes' => 'Notes',
            'updated_at' => 'Updated At',
            'person_id' => 'Person ID',
            'created_at' => 'Created At',
            'is_deleted' => 'Status',
        ];
    }

    /**
     * Gets query for [[Opportunities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOpportunities()
    {
        return $this->hasMany(Opportunity::className(), ['lead_id' => 'lead_id']);
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
