<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use CodeIgniter\HTTP\ResponseInterface;

class ProductController extends BaseController
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }
    public function index()
    {
        $data = [
            'title'    => 'Manajemen Produk',
            'products' => $this->productModel->findAll()
        ];
        return view('page/product', $data);
    }

    public function new()
    {
        $data = [
            'title' => 'Tambah Produk Baru',
            'validation' => \Config\Services::validation()
        ];
        return view('page/addProduct', $data);
    }

    public function create()
    {

        $rules = [
            'nama_produk' => 'required|min_length[3]|is_unique[products.nama_produk]',
            'kategori'    => 'required',
            'harga'       => 'required|numeric',
            'satuan'      => 'required|in_list[kg,gram,m2]',
            'jenis_formula' => 'required|in_list[unit,area]'
        ];

        if (!$this->validate($rules)) {

            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->productModel->save([
            'nama_produk'   => $this->request->getPost('nama_produk'),
            'kategori'      => $this->request->getPost('kategori'),
            'harga'         => $this->request->getPost('harga'),
            'satuan'        => $this->request->getPost('satuan'),
            'jenis_formula' => $this->request->getPost('jenis_formula'),
            'deskripsi'     => $this->request->getPost('deskripsi'),
        ]);

        session()->setFlashdata('message', 'Produk berhasil ditambahkan.');
        return redirect()->to('/products');
    }
    public function edit($id)
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk tidak ditemukan.');
        }

        $data = [
            'title'   => 'Edit Produk',
            'product' => $product,
            'validation' => \Config\Services::validation()
        ];
        return view('page/editProduct', $data);
    }
    public function productDetail($id)
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk tidak ditemukan.');
        }
        // var_dump($product);
        // exit;

        $data = [
            'title'   => 'ORDER ' . $product['nama_produk'],
            'product' => $product,
            'validation' => \Config\Services::validation()
        ];
        return view('page/addTransaction', $data);
    }

    public function update($id)
    {
        $rules = [
            'nama_produk' => "required|min_length[3]|is_unique[products.nama_produk,id,{$id}]",
            'kategori'    => 'required',
            'harga'       => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->productModel->update($id, [
            'nama_produk'   => $this->request->getPost('nama_produk'),
            'kategori'      => $this->request->getPost('kategori'),
            'harga'         => $this->request->getPost('harga'),
            'satuan'        => $this->request->getPost('satuan'),
            'jenis_formula' => $this->request->getPost('jenis_formula'),
            'deskripsi'     => $this->request->getPost('deskripsi'),
        ]);

        session()->setFlashdata('message', 'Produk berhasil diperbarui.');
        return redirect()->to('/products');
    }

    public function delete($id)
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk tidak ditemukan.');
        }

        $this->productModel->delete($id);
        session()->setFlashdata('message', 'Produk berhasil dihapus.');
        return redirect()->to('/products');
    }
}
