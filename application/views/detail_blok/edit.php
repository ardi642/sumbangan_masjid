<div class="d-none" id="data" 
data-status="<?= $status ?? '' ?>"
data-sub_blok_awal="<?= $sub_blok_awal ?? '' ?>"
data-sub_blok_sekarang="<?= $sub_blok_sekarang ?? '' ?>"
>


</div>
<div class="container mt-4 text-center">
  <a class="btn btn-primary" href="<?= base_url("detail_blok/detail/{$id_blok}") ?>" role="button">Kembali</a>
</div>
<form action="" method="post" class="container mt-4 p-5 border border-1 rounded">
  <h5 class="text-center mb-5">Form Edit Blok</h5>
  <?php if (validation_errors() != ""): ?>
    <div class="alert alert-danger mb-3 p-2" role="alert">
    <?= validation_errors() ?>
    </div>
  <?php endif ?>
  <div class="mb-3">
    <label for="blok" class="form-label">Nama Blok</label>
    <input type="text" class="form-control" disabled value=<?= $nama_blok ?>>
  </div>
  <div class="mb-3">
    <label for="subBlok" class="form-label">Sub Blok</label>
    <input type="text" class="form-control" name="sub_blok" id="subBlok" 
    value="<?= $sub_blok_sekarang ?>" placeholder="masukkan sub blok">
  </div>
  <div class="d-grid gap-2">
    <button class="btn btn-primary" type="submit">Edit</button>
    <a class="btn btn-primary" href="">Reset</a>
  </div>
</form>
