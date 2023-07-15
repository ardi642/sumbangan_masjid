const data = document.getElementById("data").dataset;

$(".id-blok").select2({
	placeholder: "masukkan blok",
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

$(".id-detail-blok").select2({
	placeholder: "masukkan sub blok",
	allowClear: true,
	ajax: {
		url: `<?= base_url() ?>api/get_detail_blok`,
		delay: 250,
		data: function (params) {
			const id_blok = $(".id-blok").val();
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

$(".id-blok").change(function () {
	$(".id-detail-blok").empty();
});

const Toast = Swal.mixin({
	toast: true,
	position: "top-end",
	showConfirmButton: false,
	timer: 1500,
	timerProgressBar: true,
	didOpen: (toast) => {
		toast.addEventListener("mouseenter", Swal.stopTimer);
		toast.addEventListener("mouseleave", Swal.resumeTimer);
	},
});

if (data.status == "berhasil") {
	Toast.fire({
		icon: "success",
		title: "berhasil",
		text: `data keluarga berhasil ditambahkan`,
	});
}

if (data.status == "gagal") {
	Toast.fire({
		timer: 3000,
		icon: "error",
		title: "gagal",
		text: `sudah ada keluarga yang menggunakan alamat yang diinputkan`,
	});
}
