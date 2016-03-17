<?php

use yii\db\Migration;

class m160316_182246_mysql_init extends Migration
{
    public function up()
    {
        $this->execute(
            "CREATE TABLE `categories` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `parent_id` int(10) unsigned DEFAULT NULL,
            `name` varchar(256) CHARACTER SET utf8 NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ");
        $this->execute("ALTER TABLE `categories` ADD CONSTRAINT `categories_parent` FOREIGN KEY (`parent_id`) REFERENCES `yii2test`.`categories`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;");
        
        $this->insert('categories', [ 'id' => 1 , 'parent_id' => null   , 'name' => 'Системы видеонаблюдения' ]);
        $this->insert('categories', [ 'id' => 2 , 'parent_id' => 1      , 'name' => 'Видеокамеры' ]);
        $this->insert('categories', [ 'id' => 3 , 'parent_id' => 2      , 'name' => 'IP-видеокамеры' ]);
        $this->insert('categories', [ 'id' => 4 , 'parent_id' => 3      , 'name' => 'IP-видеокамеры купольные' ]);
        
        $this->insert('categories', [ 'id' => 5 , 'parent_id' => 1   , 'name' => 'Системы тестовые 1' ]);
        $this->insert('categories', [ 'id' => 6 , 'parent_id' => 5   , 'name' => 'Системы тестовые 12' ]);
        $this->insert('categories', [ 'id' => 7 , 'parent_id' => 6   , 'name' => 'Системы тестовые 123' ]);
        
        $this->insert('categories', [ 'id' => 8 , 'parent_id' => 1   , 'name' => 'Системы тестовые 2' ]);
        $this->insert('categories', [ 'id' => 9 , 'parent_id' => 8   , 'name' => 'Системы тестовые 21' ]);
        $this->insert('categories', [ 'id' => 10 , 'parent_id' => 9  , 'name' => 'Системы тестовые 212' ]);
        
    }

    public function down()
    {
        echo "m160316_182246_mysql_init cannot be reverted.\n";
        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
