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
                        {{-- <button type="button" class="btn btn-info waves-effect waves-light float-right add" data-plugin="tippy" data-tippy-placement="top" title="Tambah {{$page}}" data-tippy-size="small"><i class="fas fa-plus"></i></button>  --}}
                        <?php } ?>
                    </p>
                    <div class="tab-pane active" id="home-b2">
                      <table id="tabel" class="table table-sm dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Kode Kurikulum</th>
                                <th>Kode dan Mata Kuliah</th>
                                <th>Detail</th>
                                {{-- <th>Deskripsi</th> --}}
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
 <!-- sample modal content -->
 <div id="input" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title" id="inputTitle"></h4>
                {{-- <button type="button" class="btn btn-success waves-effect waves-light close finalisasi" style="">Finalisasi Mata Kuliah</button> --}}
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
          <form id="formI" class="form-horizontal">
            <input type="hidden" name="kode" id="kode">
            <div class="modal-body p-4">
              <div class="row">
                <div class="col-lg-12">
                  <div class="row">
                    <div class="col-sm-10 col-md-10 col-lg-5">
                      <div class="form-group ">
                        <label for="nidn" class="control-label">Tambah Dosen Pengampu Mata Kuliah</label>
                        <input type="hidden" name="id_mk" id="id_mk">
                        <input type="hidden" name="semester" id="semester">
                        <input type="hidden" name="prodi" id="prodi">
                                    
                        <select class="form-control" id="nidn" name="nidn" data-toggle="select2">
                          <option value="" selected disabled>Pilih Dosen</option>
                          @foreach ($dosen as $item)
                              <option value="{{$item->nidn}}">{{$item->nidn}} - {{$item->nama}}</option>
                          @endforeach
                        </select>
                        <div class="input-group-append">
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-2 col-md-2 col-lg-1">
                      <div class="form-group" style="margin-top: 1.8rem!important;">
                        <button class="btn btn-dark waves-effect waves-light save-dosen" type="button" title="Tambah Dosen Pengampu MK" >+</button>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12">

                      <table id="tabelDosen" class="table table-sm dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>NIDN</th>
                                <th>Nama Dosen</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                      <div class="form-group">
                        <label class="control-label" for="deskripsi">Deskripsi Mata Kuliah <span class="text-danger">*</span></label>
                        <div id="summernote-basic"></div>
                        {{-- <input type="text" class="form-control"  placeholder="..." name="deskripsi" id="deskripsi"> --}}
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                      <div class="form-group">
                        <label class="control-label" for="Lampiran">File RPS <span class="text-danger"></span></label>
                        <input type="file" class="form-control" id="fileUpload" name="fileUpload" style="height: 43px;">
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

<div id="deskripsi" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title" id="inputTitle1"></h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
          <div class="modal-body p-4">
            <div class="row">
              <div class="col-lg-12">
                <div class="row">
                  <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                      <p class="control-label" id="deskripsiMK"></p>
                    </div>
                    <hr>
                  </div>
                  <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                      <label class="control-label" for="Lampiran">File RPS <span class="text-danger"></span></label> &nbsp;&nbsp;&nbsp;
                      <a target="_blank" id="rpsDownload" class="btn btn-info waves-effect waves-light "> File RPS</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer mt-2">
              <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
          </div>
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
        "url": "{{ ('/validasi-mata-kuliah') }}",
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
          {data: 'kode_kurikulum', name: 'kode_kurikulum'},
          {data: 'mk', name: 'mk'},
          {data: 'detail', name: 'detail',},
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
    var temp = $(".note-editable").html();
    if (temp == "<p><br></p>" || temp == ""){
      toastr.error("Surat Masih Kosong...", 'Gagal', {
          timeOut: 5000
      });
      return false;
    }
    var formData = new FormData($('#formI')[0]);
        formData.append("_token", "{{ csrf_token() }}");
    var form = $('#formI');
        form.find('.invalid-feedback').remove();
        form.find('.form-control').removeClass('is-invalid');
        formData.append("deskripsi", temp);
    var file = document.getElementById("fileUpload").files[0];
    formData.append("file", file);
    $.ajax({
        type: "POST",
        url: "{{ url('/matakuliah') }}",
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
  $(".save-dosen").click(function() {
    var d = $("#nidn").val();
    // console.log(d);
    if (d == null ){
      toastr.error("Silahkan Pilih Data Dosen Terlebih Dahulu...!", 'Gagal', {
          timeOut: 5000
      });
      return false;
    }
    var formData = new FormData($('#formI')[0]);
        formData.append("_token", "{{ csrf_token() }}");
    var form = $('#formI');
        form.find('.invalid-feedback').remove();
        form.find('.form-control').removeClass('is-invalid');
    $.ajax({
        type: "POST",
        url: "{{ url('/validasi-mata-kuliah') }}",
        data: formData,
        contentType: false,
        cache:false,
        processData: false,
        dataType:"json",
        success: function(data) {
              $( "#lbl-error" ).remove();
            if (data.status == true) {
                // $('#input').modal('hide');
                $('#formI').each(function() {
                        this.reset();
                    });
                var table = $('#tabelDosen').DataTable();
                table.row(this).remove().draw(false);
                
                // var tahun = $("#tahun").val();
                // getsurat();
                toastr.success("Data berhasil disimpan...", 'Berhasil', {
                    timeOut: 5000
                });
                return false;

            } else{
                // $('#input').modal('hide');
                // var table = $('#tabel').DataTable();
                // table.row(this).remove().draw(false);
                toastr.error(data.message, 'Error', {
                    timeOut: 5000
                });
                return false;
            }
            // getdata();
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
    $.get("{{ url('mata-kuliah') }}" +'/' + id +'/edit', function (data) {
        $('#summernote-basic').summernote('destroy');
        $('#input').modal('show');
        $('#inputTitle').html('Ubah '+title);
        $('#summernote-basic').html(data.deskripsi);
        // console.log(data.deskripsi);
        $('#pdf').val(data.pdf);
        $('#id_mk').val(data.id);
        $('#semester').val(data.semester);
        $('#prodi').val(data.id_prodi);
        $(".select2-selection__rendered").html("Pilih Dosen");
        $(".select2-selection__rendered").attr('title','Pilih Dosen');
        summerNote();
        // $('.note-editable').html(data.deskripsi);
        getdosen(id);
    })
  }
  
  function deskripsi(id) {
    $.get("{{ url('mata-kuliah') }}" +'/' + id +'/edit', function (data) {
        $('#deskripsi').modal('show');
        $('#inputTitle1').html('Deskripsi Mata Kuliah : '+ data.nama_mk);
        $('#deskripsiMK').html(data.deskripsi);
        // console.log(data.deskripsi);
        $('#rpsDownload').attr('href','assets/rps/'+data.rps );
        
    })
  }
  
  function summerNote() {
    $("#summernote-basic").summernote({
        placeholder:"Write something...",
        height:230,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            
            ['fontsize', ['fontsize']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']],
        ],
        callbacks:{
            onInit:function(e){
                $(e.editor).find(".custom-control-description")
                .addClass("custom-control-label")
                .parent()
                .removeAttr("for")
            }
        },
    });
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
        "url": "{{ ('/dosen-mata-kuliah') }}",
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
                url: "{{ url('validasi-mata-kuliah') }}"+'/'+id,
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
                    var table = $('#tabelDosen').DataTable();
                    table.row(this).remove().draw(false);
                }
            });
        }


    })
    return false;
  }
  function finalisasi(id, value) {
    var text = "membuka editing";
    if (value == 1){
      text = "menutup editing";
    }
    Swal.fire({
        title: 'Apakah anda yakin akan '+text+' data ini?',
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
                url: "{{ url('finalisasi-mata-kuliah') }}",
                  data:{
                    'id': id, 'value': value,
                    '_token': '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.status==true) {
                      toastr.success(response.message, 'Berhasil', {timeOut: 5000});
                    } else{
                      toastr.error(response.message, 'Gagal', {timeOut: 5000});
                    }
                    var table = $('#tabel').DataTable();
                    table.row(this).remove().draw(false);
                }
            });
        }


    })
    return false;
  }
  
</script>
@endpush