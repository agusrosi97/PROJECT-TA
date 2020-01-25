<script type="text/javascript">
	function LogoutOnClick() {
		Swal.fire({
		  title: '<h3>Anda yakin ingin keluar?</h3>',
		  type: 'question',
		  showCloseButton: true,
		  showCancelButton: true,
		  confirmButtonColor: '#dc3545',
		  cancelButtonColor: '#3085d6',
		  confirmButtonText: 'Ya',
		  cancelButtonText: 'Batal'
		}).then((result) => {
		  if (result.value) {
		    Swal.fire({
				  title: 'Hati - hati di jalan!',
				  text: "Kamu sudah bebas!",
				  type: 'success',
				  showConfirmButton: false,
          timer: 2000,
				}).then(function() {
		      window.location.href = '../logout/logout.php';
		    })
		  }
		})
	}
</script>