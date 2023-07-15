<div class="d-none" id="data" 
data-status="<?= $flashdata['status'] ?? '' ?>"
data-wakil-keluarga="<?= $flashdata['wakil_keluarga'] ?? '' ?>"
>
</div>

<div class="container mt-4 p-5 border border-1 rounded">
  <h5 class="text-center mb-5">Tabel Keluarga</h5>
  <div class="text-center mb-5">
    <a class="btn btn-success" 
    href="<?= base_url("keluarga/tambah") ?>" role="button">
    Tambah Data Keluarga
    </a>
  </div>
  <table class="table" id="tabel">
    <thead>
      <tr>
      <?php foreach ($columns as $column) : ?>
        <th><?= $column ?></th>  
      <?php endforeach ?>
      <?php if (count($keluargas) > 0 ) : ?>
        <th>Aksi</th>
      <?php endif ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($keluargas as $keluarga) : ?>
      <tr>
        <?php 
          foreach ($columns as $column) {
            $nilai = $keluarga[$column];
            if ($nilai == "") echo "<td>-</td>";
            else echo "<td>{$nilai}</td>";
          }
          ?>
          <?php if (count($keluargas) > 0 ) : ?>
            <td></td>
          <?php endif ?>
      </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</div>
