<div class="d-none" id="data" 
data-status="<?= $flashdata['status'] ?? '' ?>"
data-nama-blok="<?= $flashdata['nama_blok'] ?? '' ?>"
>
</div>
<!-- <div class="container mt-4 text-center">
  <a class="btn btn-primary" href="#" role="button">Kembali</a>
</div> -->
<div class="container mt-5 p-5 border border-1 rounded">
  <h5 class="text-center mb-4">Tabel Blok Rumah</h5>
  <div class="text-center mb-5">
    <a class="btn btn-success" 
    href="<?= base_url("blok/tambah") ?>" role="button">
    Tambah Blok Rumah
    </a>
  </div>
  <table class="table" id="tabel">
    <thead>
      <tr>
      <?php foreach ($columns as $column) : ?>
        <th><?= $column ?></th>  
      <?php endforeach ?>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($bloks as $blok) : ?>
      <tr>
        <?php 
          foreach ($columns as $column) {
            $nilai = $blok[$column];
            echo "<td>{$nilai}</td>";
          }
        ?>
        <td></td>
      </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</div>
