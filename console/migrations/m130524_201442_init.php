<?php

use yii\db\Migration;
use common\models\User;
use common\models\Handler;
use common\models\Category;
use common\models\Trip;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // Crear user table
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'nickname' => $this->string()->notNull(),
            'handler' => $this->integer()->notNull(),
            'password_hash' => $this->string()->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'access_token' => $this->string(32)->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->datetime()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
        ], $tableOptions);

        // Initialize the user admin
        $admin = new User();
        $admin->username = 'admin';
        $admin->nickname = '管理员';
        $admin->handler = 1;
        $admin->setPassword($admin->username);
        $admin->generateAuthKey();
        $admin->enable();
        $admin->created_at = $admin->updated_at = date('Y-m-d H:i:s', time());

        $this->insert('{{%user}}',$admin->toArray());

        // Crear handler table
        $this->createTable('{{%handler}}', [
            'id' => $this->primaryKey(),
            'handler_name' => $this->string(32)->notNull(),
            'handler_trip' => $this->integer()->notNull(),
            'created_at' => $this->datetime()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
            'last_editor' => $this->integer()->notNull(),
        ], $tableOptions);

        // Initialize the handler Default
        $defaultHandler = new Handler();
        $defaultHandler->handler_name = '默认经手人';
        $defaultHandler->trip = 1;
        $defaultHandler->created_at = $defaultHandler->updated_at = date('Y-m-d H:i:s', time());
        $defaultHandler->last_editor = 1;

        $this->insert('{{%handler}}',$defaultHandler->toArray());

        // Crear category table
        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
            'category_name' => $this->string(32)->notNull(),
            'category_sequence' => $this->integer()->notNull(),
            'created_at' => $this->datetime()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
            'last_editor' => $this->integer()->notNull(),
        ], $tableOptions);

        // Initialize the category Default
        $defaultCategory = new Category();
        $defaultCategory->category_name = '默认分类';
        $defaultCategory->category_sequence = 1;
        $defaultCategory->created_at = $defaultCategory->updated_at = date('Y-m-d H:i:s', time());
        $defaultCategory->last_editor = 1;

        $this->insert('{{%category}}',$defaultCategory->toArray());

        // Crear trip table
        $this->createTable('{{%trip}}', [
            'id' => $this->primaryKey(),
            'trip_name' => $this->string(32)->notNull(),
            'trip_sequence' => $this->integer()->notNull(),
            'created_at' => $this->datetime()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
            'last_editor' => $this->integer()->notNull(),
        ], $tableOptions);

        // Initialize the trip Default
        $defaultTrip = new Trip();
        $defaultTrip->trip_name = '出差项目';
        $defaultTrip->trip_sequence = 1;
        $defaultTrip->created_at = $defaultTrip->updated_at = date('Y-m-d H:i:s', time());
        $defaultTrip->last_editor = 1;

        $this->insert('{{%trip}}',$defaultTrip->toArray());

        // Crear expenses table
        $this->createTable('{{%expenses}}', [
            'id' => $this->primaryKey(),
            'expenses_item' => $this->string(32)->notNull(),
            'expenses_city' => $this->string(32)->notNull(),
            'expenses_category' => $this->integer()->notNull(),
            'expenses_trip' => $this->integer()->notNull(),
            'expenses_money' => $this->decimal(8,2)->notNull(),
            'expenses_date' => $this->date()->notNull(),
            'expenses_handler' => $this->integer()->notNull(),
            'expenses_receipt' => $this->integer()->notNull(),
            'expenses_remark' => $this->string(255)->notNull(),
            'created_at' => $this->datetime()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
            'last_editor' => $this->integer()->notNull(),
        ], $tableOptions);

        // Crear recycle table
        $this->createTable('{{%recycle}}', [
            'id' => $this->primaryKey(),
            'recycle_type' => $this->string(32)->notNull(),
            'recycle_content' => $this->string(512)->notNull(),
            'created_at' => $this->datetime()->notNull(),
            'last_editor' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%handler}}');
        $this->dropTable('{{%category}}');
        $this->dropTable('{{%trip}}');
        $this->dropTable('{{%expenses}}');
        $this->dropTable('{{%recycle}}');
    }
}
