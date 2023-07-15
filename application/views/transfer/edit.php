<div class="container mt-4 text-center">
	<a class="btn btn-primary" href="<?= base_url('transfer') ?>" role="button"
		>Kembali</a
	>
</div>
<form action="" method="post" class="container mt-4 p-5 border border-1 rounded" x-data>
	<h5 class="text-center mb-5">Form Edit Data Transfer</h5>
  <div class="mb-3">
		<label class="form-label">Blok Rumah (Optional)</label>
		<select type="text" class="form-control" id="id-blok">
    </select>
	</div>
  <div class="mb-3">
		<label class="form-label">Sub Blok Rumah (Optional)</label>
		<select type="text" class="form-control" id="id-detail-blok">
    </select>
	</div>
  <div class="mb-3">
		<label class="form-label">No Rumah (Optional)</label>
		<input type="text" class="form-control" id="no-rumah" placeholder="masukkan no rumah"/>
	</div>
  <div class="mb-3">
		<p>Untuk mempermudah mencari data keluarga, bisa mengisi data alamat di atas</p>
	</div>
  <div class="mb-3">
		<label class="form-label">Keluarga</label>
		<select type="text" class="form-control input-select2" id="id-keluarga" name="id_keluarga">
		<option value="<?= $data_transfer['id_keluarga'] ?>"><?= $data_transfer['wakil_keluarga'] ?></option>
    </select>
    <template x-if="$store.keluarga.id_keluarga != null">
      <div class="mt-2">
        <div>Alamat  : <span x-text="setAlamatKeluarga"></span></div>
      </div>
    </template>
    <template x-if="$store.validasi.id_keluarga != null">
      <div class="alert alert-danger  py-1 px-2 mt-2">
      <span x-text="$store.validasi.id_keluarga"></span>
      </div>
    </template>
	</div>
  <div class="mb-3">
		<label class="form-label">jenis transfer</label>
		<select type="text" class="form-control" name="jenis_transfer" id="jenis-transfer"
		x-model="$store.input.jenis_transfer">
      <option value="">Pilih Jenis Transfer</option>
      <option value="sumbangan">sumbangan</option>
      <option value="pengeluaran">pengeluaran</option>
    </select>
    <template x-if="$store.validasi.jenis_transfer != null">
      <div class="alert alert-danger  py-1 px-2 mt-2">
      <span x-text="$store.validasi.jenis_transfer"></span>
      </div>
    </template>
	</div>
	<div class="mb-3">
		<label class="form-label">label transfer</label>
		<select type="text" class="form-control input-select2" name="id_label_transfer" 
		id="id-label-transfer">
      <option value="<?= $data_transfer['id_label_transfer'] ?>"><?= $data_transfer['label_transfer'] ?></option>
    </select>
    <template x-if="$store.validasi.id_label_transfer != null">
      <div class="alert alert-danger  py-1 px-2 mt-2">
      <span x-text="$store.validasi.id_label_transfer"></span>
      </div>
    </template>
	</div>
  <div class="mb-3">
		<label class="form-label">nominal</label>
		<input type="number" class="form-control" name="nominal" placeholder="masukkan nominal transfer" 
    x-model="$store.input.nominal" min="0"
		/>
    <template x-if="$store.validasi.nominal != null">
      <div class="alert alert-danger  py-1 px-2 mt-2">
      <span x-text="$store.validasi.nominal"></span>
      </div>
    </template>
	</div>
  <div class="mb-3">
		<label class="form-label">Keterangan (Optional)</label>
    <textarea name="keterangan_transfer" class="form-control" rows="5" 
    placeholder="masukkan keterangan" x-model="$store.input.keterangan_transfer"></textarea>
    <template x-if="$store.validasi.keterangan_transfer != null">
      <div class="alert alert-danger  py-1 px-2 mt-2">
      <span x-text="$store.validasi.keterangan_transfer"></span>
      </div>
    </template>
	</div>
	<div class="d-grid gap-2">
		<button class="btn btn-primary" type="submit" @click="handleEdit">Edit</button>
		<a class="btn btn-primary" href="">Reset</a>
	</div>
</form>

<script>
	const Toast = Swal.mixin({
	toast: true,
	position: 'top-end',
	showConfirmButton: false,
  timer: 1500,
	timerProgressBar: true
	})

	document.addEventListener('alpine:init', () => {
    Alpine.store('validasi', {

    });
    
    Alpine.store('input', {
			id_keluarga: '<?= $data_transfer['id_keluarga'] ?>',
			jenis_transfer: '<?= $data_transfer['jenis_transfer'] ?>',
			id_label_transfer: '<?= $data_transfer['id_label_transfer'] ?>',
			nominal: '<?= $data_transfer['nominal'] ?>',
			keterangan_transfer: '<?= $data_transfer['keterangan_transfer'] ?>',
    })
    Alpine.store('keluarga', {
      nama_blok: '<?= $data_transfer['nama_blok']?>',
      sub_blok: '<?= $data_transfer['sub_blok']?>',
      no_rumah: '<?= $data_transfer['no_rumah']?>',
      id_keluarga: '<?= $data_transfer['id_keluarga']?>'
    })

		if (Alpine.store('input').jenis_transfer == 'pengeluaran')
			Alpine.store('input').nominal *= -1;
	})

async function handleEdit(event) {
	event.preventDefault();
	const storeInput = Alpine.store('input');
	const storeValidasi = Alpine.store('validasi');

	try {
		const {data} = await axios.post("<?= base_url("transfer/proses_edit/{$data_transfer['id_transfer']}") ?>", storeInput)
		for (keyValidasi in storeValidasi) {
			delete storeValidasi[keyValidasi];
		}

		Toast.fire({
			icon: 'success',
			title: 'berhasil mengubah data transfer',
			text: data.pesan
		})
	}
	catch (error) {
		const response = error.response;
		let kodeStatus = response.status;
		const data = response.data;
		let pesan = response.data.pesan;
		if (kodeStatus == 400) {
			for (keyValidasi in storeValidasi) {
				delete storeValidasi[keyValidasi];
			}
			Object.assign(storeValidasi, data.validasi);
		}
		
		if (kodeStatus != 400) {
			pesan = "Nampaknya ada error di server";
			Toast.fire({
				icon: 'error',
				timer: 3000,
				title: 'gagal menambahkan data transfer',
				text: pesan
			})
		}
	}

}

function setAlamatKeluarga() {
	const storeKeluarga = Alpine.store('keluarga');
	let alamat = ""
	alamat += storeKeluarga.nama_blok;
	
	if (storeKeluarga.sub_blok != "")
		alamat += `/${storeKeluarga.sub_blok}`

	if (storeKeluarga.no_rumah != "")
		alamat += ` No. ${storeKeluarga.no_rumah}`
	return alamat;
}

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

$("#id-blok").select2({
	placeholder: "pilih blok rumah",
	allowClear: true,
	ajax: {
		url: `<?= base_url() ?>api/get_blok`,
		delay: 250,
		dataType: "json",
		processResults: function (data) {
			// Transforms the top-level key of the response object from 'items' to 'results'
			const newData = data.map(function (item, index) {
				return {
					id: item.id_blok,
					text: item.nama_blok,
					...item,
				};
			});

			return {
				results: newData,
			};
		},
	},
});

$("#id-detail-blok").select2({
	placeholder: "pilih sub blok",
	allowClear: true,
	ajax: {
		url: `<?= base_url() ?>api/get_detail_blok`,
		delay: 250,
		data: function (params) {
			const id_blok = $("#id-blok").val();
			return {
				sub_blok: params.term,
				id_blok: id_blok,
			};
		},
		dataType: "json",
		processResults: function (data) {
			// Transforms the top-level key of the response object from 'items' to 'results'
			const newData = data.map(function (item, index) {
				return {
					id: item.id_detail_blok,
					text: item.sub_blok != "" ? item.sub_blok : "-",
					...item,
				};
			});

			return {
				results: newData,
			};
		},
	},
});

$("#id-keluarga").select2({
	placeholder: "pilih keluarga",
	allowClear: true,
	ajax: {
		url: `<?= base_url() ?>api/get_keluarga`,
		delay: 250,
		data: function (params) {
			const id_blok = $("#id-blok").val();
      const id_detail_blok = $("#id-detail-blok").val();
      const no_rumah = $("#no-rumah").val();
			return {
				id_detail_blok: id_detail_blok,
				id_blok: id_blok,
        no_rumah: no_rumah
			};
		},
		dataType: "json",
		processResults: function (data) {
			// Transforms the top-level key of the response object from 'items' to 'results'
			const newData = data.map(function (item, index) {
				return {
					id: item.id_keluarga,
					text: item.wakil_keluarga,
					...item,
				};
			});

			return {
				results: newData,
			};
		},
	},
});

const data = $('#id-keluarga').select2('data')[0] || null;
if (data != null) {
	data.nama_blok = '<?= $data_transfer['nama_blok']?>';
	data.sub_blok = '<?= $data_transfer['sub_blok']?>';
	data.no_rumah = '<?= $data_transfer['no_rumah']?>';
	data.id_keluarga = '<?= $data_transfer['id_keluarga']?>';
}

$("#id-blok").change(function () {
  $('#id-detail-blok').val(null).trigger('change');
  $("#id-keluarga").val(null).trigger('change');
});

$("#id-detail-blok").change(function () {
  $("#id-keluarga").val(null).trigger('change');
});

$("#no-rumah").keyup(function() {
  $("#id-keluarga").val(null).trigger('change');
})

$("#id-keluarga").change(function () {
  const data = $('#id-keluarga').select2('data')[0] || null;
  if (data == null) {
    Alpine.store('keluarga').id_keluarga = null;
    return;
  }

  const storeKeluarga = Alpine.store('keluarga');
  Object.assign(storeKeluarga, data);

});

$(".input-select2").change(function() {
	const namaInput = $(this).attr('name');
	const nilaiInput = $(this).val();

	const storeInput = Alpine.store('input');
	storeInput[namaInput] = nilaiInput;
})



</script>
