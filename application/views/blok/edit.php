<div class="d-none" id="data" 
data-status="<?= $status ?? '' ?>"
data-nama_blok_awal="<?= $nama_blok_awal ?? '' ?>"
data-nama_blok_sekarang="<?= $nama_blok_sekarang ?? '' ?>"
>


</div>
<div class="container mt-4 text-center">
  <a class="btn btn-primary" href="<?= base_url('blok') ?>" role="button">Kembali</a>
</div>
<form action="" method="post" class="container mt-4 p-5 border border-1 rounded">
  <h5 class="text-center mb-5">Form Edit Blok</h5>
  <?php if (validation_errors() != ""): ?>
    <div class="alert alert-danger mb-3 p-2" role="alert">
    <?= validation_errors() ?>
    </div>
  <?php endif ?>
  <div class="mb-3">
    <label for="blok" class="form-label">Blok Rumah</label>
    <input type="text" class="form-control" name="nama_blok" id="blok" 
    value="<?= set_value('nama_blok', $nama_blok_sekarang) ?>" placeholder="masukkan nama blok rumah">
  </div>
  <div class="d-grid gap-2">
    <button class="btn btn-primary" type="submit">Edit</button>
    <a class="btn btn-primary" href="">Reset</a>
  </div>
</form>
