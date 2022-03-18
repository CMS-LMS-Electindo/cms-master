@extends('layouts.das')

@push('prepend-style')
<!-- Summernote css -->
<link href="assets/libs/summernote/summernote-bs4.min.css" rel="stylesheet" type="text/css" />

<link href="assets/libs/mohithg-switchery/switchery.min.css" rel="stylesheet" type="text/css" />
<link href="assets/libs/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />
<link href="assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="assets/libs/selectize/css/selectize.bootstrap3.css" rel="stylesheet" type="text/css" />
<link href="assets/libs/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
<link href="assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" type="text/css" />
@endpush

@section('title')
    {{$page}} :: {{session('applicationName')}}
@endsection

@section('content')

  <!-- Start Content-->
  <div class="container-fluid">
    <!-- start page title -->
    <div class="row">
      <div class="col-12">
        <div class="page-title-box page-title-box-alt">
          <h4 class="page-title">
            {{session('applicationName')}}
          </h4>
          <div class="page-title-right">
            <ol class="breadcrumb m-0">
              <li class="breadcrumb-item">
                <a href="dashboard">{{session('appName')}}</a>
              </li>
              <li class="breadcrumb-item active">{{$page}}</li>
              {{-- <li class="breadcrumb-item active">Sales</li> --}}
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!-- end page title -->

    
    <div class="row">
        <div class="col-12">
            <div class="card ribbon-box">
                <div class="card-body">
                    <div class="ribbon-two ribbon-two-dark"><span>{{session('appName')}}</span></div>
                    <h4 class="header-title ml-4">{{$page}}</h4>
                    <p class="text-muted font-13 mb-4 ml-4">
                        {{-- DataTables has most features enabled by default, so all you need to do to use it with your own tables is to call the construction
                        function:
                        <code>$().DataTable();</code>. --}}
                        Data Semua {{$page}}. <?php if (Auth::user()->role_id == 4){ ?> Silahkan manipulasi data {{$page}} sesuai keinginan anda!
                        <button type="button" class="btn btn-info waves-effect waves-light float-right add" data-plugin="tippy" data-tippy-placement="top" title="Tambah {{$page}}" data-tippy-size="small"><i class="fas fa-plus"></i></button> 
                        <?php } ?>
                    </p>
                    <div class="tab-pane active" id="home-b2">
                      <table id="tabel" class="table table-sm dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Universitas</th>
                                <th>Fakultas</th>
                                <th>Kode Jurusan</th>
                                <th>Nama Jurusan</th>
                                <th>Kajur / NIP</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->
  </div>
  <!-- container -->
  <!-- sample modal content -->
  <div id="input" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="inputTitle"></h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              </div>
              <form id="formI" class="form-horizontal">
                <input type="hidden" name="kode" id="kode">
                <div class="modal-body p-4">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-6">
                          <div class="form-group">
                            <label for="universitas" class="control-label">Universitas <span class="text-danger">*</span></label>
                            <select class="form-control" id="universitas" name="universitas">
                                @foreach ($universitas as $item)
                                <option value="{{$item->id}}">{{$item->nama_universitas}}</option>
                                @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6">
                          <div class="form-group">
                            <label for="fakultas" class="control-label">Fakultas <span class="text-danger">*</span></label>
                            <select class="form-control" id="fakultas" name="fakultas">
                                @foreach ($fakultas as $item)
                                <option value="{{$item->id}}">{{$item->nama_fakultas}}</option>
                                @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6">
                          <div class="form-group">
                            <label class="control-label" for="kode_jurusan">Kode Jurusan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control"  placeholder="..." name="kode_jurusan" id="kode_jurusan">
                          </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6">
                          <div class="form-group">
                            <label class="control-label" for="nama_jurusan">Nama Jurusan<span class="text-danger">*</span></label>
                            <input type="text" class="form-control"  placeholder="..." name="nama_jurusan" id="nama_jurusan">
                          </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6">
                          <div class="form-group">
                            <label class="control-label" for="kajur">Ketua Jurusan  <span class="text-danger">*</span></label>
                            <input type="text" class="form-control"  placeholder="..." name="kajur" id="kajur">
                          </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6">
                          <div class="form-group">
                            <label class="control-label" for="nip">NIP <span class="text-danger">*</span></label>
                            <input type="number" class="form-control"  placeholder="..." name="nip" id="nip">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer mt-2">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-info waves-effect waves-light save">Simpan {{$page}}</button>
                </div>
              </form>
          </div>
      </div>
  </div><!-- /.modal -->
    
@endsection


@push('prepend-script')
  <!-- Vendor js -->
<script src="assets/js/vendor.min.js"></script>

@endpush

@push('addon-script')
<script src="assets/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
{{-- <script src="assets/libs/selectize/js/standalone/selectize.min.js"></script> --}}


<!-- Summernote js -->
<script src="assets/libs/summernote/summernote-bs4.min.js"></script>

<script src="assets/libs/selectize/js/standalone/selectize.min.js"></script>
<script src="assets/libs/mohithg-switchery/switchery.min.js"></script>
<script src="assets/libs/multiselect/js/jquery.multi-select.js"></script>
<script src="assets/libs/jquery.quicksearch/jquery.quicksearch.min.js"></script>
<script src="assets/libs/select2/js/select2.min.js"></script>
<script src="assets/libs/bootstrap-select/js/bootstrap-select.min.js"></script>
<script src="assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
<script src="assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
<!-- Init js -->
{{-- <script src="assets/js/pages/form-advanced.init.js"></script> --}}
<script src="assets/js/pages/form-summernote.init.js"></script>
<!-- App js -->
<script>
  // !(function(l){
  //   "use strict";
  //   function e(){}e.prototype.initSelect2=function(){
  //     l('[data-toggle="select2"]').select2()
  //   }
  //  (l.FormAdvanced = new e()),
  //   (l.FormAdvanced.Constructor = e);
  // })(window.jQuery),
  //   (function () {
  //     "use strict";
  //     window.jQuery.FormAdvanced.init();
  //   })();
  </script>
<script src="assets/js/app.min.js"></script>
<script>

  $(document).ready(function () {
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('')
        }
    });
    getdata()
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
        "url": "{{ ('/jurusan') }}",
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
          {data: 'universitas', name: 'universitas'},
          {data: 'fakultas', name: 'fakultas'},
          {data: 'kode_jurusan', name: 'kode_jurusan'},
          {data: 'nama_jurusan', name: 'nama_jurusan'},
          {data: 'kajur1', name: 'kajur1',},
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
    $('#formI').each(function() {
        this.reset();
    });
    $('#kode').val('');
    var form = $('#formI');
        form.find('.invalid-feedback').remove();
        form.find('.form-control').removeClass('is-invalid');
    $('#input').modal('show');
    $('#inputTitle').html('Tambah '+title);
    $('.save').html('Simpan '+ title);
  });
  
  $(".save").click(function() {
    var formData = new FormData($('#formI')[0]);
        formData.append("_token", "{{ csrf_token() }}");
    var form = $('#formI');
        form.find('.invalid-feedback').remove();
        form.find('.form-control').removeClass('is-invalid');
    $.ajax({
        type: "POST",
        url: "{{ url('/jurusan') }}",
        data: formData,
        contentType: false,
        cache:false,
        processData: false,
        dataType:"json",
        success: function(data) {
              $( "#lbl-error" ).remove();
            if (data.status == true) {
                $('#input').modal('hide');
                $('#formI').each(function() {
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
                $('#input').modal('hide');
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
    var form = $('#formI');
        form.find('.invalid-feedback').remove();
        form.find('.form-control').removeClass('is-invalid');
    $.get("{{ url('jurusan') }}" +'/' + id +'/edit', function (data) {
        $('#input').modal('show');
        $('#inputTitle').html('Ubah '+title);
        $('#kode_jurusan').val(data.kode_jurusan);
        $('#nama_jurusan').val(data.nama_jurusan);
        $('#universitas').val(data.id_universitas);
        $('#fakultas').val(data.id_fakultas);
        $('#kajur').val(data.kajur);
        $('#nip').val(data.nip);
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
          url: "{{ url('jurusan') }}"+'/'+id,
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
</script>
@endpush