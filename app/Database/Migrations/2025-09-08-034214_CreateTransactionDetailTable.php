<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransactionDetailTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'transaction_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'product_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'qty' => ['type' => 'INT', 'constraint' => 11],
            'panjang' => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'lebar' => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'price_at_sale' => ['type' => 'DECIMAL', 'constraint' => '15,2'],
            'subtotal' => ['type' => 'DECIMAL', 'constraint' => '15,2'],
        ]);
        $this->forge->addKey('id', true);

        // Menambahkan Foreign Keys
        $this->forge->addForeignKey('transaction_id', 'transactions', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'RESTRICT');

        $this->forge->createTable('transaction_details');
    }

    public function down()
    {
        $this->forge->dropTable('transactions_details');
    }
}
