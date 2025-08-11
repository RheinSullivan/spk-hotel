@extends('layouts.app')

@section('content')
<div class="section-header">
  <h1>Dashboard Admin</h1>
</div>

<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-primary">
        <i class="fas fa-hotel"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Jumlah Hotel</h4>
        </div>
        <div class="card-body">
          {{ $jumlahHotel }}
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-6 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-success">
        <i class="fas fa-users"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Jumlah Pengguna</h4>
        </div>
        <div class="card-body">
          {{ $jumlahPengguna }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
