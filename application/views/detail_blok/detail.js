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
    text: `Sub Blok ${data.subBlok} berhasil dihapus`
  })
}

if (data.status == 'gagal') {
  Toast.fire({
    icon: 'error',
    title: 'gagal menghapus data',
    text: `masih terdapat keluarga yang berada pada sub blok ${data.subBlokGagal}`
  })
}

let table = new DataTable('#tabel', {
  columnDefs: [{
    targets: 3,
    render: function(data, type, row, meta) {
      const idDetailBlok = row[0];
      const namaBlok = row[1];
      const subBlok = row[2];
        return `<a href="../../detail_blok/edit/${idDetailBlok}" class="btn btn-sm btn-warning">Edit</a>
                <a href="../../detail_blok/hapus/${idDetailBlok}" class="btn btn-sm btn-danger tombol-hapus" 
                data-id-blok="${idDetailBlok}"
                data-nama-blok="${namaBlok}"
                data-sub-blok="${subBlok}"
                >Delete</a>`;
    }
  }]
})

$('.tombol-hapus').on('click', function(e) {
  e.preventDefault();
  const idBlok = $(this).data('id-blok');
  const namaBlok = $(this).data('nama-blok');
  let subBlok = $(this).data('sub-blok');

  if (subBlok == "") subBlok = 'polos';

  Swal.fire({
    title: 'Apakah Anda yakin?',
    text: `Anda akan menghapus Sub Blok ${subBlok} pada Blok ${namaBlok}`,
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