const data = $("#data").data();

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})

if (data.status == 'berhasil') {
  Toast.fire({
    icon: 'success',
    title: 'berhasil',
    text: `nama blok ${data.namaBlok} berhasil dihapus`
  })
}

if (data.status == 'gagal') {
  Toast.fire({
    icon: 'error',
    title: 'gagal menghapus data',
    text: `masih terdapat keluarga yang berada pada blok ${data.namaBlok}`
  })
}


let table = new DataTable('#tabel', {
  columnDefs: [{
    targets: 2,
    render: function(data, type, row, meta) {
      const idBlok = row[0];
      const namaBlok = row[1];
        return `<a href="detail_blok/detail/${idBlok}" class="btn btn-sm btn-success">Detail</a>
                <a href="blok/edit/${idBlok}" class="btn btn-sm btn-warning">Edit</a>
                <a href="blok/hapus/${idBlok}" class="btn btn-sm btn-danger tombol-hapus" 
                data-id-blok="${idBlok}"
                data-nama-blok="${namaBlok}"
                >Delete</a>`;
    }
  }]
})

$('.tombol-hapus').on('click', function(e) {
  e.preventDefault();
  const idBlok = $(this).data('id-blok');
  const namaBlok = $(this).data('nama-blok');
  Swal.fire({
    title: 'Apakah Anda yakin?',
    text: `Anda akan menghapus blok rumah ${namaBlok}`,
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