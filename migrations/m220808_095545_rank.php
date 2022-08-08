<?php

use yii\db\Migration;
use yii\db\Expression;

/**
 * Class m220808_101605_rank
 */
class m220808_095545_rank extends Migration
{
    /**
     * @var string $table
     */
    public string $table = 'rank';

    /**
     * @var string $tableOptions
     */
    public string $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

    /**
     * {@inheritdoc}
     * @throws \yii\db\Exception
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->bigPrimaryKey()->unsigned()->notNull()
                ->comment('ID'),
            'name' => $this->string(255)
                ->comment('Rank name'),

            'date_create' => $this->dateTime()->defaultValue(new Expression('NOW()'))
                ->comment('Date create'),
            'date_update' => $this->dateTime()->defaultValue(null)
                ->comment('Date update'),
        ], $this->tableOptions);

        // Insert data
        $this->insertData();
    }

    /**
     * @return void
     * @throws \yii\db\Exception
     * @author sihoullete
     */
    protected function insertData(): void
    {
        $data = [
            [
                1,
                'Менеджер',
            ],
            [
                2,
                'Программист',
            ],
            [
                3,
                'Тестировщик',
            ],
        ];

        Yii::$app->db->createCommand()
            ->batchInsert($this->table, [
                'id',
                'name',
            ], $data)->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);

        return true;
    }
}
