<div class="container mt-4 text-center">
	<a class="btn btn-primary" href="<?= base_url('label_transfer') ?>" role="button"
		>Kembali</a
	>
</div>
<form action="" method="post" class="container mt-4 p-5 border border-1 rounded" x-data>
	<h5 class="text-center mb-5">Form Edit Label Transfer</h5>
	<div class="mb-3">
		<label for="namaWakilKeluarga" class="form-label">label transfer</label>
		<input type="text" class="form-control" name="label_transfer" placeholder="masukkan label transfer" 
    x-model="$store.input.label_transfer"
		/>
    <template x-if="$store.validasi.label_transfer != null">
      <div class="alert alert-danger  py-1 px-2 mt-2">
      <span x-text="$store.validasi.label_transfer"></span>
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
      'label_transfer': null
    });
    
    Alpine.store('input', {
        label_transfer: "<?= $data_transfer['label_transfer'] ?>",
    })
	})

  async function handleEdit(event) {
    event.preventDefault();
    const input = Alpine.store('input');
    const dataForm = new FormData();
    dataForm.append('label_transfer', input.label_transfer);
    try {
      const {data} = await axios.post("<?= base_url("label_transfer/proses_edit/{$data_transfer['id_label_transfer']}") ?>", dataForm,
      {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
      Alpine.store('validasi').label_transfer = null
      this.label_transfer = ''
      Toast.fire({
        icon: 'success',
        title: 'berhasil mengubah data',
        text: data.pesan
      })
    }
    catch (error) {
      const response = error.response;
      let kodeStatus = response.status;
      const data = response.data;
      let pesan = response.data.pesan;
      if (kodeStatus == 400) {
        Alpine.store('validasi').label_transfer = data.validasi?.label_transfer
      }
      
      if (kodeStatus != 400) {
        pesan = "Nampaknya ada error di server";
        Toast.fire({
          icon: 'error',
          timer: 3000,
          title: 'gagal mengubah data',
          text: pesan
        })
      }
    }

  }
</script>
