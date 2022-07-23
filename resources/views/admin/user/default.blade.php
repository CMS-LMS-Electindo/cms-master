@extends('layouts.das')

@push('prepend-style')
@endpush

@section('title')
    {{$page}} :: {{session('namaApp')}}
@endsection

@section('content')
{{--referensi tampilan file:///D:/template%20web/metronic_v8.0.37/html/demo1/dist/dashboards/online-courses.html 
  file:///D:/template%20web/metronic_v8.0.37/html/demo1/dist/pages/careers/list.html --}}
  <div class="card mb-5 mb-xl-8 m-5">
    <!--begin::Header-->
    <div class="card-header border-0 pt-5">
      <h3 class="card-title align-items-start flex-column">
        <span class="card-label fw-bolder fs-3 mb-1">{{$page}}</span>
        {{-- <span class="text-muted mt-1 fw-bold fs-7">Over 500 members</span> --}}
      </h3>
      <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="Click Untuk Sinkronisasi Data Dosen">
        <button class="btn btn-sm btn-light btn-active-primary sync-dosen mb-2 mx-2" >
          <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
          <span class="svg-icon svg-icon-3">
            <span class="svg-icon svg-icon-2">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M13 5.91517C15.8 6.41517 18 8.81519 18 11.8152C18 12.5152 17.9 13.2152 17.6 13.9152L20.1 15.3152C20.6 15.6152 21.4 15.4152 21.6 14.8152C21.9 13.9152 22.1 12.9152 22.1 11.8152C22.1 7.01519 18.8 3.11521 14.3 2.01521C13.7 1.91521 13.1 2.31521 13.1 3.01521V5.91517H13Z" fill="black"></path>
                <path opacity="0.3" d="M19.1 17.0152C19.7 17.3152 19.8 18.1152 19.3 18.5152C17.5 20.5152 14.9 21.7152 12 21.7152C9.1 21.7152 6.50001 20.5152 4.70001 18.5152C4.30001 18.0152 4.39999 17.3152 4.89999 17.0152L7.39999 15.6152C8.49999 16.9152 10.2 17.8152 12 17.8152C13.8 17.8152 15.5 17.0152 16.6 15.6152L19.1 17.0152ZM6.39999 13.9151C6.19999 13.2151 6 12.5152 6 11.8152C6 8.81517 8.2 6.41515 11 5.91515V3.01519C11 2.41519 10.4 1.91519 9.79999 2.01519C5.29999 3.01519 2 7.01517 2 11.8152C2 12.8152 2.2 13.8152 2.5 14.8152C2.7 15.4152 3.4 15.7152 4 15.3152L6.39999 13.9151Z" fill="black"></path>
              </svg>
            </span>
          </span>
          <!--end::Svg Icon-->Sinkronisasi Kolektif {{$page}} Dosen 
        </button>
        <button class="btn btn-sm btn-secondary btn-active-primary sync-dosen-1 mb-2 mx-2" >
          <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
          <span class="svg-icon svg-icon-3">
            <span class="svg-icon svg-icon-2">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M13 5.91517C15.8 6.41517 18 8.81519 18 11.8152C18 12.5152 17.9 13.2152 17.6 13.9152L20.1 15.3152C20.6 15.6152 21.4 15.4152 21.6 14.8152C21.9 13.9152 22.1 12.9152 22.1 11.8152C22.1 7.01519 18.8 3.11521 14.3 2.01521C13.7 1.91521 13.1 2.31521 13.1 3.01521V5.91517H13Z" fill="black"></path>
                <path opacity="0.3" d="M19.1 17.0152C19.7 17.3152 19.8 18.1152 19.3 18.5152C17.5 20.5152 14.9 21.7152 12 21.7152C9.1 21.7152 6.50001 20.5152 4.70001 18.5152C4.30001 18.0152 4.39999 17.3152 4.89999 17.0152L7.39999 15.6152C8.49999 16.9152 10.2 17.8152 12 17.8152C13.8 17.8152 15.5 17.0152 16.6 15.6152L19.1 17.0152ZM6.39999 13.9151C6.19999 13.2151 6 12.5152 6 11.8152C6 8.81517 8.2 6.41515 11 5.91515V3.01519C11 2.41519 10.4 1.91519 9.79999 2.01519C5.29999 3.01519 2 7.01517 2 11.8152C2 12.8152 2.2 13.8152 2.5 14.8152C2.7 15.4152 3.4 15.7152 4 15.3152L6.39999 13.9151Z" fill="black"></path>
              </svg>
            </span>
          </span>
          <!--end::Svg Icon-->Sinkronisasi  {{$page}} Dosen 
        </button>
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
              <th class="min-w-200px">Nama User</th>
              <th class="min-w-200px">Jenis User</th>
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

  <div class="modal fade" id="kt_modal_new_target" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-850px">
      <!--begin::Modal content-->
      <div class="modal-content rounded">
        <!--begin::Modal header-->
        <div class="modal-header pb-0 border-0 justify-content-end">
          <!--begin::Close-->
          <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
            <span class="svg-icon svg-icon-1">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
              </svg>
            </span>
            <!--end::Svg Icon-->
          </div>
          <!--end::Close-->
        </div>
        <!--begin::Modal header-->
        <!--begin::Modal body-->
        <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
          <!--begin:Form-->
          <form id="kt_modal_new_target_form" class="form" action="#">
            <!--begin::Heading-->
            <div class="mb-13 text-center">
              <!--begin::Title-->
              <h1 class="mb-3" id="inputTitle">Sinkronisasi User Perseorangan</h1>
              <!--end::Title-->
              <!--begin::Description-->
              <div class="text-muted fw-bold fs-5">Silahkan Input jumlah data yang akan disinkron dan jangan menutup pop up ini sebelum proses sinkronisasi selesai.
              {{-- <a href="#" class="fw-bolder link-primary">Project Guidelines</a>. --}}
              </div>
              <!--end::Description-->
            </div>
           
            <div class="row g-9 mb-8 ">
              <div class="col-sm-8 fv-row">
                <!--end::Label-->
                <input type="number" class="form-control form-control-solid" placeholder="Enter jumlah data" name="jumlah" id="jumlah" />
              </div>
              <div class="col-sm-4 fv-row text-center ">
                <button type="button" id="kt_modal_new_target_submit" class="btn btn-primary save">
                  <span class="indicator-label">Sync</span>
                  <span class="indicator-progress">Please wait...
                  <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
              </div>
            </div>
            
            <!--end::Actions-->
          </form>
          <!--end:Form-->
          <div id="progressDiv" class="d-none">
            <div class="progress" style="height: 2rem;">
              <div class="progress-bar progress-bar-striped progress-bar-animated " role="progressbar" style="width: 0%" id="progressBarMK" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
            </div>
            <div class="mt-2" style="border: 4px solid #F3F6F9;
            padding: 1.25rem 1.5rem;
            border-top-left-radius: 0.42rem;
            border-top-right-radius: 0.42rem;">
              <h3 id="progressTitle">Progress Title 
              <small class="text-muted">...</small></h3>
            </div>
          </div>
          
          <div class="table-responsive">
            <!--begin::Table-->
            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                <!--begin::Table head-->
                <thead>
                    <tr class="fw-bolder text-muted">
                        <th class="w-25px">Nomor</th>
                        <th class="min-w-200px">Kode Dosen</th>
                        <th class="min-w-150px">Program Studi</th>
                        <th class="min-w-150px">Email</th>
                        <th class="min-w-150px text-center">Status</th>
                    </tr>
                </thead>
                <!--end::Table head-->
                <!--begin::Table body-->
                <tbody id="tBodyUser">
                  
                </tbody>
                <!--end::Table body-->
            </table>
            <!--end::Table-->
          </div>
        </div>
        <!--end::Modal body-->
      </div>
      <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
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
        "url": "{{ ('/user') }}",
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
          {data: 'type', name: 'type',},
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
  $(".sync-dosen").click(function() {
    Swal.fire({
        title: 'Apakah anda yakin akan melakukan sinkronisasi data dosen ke LMS?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#f00',
        cancelButtonText: 'Batal',
        cancelButtonColor: '#D0D0D0',
        confirmButtonText: 'Ya'
    }).then((result) => {
        if (result.value) {
          $(".sync-dosen").html("<i class='fas fa-sync-alt mt-0 fa-spin'></i> Loading");
          $(".sync-dosen").addClass('btn-danger');
          $(".sync-dosen").removeClass("btn-light");
                $.ajax({
                type: "POST",
                url: "{{ url('sync-dosen') }}",
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
                    
                    $(".sync-dosen").html("<i class='fas fa-sync-alt mt-0 '></i> Sinkronisasi {{$page}} Dosen");
                    $(".sync-dosen").addClass('btn-light');
                    $(".sync-dosen").removeClass("btn-danger");
                }
            });
        }
    })
  });
  $(".sync-dosen-1").click(function() {
    $('#kt_modal_new_target').modal('show');
  });
  $("#kt_modal_new_target_submit").click(function() {
    var jumlah = $("#jumlah").val();
    if (jumlah == ""){
      toastr.error("Mohon Input Jumlah Data yang Akan Disinkron!", 'Gagal', {timeOut: 5000});
      return false;
    }
    Swal.fire({
        title: 'Apakah anda yakin akan melakukan sinkronisasi data dosen sebanyak '+jumlah+' data ke LMS?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#f00',
        cancelButtonText: 'Batal',
        cancelButtonColor: '#D0D0D0',
        confirmButtonText: 'Ya'
    }).then((result) => {
        if (result.value) {
          $("#progressDiv").removeClass("d-none");
          // var progress = response.progress;
          $("#progressBarMK").css("width","5%");
          $("#progressBarMK").attr("aria-valuenow",'5');
          $("#progressBarMK").html("5%");
          $("#progressTitle").html("Ambil Data Dosen...");

          $("#kt_modal_new_target_submit").html("<i class='fas fa-sync-alt mt-0 fa-spin'></i> Loading");
          $("#kt_modal_new_target_submit").addClass('btn-danger');
          $("#kt_modal_new_target_submit").removeClass("btn-light");
            $.ajax({
                type: "POST",
                url: "{{ url('get-dosen-1') }}",
                  data:{
                    '_token': '{{ csrf_token() }}',jumlah,
                },
                success: function(response) {
                    // if (response.status==true) {
                    // toastr.success(response.message, 'Terhapus', {timeOut: 5000});
                    // } else{
                    // toastr.error(response.message, 'Gagal', {timeOut: 5000});
                    // }
                    // var table = $('#tabel').DataTable();
                    // table.row(this).remove().draw(false);
                    
                    // $("#kt_modal_new_target_submit").html("<i class='fas fa-sync-alt mt-0 '></i> Sync");
                    // $("#kt_modal_new_target_submit").addClass('btn-light');
                    // $("#kt_modal_new_target_submit").removeClass("btn-danger");

                  var progress = response.progress;
                  $("#progressBarMK").css("width",progress+"%");
                  $("#progressBarMK").attr("aria-valuenow",progress);
                  $("#progressBarMK").html(progress+"%");
                  $("#progressTitle").html("Sync Dosen 1...");
                  $('#tBodyUser').html(response.html);
                  createUser(0, jumlah, response.data);
                }
            });
        }
    })
  });
  function createUser(id, jumlah, data) {
    $.ajax({
      type: "POST",
      url: "{{ url('create-user-lms') }}",
        data:{
          '_token': '{{ csrf_token() }}',jumlah,id,data
      },
      success: function(response) {
        if (response.status==true) {
          // toastr.success(response.message, 'Terhapus', {timeOut: 5000});
          $("#status"+ response.id).html("Berhasil");
          $("#status"+ response.id).removeClass("badge-light-primary");
          $("#status"+ response.id).addClass("badge-light-success");
        } else{
          // toastr.error(response.message, 'Gagal', {timeOut: 5000});
          $("#status"+ response.id).html("Gagal");
          $("#status"+ response.id).removeClass("badge-light-primary");
          $("#status"+ response.id).addClass("badge-light-danger");
        }
          
        var progress = response.progress;
        $("#progressBarMK").css("width",progress+"%");
        $("#progressBarMK").attr("aria-valuenow",progress);
        $("#progressBarMK").html(progress+"%");
        $("#progressTitle").html("Sync Dosen "+response.next+"...");

        if(response.next == jumlah){
          toastr.success("Proses Sinkronisasi Telah Selesai", 'Siknronisasi', {timeOut: 5000});
          $("#kt_modal_new_target_submit").html("<i class='fas fa-sync-alt mt-0 '></i> Sync");
          $("#kt_modal_new_target_submit").addClass('btn-primary');
          $("#kt_modal_new_target_submit").removeClass("btn-danger");
          $("#progressTitle").html("Sync Mahasiswa Selesai.");
          $("#progressDiv").addClass("d-none");
        }else{
          createUser(response.next, jumlah, data);
        }
          

      }
    });
  }
</script>
@endpush