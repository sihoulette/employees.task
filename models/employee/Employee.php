<?php

namespace app\models\employee;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use app\models\rank\Rank;

/**
 * Class Employee
 *
 * @package app\models
 */
class Employee extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%employee}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['id', 'rank_id'], 'integer'],
            [['first_name', 'last_name'], 'string', 'max' => 255],
            [['date_create', 'date_update'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            [['rank_id'], 'exist', 'targetClass' => Rank::class, 'targetAttribute' => ['rank_id' => 'id']],
            [['date_update'], 'default', 'value' => null],
            [['rank_id', 'first_name', 'last_name'], 'required', 'isEmpty' => function ($value) {
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
            'rank_id' => Yii::t('attribute', 'Rank ID'),
            'first_name' => Yii::t('attribute', 'First name'),
            'last_name' => Yii::t('attribute', 'Last name'),
            'date_create' => Yii::t('attribute', 'Create'),
            'date_update' => Yii::t('attribute', 'Update'),
        ];
    }

    /**
     * @return string
     * @author sihoullete
     */
    public function getFullName(): string
    {
        return $this->first_name . '&nbsp;' . $this->last_name;
    }

    /**
     * @return ActiveQuery
     * @author sihoullete
     */
    public function getRank(): ActiveQuery
    {
        return $this->hasOne(Rank::class, ['id' => 'rank_id']);
    }
}
