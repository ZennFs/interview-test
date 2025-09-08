<?= $this->extend('layout/layout') ?>
<?= $this->section('css') ?>
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<?= $this->endSection('css') ?>
<?= $this->section('content') ?>

<h1><?= esc($title) ?></h1>

<?php $errors = session('errors'); ?>

<form action="/products/update/<?= esc($product['id'], 'url') ?>" method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="_method" value="PUT">

    <div>
        <label for="nama_produk">Nama Produk</label><br>
        <input type="text" name="nama_produk" value="<?= old('nama_produk', $product['nama_produk']) ?>">
        <?php if (isset($errors['nama_produk'])): ?><p class="error"><?= esc($errors['nama_produk']) ?></p><?php endif; ?>
    </div>
    <br>
    <div>
        <label for="kategori">Kategori</label><br>
        <input type="text" name="kategori" value="<?= old('kategori', $product['kategori']) ?>">
        <?php if (isset($errors['kategori'])): ?><p class="error"><?= esc($errors['kategori']) ?></p><?php endif; ?>
    </div>
    <br>
    <div>
        <label for="harga">Harga</label><br>
        <input type="number" step="0.01" name="harga" value="<?= old('harga', $product['harga']) ?>">
        <?php if (isset($errors['harga'])): ?><p class="error"><?= esc($errors['harga']) ?></p><?php endif; ?>
    </div>
    <br>
    <div>
        <label for="satuan">Satuan</label><br>
        <select name="satuan">
            <option value="kg" <?= old('satuan', $product['satuan']) == 'kg' ? 'selected' : '' ?>>Kg</option>
            <option value="gram" <?= old('satuan', $product['satuan']) == 'gram' ? 'selected' : '' ?>>Gram</option>
            <option value="m2" <?= old('satuan', $product['satuan']) == 'm2' ? 'selected' : '' ?>>m2</option>
        </select>
    </div>
    <br>
    <div>
        <label for="jenis_formula">Jenis Formula</label><br>
        <select name="jenis_formula">
            <option value="unit" <?= old('jenis_formula', $product['jenis_formula']) == 'unit' ? 'selected' : '' ?>>Unit</option>
            <option value="area" <?= old('jenis_formula', $product['jenis_formula']) == 'area' ? 'selected' : '' ?>>Area</option>
        </select>
    </div>
    <br>
    <div>
        <label for="deskripsi">Deskripsi</label><br>
        <textarea name="deskripsi"><?= old('deskripsi', $product['deskripsi']) ?></textarea>
    </div>
    <br>
    <button type="submit">Perbarui Produk</button>
</form>
<?= $this->endSection('content') ?>