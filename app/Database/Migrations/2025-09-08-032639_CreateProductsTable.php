<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_produk' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'kategori' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'satuan' => [
                'type'       => 'ENUM',
                'constraint'     => ['kg', 'gram', 'm2'],
                'default'        => 'gram',
            ],
            'jenis_formula' => [
                'type'       => 'ENUM',
                'constraint'     => ['unit', 'area'],
                'default'        => 'unit',
            ],
            'harga' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'deskripsi' => [
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
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('products');
    }

    public function down()
    {
        $this->forge->dropTable('products');
    }
}
