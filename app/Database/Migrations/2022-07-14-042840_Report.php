<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Report extends Migration
{
    public function up()
    {
        $forge = \Config\Database::forge();
        $this->forge->addField([
            'reportId' => [
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
            'job_id' => [
                'type' => 'INT',
                'constraint' => 12,
                'unsigned' => true,
                'null' => true,
            ],
            'total' => [
                'type' => 'INT',
                'type' => 'TEXT',
                'null' => true,
            ],
            'description_report' => [
                'type' => 'INT',
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_report' => [
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
        $this->forge->addKey('reportId', true);

        // Relations
        $this->forge->addForeignKey('user_id', 'users', 'userId');
        $this->forge->addForeignKey('job_id', 'jobs', 'jobId');

        // Create Table Categories
        $this->forge->createTable('reports');
    }

    public function down()
    {
        // Drop Table Categories
        $forge = \Config\Database::forge();
        $this->forge->dropTable('reports');
    }
}
