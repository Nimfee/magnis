<?php

use yii\db\Migration;

/**
 * Class m190320_133835_init_add_tables
 */
class m190320_133835_init_add_tables extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('{{%students}}', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string()->notNull(),
            'last_name' => $this->string()->notNull(),
            'age' => $this->integer()->notNull(),
            'group' => $this->integer()->notNull(),
        ]);
        $this->createTable('{{%classes}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'room' => $this->string()->notNull(),
            'day' => $this->integer()->notNull(),
            'starting_hours' => $this->time()->notNull(),
        ]);
        $this->createTable('{{%teachers}}', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string()->notNull(),
            'last_name' => $this->string()->notNull(),
            'job_title' => $this->string()->notNull(),
            'age' => $this->string()->notNull(),
        ]);
        $this->createTable('{{%students_classes}}', [
            'student_id' => $this->integer(),
            'class_id' => $this->integer(),
            'PRIMARY KEY(student_id, class_id)'
        ]);
        $this->createIndex('idx-students_classes-student_id', '{{%students_classes}}', 'student_id');
        $this->createIndex('idx-students_classes-class_id', '{{%students_classes}}', 'class_id');

        $this->addForeignKey('fk_students_classes_to_student', '{{%students_classes}}', 'student_id', '{{%students}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_students_classes_to_class', '{{%students_classes}}', 'class_id', '{{%classes}}', 'id', 'CASCADE');
    }

    public function down()
    {

    }
}
