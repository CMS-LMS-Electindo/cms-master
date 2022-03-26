@extends('layouts.das')

@push('prepend-style')
@endpush

@section('title')
    {{$page}} :: {{session('applicationName')}}
@endsection

@section('content')
{{--referensi tampilan file:///D:/template%20web/metronic_v8.0.37/html/demo1/dist/dashboards/online-courses.html 
  file:///D:/template%20web/metronic_v8.0.37/html/demo1/dist/pages/careers/list.html --}}
  <div class="card mb-5 mb-xl-8">
    <!--begin::Header-->
    <div class="card-header border-0 pt-5">
      <h3 class="card-title align-items-start flex-column">
        <span class="card-label fw-bolder fs-3 mb-1">{{$page}}</span>
        {{-- <span class="text-muted mt-1 fw-bold fs-7">Over 500 members</span> --}}
      </h3>
      <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="Click to sync category">
        <button class="btn btn-sm btn-light btn-active-primary sync-fakultas mb-2 mx-2" >
        <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
        <span class="svg-icon svg-icon-3">
          <span class="svg-icon svg-icon-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path d="M13 5.91517C15.8 6.41517 18 8.81519 18 11.8152C18 12.5152 17.9 13.2152 17.6 13.9152L20.1 15.3152C20.6 15.6152 21.4 15.4152 21.6 14.8152C21.9 13.9152 22.1 12.9152 22.1 11.8152C22.1 7.01519 18.8 3.11521 14.3 2.01521C13.7 1.91521 13.1 2.31521 13.1 3.01521V5.91517H13Z" fill="black"></path>
              <path opacity="0.3" d="M19.1 17.0152C19.7 17.3152 19.8 18.1152 19.3 18.5152C17.5 20.5152 14.9 21.7152 12 21.7152C9.1 21.7152 6.50001 20.5152 4.70001 18.5152C4.30001 18.0152 4.39999 17.3152 4.89999 17.0152L7.39999 15.6152C8.49999 16.9152 10.2 17.8152 12 17.8152C13.8 17.8152 15.5 17.0152 16.6 15.6152L19.1 17.0152ZM6.39999 13.9151C6.19999 13.2151 6 12.5152 6 11.8152C6 8.81517 8.2 6.41515 11 5.91515V3.01519C11 2.41519 10.4 1.91519 9.79999 2.01519C5.29999 3.01519 2 7.01517 2 11.8152C2 12.8152 2.2 13.8152 2.5 14.8152C2.7 15.4152 3.4 15.7152 4 15.3152L6.39999 13.9151Z" fill="black"></path>
            </svg>
          </span>
        </span>
        <!--end::Svg Icon-->Sinkronisasi {{$page}} Fakultas</button>
        <button class="btn btn-sm btn-light btn-active-primary sync-prodi mb-2 mx-2" >
          <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
          <span class="svg-icon svg-icon-3">
            <span class="svg-icon svg-icon-2">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M13 5.91517C15.8 6.41517 18 8.81519 18 11.8152C18 12.5152 17.9 13.2152 17.6 13.9152L20.1 15.3152C20.6 15.6152 21.4 15.4152 21.6 14.8152C21.9 13.9152 22.1 12.9152 22.1 11.8152C22.1 7.01519 18.8 3.11521 14.3 2.01521C13.7 1.91521 13.1 2.31521 13.1 3.01521V5.91517H13Z" fill="black"></path>
                <path opacity="0.3" d="M19.1 17.0152C19.7 17.3152 19.8 18.1152 19.3 18.5152C17.5 20.5152 14.9 21.7152 12 21.7152C9.1 21.7152 6.50001 20.5152 4.70001 18.5152C4.30001 18.0152 4.39999 17.3152 4.89999 17.0152L7.39999 15.6152C8.49999 16.9152 10.2 17.8152 12 17.8152C13.8 17.8152 15.5 17.0152 16.6 15.6152L19.1 17.0152ZM6.39999 13.9151C6.19999 13.2151 6 12.5152 6 11.8152C6 8.81517 8.2 6.41515 11 5.91515V3.01519C11 2.41519 10.4 1.91519 9.79999 2.01519C5.29999 3.01519 2 7.01517 2 11.8152C2 12.8152 2.2 13.8152 2.5 14.8152C2.7 15.4152 3.4 15.7152 4 15.3152L6.39999 13.9151Z" fill="black"></path>
              </svg>
            </span>
          </span>
          <!--end::Svg Icon-->Sinkronisasi {{$page}} Prodi</button>
      </div>
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body py-3">
      <!--begin::Table container-->
      <div class="table-responsive">
        <!--begin::Table-->
        <table id="tabel" class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
          <!--begin::Table head-->
          <thead>
            <tr class="fw-bolder text-muted">
              <th class="w-25px"> No
                {{-- <div class="form-check form-check-sm form-check-custom form-check-solid">
                  <input class="form-check-input" type="checkbox" value="1" data-kt-check="true" data-kt-check-target=".widget-9-check" />
                </div> --}}
              </th>
              <th class="min-w-200px">Nama Kategori</th>
              <th class="min-w-200px">Parent</th>
            </tr>
          </thead>
          <!--end::Table head-->
          <!--begin::Table body-->
          <tbody>
          </tbody>
          <!--end::Table body-->
        </table>
        <!--end::Table-->
      </div>
      <!--end::Table container-->
    </div>
    <!--begin::Body-->
  </div>

@endsection


@push('prepend-script')

@endpush

@push('addon-script')

<script src="assets/js/custom/utilities/modals/new-target.js"></script>
<script>

  $(document).ready(function () {
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('')
        }
    });
    getdata();
    $('[name="startDate"]').flatpickr({ enableTime: !0, dateFormat: "d-m-Y" });
    $('[name="endDate"]').flatpickr({ enableTime: !0, dateFormat: "d-m-Y" });
  });
  function getdata(){
    // console.log(tahun);
     var table = $('#tabel').DataTable();
    table.destroy();
    var table = $('#tabel').DataTable({
        
      // "scrollY": "200px",
      "scrollCollapse": true,
      processing: false,
      serverSide: true,
      ajax:{
        "url": "{{ ('/category') }}",
        "dataType": "json",
        "type": "GET",
        "data":{ _token: "{{csrf_token()}}"}
      },
      columns: [
          {
              data: 'DT_RowIndex', 
              name: 'DT_RowIndex',
                className: "text-center"
          },
          {data: 'nama', name: 'nama'},
          {data: 'parent1', name: 'parent1',},
      ],
      language:{paginate:{
          previous:"<i class='mdi mdi-chevron-left'>",
          next:"<i class='mdi mdi-chevron-right'>"
      }},
      drawCallback:function(){
          $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
      }
    });

    $('.dataTables_length').addClass('bs-select');
    $('[data-toggle="select2"]').select2();
    // ("#nik").select2();
  }
  $(".sync-fakultas").click(function() {
    Swal.fire({
        title: 'Apakah anda yakin akan melakukan sinkronisasi data kategori fakultas ke LMS?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#f00',
        cancelButtonText: 'Batal',
        cancelButtonColor: '#D0D0D0',
        confirmButtonText: 'Ya'
    }).then((result) => {
        if (result.value) {
          $(".sync-fakultas").html("<i class='fas fa-sync-alt mt-0 fa-spin'></i> Loading");
          $(".sync-fakultas").addClass('btn-danger');
          $(".sync-fakultas").removeClass("btn-light");
                $.ajax({
                type: "POST",
                url: "{{ url('sync-category-prodi') }}",
                  data:{
                    '_token': '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.status==true) {
                    toastr.success(response.message, 'Terhapus', {timeOut: 5000});
                    } else{
                    toastr.error(response.message, 'Gagal', {timeOut: 5000});
                    }
                    var table = $('#tabel').DataTable();
                    table.row(this).remove().draw(false);
                    
                    $(".sync-fakultas").html("<i class='fas fa-sync-alt mt-0 '></i> Sinkronisasi {{$page}} Fakultas");
                    $(".sync-fakultas").addClass('btn-light');
                    $(".sync-fakultas").removeClass("btn-danger");
                }
            });
        }
    })
  });
  $(".sync-prodi").click(function() {
    Swal.fire({
        title: 'Apakah anda yakin akan melakukan sinkronisasi data kategori Prodi ke LMS?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#f00',
        cancelButtonText: 'Batal',
        cancelButtonColor: '#D0D0D0',
        confirmButtonText: 'Ya'
    }).then((result) => {
        if (result.value) {
          $(".sync-prodi").html("<i class='fas fa-sync-alt mt-0 fa-spin'></i> Loading");
          $(".sync-prodi").addClass('btn-danger');
          $(".sync-prodi").removeClass("btn-light");
                $.ajax({
                type: "POST",
                url: "{{ url('sync-category-prodi') }}",
                  data:{
                    '_token': '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.status==true) {
                    toastr.success(response.message, 'Terhapus', {timeOut: 5000});
                    } else{
                    toastr.error(response.message, 'Gagal', {timeOut: 5000});
                    }
                    var table = $('#tabel').DataTable();
                    table.row(this).remove().draw(false);
                    $(".sync-prodi").html("<i class='fas fa-sync-alt mt-0 '></i> Sinkronisasi {{$page}} Prodi");
                    $(".sync-prodi").addClass('btn-light');
                    $(".sync-prodi").removeClass("btn-danger");
                }
            });
        }
    })
  });
</script>
@endpush