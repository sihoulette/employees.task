<?php

namespace app\models\rank;

use Yii;
use yii\db\ActiveRecord;

/**
 * Class Rank
 *
 * @package app\models
 */
class Rank extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%rank}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['date_create', 'date_update'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            [['date_update'], 'default', 'value' => null],
            [['name'], 'required', 'isEmpty' => function ($value) {
                return empty($value);
            }]
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('attribute', 'ID'),
            'name' => Yii::t('attribute', 'Name'),
            'date_create' => Yii::t('attribute', 'Create'),
            'date_update' => Yii::t('attribute', 'Update'),
        ];
    }
}
