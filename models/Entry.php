<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "entry".
 *
 * @property string $id
 * @property int $internal_id
 * @property string|null $last_modify
 * @property string|null $regulator
 */
class Entry extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'entry';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'internal_id'], 'required'],
            [['id', 'regulator'], 'string'],
            [['internal_id'], 'integer'],
            [['last_modify'], 'safe'],
            [['internal_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'internal_id' => 'Internal ID',
            'last_modify' => 'Last Modify',
            'regulator' => 'Regulator',
        ];
    }
}
