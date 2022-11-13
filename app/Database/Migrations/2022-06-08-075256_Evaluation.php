<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Evaluation extends Migration
{
    public function up()
    {
        $forge = \Config\Database::forge();
        $this->forge->addField([
            'evaluationId' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'null' => true,
            ],
            'disiplin' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => true,
            ],
            'loyalitas' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => true,
            ],
            'kerjasama' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => true,
            ],
            'perilaku' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => true,
            ],
            'total_sikap' => [
                'type' => 'INT',
                'constraint' => 100,
                'null' => true,
            ],
            'total_percentage_sikap' => [
                'type' => 'INT',
                'constraint' => 100,
                'null' => true,
            ],
            'total_working_result' => [
                'type' => 'INT',
                'constraint' => 100,
                'null' => true,
            ],
            'total_percentage_working_result' => [
                'type' => 'INT',
                'constraint' => 100,
                'null' => true,
            ],
            'total' => [
                'type' => 'INT',
                'constraint' => 100,
                'null' => true,
            ],
            'predikat' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'evaluation_created' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        // Primary Key Table ID
        $this->forge->addKey('evaluationId', true);

        // Relations
        $this->forge->addForeignKey('user_id', 'users', 'userId');

        // Create Table Categories
        $this->forge->createTable('evaluations');
    }

    public function down()
    {
        // Drop Table Categories
        $forge = \Config\Database::forge();
        $this->forge->dropTable('evaluations');
    }
}
