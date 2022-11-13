<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EvaluationJobResults extends Migration
{
    public function up()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->addField([
            'jobResultsId' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'evaluation_id' => [
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
            'job_score' => [
                'type' => 'INT',
                'constraint' => 12,
                'unsigned' => true,
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
        $this->forge->addKey('jobResultsId', true);

        // Added Relation
        $this->forge->addForeignKey('evaluation_id', 'evaluations', 'evaluationId');
        $this->forge->addForeignKey('job_id', 'jobs', 'jobId');

        // Create Table Attendance
        $this->forge->createTable('evaluation_job_results');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        // Drop Table Attendance
        $forge = \Config\Database::forge();
        $this->forge->dropTable('evaluation_job_results');
    }
}
