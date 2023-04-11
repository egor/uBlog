<?php

use yii\db\Migration;

/**
 * Class m230410_094209_add_table_blog
 */
class m230410_094209_add_table_blog extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `blog` (
            `id` INT NOT NULL AUTO_INCREMENT , 
            `url` VARCHAR(255) NOT NULL , 
            `meta_title` VARCHAR(255) NOT NULL , 
            `meta_keywords` VARCHAR(255) NOT NULL , 
            `meta_description` VARCHAR(255) NOT NULL , 
            `menu_name` VARCHAR(255) NOT NULL , 
            `header` VARCHAR(255) NOT NULL , 
            `short_text` TEXT NOT NULL , 
            `text` TEXT NOT NULL , 
            `status` SMALLINT NOT NULL , 
            `created_at` INT NOT NULL , 
            `updated_at` INT NOT NULL , 
            `displayed_at` INT NOT NULL , 
            UNIQUE (`url`) ,
            PRIMARY KEY (`id`)) ENGINE = InnoDB;");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('blog');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230410_094209_add_table_blog cannot be reverted.\n";

        return false;
    }
    */
}
