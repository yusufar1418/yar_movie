// $(function() {
// 	$('.tombolTambahData').on('click', function () {
// 		$('h5#formModelLabel').html('Tambah Data Barang');
// 		$('.modal-footer button[type=submit]').html('Tambah Data');
// 		$('#namabarang').val('');
// 		$('#kodebarang').val('');
// 		$('#merek').val('');
// 		$('#jenisbarang').val('');
// 		$('#stok').val('');
// 		$('#tempat').val('');
// 		$('#id').val('');
// 	});

// 	$('.tampilModalUbah').on('click', function () {
// 		$('h5#formModelLabel').html('Ubah Data Barang');
// 		$('.modal-footer button[type=submit]').html('Ubah Data');
// 		$('.modal-body form').attr('action', '<?= base_url(); ?>inventory/ubah');
	

// 		const id = $(this).data('id');
// 		$.ajax({
// 			url: '<?= base_url(); ?>inventory/getubah',
// 			async: false,
// 			data: {id : id}, 
// 			method: 'post',
// 			dataType: 'JSON',
// 			success: function(data){
// 				console.log(data);
// 				// $('#namabarang').val(data.namabarang);
// 				// $('#kodebarang').val(data.kodebarang);
// 				// $('#merek').val(data.merek);
// 				// $('#jenisbarang').val(data.jenisbarang);
// 				// $('#tempat').val(data.tempat);
// 				// $('#stok').val(data.stok);
// 				// $('#id').val(data.id);
// 			}
// 		});
// 	});
// });