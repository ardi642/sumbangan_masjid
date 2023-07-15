<div class="container mt-4 p-5 border border-1 rounded">
  <h5 class="text-center mb-5">Tabel Data Transfer</h5>
  <div class="text-center mb-5">
    <a class="btn btn-success" 
    href="<?= base_url("transfer/tambah") ?>" role="button">
    Tambah Data Transfer
    </a>
  </div>
  <div class="table-responsive">
    <table class="table" id="tabel">
      <thead>
        <tr>
          <th class="id-transfer">ID</th>
          <th class="wakil-keluarga">wakil keluarga</th>
          <th class="nama-blok">nama blok</th>
          <th class="sub-blok">sub blok</th>
          <th class="no-rumah">no rumah</th>
          <th class="alamat">alamat</th>
          <th class="jenis-transfer">jenis transfer</th>
          <th class="label-transfer">label transfer</th>
          <th class="nominal">nominal</th>
          <th class="waktu">waktu</th>
          <th class="keterangan">keterangan</th>
          <th class="aksi">aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($transfers as $transfer) : ?>
        <tr>
          <td><?= $transfer['id_transfer'] ?></td>
          <td><?= $transfer['wakil_keluarga'] ?></td>
          <td><?= $transfer['nama_blok'] ?></td>
          <td><?= $transfer['sub_blok'] ?></td>
          <td><?= $transfer['no_rumah'] ?></td>
          <td></td>
          <td><?= $transfer['jenis_transfer'] ?></td>
          <td><?= $transfer['label_transfer'] ?></td>
          <td><?= $transfer['nominal'] ?></td>
          <td><?= $transfer['waktu'] ?></td>
          <td><?= $transfer['keterangan_transfer'] ?></td>
          <td></td>
        </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
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
      {data: "nama_blok", targets: 'nama-blok'},
      {data: "sub_blok", targets: 'sub-blok'},
      {data: "no_rumah", targets: 'no-rumah'},
      {
        targets: ['nama-blok', 'sub-blok', 'no-rumah'],
        visible: false,
        searchable: false
      },
      {
        targets: 'alamat',
        render: function(data, type, row, meta) {
          let alamat = "";
          alamat += row.nama_blok;
          
          if (row.sub_blok != "")
            alamat += `/${row.sub_blok}`

          if (row.no_rumah != "")
            alamat += ` No. ${row.no_rumah}`
            
          return alamat
        }
      },
      {
        targets: 'aksi',
        render: function(data, type, row) {
          let idTransfer = row[0]
          return `
          <div>
            <a href="<?= base_url("transfer/edit/") ?>${idTransfer}" class="btn btn-warning">Edit</a>
            <a href="<?= base_url("transfer/hapus/") ?>${idTransfer}" data-id-transfer="${idTransfer}"
            class="btn btn-danger btn-hapus">Hapus</a>
          </div>
          `
        }
      }
    ]
  });

  $(document).on('click', '.btn-hapus', async function(event) {
    event.preventDefault();
    const idTransfer = $(this).data('idTransfer');
    const result = await Swal.fire({
      title: 'Apakah anda yakin?',
      text: `Anda akan menghapus data transfer dengan id transfer ${idTransfer}`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, hapus!'
    })
    if (result.isConfirmed)
      window.location = $(this).attr('href');
  })

  <?php if ($this->session->flashdata('status') == 'sukses'): ?>
    Toast.fire({
      icon: 'success',
      timer: 3000,
      title: 'berhasil menghapus data transfer',
      text: "<?= $this->session->flashdata('pesan') ?>"
    })
  <?php endif; ?>

  <?php if ($this->session->flashdata('status') == 'gagal'): ?>
    Toast.fire({
      icon: 'error',
      timer: 3000,
      title: 'gagal menghapus data transfer',
      text: "<?= $this->session->flashdata('pesan') ?>"
    })
  <?php endif; ?>

</script>
