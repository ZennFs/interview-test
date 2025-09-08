<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransactionTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'customer' => ['type' => 'VARCHAR', 'constraint' => 255],
            'total_harga' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0.00],
            'harga_dibayar' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0.00],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);

        // Menambahkan Foreign Keys
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'RESTRICT');

        $this->forge->createTable('transactions');
    }

    public function down()
    {
        $this->forge->dropTable('transactions');
    }
}
