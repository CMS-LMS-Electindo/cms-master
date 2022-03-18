@extends('layouts.app')
@section('title')
    {{ session('applicationName') }}
@endsection

@section('content')
<div class="d-flex flex-column flex-root">
  <!--begin::Authentication - Sign-in -->
  <div class="d-flex flex-column flex-lg-row flex-column-fluid">
    <!--begin::Aside-->
    <div class="d-flex flex-column flex-lg-row-auto w-xl-600px positon-xl-relative" style="background-color: #F2C98A">
      <!--begin::Wrapper-->
      <div class="d-flex flex-column position-xl-fixed top-0 bottom-0 w-xl-600px scroll-y">
        <!--begin::Content-->
        <div class="d-flex flex-row-fluid flex-column text-center p-10 pt-lg-20">
          <!--begin::Logo-->
          <a href="../../demo1/dist/index.html" class="py-9 mb-5">
            <img alt="Logo" src="assets/media/logos/unm.png" class="h-90px" />
          </a>
          <!--end::Logo-->
          <!--begin::Title-->
          <h1 class="fw-bolder fs-2qx pb-5 pb-md-10" style="color: #986923;">Welcome to Course Management System</h1>
          <!--end::Title-->
          <!--begin::Description-->
          <p class="fw-bold fs-2" style="color: #986923;">Universitas Negeri Makassar
          </p>
          <!--end::Description-->
        </div>
        <!--end::Content-->
        <!--begin::Illustration-->
        <div class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px" style="background-image: url(assets/media/illustrations/sketchy-1/13.png"></div>
        <!--end::Illustration-->
      </div>
      <!--end::Wrapper-->
    </div>
    <!--end::Aside-->
    <!--begin::Body-->
    <div class="d-flex flex-column flex-lg-row-fluid py-10">
      <!--begin::Content-->
      <div class="d-flex flex-center flex-column flex-column-fluid">
        <!--begin::Wrapper-->
        <div class="w-lg-500px p-10 p-lg-15 mx-auto">
          <!--begin::Form-->
              @csrf
            <!--begin::Heading-->
            <div class="text-center mb-10">
              <!--begin::Title-->
              <h1 class="text-dark mb-3">Sign In to CMS - UNM</h1>
              <!--end::Title-->
              <!--begin::Link-->
              {{-- <div class="text-gray-400 fw-bold fs-4">New Here?
              <a href="../../demo1/dist/authentication/layouts/aside/sign-up.html" class="link-primary fw-bolder">Create an Account</a></div> --}}
              <!--end::Link-->
            </div>
                <div id="message"></div>
                {{-- <div class="card-header">{{ __('Login') }}</div> --}}

            <!--begin::Heading-->
          <form method="POST" action="{{ route('login') }}" class="form w-100" novalidate="novalidate" id="kt_sign_in_form1" >
            @csrf
            <!--begin::Input group-->
            <div class="fv-row mb-10">
              <!--begin::Label-->
              <label class="form-label fs-6 fw-bolder text-dark" for="username">Username</label>
              <!--end::Label-->
              <!--begin::Input-->
              <input class="form-control form-control-lg form-control-solid" type="text" name="username" id="username" autocomplete="off" />
              @error('email')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
              <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-10">
              <!--begin::Wrapper-->
              <div class="d-flex flex-stack mb-2">
                <!--begin::Label-->
                <label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
                <!--end::Label-->
                <!--begin::Link-->
                <a href="../../demo1/dist/authentication/layouts/aside/password-reset.html" class="link-primary fs-6 fw-bolder">Forgot Password ?</a>
                <!--end::Link-->
              </div>
              <!--end::Wrapper-->
              <!--begin::Input-->
              <input class="form-control form-control-lg form-control-solid" type="password" name="password" autocomplete="off" id="password"/>
              @error('password')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
              <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Actions-->
            <div class="text-center">
              <!--begin::Submit button-->
              <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                <span class="indicator-label">Continue</span>
                <span class="indicator-progress">Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
              </button>
              <!--end::Submit button-->
              <!--begin::Separator-->
              <div class="text-center text-muted text-uppercase fw-bolder mb-5">or</div>
              <!--end::Separator-->
              <!--begin::Google link-->
              <a href="#" class="btn btn-flex flex-center btn-light btn-lg w-100 mb-5">
              <img alt="Logo" src="assets/media/svg/brand-logos/google-icon.svg" class="h-20px me-3" />Continue with Google</a>
              <!--end::Google link-->
              <!--begin::Google link-->
              <a href="#" class="btn btn-flex flex-center btn-light btn-lg w-100 mb-5">
              <img alt="Logo" src="assets/media/svg/brand-logos/facebook-4.svg" class="h-20px me-3" />Continue with Facebook</a>
              <!--end::Google link-->
              <!--begin::Google link-->
              <a href="#" class="btn btn-flex flex-center btn-light btn-lg w-100">
              <img alt="Logo" src="assets/media/svg/brand-logos/apple-black.svg" class="h-20px me-3" />Continue with Apple</a>
              <!--end::Google link-->
          </form>

            </div>
            <!--end::Actions-->
          <!--end::Form-->
        </div>
        <!--end::Wrapper-->
      </div>
      <!--end::Content-->
      <!--begin::Footer-->
      <div class="d-flex flex-center flex-wrap fs-6 p-5 pb-0">
        <!--begin::Links-->
        <div class="d-flex flex-center fw-bold fs-6">
          <a href="https://keenthemes.com" class="text-muted text-hover-primary px-2" target="_blank">About</a>
          <a href="https://devs.keenthemes.com" class="text-muted text-hover-primary px-2" target="_blank">Support</a>
          <a href="https://1.envato.market/EA4JP" class="text-muted text-hover-primary px-2" target="_blank">Purchase</a>
        </div>
        <!--end::Links-->
      </div>
      <!--end::Footer-->
    </div>
    <!--end::Body-->
  </div>
  <!--end::Authentication - Sign-in-->
</div>
@endsection

@push('prepend-script')
  <!-- Vendor js -->
<script src="assets/js/vendor.min.js"></script>

@endpush
@push('addon-script')
<script>
  function detail(id){
    var form = $('#formI');
        form.find('.invalid-feedback').remove();
        form.find('.form-control').removeClass('is-invalid');
    $.get("{{ url('mata-kuliah-detail') }}" +'/' + id +'/edit', function (data) {
        $('#detail').modal('show');
        // $('#inputTitle').html('Ubah '+title);
        $('#img1').attr('src', 'assets/img_mk/'+ data.image);
        if (data.image == null)
          $('#img1').attr('src', 'assets/img_mk/matakuliah.png');
        $('#nama').html(data.kode_mk+" - "+data.nama_mk);
        $('#sks').html(""+data.sks + " sks");
        $('#semester').html('semester : '+data.semester);
        $('#deskripsi').html(data.deskripsi);

        $('#li11').html('<i class="mdi mdi-circle-medium mr-1 align-middle"></i> Jenis Pengajaran MK : ' +data.jenis_mk);
        $('#li12').html('<i class="mdi mdi-circle-medium mr-1 align-middle"></i> Jenis Kewajiban MK : '+data.kewajiban_mk);
        $('#li13').html('<i class="mdi mdi-circle-medium mr-1 align-middle"></i> Konsentrasi : '+data.konsentrasi);
        $('#prodi').html(data.prodi1['nama_prodi']);
    })
    getdosen(id);
  }
  function getdosen(id_mk){
    // console.log(tahun);
     var table = $('#tabelDosen').DataTable();
    table.destroy();
    var table = $('#tabelDosen').DataTable({
        
      // "scrollY": "200px",
      "scrollCollapse": true,
      processing: false,
      serverSide: true,
      ajax:{
        "url": "{{ ('/dosen-mata-kuliah-home') }}",
        "dataType": "json",
        "type": "GET",
        "data":{ _token: "{{csrf_token()}}",id_mk}
      },
      // ajax: "{{ ('/nomor-surat') }}",
      columns: [
          {
              data: 'DT_RowIndex', 
              name: 'DT_RowIndex',
                className: "text-center"
          },
          {data: 'nidn', name: 'nidn'},
          {data: 'nama', name: 'nama'},
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
  }
</script>
@endpush