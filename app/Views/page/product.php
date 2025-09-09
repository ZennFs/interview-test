<?= $this->extend('layout/layout') ?>
<?= $this->section('css') ?>
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<?= $this->endSection('css') ?>
<?= $this->section('content') ?>

<h1><?= esc($title) ?></h1>

<?php if (session()->getFlashdata('message')) : ?>
    <div class=""><?= session()->getFlashdata('message'); ?></div>
<?php endif; ?>

<a href="/addProduct">Tambah Produk Baru</a>
<hr>

<table class="table-auto ">
    <thead class="p-4">
        <tr>
            <th rowspan="2">Nama Produk</th>
            <th class="ml-3">Kategori</th>
            <th>Harga</th>
            <th>Satuan</th>
            <th>jenis formula</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product): ?>
            <tr>
                <?php if ($product < 0) { ?>
                    <td> produk tidak ditemukan</td>
                <?php }; ?>
                <td><?= esc($product['nama_produk']) ?></td>
                <td><?= esc($product['kategori']) ?></td>
                <td><?= esc($product['harga']) ?></td>
                <td><?= esc($product['satuan']) ?></td>
                <td><?= esc($product['jenis_formula']) ?></td>
                <td>
                    <a href="/products/edit/<?= esc($product['id'], 'url') ?>" class="action-btn">Edit</a>
                    <form action="/products/delete/<?= esc($product['id'], 'url') ?>" method="post" style="display:inline;">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">Hapus</button>
                    </form>
                    <a href="/products/transaction/<?= esc($product['id'], 'url') ?>" class="action-btn">Transaction</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>