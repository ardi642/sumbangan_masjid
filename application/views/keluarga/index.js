const data = $("#data").data();

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})

if (data.status == 'berhasil') {
  Toast.fire({
    timer: 1500,
    icon: 'success',
    title: 'berhasil',
    text: `Data Keluarga ${data.wakilKeluarga} berhasil dihapus`
  })
}

if (data.status == 'gagal') {
  Toast.fire({
    timer: 3000,  
    icon: 'error',
    title: 'gagal menghapus data',
    text: `gagal menghapus data keluarga ${data.wakilKeluarga} karena terdapat sumbangan
          dari keluarga tersebut`
  })
}


let table = new DataTable('#tabel', {
  columnDefs: [{
    targets: 5,
    render: function(data, type, row, meta) {
      const idKeluarga = row[0];
      const wakilKeluarga = row[1];
        return `<a href="keluarga/edit/${idKeluarga}" class="btn btn-sm btn-warning">Edit</a>
                <a href="keluarga/hapus/${idKeluarga}" class="btn btn-sm btn-danger tombol-hapus" 
                data-id-keluarga="${idKeluarga}"
                data-wakil-keluarga="${wakilKeluarga}"
                >Delete</a>`;
    }
  }]
})

$('.tombol-hapus').on('click', function(e) {
  e.preventDefault();
  const idKeluarga = $(this).data('id-keluarga');
  const wakilKeluarga = $(this).data('wakil-keluarga');
  Swal.fire({
    title: 'Apakah Anda yakin?',
    text: `Anda akan menghapus data keluarga ${wakilKeluarga}`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal'
  }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = $(this).attr('href');
      }
  });
});