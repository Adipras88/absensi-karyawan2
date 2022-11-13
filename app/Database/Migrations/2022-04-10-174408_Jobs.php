<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Jobs extends Migration
{
    public function up()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->addField([
            'jobId' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 12,
                'unsigned' => true,
                'null' => true,
            ],

            'type_of_work' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'point' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => true,
            ],
            'is_completed' => [
                'type' => 'BOOLEAN',
                'default' => false
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
        $this->forge->addKey('jobId', true);

        // Added Relation
        $this->forge->addForeignKey('user_id', 'users', 'userId');

        // Create Table Jobs
        $this->forge->createTable('jobs');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        // Drop Table Jobs
        $forge = \Config\Database::forge();
        $this->forge->dropTable('jobs');
    }
}