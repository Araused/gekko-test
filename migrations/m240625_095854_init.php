<?php

use yii\db\Migration;

/**
 * Class m240625_095854_init
 */
class m240625_095854_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('html', [
            'id' => $this->primaryKey(),
            'file' => $this->string()->notNull(),
            'data' => $this->text()->defaultValue('[]'),
            'uploaded_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('html');
    }
}
