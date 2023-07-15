<div class="container mt-4 p-5 border border-1 rounded">
  <h5 class="text-center mb-5">Tabel Data Transfer</h5>
  <div class="text-center mb-5">
    <a class="btn btn-success" 
    href="<?= base_url('transfer/tambah') ?>" role="button">
    Tambah Data Transfer
    </a>
  </div>
  <form action="" method="post" class=" mb-3" x-data>
    <input type="hidden" name="label_transfer" x-model="$store.pencarian.label_transfer" id="label-transfer">
    <h5 class="text">Pencarian : </h5>
    <div class="row g-3 align-items-center">
      <div class="col-6">
        <div class="row g-3 align-items-center">
          <div class="col-auto">mulai dari tanggal</div>
          <div class="col-auto">
            <input type="date" class="form-control" name="tanggal_dari" x-model="$store.pencarian.tanggal_dari">
          </div>
          <div class="col-auto">Sampai</div>
          <div class="col-auto">
          <input type="date" class="form-control" name="tanggal_sampai" x-model="$store.pencarian.tanggal_sampai">
          </div>
        </div>
      </div>
      <div class="col-6">
        <div class="row g-3 align-items-center">
          <div class="col-6">
            <div class="mb-3">
              <label class="form-label">jenis transfer</label>
              <select name="jenis_transfer" class="form-control" id="jenis-transfer" x-model="$store.pencarian.jenis_transfer">
                <option value=""></option>
                <option value="sumbangan">sumbangan</option>
                <option value="pengeluaran">pengeluaran</option>
              </select>
            </div>
          </div>
          <div class="col-6">
            <div class="mb-3">
              <label class="form-label">label transfer</label>
              <select class="form-control" name="id_label_transfer" 
              id="id-label-transfer">
              <?php if ($id_label_transfer != "") : ?>
                <option value="<?= $id_label_transfer ?>"><?= $label_transfer ?></option>
              <?php endif ?>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="d-flex justify-content-end">
      <a class="btn btn-primary me-2" href="">reset pencarian</a>
      <button class="btn btn-primary">lakukan pencarian</button>
    </div>
  </form>
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
  <?php if ($tanggal_dari == '' and $tanggal_sampai == '') : ?>
    <div>Total Nominal Keseluruhan : Rp. <?= $total_nominal ?></div>
    <?php else : ?>
    <div>
      <div>Rentang Waktu : </div>
      <div>mulai dari tanggal : <?= $tanggal_dari != '' ? $tanggal_dari : '(tidak ditentukan)' ?>
      sampai tanggal : <?= $tanggal_sampai != '' ? $tanggal_sampai : '(tidak ditentukan)' ?>
      </div>
      <div>Total Nominal : Rp. <?= $total_nominal ?></div>
    </div>
    <?php endif ?>
</div>
<script>

  document.addEventListener('alpine:init', () => {
    
    Alpine.store('pencarian', {
			tanggal_dari: "<?= $tanggal_dari ?>",
      tanggal_sampai: "<?= $tanggal_sampai ?>",
			jenis_transfer: "<?= $jenis_transfer ?>",
			id_label_transfer: "<?= $id_label_transfer ?>",
      label_transfer: "<?= $label_transfer ?>",
    })

    $("#jenis-transfer").val("<?= $jenis_transfer ?>").trigger('change');
	})

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

  $("#jenis-transfer").select2({
    placeholder: "pilih jenis transfer",
    allowClear: true
  })

  $("#id-label-transfer").select2({
	placeholder: "pilih label transfer",
	allowClear: true,
	ajax: {
		url: `<?= base_url() ?>api/get_label_transfer`,
		delay: 250,
		dataType: "json",
		processResults: function (data) {
			// Transforms the top-level key of the response object from 'items' to 'results'
			const newData = data.map(function (item, index) {
				return {
					id: item.id_label_transfer,
					text: item.label_transfer,
					...item,
				};
			});
			return {
				results: newData,
			};
		},
	},
  });

  $("#jenis-transfer").change(function() {
    const storePencarian = Alpine.store('pencarian');
    const data = $('#jenis-transfer').select2('data')[0] || null;
    if (data == null) {
      storePencarian.jenis_transfer = ''
    }
    else {
      storePencarian.jenis_transfer = data.id
    }
  })

  $("#id-label-transfer").change(function() {
    const storePencarian = Alpine.store('pencarian');
    const data = $('#id-label-transfer').select2('data')[0] || null;
    if (data == null) {
      storePencarian.label_transfer = ''
      storePencarian.id_label_transfer = ''
    }
    else {
      storePencarian.label_transfer = data.text
      storePencarian.id_label_transfer = data.id
    }
  })

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
