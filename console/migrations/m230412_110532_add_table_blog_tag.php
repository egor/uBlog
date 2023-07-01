<?php

use yii\db\Migration;

/**
 * Class m230412_110532_add_table_blog_tag
 */
class m230412_110532_add_table_blog_tag extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `blog_tag` (
            `id` INT NOT NULL AUTO_INCREMENT , 
            `blog_id` INT NOT NULL , 
            `tag_id` INT NOT NULL , 
            PRIMARY KEY (`id`), 
            INDEX (`blog_id`), 
            INDEX (`tag_id`)) ENGINE = InnoDB;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('blog_tag');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230412_110532_add_table_blog_tag cannot be reverted.\n";

        return false;
    }
    */
}
