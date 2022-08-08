<?php

use yii\db\Migration;
use yii\db\Expression;

/**
 * Class m220808_095755_user
 */
class m220808_095755_employee extends Migration
{
    /**
     * @var string $table
     */
    public string $table = 'employee';

    /**
     * @var string $tableOptions
     */
    public string $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->bigPrimaryKey()->unsigned()->notNull()
                ->comment('ID'),
            'rank_id' => $this->bigInteger()->unsigned()->notNull()
                ->comment('Rank ID'),

            'first_name' => $this->string(255)
                ->comment('First name'),
            'last_name' => $this->string(255)
                ->comment('Last name'),

            'date_create' => $this->dateTime()->defaultValue(new Expression('NOW()'))
                ->comment('Date create'),
            'date_update' => $this->dateTime()->defaultValue(null)
                ->comment('Date update'),
        ], $this->tableOptions);

        $this->addForeignKey("fk_{$this->table}_rank", $this->table, 'rank_id',
            'rank', 'id', 'CASCADE', 'CASCADE');

        return true;
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
