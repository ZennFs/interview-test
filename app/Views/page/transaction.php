<?= $this->extend('layout/layout') ?>
<?= $this->section('css') ?>
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<?= $this->endSection('css') ?>
<?= $this->section('content') ?>
<h1><?= esc($title) ?></h1>

<?php if (session()->getFlashdata('message')) : ?>
    <div class="alert"><?= session()->getFlashdata('message'); ?></div>
<?php endif; ?>
<hr>

<table>
    <thead>
        <tr>
            <th>ID Transaksi</th>
            <th>Waktu</th>
            <th>Customer</th>
            <th>Kasir</th>
            <th>Total Harga</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($transactions as $trx): ?>
            <tr>
                <td><?= esc($trx['id']) ?></td>
                <td><?= esc($trx['created_at']) ?></td>
                <td><?= esc($trx['customer']) ?></td>
                <td><?= esc($trx['cashier_name'] ?? 'N/A') ?></td>
                <td><?= esc(number_format($trx['total_harga'], 2, ',', '.')) ?></td>
                <td>
                    <a href="/transactions/show/<?= esc($trx['id'], 'url') ?>">Lihat Detail</a>
                    <form action="/transactions/delete/<?= esc($trx['id'], 'url') ?>" method="post" style="display:inline; margin-left: 10px;">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini? Ini tidak bisa dibatalkan.');">Hapus</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>