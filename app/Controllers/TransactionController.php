<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;

class TransactionController extends BaseController
{
    protected $productModel;
    protected $transactionModel;
    protected $transactionDetailModel;
    protected $db;

    public function __construct()
    {

        $this->productModel = new ProductModel();
        $this->transactionModel = new TransactionModel();
        $this->transactionDetailModel = new TransactionDetailModel();
        $this->db = \Config\Database::connect();
    }


    public function create()
    {
        $data = $this->request->getJSON(true);

        $items = $data['items'];
        $grandTotal = 0;
        $detailItems = [];

        $this->db->transStart();

        foreach ($items as $item) {
            $product = $this->productModel->find($item['product_id']);

            if (!$product) {
                $this->db->transRollback();
                return $this->response
                    ->setStatusCode(404)
                    ->setJSON(['status' => 'error', 'message' => 'Produk dengan ID ' . $item['product_id'] . ' tidak ditemukan.']);
            }

            $subtotal = 0;
            if ($product['jenis_formula'] === 'unit') {
                $subtotal = $item['qty'] * $product['harga'];
            } elseif ($product['jenis_formula'] === 'area') {
                $subtotal = $item['panjang'] * $item['lebar'] * $product['harga'];
            }
            $grandTotal += $subtotal;
            $detailItems[] = [
                'product_id'    => $item['product_id'],
                'qty'           => $item['qty'],
                'panjang'       => $item['panjang'] ?? null,
                'lebar'         => $item['lebar'] ?? null,
                'price_at_sale' => $product['harga'],
                'subtotal'      => $subtotal,
            ];
        }

        $transactionData = [
            'user_id'       => 1,
            'customer'      => $data['customer_name'],
            'total_harga'   => $grandTotal,
            'harga_dibayar' => $data['harga_dibayar'],
        ];
        $this->transactionModel->insert($transactionData);
        $transactionId = $this->transactionModel->getInsertID();

        foreach ($detailItems as &$detail) {
            $detail['transaction_id'] = $transactionId;
        }
        $this->transactionDetailModel->insertBatch($detailItems);

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return $this->response
                ->setStatusCode(500)
                ->setJSON(['status' => 'error', 'message' => 'Gagal menyimpan transaksi.']);
        }

        return $this->response
            ->setStatusCode(201)
            ->setJSON(['status' => 'success', 'message' => 'Transaksi berhasil dibuat.', 'transaction_id' => $transactionId]);
    }
}
