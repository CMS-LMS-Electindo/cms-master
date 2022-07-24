@extends('layouts.das')

@push('prepend-style')

@endpush

@section('title')
    {{$page}} :: {{session('namaApp')}}
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
          <button type="button" class="btn btn-primary me-5" onclick="return getdata();">Cari Mata Kuliah</button>
          <a id="kt_horizontal_search_advanced_link" class="btn btn-link" data-bs-toggle="collapse" href="#kt_advanced_search_form">Filter Mata Kuliah</a>
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
                  @foreach ($sem as $item)
                  <option value="{{$item->id}}" @php
                      if ($item->active == 1) echo "selected";
                  @endphp >{{$item->name}}</option>
                  @endforeach
                </select>
                <!--end::Select-->
              </div>
              <div class="col-lg-9 col-md-8 col-sm-7">
                <label class="fs-6 form-label fw-bolder text-dark">Program Studi</label>
                <!--begin::Select-->
                <select class="form-select form-select-solid" data-control="select2" data-placeholder="Pilih Program Studi"  id="prodiddl" name="prodiddl">
                  <option value=""></option>
                  @foreach ($prodi as $item)
                  <option value="{{$item->code_sia}}" >{{$item->name}}</option>
                  @endforeach
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
      {{-- <div class="mb-xl-8 bg-light-warning rounded p-4 border-danger border border-dashed">
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
        <div class=" d-flex mb-4">
          <div class="symbol symbol-100px symbol-2by3 flex-shrink-0 me-4">
            <img src="assets/media/stock/600x400/img-3.jpg" class="mw-100" alt="" />
          </div>
          <div class="d-flex align-items-center flex-wrap flex-grow-1 mt-n2 mt-lg-n1">
            <div class="d-flex flex-column flex-grow-1 my-lg-0 my-2 pe-3">
              <a href="#" class="fs-5 text-gray-800 text-hover-primary fw-bolder">Nama Mata Kuliah</a>
              <span class="text-gray-400 fw-bold fs-7 my-1">Nama Program Studi</span>
              <span class="text-gray-400 fw-bold fs-7">kurikulum:
              <a href="#" class="text-primary fw-bold">kode kurikulum</a></span>
            </div>
            <div class="text-end py-lg-0 py-2">
              <span class="text-gray-800 fw-boldest fs-3">6</span>
              <span class="text-gray-400 fs-7 fw-bold d-block">SKS</span>
            </div>
          </div>
        </div>
      </div> --}}
      <div class="row g-5 g-xl-8" id="mk_view">
        
      </div>
    </div>
  </div>
 
<div class="modal fade" id="kt_modal_new_target" tabindex="-1" aria-hidden="true">
  <!--begin::Modal dialog-->
  <div class="modal-dialog modal-xl">
    <!--begin::Modal content-->
    <div class="modal-content rounded">
      <!--begin::Modal header-->
      <div class="modal-header justify-content-end border-0 pb-0">
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
      <div class="modal-body pt-0 pb-15 px-5 px-xl-20">
        <div class="mb-13 text-center">
          <h1 class="mb-3">Detail Mata Kuliah</h1>
        </div>
        <div class="d-flex flex-column">
          <div class="row mt-10" id="modalBodyDetail">
            
          </div>
        </div>
        <div class="d-flex flex-center flex-row-fluid pt-12">
          <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
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
    var kode_prodi = $("#prodiddl").val();
    var semester= $("#semester").val();
    var search = $("#search").val();
    $.ajax({
      type: "POST",
      url: "{{ url('get-mk-dosen') }}",
        data:{
          '_token': '{{ csrf_token() }}',kode_prodi,semester,search
      },
      success: function(response) {
        // if (response.status==true) {
          $('#mk_view').html('');
          $('#mk_view').html(response.html);
          $("#progressLMS").addClass('d-none');
          KTMenu.createInstances();
        // }
      }
    })
  }
  
  function buatMK(kelas, kode_prodi,kode_kurikulum,kode_mk,nama_mk,kode_fakultas) {
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
                '_token': '{{ csrf_token() }}',kode_prodi,kode_kurikulum,kode_mk,nama_mk,kode_fakultas
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
                        // Enrol mahasiswa

                        // proses berhenti if error enrol mahasiswa
                        // toastr.success(response.message, 'Pembuatan Mata Kuliah telah selesai', {timeOut: 5000});
                        // $("."+kelas).html(" Buat Kelas");
                        // // $("."+kelas).html(" Buat Mata Kuliah");
                        // $("."+kelas).addClass('btn-danger');
                        // $("."+kelas).removeClass("btn-light");
                        
                        // $("#progressBarMK").css("width","100%");
                        // $("#progressBarMK").attr("aria-valuenow",'100');
                        // $("#progressBarMK").html("100%");

                        // getdata();
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
  
  function syncMahasiswa(kelas, kode_prodi,kode_kurikulum,kode_mk,nama_mk, idLMS) {
    
    $("#progressLMS").removeClass('d-none');
    const element = document.getElementById("progressLMS");
    element.scrollIntoView();
    var progress = Math.floor(Math.random() * 10) + 12;
    $("#progressBarMK").css("width",progress+"%");
    $("#progressBarMK").attr("aria-valuenow",progress);
    $("#progressBarMK").html(progress+"%");
    $("#progressTitle").html("Ambil Data Mahasiswa Pada Mata Kuliah... (Mohon Bersabar)");
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
          var grup = 0;
          $.ajax({
            type: "POST",
            url: "{{ url('add-mhs-grup-mata-kuliah') }}",
              data:{
                '_token': '{{ csrf_token() }}',kode_prodi,kode_kurikulum,kode_mk,idLMS,grup
            },
            success: function(response) {
              //ubah progressBar
              if (response.status==true) {
                var progress = response.progress;
                $("#progressBarMK").css("width",progress+"%");
                $("#progressBarMK").attr("aria-valuenow",progress);
                $("#progressBarMK").html(progress+"%");
                $("#progressTitle").html("Gruping Mahasiswa...");
                toastr.success(response.message, 'Sinkronisasi Mahasiswa Telah Selesai', {timeOut: 5000});
                $("#progressLMS").addClass('d-none');
                // getdata();
              } else{
                toastr.error(response.message, 'Gagal', {timeOut: 5000});
              }
            }
          });
        } else{
          toastr.error(response.message, 'Gagal', {timeOut: 5000});
        }
      }
    });
  }
  function detailMK(kode_kurikulum,kode_mk) {
    $('#kt_modal_new_target').modal('show');
    $.ajax({
      type: "POST",
      url: "{{ url('get-detail-mk') }}",
        data:{
          '_token': '{{ csrf_token() }}',kode_kurikulum,kode_mk,
      },
      success: function(response) {
          if (response.status==true) {
            $("#modalBodyDetail").html(response.html);
          } else{
          }
      }
    })
  }
</script>
@endpush