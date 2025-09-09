<?= $this->extend('layout/layout') ?>
<?= $this->section('css') ?>
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<?= $this->endSection('css') ?>
<?= $this->section('content') ?>

<h1><?= esc($title) ?></h1>

<?php $errors = session('errors'); ?>

<form action="/transactions/create/<?= esc($product['id'], 'url') ?>" method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="_method" value="PUT">

    <div>
        <label for="nama_produk">Nama Produk</label><br>
        <span><?= $product['nama_produk'] ?></span>
    </div>
    <br>
    <div>
        <label for="satuan">Satuan</label><br>
        <span><?= $product['satuan'] ?></span>
    </div>
    <br>
    <div>
        <label for="customer_name">Nama Customer</label><br>
        <input type="text" id="customer_name" name="customer_name">
        <?php if (isset($errors['customer_name'])): ?><p class="error"><?= esc($errors['customer_name']) ?></p><?php endif; ?>
    </div>
    <br>
    <div>
        <label for="qty">Quantity</label><br>
        <input type="number" id="qty" name="qty">
        <?php if (isset($errors['qty'])): ?><p class="error"><?= esc($errors['qty']) ?></p><?php endif; ?>
    </div>
    <br>
    <div>
        <?php if ($product['jenis_formula'] == 'area') { ?>

            <div>
                <label for="panjang">Panjang</label><br>
                <input type="number" name="panjang">
                <?php if (isset($errors['panjang'])): ?><p class="error"><?= esc($errors['panjang']) ?></p><?php endif; ?>
            </div>
            <br>
            <div>
                <label for="lebar">Lebar</label><br>
                <input type="number" name="lebar">
                <?php if (isset($errors['lebar'])): ?><p class="error"><?= esc($errors['lebar']) ?></p><?php endif; ?>
            </div>
            <br>
        <?php } else {
        } ?>
    </div>
    <br>
    <div>
        <label for="qty">Dibayar</label><br>
        <input type="number" id="harga_dibayar" name="harga_dibayar">
        <?php if (isset($errors['harga_dibayar'])): ?><p class="error"><?= esc($errors['harga_dibayar']) ?></p><?php endif; ?>
    </div>
    <br>
    <button type="submit">Order Produk</button>
</form>
<?= $this->endSection('content') ?>