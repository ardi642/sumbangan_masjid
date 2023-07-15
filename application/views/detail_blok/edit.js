
const data = document.getElementById('data').dataset;

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 1500,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})

if (data.status == "berhasil") {
  Toast.fire({
    icon: 'success',
    title: 'berhasil',
    text: `Sub Blok ${data.sub_blok_awal} berhasil diubah menjadi sub blok ${data.sub_blok_sekarang}`
  })
}

if (data.status == "gagal") {
  Toast.fire({
    icon: 'error',
    title: 'gagal',
    text: `Sub Blok ${data.sub_blok_awal} gagal diubah menjadi sub blok ${data.sub_blok_sekarang}
            karena sub blok ${data.sub_blok_awal} sudah tersedia sebelumnya`
  })
}
