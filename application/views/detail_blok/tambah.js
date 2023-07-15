
const data = $("#data").data();
console.log(data);
const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 2000,
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
    text: `sub blok ${data.subBlok} berhasil ditambahkan`
  })
}

if (data.status == "gagal") {
  Toast.fire({
    icon: 'error',
    title: 'gagal',
    text: `Sub Blok ${data.subBlokGagal} gagal ditambahkan karena sudah tersedia sebelumnya`
  })
}
