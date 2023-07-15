<div class="d-none" id="data" 
data-status="<?= $flashdata['status'] ?? '' ?>"
data-nama_blok="<?= $flashdata['nama_blok'] ?? '' ?>"
>


</div>
<div class="container mt-4 text-center">
  <a class="btn btn-primary" href="<?= base_url('blok') ?>" role="button">Kembali</a>
</div>
<form action="" method="post" class="container mt-4 p-5 border border-1 rounded">
  <h5 class="text-center mb-5">Form Tambah Blok</h5>
  <?php if (validation_errors() != ""): ?>
    <div class="alert alert-danger mb-3 p-2" role="alert">
    <?= validation_errors() ?>
    </div>
  <?php endif ?>
  <div class="mb-3">
    <label for="blok" class="form-label">Blok Rumah</label>
    <input type="text" class="form-control" name="nama_blok" id="blok" placeholder="masukkan nama blok rumah">
  </div>
  <div class="d-grid gap-2">
    <button class="btn btn-primary" type="submit">Tambah</button>
    <button class="btn btn-primary" type="reset">Reset</button>
  </div>
</form>
