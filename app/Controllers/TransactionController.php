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


    public function index()
    {
        $data = [
            'title'    => 'Riwayat Transaksi',
            'transactions' => $this->transactionModel
                ->select('transactions.*, users.username as cashier_name')
                ->join('users', 'users.id = transactions.user_id', 'left')
                ->orderBy('transactions.created_at', 'DESC')
                ->findAll()
        ];
        return view('page/transaction', $data);
    }

    public function create($productId)
    {
        $product = $this->productModel->find($productId);
        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        $rules = [
            'qty'           => 'required|numeric|greater_than[0]',
            'customer_name' => 'required|min_length[3]',
            'harga_dibayar' => 'required|numeric',
        ];
        if ($product['jenis_formula'] === 'area') {
            $rules['panjang'] = 'required|numeric|greater_than[0]';
            $rules['lebar']   = 'required|numeric|greater_than[0]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $subtotal = 0;
        if ($product['jenis_formula'] === 'unit') {
            $subtotal = $this->request->getPost('qty') * $product['harga'];
        } else {
            $subtotal = $this->request->getPost('panjang') * $this->request->getPost('lebar') * $product['harga'];
        }

        $this->db->transStart();
        $this->transactionModel->insert([
            'user_id'       => 1,
            'customer'      => $this->request->getPost('customer_name'),
            'total_harga'   => $subtotal,
            'harga_dibayar' => $this->request->getPost('harga_dibayar'),
        ]);

        $transactionId = $this->transactionModel->getInsertID();
        $this->transactionDetailModel->insert([
            'transaction_id' => $transactionId,
            'product_id'    => $product['id'],
            'qty'           => $this->request->getPost('qty'),
            'panjang'       => $this->request->getPost('panjang') ?? null,
            'lebar'         => $this->request->getPost('lebar') ?? null,
            'price_at_sale' => $product['harga'],
            'subtotal'      => $subtotal,
        ]);

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan transaksi.');
        }
        return redirect()->to('/transactions')->with('message', 'Transaksi berhasil disimpan.');
    }
    public function show($id)
    {
        $transaction = $this->transactionModel
            ->select('transactions.*, users.username as cashier_name')
            ->join('users', 'users.id = transactions.user_id', 'left')
            ->find($id);

        if (!$transaction) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Transaksi tidak ditemukan.');
        }

        $details = $this->transactionDetailModel
            ->select('transaction_details.*, products.nama_produk')
            ->join('products', 'products.id = transaction_details.product_id', 'left')
            ->where('transaction_id', $id)
            ->findAll();

        $data = [
            'title'       => 'Detail Transaksi: ' . $transaction['id'],
            'transaction' => $transaction,
            'details'     => $details
        ];

        return view('page/transactionDetail', $data);
    }
    public function delete($id)
    {
        $transaction = $this->transactionModel->find($id);
        if (!$transaction) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Transaksi tidak ditemukan.');
        }

        $this->transactionModel->delete($id);

        session()->setFlashdata('message', 'Transaksi berhasil dihapus.');
        return redirect()->to('/transactions');
    }
}
