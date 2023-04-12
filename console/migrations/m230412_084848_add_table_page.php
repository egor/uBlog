<?php

use yii\db\Migration;

/**
 * Class m230412_084848_add_table_page
 */
class m230412_084848_add_table_page extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `page` (
            `id` INT NOT NULL AUTO_INCREMENT , 
            `pid` int NOT NULL ,
            `url` VARCHAR(255) NOT NULL , 
            `meta_title` VARCHAR(255) NOT NULL , 
            `meta_keywords` VARCHAR(255) NOT NULL , 
            `meta_description` VARCHAR(255) NOT NULL , 
            `menu_name` VARCHAR(255) NOT NULL , 
            `header` VARCHAR(255) NOT NULL , 
            `short_text` TEXT NOT NULL , 
            `text` TEXT NOT NULL , 
            `status` SMALLINT NOT NULL , 
            `status_list` smallint NOT NULL ,
            `created_at` INT NOT NULL , 
            `updated_at` INT NOT NULL , 
            `displayed_at` INT NOT NULL , 
            `position` int NOT NULL ,
            UNIQUE (`url`) ,
            PRIMARY KEY (`id`)) ENGINE = InnoDB;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('page');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230412_084848_add_table_page cannot be reverted.\n";

        return false;
    }
    */
}
