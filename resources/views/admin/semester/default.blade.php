@extends('layouts.das')

@push('prepend-style')
@endpush

@section('title')
    {{$page}} :: {{session('namaApp')}}
@endsection

@section('content')

  <div class="card mb-5 mb-xl-8">
    <!--begin::Header-->
    <div class="card-header border-0 pt-5">
      <h3 class="card-title align-items-start flex-column">
        <span class="card-label fw-bolder fs-3 mb-1">{{$page}}</span>
        {{-- <span class="text-muted mt-1 fw-bold fs-7">Over 500 members</span> --}}
      </h3>
      <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="Click to add a user">
        <button class="btn btn-sm btn-light btn-active-primary add" >
        <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
        <span class="svg-icon svg-icon-3">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="black" />
            <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black" />
          </svg>
        </span>
        <!--end::Svg Icon-->Tambah {{$page}}</button>
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
              <th class="min-w-200px">Nama Semester</th>
              <th class="min-w-150px">About</th>
              <th class="min-w-150px">Aktif</th>
              <th class="min-w-100px text-end">Actions</th>
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
  <div class="modal-dialog modal-dialog-centered mw-650px">
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
          <input type="hidden" name="kode" id="kode">
          <!--begin::Heading-->
          <div class="mb-13 text-center">
            <!--begin::Title-->
            <h1 class="mb-3" id="inputTitle">Set First Target</h1>
            <!--end::Title-->
            <!--begin::Description-->
            <div class="text-muted fw-bold fs-5">Penambahan Data Semester dalam rangka menentukan cut off tanggal disetiap semester dan config penambahan mata kuliah.
            {{-- <a href="#" class="fw-bolder link-primary">Project Guidelines</a>. --}}
            </div>
            <!--end::Description-->
          </div>
          <!--end::Heading-->
          <!--begin::Input group-->
          <div class="d-flex flex-column mb-8 fv-row">
            <!--begin::Label-->
            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
              <span class="required" for="semesterName">Nama Semester</span>
            </label>
            <!--end::Label-->
            <input type="text" class="form-control form-control-solid" placeholder="Enter Nama Semester" name="semesterName" id="semesterName" />
          </div>
          <!--end::Input group-->
          <div class="row g-9 mb-8">
            <div class="col-md-6 fv-row">
              <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                <span class="required" for="year">Tahun Akademik</span>
                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="format tahun akademik : 2021-2022"></i>
              </label>
              <!--end::Label-->
              <input type="text" class="form-control form-control-solid" placeholder="Enter tahun akademik" name="year" id="year" />
            </div>
            <div class="col-md-6 fv-row">
              <label class="required fs-6 fw-bold mb-2" for="semester">Semester</label>
              <select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Pilih Semester" name="semester" id="semester">
                <option value="">Pilih Semester...</option>
                <option value="1">Ganjil</option>
                <option value="2">Genap</option>
              </select>
            </div>
          </div>
          <!--begin::Input group-->
          <div class="row g-9 mb-8">
            <!--begin::Col-->
            
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-md-6 fv-row">
              <label class="required fs-6 fw-bold mb-2" for="startDate">Start Date</label>
              <!--begin::Input-->
              <div class="position-relative d-flex align-items-center">
                <!--begin::Icon-->
                <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                <span class="svg-icon svg-icon-2 position-absolute mx-4">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="black" />
                    <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="black" />
                    <path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="black" />
                  </svg>
                </span>
                <!--end::Svg Icon-->
                <!--end::Icon-->
                <!--begin::Datepicker-->
                <input class="form-control form-control-solid ps-12" placeholder="Select a date" name="startDate" id="startDate" />
                <!--end::Datepicker-->
              </div>
              <!--end::Input-->
            </div>
            
            <div class="col-md-6 fv-row">
              <label class="required fs-6 fw-bold mb-2" for="endDate">End Date</label>
              <!--begin::Input-->
              <div class="position-relative d-flex align-items-center">
                <!--begin::Icon-->
                <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                <span class="svg-icon svg-icon-2 position-absolute mx-4">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="black" />
                    <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="black" />
                    <path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="black" />
                  </svg>
                </span>
                <!--end::Svg Icon-->
                <!--end::Icon-->
                <!--begin::Datepicker-->
                <input class="form-control form-control-solid ps-12" placeholder="Select a date" name="endDate" id="endDate" />
                <!--end::Datepicker-->
              </div>
              <!--end::Input-->
            </div>
            <!--end::Col-->
          </div>
          <!--end::Input group-->
          <div class="row g-9 mb-8">
            <div class="col-md-12 fv-row">
              <label class="required fs-6 fw-bold mb-2" for="config_type">Tipe Konfig</label>
              <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Tipe Konfigurasi pembuatan mata kuliah"></i>
              <select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Pilih Tipe Konfig" name="config_type" id="config_type">
                <option value="">Pilih Tipe Konfig...</option>
                <option value="1">Type 1</option>
                <option value="2">Type 2</option>
                <option value="3">Type 3</option>
              </select>
            </div>
          </div>
          <div class="text-center">
            <button type="reset" id="kt_modal_new_target_cancel" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
            <button type="button" id="kt_modal_new_target_submit" class="btn btn-primary save">
              <span class="indicator-label">Submit</span>
              <span class="indicator-progress">Please wait...
              <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
          </div>
          <!--end::Actions-->
        </form>
        <!--end:Form-->
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

{{-- <script src="assets/js/custom/utilities/modals/new-target.js"></script> --}}
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
      processing: false,
      serverSide: true,
      ajax:{
        "url": "{{ ('/semester') }}",
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
          {data: 'config', name: 'config',},
          {data: 'aktif', name: 'aktif',},
          {data: 'action', name: 'action', orderable: false, searchable: false,visible: true,},
      ],
      language:{paginate:{
          previous:"<i class='mdi mdi-chevron-left'>",
          next:"<i class='mdi mdi-chevron-right'>"
      }},
      drawCallback:function(){
          $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
      }
    });
    // table.draw( true );

    $('.dataTables_length').addClass('bs-select');
    $('[data-toggle="select2"]').select2();
    // ("#nik").select2();
  }
  
  $(".add").click(function() {
    var title = " {{ $page }}";
    $('#kt_modal_new_target_form').each(function() {
        this.reset();
    });
    $('#kode').val('');
    var form = $('#kt_modal_new_target_form');
        form.find('.invalid-feedback').remove();
        form.find('.form-control').removeClass('is-invalid');
    $('#kt_modal_new_target').modal('show');
    $('#inputTitle').html('Tambah '+title);
    $('.save').html('Simpan '+ title);
  });
  
  $(".save").click(function() {
    var formData = new FormData($('#kt_modal_new_target_form')[0]);
        formData.append("_token", "{{ csrf_token() }}");
    var form = $('#kt_modal_new_target_form');
        form.find('.invalid-feedback').remove();
        form.find('.form-control').removeClass('is-invalid');
    $.ajax({
        type: "POST",
        url: "{{ url('/semester') }}",
        data: formData,
        contentType: false,
        cache:false,
        processData: false,
        dataType:"json",
        success: function(data) {
              $( "#lbl-error" ).remove();
            if (data.status == true) {
                $('#kt_modal_new_target').modal('hide');
                $('#kt_modal_new_target_form').each(function() {
                        this.reset();
                    });
                var table = $('#tabel').DataTable();
                table.row(this).remove().draw(false);
                
                // var tahun = $("#tahun").val();
                // getsurat();
                toastr.success("Data berhasil disimpan...", 'Berhasil', {
                    timeOut: 5000
                });
                return false;

            } else{
                $('#kt_modal_new_target').modal('hide');
                // var table = $('#tabel').DataTable();
                // table.row(this).remove().draw(false);
                toastr.error(data.message, 'Error', {
                    timeOut: 5000
                });
                return false;
            }
        
            getdata();
        },
        error: function(xhr){
            let response = xhr.responseJSON
            if($.isEmptyObject(response)==false){
              $.each(response.errors, (key, value)=>{
                  
                  $('#'+key)
                      .closest('.form-control')
                      .addClass('is-invalid')
                      .after('<div  class="invalid-feedback" >  '+ value +'</div>')
              })
            }
        }

    });
  });
    
  function edit(id) {
    var title = " {{ $page }}";
    $('.save').html('<i class="fa fa-save"></i> Simpan Perubahan');
    $('#kode').val(id);
    var form = $('#kt_modal_new_target_form');
        form.find('.invalid-feedback').remove();
        form.find('.form-control').removeClass('is-invalid');
    $.get("{{ url('semester') }}" +'/' + id +'/edit', function (data) {
        $('#kt_modal_new_target').modal('show');
        $('#inputTitle').html('Ubah '+title);
        $('#semesterName').val(data.name);
        $('#year').val(data.year);
        $('#semester').val(data.semester);
        var sem ='';
        if (data.semester == 1)
          sem = "Ganjil";
        else
          sem = "Genap";
        $("#select2-semester-container").html("<span class='select2-selection__placeholder'> "+sem+"</span>");
        $('#config_type').val(data.config_course);
        $("#select2-config_type-container").html("<span class='select2-selection__placeholder'>Type "+data.config_course+"</span>");
        var sp = data.enddate.split("-");
        $('#endDate').val(sp[2]+"-"+sp[1]+"-"+sp[0]);
        var sp = data.startdate.split("-");
        $('#startDate').val(sp[2]+"-"+sp[1]+"-"+sp[0]);
    })
  }
  function hapus(id) {
    Swal.fire({
        title: 'Apakah anda yakin akan menghapus data ini?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#f00',
        cancelButtonText: 'Batal',
        cancelButtonColor: '#D0D0D0',
        confirmButtonText: 'Ya'
    }).then((result) => {
        if (result.value) {
                $.ajax({
                type: "POST",
                url: "{{ url('semester') }}"+'/'+id,
                  data:{
                    'id': id,
                    '_method': "DELETE",
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
                }
            });
        }


    })

  }
  
  function aktifkan(id) {
    Swal.fire({
        title: 'Apakah anda yakin akan mengaktifkan data semester ini?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#f00',
        cancelButtonText: 'Batal',
        cancelButtonColor: '#D0D0D0',
        confirmButtonText: 'Ya'
    }).then((result) => {
        if (result.value) {
                $.ajax({
                type: "POST",
                url: "{{ url('semester-aktif') }}",
                  data:{
                    'id': id,
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
                }
            });
        }


    })

  }
  
 
</script>
@endpush