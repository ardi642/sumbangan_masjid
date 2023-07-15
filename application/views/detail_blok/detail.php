<div class="d-none" id="data" 
data-status="<?= $flashdata['status'] ?? '' ?>"
data-sub-blok="<?= $flashdata['sub_blok'] ?? '' ?>"
data-sub-blok-gagal="<?= $flashdata['sub_blok_gagal'] ?? '' ?>"
>


</div>
<div class="container mt-4 text-center">
  <a class="btn btn-primary" href="<?= base_url('blok') ?>" role="button">Kembali</a>
</div>
<div class="container mt-4 p-5 border border-1 rounded">
  <div class="text-center mb-4">
    <a class="btn btn-success" 
    href="<?= base_url("/detail_blok/tambah/{$id_blok}") ?>" role="button">
    Tambah Sub Blok
    </a>
  </div>
<h5 class="text-center mb-5">Tabel Sub Blok Rumah</h5>
  <table class="table" id="tabel">
    <thead>
      <tr>
      <?php foreach ($columns as $column) : ?>
        <th><?= $column ?></th>  
      <?php endforeach ?>
      <?php if (count($columns) > 0) : ?>
        <th>Aksi</th>
      <?php endif ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($details as $detail) : ?>
      <tr>
        <?php 
          foreach ($columns as $column) {
            $nilai = $detail[$column];
            if ($nilai == "") echo "<td> - </td>";
            else echo "<td>{$nilai}</td>";
          }
        ?>
        <td></td>
      </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</div>
