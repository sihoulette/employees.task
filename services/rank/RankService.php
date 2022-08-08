<?php

namespace app\services\rank;

use app\models\rank\Rank;
use yii\helpers\ArrayHelper;

/**
 * Class RankService
 *
 * @package app\services\rank
 */
class RankService
{
    /**
     * @return array
     * @author sihoullete
     */
    static public function getListOptions(): array
    {
        $ranks = Rank::find()->all();

        return ArrayHelper::map($ranks, 'id', 'name');
    }
}
