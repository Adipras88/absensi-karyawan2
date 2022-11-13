<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class QR extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'qrId' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'content' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'file' => [
                'type' => 'TEXT',
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
        $this->forge->addKey('qrId', true);

        // Create Table Categories
        $this->forge->createTable('qr');
    }

    public function down()
    {
        $this->forge->dropTable('qr');
    }
}
