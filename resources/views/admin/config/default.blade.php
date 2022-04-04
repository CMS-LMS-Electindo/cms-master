@extends('layouts.das')

@push('prepend-style')
@endpush

@section('title')
    {{$page}} :: {{session('applicationName')}}
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
              <th class="min-w-200px">Nama Aplikasi</th>
              <th class="min-w-200px">Domain PT</th>
              <th class="min-w-150px">Config </th>
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
  <div class="modal-dialog modal-dialog-centered modal-lg">
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
            <div class="text-muted fw-bold fs-5">Penambahan Data Config dalam rangka menentukan konfigurasi aplikasi dalam manajemen mata kuliah yang akan dikoneksikan ke LMS.
            {{-- <a href="#" class="fw-bolder link-primary">Project Guidelines</a>. --}}
            </div>
            <!--end::Description-->
          </div>
          <!--end::Heading-->
          <!--begin::Input group-->
          <div class="d-flex flex-column mb-8 fv-row">
            <!--begin::Label-->
            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
              <span class="required" for="appName">Nama Aplikasi</span>
              {{-- <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify a target name for future usage and reference"></i> --}}
            </label>
            <!--end::Label-->
            <input type="text" class="form-control form-control-solid" placeholder="Enter Nama Aplikasi" name="appName" id="appName" />
          </div>
          <div class="row g-9 mb-8">
            <!--begin::Col-->
            
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-md-6 fv-row">
              <label class="required fs-6 fw-bold mb-2" for="ptName">Nama Perguruan Tinggi</label>
              <!--begin::Input-->
              <div class="position-relative d-flex align-items-center">
                <input type="text" class="form-control form-control-solid" placeholder="Enter Nama Perguruan Tinggi" name="ptName" id="ptName" />
              </div>
              <!--end::Input-->
            </div>
            <!--end::Col-->
            <div class="col-md-6 fv-row">
              <label class="required fs-6 fw-bold mb-2" for="ptCode">Kode Perguruan Tinggi</label>
              <!--begin::Input-->
              <div class="position-relative d-flex align-items-center">
                <input type="text" class="form-control form-control-solid" placeholder="Enter Nama Kode Perguruan Tinggi" name="ptCode" id="ptCode" />
              </div>
              <!--end::Input-->
            </div>
            
          </div>
          <div class="row g-9 mb-8">
            <!--begin::Col-->
            
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-md-6 fv-row">
              <label class="required fs-6 fw-bold mb-2" for="ptDomain">Domain Perguruan Tinggi</label>
              <!--begin::Input-->
              <div class="position-relative d-flex align-items-center">
                <input type="text" class="form-control form-control-solid" placeholder="Enter Domain Perguruan Tinggi" name="ptDomain" id="ptDomain" />
              </div>
              <!--end::Input-->
            </div>
            <!--end::Col-->
            <div class="col-md-6 fv-row">
              <label class="required fs-6 fw-bold mb-2" for="ptEmail">Email Perguruan Tinggi</label>
              <!--begin::Input-->
              <div class="position-relative d-flex align-items-center">
                <input type="text" class="form-control form-control-solid" placeholder="Enter Email Kode Perguruan Tinggi" name="ptEmail" id="ptEmail" />
              </div>
              <!--end::Input-->
            </div>
            <div class="col-md-12 fv-row">
              <label class=" fs-6 fw-bold mb-2" for="lmsDomain">Domain LMS</label>
              <!--begin::Input-->
              <div class="position-relative d-flex align-items-center">
                <input type="text" class="form-control form-control-solid" placeholder="Enter Domain LMS Perguruan Tinggi" name="lmsDomain" id="lmsDomain" />
              </div>
              <!--end::Input-->
            </div>
            
            <div class="col-md-6 fv-row">
              <label class=" fs-6 fw-bold mb-2" for="apiDomain">Domain API SIA</label>
              <!--begin::Input-->
              <div class="position-relative d-flex align-items-center">
                <input type="text" class="form-control form-control-solid" placeholder="Enter Domain API SIA Perguruan Tinggi" name="apiDomain" id="apiDomain" />
              </div>
              <!--end::Input-->
            </div>
            <div class="col-md-6 fv-row">
              <label class=" fs-6 fw-bold mb-2" for="keyApiSia">Key App SIA</label>
              <!--begin::Input-->
              <div class="position-relative d-flex align-items-center">
                <input type="text" class="form-control form-control-solid" placeholder="Enter Key API SIA" name="keyApiSia" id="keyApiSia" />
              </div>
              <!--end::Input-->
            </div>
            
            
          </div>
          <div class="row g-9 mb-8">
            <div class="col-md-12 fv-row">
              <label class=" fs-6 fw-bold mb-2" for="token_lms">Token LMS</label>
              <input type="text" class="form-control form-control-solid" placeholder="Enter Token" name="token_lms" id="token_lms" />
            </div>
            <div class="col-md-12 fv-row">
              <label class=" fs-6 fw-bold mb-2" for="token_auth">Token Auth</label>
              <input type="text" class="form-control form-control-solid" placeholder="Enter Token" name="token_auth" id="token_auth" />
            </div>
            <div class="col-md-12 fv-row">
              <label class=" fs-6 fw-bold mb-2" for="token_sia">Token API SIA</label>
              <input type="text" class="form-control form-control-solid" placeholder="Enter Token" name="token_sia" id="token_sia" />
            </div>
          </div>
          <div class="row g-9 mb-8">
            <div class="col-md-12 fv-row">
              <label class="required fs-6 fw-bold mb-2" for="config_req">Config Pembuatan Mata Kuliah</label>
              <select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Select a Config Type" name="config_req" id="config_req">
                <option value="">Select Type...</option>
                <option value="Buat Otomatis">Buat Otomatis</option>
                <option value="Paksa Buat">Paksa Buat</option>
              </select>
            </div>
            <div class="d-flex flex-column mb-8">
              <label class="fs-6 fw-bold mb-2">Deskripsi</label>
              <textarea class="form-control form-control-solid" rows="3" name="desc" id="desc" placeholder="Type Deskripsi"></textarea>
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
        "url": "{{ ('/config') }}",
        "dataType": "json",
        "type": "GET",
        "data":{ _token: "{{csrf_token()}}"}
      },
      // ajax: "{{ ('/nomor-surat') }}",
      columns: [
          {
              data: 'DT_RowIndex', 
              name: 'DT_RowIndex',
                className: "text-center"
          },
          {data: 'nama', name: 'nama'},
          {data: 'domain', name: 'domain',},
          {data: 'config', name: 'config',},
          {data: 'aktif', name: 'aktif',},
          {data: 'action', name: 'action', orderable: false, searchable: false},
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
        url: "{{ url('/config') }}",
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
    $.get("{{ url('config') }}" +'/' + id +'/edit', function (data) {
        $('#kt_modal_new_target').modal('show');
        $('#inputTitle').html('Ubah '+title);
        $('#appName').val(data.nama_app);
        $('#ptName').val(data.nama_pt);
        $('#ptCode').val(data.code_pt);
        $('#ptDomain').val(data.domain_pt);
        $('#ptEmail').val(data.email_pt);
        $('#config_req').val(data.req_course);
        $('#desc').val(data.desc);
        $('#lmsDomain').val(data.domain_lms);
        $('#apiDomain').val(data.domain_api);
        $('#token_lms').val(data.token_lms);
        $('#token_auth').val(data.token_auth);
        $('#keyApiSia').val(data.app_sia);
        $('#token_sia').val(data.token_sia);
        $("#select2-config_req-container").html("<span class='select2-selection__placeholder'>"+data.req_course+"</span>");
        
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
                url: "{{ url('config') }}"+'/'+id,
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
        title: 'Apakah anda yakin akan mengaktifkan data Config ini?',
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
                url: "{{ url('config-aktif') }}",
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