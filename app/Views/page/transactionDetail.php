<?= $this->extend('layout/layout') ?>
<?= $this->section('css') ?>
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<?= $this->endSection('css') ?>
<?= $this->section('content') ?>

<div class="">
    <table>
        <tr class="">
            <td colspan="4">
                <table>
                    <tr>
                        <td>
                            <h2>Detail Transaksi</h2>
                        </td>
                        <td class="text-right">
                            <strong>ID Transaksi:</strong> #<?= esc($transaction['id']) ?><br>
                            <strong>Tanggal:</strong> <?= esc($transaction['created_at']) ?><br>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <strong>Customer:</strong> <?= esc($transaction['customer']) ?><br>
                <strong>Kasir:</strong> <?= esc($transaction['cashier_name'] ?? 'N/A') ?>
            </td>
        </tr>
        <tr class="">
            <td>Produk</td>
            <td class="text-right">Kuantitas</td>
            <td class="text-right">Harga Satuan</td>
            <td class="text-right">Subtotal</td>
        </tr>

        <?php foreach ($details as $item): ?>
            <tr class="item">
                <td><?= esc($item['nama_produk']) ?></td>
                <td class="text-right"><?= esc($item['qty']) ?></td>
                <td class="text-right"><?= esc(number_format($item['price_at_sale'], 2, ',', '.')) ?></td>
                <td class="text-right"><?= esc(number_format($item['subtotal'], 2, ',', '.')) ?></td>
            </tr>
        <?php endforeach; ?>

        <tr class="total">
            <td colspan="3" class="text-right"><strong>Total</strong></td>
            <td class="text-right"><strong><?= esc(number_format($transaction['total_harga'], 2, ',', '.')) ?></strong></td>
        </tr>
        <tr class="total">
            <td colspan="3" class="text-right">Dibayar</td>
            <td class="text-right"><?= esc(number_format($transaction['harga_dibayar'], 2, ',', '.')) ?></td>
        </tr>
    </table>
    <br>
    <a href="/transactions">Kembali ke Daftar Transaksi</a>
</div>
<?= $this->endSection('content') ?>