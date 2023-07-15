
const data = document.getElementById('data').dataset;

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

if (data.status != "") {
  Toast.fire({
    icon: 'success',
    title: 'berhasil',
    text: `nama blok ${data.nama_blok_awal} berhasil diubah menjadi blok ${data.nama_blok_sekarang}`
  })
}
