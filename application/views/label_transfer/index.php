<div class="container mt-4 p-5 border border-1 rounded">
  <h5 class="text-center mb-5">Tabel Label Transfer</h5>
  <div class="text-center mb-5">
    <a class="btn btn-success" 
    href="<?= base_url("label_transfer/tambah") ?>" role="button">
    Tambah Label Transfer
    </a>
  </div>
  <table class="table" id="tabel">
    <thead>
      <tr>
        <th>id label transfer</th>
        <th>label transfer</th>
        <th class="aksi">aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($label_transfers as $label_transfer) : ?>
      <tr>
        <td><?= $label_transfer['id_label_transfer'] ?></td>
        <td><?= $label_transfer['label_transfer'] ?></td>
        <td></td>
      </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</div>
<script>

  const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 1500,
    timerProgressBar: true
	})

  $('.table').dataTable({
    columnDefs: [
      {
        targets: 'aksi',
        render: function(data, type, row) {
          let idLabelTransfer = row[0]
          return `
          <div>
            <a href="<?= base_url("label_transfer/edit/") ?>${idLabelTransfer}" class="btn btn-warning">Edit</a>
            <a href="<?= base_url("label_transfer/hapus/") ?>${idLabelTransfer}" class="btn btn-danger">Hapus</a>
          </div>
          `
        }
      }
    ]
  });

  <?php if ($this->session->flashdata('status') == 'sukses'): ?>
    Toast.fire({
      icon: 'success',
      timer: 3000,
      title: 'berhasil menghapus data',
      text: "<?= $this->session->flashdata('pesan') ?>"
    })
  <?php endif; ?>

  <?php if ($this->session->flashdata('status') == 'gagal'): ?>
    Toast.fire({
      icon: 'error',
      timer: 3000,
      title: 'gagal menghapus data',
      text: "<?= $this->session->flashdata('pesan') ?>"
    })
  <?php endif; ?>

</script>
