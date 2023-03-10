<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Admin Dashboard</title>
	<!-- Custom fonts for this template-->
	<link href="{{URL::to('/public/admin-panel/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
	<!-- Custom styles for this template-->
	<link href="{{URL::to('/public/admin-panel/css/sb-admin-2.min.css')}}" rel="stylesheet"> </head>
	<link href="{{URL::to('/public/admin-panel/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
	
<body id="page-top">
	<!-- Page Wrapper -->
	<div id="wrapper">
		@include('admin.layouts.sidebar')
		@yield('content')
	</div>
	<!-- End of Page Wrapper -->
	<!-- Scroll to Top Button-->
	<a class="scroll-to-top rounded" href="#page-top"> <i class="fas fa-angle-up"></i> </a>
	<!-- Logout Modal-->
	<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
				</div>
				<div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button> 
					<form method="POST" action="{{ route('logout') }}">
						@csrf
						<a  class="btn btn-primary" href="{{ route('logout') }}"
										onclick="event.preventDefault();
												 this.closest('form').submit();">
							{{ __('Logout') }}
						</a>
					</form>
			</div>
		</div>
	</div>

	@include('admin.layouts.scripts')
</body>

</html>