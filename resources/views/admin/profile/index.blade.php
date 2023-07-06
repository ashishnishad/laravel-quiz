@extends('layouts.admin.app-dashboard')
@section('content')
    @include('layouts.admin.login-header')
    <!-- end header -->
    <div class="app-body">
         @include('layouts.admin.sidebar')
        <!-- end sidebar -->
        <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
                <li class="breadcrumb-item ">
                    <a href="">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#">Admin</a>
                </li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="container-fluid">
                <div class="animated fadeIn">
                    <div class="row">
                        <div class="col-md-12">
							<div class="card">
								<div class="card-header text-theme">
									<strong>Profile</strong>
								</div>
							</div>
						</div>
					</div>
						
						
                    <!-- end row -->
                    <!-- end row -->
                    <!-- end row -->
                    <!-- end row -->
                </div>
                <!-- end animated fadeIn -->
            </div>
            <!-- end container-fluid -->
        </main>
        <!-- end main -->
        <!-- end aside -->
    </div>
@endsection