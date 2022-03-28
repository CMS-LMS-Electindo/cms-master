@extends('layouts.das')

@push('prepend-style')

@endpush

@section('title')
    {{$page}} :: {{session('applicationName')}}
@endsection

@section('content')


  <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6 mb-5 mx-5">
    <!--begin::Wrapper-->
    <div class="d-flex flex-stack flex-grow-1">
      <!--begin::Content-->
      <div class="fw-bold">
        <div class="fs-6 text-gray-700">
        <a href="#" class="fw-bolder me-1">Peringatan </a> Jika ada data mata kuliah yang belum masuk atau tidak sesuai, silakan hubungi operator prodi masing-masing.</div>
      </div>
      <!--end::Content-->
    </div>
    <!--end::Wrapper-->
  </div>
  <!--begin::Card-->
  <div class="card mb-7 mx-5">
    <!--begin::Card body-->
    <div class="card-body">
      <div class="d-flex align-items-center">
        <div class="position-relative w-md-400px me-md-2">
          <span class="svg-icon svg-icon-3 svg-icon-gray-500 position-absolute top-50 translate-middle ms-6">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
              <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
            </svg>
          </span>
          <input type="text" class="form-control form-control-solid ps-10" name="search" id="search" value="" placeholder="Cari Nama / Kode Mata Kuliah" />
        </div>
        <!--end::Input group-->
        <!--begin:Action-->
        <div class="d-flex align-items-center">
          <button type="button" class="btn btn-primary me-5">Cari Mata Kuliah</button>
          <a id="kt_horizontal_search_advanced_link" class="btn btn-link" data-bs-toggle="collapse" href="#kt_advanced_search_form">Advanced Search</a>
        </div>
        <!--end:Action-->
      </div>
      <div class="collapse" id="kt_advanced_search_form">
        <!--begin::Separator-->
        <div class="separator separator-dashed mt-9 mb-6"></div>
        <!--end::Separator-->
        <!--begin::Row-->
        <div class="row g-8 mb-8">
          <div class="col-xxl-5">
            <!--begin::Row-->
            <div class="row g-8">
              <!--begin::Col-->
              <div class="col-lg-3 col-md-4 col-sm-5">
                <label class="fs-6 form-label fw-bolder text-dark">Semester</label>
                <!--begin::Select-->
                <select class="form-select form-select-solid" data-control="select2" data-placeholder="Pilih Semester" data-hide-search="true" id="semester" name="semester">
                  <option value=""></option>
                  <option value="1">Not started</option>
                </select>
                <!--end::Select-->
              </div>
              <div class="col-lg-9 col-md-8 col-sm-7">
                <label class="fs-6 form-label fw-bolder text-dark">Program Studi</label>
                <!--begin::Select-->
                <select class="form-select form-select-solid" data-control="select2" data-placeholder="Pilih Program Studi" data-hide-search="true" id="prodi" name="prodi">
                  <option value=""></option>
                  <option value="1">Not started</option>
                </select>
                <!--end::Select-->
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Col-->
        </div>
        <!--end::Row-->
      </div>
    </div>
  </div>
  <div class="card mb-7 mx-5 d-none" id="progressLMS">
    <!--begin::Card body-->
    <div class="card-body">
      <div class="d-flex align-items-center">
        <div class="modal-body ">
          <!--begin:Form-->
          <form id="kt_modal_new_target_form" class="form" action="#">
          <!--begin::Heading-->
            <div class="mb-13 text-center">
              <h1 class="mb-3" id="inputTitle">Progresh Pembuatan Mata Kuliah LMS</h1>
            </div>
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
          </form>
          <!--end:Form-->
        </div>
      </div>
    </div>
  </div>
  <!--end::Form-->
  <div class="card mb-5 mb-xl-8 mx-5">
    <!--begin::Header-->
    <div class="card-header border-0 pt-5 ">
      <h3 class="card-title align-items-start flex-column">
        <span class="card-label fw-bolder fs-3 mb-1">List {{$page}}</span>
        {{-- <span class="text-muted mt-1 fw-bold fs-7">Over 500 members</span> --}}
      </h3>
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body py-3">
      <div class="row g-5 g-xl-8" id="mk_view">
        
          {{-- <div class="col-xl-12">
            <div class="card card-xl-stretch mb-5 mb-xl-8 bg-light-warning rounded p-4 border-danger border border-dashed">
              <div class="card-header border-0 mb-3" style="min-height: auto; justify-content: start; z-index: 1;">
                <div class=" m-2">
                  <button type="button" class="btn btn-sm btn-icon btn-color-light-dark btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" style="width: auto;">
                    <div class="badge badge-primary p-3" style="font-size: 11px;"> 
                      <span class="menu-icon">
                        <i class="bi bi-people-fill fs-3" style="color: white"></i>
                      </span> &nbsp;&nbsp;Peserta  &nbsp;&nbsp; 
                      
                      <span class="menu-icon">
                        <i class="bi bi-caret-down-fill fs-5 " style="color: white"></i>
                      </span>
                    </div>
                  </button>
                  <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3" data-kt-menu="true">
                    <div class="menu-item px-3">
                      <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Peserta</div>
                    </div>
                    <div class="menu-item px-3">
                      <a href="#" class="menu-link px-3">Sinkron Peserta</a>
                    </div>
                    <div class="menu-item px-3 my-1">
                      <a href="#" class="menu-link px-3">Enrol Dosen LB/Tamu</a>
                    </div>
                    <div class="menu-item px-3">
                      <a href="#" class="menu-link px-3">Daftar Mahasiswa</a>
                    </div>
                    <div class="menu-item px-3">
                      <a href="#" class="menu-link px-3">Daftar Kelas</a>
                    </div>
                  </div>
                </div>
                <div class=" m-2">
                  <button type="button" class="btn btn-sm btn-icon btn-color-light-dark btn-active-light-success" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" style="width: auto;">
                    <div class="badge badge-success p-3" style="font-size: 11px;"> 
                      <span class="menu-icon">
                        <i class="bi bi-award-fill fs-3" style="color: white"></i>
                      </span> &nbsp;&nbsp; Nilai  &nbsp;&nbsp; 
                      <span class="menu-icon">
                        <i class="bi bi-caret-down-fill fs-5" style="color: white"></i>
                      </span>
                    </div>
                  </button>
                  <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3" data-kt-menu="true">
                    <div class="menu-item px-3">
                      <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Nilai</div>
                    </div>
                    <div class="menu-item px-3">
                      <a href="#" class="menu-link px-3">Atur Bobot Nilai</a>
                    </div>
                    <div class="menu-item px-3 my-1">
                      <a href="#" class="menu-link px-3">Daftar Nilai</a>
                    </div>
                    <div class="menu-item px-3 my-1">
                      <a href="#" class="menu-link px-3">Export Nilai</a>
                    </div>
                  </div>
                </div>
                <div class=" m-2">
                  <button type="button" class="btn btn-sm btn-icon btn-color-light-dark btn-active-light-secondary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" style="width: auto;">
                    <div class="badge badge-secondary p-3" style="font-size: 11px;"> 
                      <span class="menu-icon">
                        <i class="bi bi-binoculars-fill fs-3" style="color: white"></i>
                      </span> &nbsp;&nbsp;Monitoring Kelas  &nbsp;&nbsp; 
                      
                      <span class="menu-icon">
                        <i class="bi bi-caret-down-fill fs-5" style="color: white"></i>
                      </span>
                    </div>
                  </button>
                  <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3" data-kt-menu="true">
                    <div class="menu-item px-3">
                      <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Monitoring Kelas</div>
                    </div>
                    <div class="menu-item px-3">
                      <a href="#" class="menu-link px-3">Statistik Kelas</a>
                    </div>
                    <div class="menu-item px-3 my-1">
                      <a href="#" class="menu-link px-3">Ketuntasan Mahasiswa</a>
                    </div>
                    <div class="menu-item px-3 my-1">
                      <a href="#" class="menu-link px-3">Partisipasi Mahasiswa</a>
                    </div>
                  </div>
                </div>
                <div class=" m-2">
                  <button type="button" class="btn btn-sm btn-icon btn-color-light-dark btn-active-light-warning" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" style="width: auto;">
                    <div class="badge badge-warning p-3" style="font-size: 11px;"> 
                      <span class="menu-icon">
                        <i class="bi bi-bookmarks-fill fs-3" style="color: white"></i>
                      </span> &nbsp;&nbsp;Bank Soal  &nbsp;&nbsp; 
                      
                      <span class="menu-icon">
                        <i class="bi bi-caret-down-fill fs-5" style="color: white"></i>
                      </span>
                    </div>
                  </button>
                  <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3" data-kt-menu="true">
                    <div class="menu-item px-3">
                      <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Bank Soal</div>
                    </div>
                    <div class="menu-item px-3">
                      <a href="#" class="menu-link px-3">Daftar Soal</a>
                    </div>
                    <div class="menu-item px-3 my-1">
                      <a href="#" class="menu-link px-3">Import Soal</a>
                    </div>
                    <div class="menu-item px-3 my-1">
                      <a href="#" class="menu-link px-3">Export Soal</a>
                    </div>
                  </div>
                </div>
                <div class=" m-2">
                  <button type="button" class="btn btn-sm btn-icon btn-color-light-dark btn-active-light-danger" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" style="width: auto;">
                    <div class="badge badge-danger p-3" style="font-size: 11px;"> 
                      <span class="menu-icon">
                        <i class="bi bi-gear-fill fs-3" style="color: white"></i>
                      </span> &nbsp;&nbsp;Tools  &nbsp;&nbsp; 
                      
                      <span class="menu-icon">
                        <i class="bi bi-caret-down-fill fs-5" style="color: white"></i>
                      </span>
                    </div>
                  </button>
                  <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3" data-kt-menu="true">
                    <div class="menu-item px-3">
                      <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Pengaturan</div>
                    </div>
                    <div class="menu-item px-3">
                      <a href="#" class="menu-link px-3">Pengaturan Kelas</a>
                    </div>
                    <div class="menu-item px-3 my-1">
                      <a href="#" class="menu-link px-3">Backup Kelas</a>
                    </div>
                    <div class="menu-item px-3 my-1">
                      <a href="#" class="menu-link px-3">Restore Kelas</a>
                    </div>
                    <div class="menu-item px-3 my-1">
                      <a href="#" class="menu-link px-3">Import Kelas</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body p-0" style=" z-index: 1;">
                <div class="d-flex align-items-center p-5 pt-0 ">
                  <span class="svg-icon svg-icon-warning me-5">
                    <span class="svg-icon svg-icon-1">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="black" />
                        <path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="black" />
                      </svg>
                    </span>
                  </span>
                  <div class="flex-grow-1 me-2">
                    <a href="#" class="fw-bolder text-gray-800 text-hover-primary fs-2x">{{$item->}} - Arsitektur</a>
                    <div class="d-flex mb-1">
                      <div class="notice d-flex bg-light-warning rounded border-primary border border-dashed p-2 mx-1" style="width: fit-content;">
                        <span class="text-muted fw-bold d-block">kode Kurikulum</span> 
                      </div>
                      <div class="notice d-flex bg-light-warning rounded border-primary border border-dashed p-2 mx-1" style="width: fit-content;">
                        <span class="fw-bolder text-gray-800 text-hover-primary fs-6"> Nama Program Studi </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer p-0" style="border-top: 0px; z-index: 0;">
                <div class="d-flex mb-1" style="justify-content: flex-end;">
                  <a href="#" class="btn btn-sm btn-bg-light btn-active-color-primary me-3">Info Mata Kuliah</a>
                  <a href="#" class="btn btn-sm btn-success me-3">Masuk</a>
                  <a href="#" class="btn btn-sm btn-danger me-3">Buat Mata Kuliah</a>
                </div>
              </div>
              <img src="assets/media/illustrations/sigma-1/17-dark.png" class="position-absolute me-3 end-0 h-200px" alt="" style="z-index: 1; bottom: 28px;" />
            </div>
          </div> --}}
      </div>
    </div>
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
    $.get("{{ url('mata-kuliah') }}" +'/1/edit', function (data) {
        $('#mk_view').html('');
        $('#mk_view').html(data.html);
        $("#progressLMS").addClass('d-none');
        KTMenu.createInstances();
      // var menuElement = document.querySelector("#kt_menu");
      // var menu = KTMenu.getInstance(menuElement);
    })
  }
  
  function buatMK(kelas, kode_prodi,kode_kurikulum,kode_mk,nama_mk) {
    Swal.fire({
        title: 'Apakah anda yakin akan membuat Mata Kuliah ini ke LMS?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#f00',
        cancelButtonText: 'Batal',
        cancelButtonColor: '#D0D0D0',
        confirmButtonText: 'Ya'
    }).then((result) => {
        if (result.value) {
          $("#progressLMS").removeClass('d-none');
          const element = document.getElementById("progressLMS");
          element.scrollIntoView();
          $("."+kelas).html("<i class='fas fa-sync-alt mt-0 fa-spin'></i> Loading");
          $("."+kelas).addClass('btn-danger');
          $("."+kelas).removeClass("btn-light");

          $("#progressBarMK").css("width","5%");
          $("#progressBarMK").attr("aria-valuenow","5");
          $("#progressBarMK").html("5%");
          $("#progressTitle").html("Pembuatan Mata Kuliah...");
          $.ajax({
            type: "POST",
            url: "{{ url('buat-mata-kuliah') }}",
              data:{
                '_token': '{{ csrf_token() }}',kode_prodi,kode_kurikulum,kode_mk,nama_mk
            },
            success: function(response) {
                if (response.status==true) {
                  document.body.scrollTop = 0; // For Safari
                  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
                  // toastr.success(response.message, 'Berhasil', {timeOut: 5000});
                  // getdata();
                  //ubah progressBar
                  var progress = response.progress;
                  $("#progressBarMK").css("width",progress+"%");
                  $("#progressBarMK").attr("aria-valuenow",progress);
                  $("#progressBarMK").html(progress+"%");
                  $("#progressTitle").html("Enrol Dosen Pengampu Mata Kuliah...");
                  
                  var idLMS = response.id_lms ;
                  // Enrol Dosen
                  $.ajax({
                    type: "POST",
                    url: "{{ url('enrol-dosen-mata-kuliah') }}",
                      data:{
                        '_token': '{{ csrf_token() }}',kode_prodi,kode_kurikulum,kode_mk,idLMS
                    },
                    success: function(response) {
                      //ubah progressBar
                      if (response.status==true) {
                        var progress = response.progress;
                        $("#progressBarMK").css("width",progress+"%");
                        $("#progressBarMK").attr("aria-valuenow",progress);
                        $("#progressBarMK").html(progress+"%");
                        $("#progressTitle").html("Enrol Mahasiswa Mata Kuliah (Harap Bersabar)...");
                        // Enrol Dosen
                        $.ajax({
                          type: "POST",
                          url: "{{ url('enrol-mahasiswa-mata-kuliah') }}",
                            data:{
                              '_token': '{{ csrf_token() }}',kode_prodi,kode_kurikulum,kode_mk,idLMS
                          },
                          success: function(response) {
                            //ubah progressBar
                            if (response.status==true) {
                              var progress = response.progress;
                              $("#progressBarMK").css("width",progress+"%");
                              $("#progressBarMK").attr("aria-valuenow",progress);
                              $("#progressBarMK").html(progress+"%");
                              $("#progressTitle").html("Gruping Mahasiswa pada Mata Kuliah...");
                              $.ajax({
                                type: "POST",
                                url: "{{ url('buat-grup-mata-kuliah') }}",
                                  data:{
                                    '_token': '{{ csrf_token() }}',kode_prodi,kode_kurikulum,kode_mk,idLMS
                                },
                                success: function(response) {
                                  //ubah progressBar
                                  if (response.status==true) {
                                    var progress = response.progress;
                                    $("#progressBarMK").css("width",progress+"%");
                                    $("#progressBarMK").attr("aria-valuenow",progress);
                                    $("#progressBarMK").html(progress+"%");
                                    $("#progressTitle").html("Gruping Mahasiswa...");
                                    toastr.success(response.message, 'Pembuatan Mata Kuliah telah selesai', {timeOut: 5000});
                                    $("."+kelas).html(" Buat Kelas");
                                    // $("."+kelas).html(" Buat Mata Kuliah");
                                    $("."+kelas).addClass('btn-danger');
                                    $("."+kelas).removeClass("btn-light");
                                    getdata();
                                  } else{
                                    toastr.error(response.message, 'Gagal', {timeOut: 5000});
                                    $("."+kelas).html(" Buat Kelas");
                                    // $("."+kelas).html(" Buat Mata Kuliah");
                                    $("."+kelas).addClass('btn-danger');
                                    $("."+kelas).removeClass("btn-light");
                                  }
                                }
                              });
                            } else{
                              toastr.error(response.message, 'Gagal', {timeOut: 5000});
                              $("."+kelas).html(" Buat Kelas");
                              // $("."+kelas).html(" Buat Mata Kuliah");
                              $("."+kelas).addClass('btn-danger');
                              $("."+kelas).removeClass("btn-light");
                            }
                          }
                        });
                      } else{
                        toastr.error(response.message, 'Gagal', {timeOut: 5000});
                        $("."+kelas).html(" Buat Kelas");
                        // $("."+kelas).html(" Buat Mata Kuliah");
                        $("."+kelas).addClass('btn-danger');
                        $("."+kelas).removeClass("btn-light");
                      }
                    }
                  });
                } else{
                  toastr.error(response.message, 'Gagal', {timeOut: 5000});
                $("."+kelas).html(" Buat Kelas");
                // $("."+kelas).html(" Buat Mata Kuliah");
                $("."+kelas).addClass('btn-danger');
                $("."+kelas).removeClass("btn-light");
                }
            }
          });
        }
    })
  }
</script>
@endpush