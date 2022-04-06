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
      <div class="align-items-center row">
        <div class="position-relative  col-md-4 mt-2">
          <span class="svg-icon svg-icon-3 svg-icon-gray-500 position-absolute top-50 translate-middle ms-6">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
              <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
            </svg>
          </span>
          <input type="text" class="form-control form-control-solid ps-10" name="search" id="search" value="" placeholder="Cari Nama / Kode Mata Kuliah" />
        </div>
        <div class="position-relative col-md-4 mt-2">
          <span class="svg-icon svg-icon-3 svg-icon-gray-500 position-absolute top-50 translate-middle ms-6">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
              <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
            </svg>
          </span>
          <select class="form-select form-select-solid" data-control="select2" data-placeholder="Pilih Semester" data-hide-search="true" id="semester" name="semester">
            <option value=""></option>@foreach ($sem as $item)
            <option value="{{$item->id}}" @php
                if ($item->active == 1) echo "selected";
            @endphp >{{$item->name}}</option>
            @endforeach
          </select>
        </div>
        <!--end::Input group-->
        <!--begin:Action-->
        <div class="d-flex align-items-center col-md-4 text-center mt-2">
          <button type="button" class="btn btn-primary me-5" onclick="getdata()">Cari Mata Kuliah</button>
        </div>
        <!--end:Action-->
      </div>
    </div>
  </div>
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
    // $.get("{{ url('mata-kuliah-mahasiswa') }}" +'/1/edit', function (data) {
    //     $('#mk_view').html('');
    //     $('#mk_view').html(data.html);
    //     KTMenu.createInstances();
    // })
    var semester= $("#semester").val();
    var search = $("#search").val();
    $.ajax({
      type: "POST",
      url: "{{ url('get-mk-mahasiswa') }}",
        data:{
          '_token': '{{ csrf_token() }}',semester,search
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