<div class="d-none" id="data" 
data-status="<?= $flashdata['status'] ?? '' ?>"
data-id-keluarga="<?= $keluarga['id_keluarga'] ?? '' ?>"
data-id-blok="<?= $keluarga['id_blok'] ?? '' ?>"
data-nama-blok="<?= $keluarga['nama_blok'] ?? '' ?>"
data-id-detail-blok="<?= $keluarga['id_detail_blok'] ?? '' ?>"
data-sub-blok="<?= $keluarga['sub_blok'] ?? '' ?>"
>


</div>
<div class="container mt-4 text-center">
  <a class="btn btn-primary" href="<?= base_url('keluarga') ?>" role="button">Kembali</a>
</div>
<form action="" method="post" class="container mt-4 p-5 border border-1 rounded">
  <h5 class="text-center mb-5">Form Edit Keluarga</h5>
  <?php if (validation_errors() != ""): ?>
    <div class="alert alert-danger mb-3 p-2" role="alert">
    <?= validation_errors() ?>
    </div>
  <?php endif ?>
  <div class="mb-3">
    <label for="namaWakilKeluarga" class="form-label">Nama Wakil Keluarga</label>
    <input type="text" class="form-control" name="wakil_keluarga" id="namaWakilKeluarga" 
    placeholder="masukkan nama wakil keluarga" value="<?= $keluarga['wakil_keluarga'] ?>" required>
  </div>
  <div class="mb-3">
    <label for="id-blok" class="form-label">Blok Rumah</label>
    <select class="form-control id-blok" name="id_blok" id="id-blok" required>
    </select>
  </div>
  <div class="mb-3">
    <label for="id-detail-blok" class="form-label">Sub Blok</label>
    <select class="form-control id-detail-blok" name="id_detail_blok" id="id-detail-blok" required>
    </select>
  </div>
  <div class="mb-3">
    <label for="no-rumah" class="form-label">No Rumah (Optional)</label>
    <input type="number" class="form-control no-rumah" value="<?= $keluarga['no_rumah'] ?>"
    name="no_rumah" id="no-rumah">
  </div>
  <div class="d-grid gap-2">
    <button class="btn btn-primary" type="submit">Edit</button>
    <a class="btn btn-primary" href="">Reset</a>
  </div>
</form>
