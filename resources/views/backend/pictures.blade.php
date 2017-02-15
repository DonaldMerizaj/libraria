@extends('backend.layouts.master')
@section('main_container')
<div class="row">
  <div class="col-xs-12 col-md-6">
    <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">Add new picture</h3> </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form role="form" name="pictureForm">
        <div class="box-body">
          <div class="form-group">
            <label for="name">Picture Title</label>
            <input type="text" class="form-control hidden" name="pictureId" id="pictureId">
            <input type="text" class="form-control" name="pictureName" id="pictureName" placeholder="Enter Picture Name"> 
          </div>
          <div class="form-group">
              <label for="description">Description</label>
              <textarea name="description" id="description" cols="30" rows="10" class="form-control" ></textarea>
          </div>
          <div class="form-group">
              <select name="categoryId" id="categoryId" class="form-control chosen-select">
                <option value="" disabled selected>Select category...</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="name">Image</label>
            <div class="text-center">
              <input type="file" name="image" accept="image/*" class="form-control" id="image" class="form-control">
              <img src="" class="hidden" id="image_thumb"></img>
            </div>
          </div>
        </div>
        <br>
        <!-- /.box-body -->
        <div class="box-footer">
          <button id="btnCreatePicture" type="submit" class="btn btn-success">Create</button>
          <button id="btnUpdatePicture" type="submit" class="btn btn-warning hidden">Update</button>
          <button id="btnCancelUpdate" type="submit" class="btn btn-danger hidden">Cancel</button>
        </div>
      </form>
    </div>
  </div>
  <div class="col-xs-12 col-md-6">
    <div class="box box-dafault">
      <div class="box-header with-border">
        <h3 class="box-title">List of pictures</h3>
        <div class="box-tools pull-right">
          <div class="input-group" style="width: 150px;">
            <input type="text" name="table_search" id="table_search" class="form-control input-sm pull-right" placeholder="Search">
            <div class="input-group-btn">
              <button id="btnSearchPicture" class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
            </div>
          </div>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table class="table table-responsive table-condensed table-hover" id="pictureTable">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Category Name</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody> </tbody>
        </table>
      </div>
      <!-- /.box-body -->
      <div class="box-footer text-center">
        <div id="nav-pag"></div>
      </div>
      <!-- /.box-footer -->
    </div>
  </div>
    
    
  <style type="text/css">
    .pagination {
        margin: 0;
    }
    #image_thumb {
        max-height: 100px;
        margin: 10px;
        padding: 5px;
        border: solid 1px #ddd;
    }
  </style>
    
  <script>
  
    $(function(){
      run();
    })
    
    function run() {
      // send csrf token on every ajax request
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      
      // chosen select
      $("#categoryId").chosen({no_results_text: "Oops, nothing found!"});
      
      /* global swal */
      
      // array of categories to manipulate
      var pictures = [];
      
      // run
      getAllPictures();
      
      // form create button
      $('#btnCreatePicture').click(function(event) {
        event.preventDefault();
        debugger;
        $('#overlay').removeClass('hidden');
        var fd = new FormData();
        fd.append('picture_name', $('#pictureName').val());
        fd.append('description', $('#description').val());
        fd.append('category_id', $('#categoryId').val());
        fd.append('image', document.getElementById('image').files[0]);
        $.ajax({
          url: '/admin/create-picture',
          method: 'POST',
          processData: false,
          contentType: false,
          data: fd,
          success: function(res) {
            debugger;
            if (res.message == 'OK') {
              pictures.unshift(res.result);
              updateTable(pictures);
              $('#pictureId').val('');
              $('#pictureName').val('');
              $('#categoryId').val('');
              $('#categoryId').trigger('chosen:updated');
              $('#description').val('');
              $('#image').val('');
              $('#image_thumb').attr('src', '');
              $('#image_thumb').addClass('hidden');
              swal({
                title: 'Picture created successfully',
                type: 'success'
              });
            }
            else {
              swal({
                title: 'Error',
                text: res.result.picture_name,
                type: 'error'
              });
            }
            $('#overlay').addClass('hidden');
          }
        });
      });
      
      // action delete button
      $(document).on('click','#btnDeletePicture', function(event) {
        
        event.preventDefault();
        
        var $pic_id = this.getAttribute('picId');
        
        swal({
          title: "Are you sure?",
          text: "You will not be able to recover this picture!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Yes, delete it!",
          closeOnConfirm: true
        }, function() {
          $('#overlay').removeClass('hidden');
          
          $.ajax({
            url: '/admin/delete-picture',
            method: 'POST',
            data: {
              picture_id: $pic_id
            },
            success: function(res) {
              if (res.message == 'OK') {
                removePictureFromArray($pic_id);
                updateTable(pictures);
                swal({
                  title: 'Picture deleted successfully',
                  type: 'success'
                });
              }
              else {
                swal({
                  title: 'Error',
                  text: res.result.picture_id,
                  type: 'error'
                });
              }
              $('#overlay').addClass('hidden');
            }
          });
        });
      });
      
      // action edit button
      $(document).on('click', '#btnEditPicture', function(event) {
        event.preventDefault();
        $('#overlay').removeClass('hidden');
        var $pic_id = this.getAttribute('picId');
        
        $.ajax({
          url: '/admin/get-picture-by-id',
          method: 'POST',
          data: {
            picture_id: $pic_id
          },
          success: function(res) {
            debugger;
            if (res.message == 'OK') {
              $('#pictureId').val(res.result.id);
              $('#pictureName').val(res.result.name);
              $('#categoryId').val(res.result.category_id);
              $('#image_thumb').attr('src',res.result.image);
              $('#image_thumb').removeClass('hidden');
              $('#description').val(res.result.description);
              $('#categoryId').trigger('chosen:updated');
              $('#btnCreatePicture').addClass('hidden');
              $('#btnCancelUpdate').removeClass('hidden');
              $('#btnUpdatePicture').removeClass('hidden');
            }
            else {
              $('#overlay').addClass('hidden');
              swal({
                title: 'Error',
                text: res.result.id,
                type: 'error'
              });
            }
            $('#overlay').addClass('hidden');
          }
        });
      });
      
      // form update button
      $(document).on('click', '#btnUpdatePicture', function(event) {
        event.preventDefault();
        $('#overlay').removeClass('hidden');
        debugger;
        var fd = new FormData();
        fd.append('picture_id', $('#pictureId').val());
        fd.append('picture_name', $('#pictureName').val());
        fd.append('description', $('#description').val());
        fd.append('category_id', $('#categoryId').val());
        fd.append('image', document.getElementById('image').files[0]);
        
        $.ajax({
          url: '/admin/update-picture',
          method: 'POST',
          processData: false,
          contentType: false,
          data: fd,
          success: function(res) {
            if (res.message == 'OK') {
              debugger;
              updatePictureInArray(res.result.id, res.result.name, res.result.category_name);
              updateTable(pictures);
              $('#pictureId').val('');
              $('#pictureName').val('');
              $('#categoryId').val('');
              $('#image_thumb').attr('src','');
              $('#image_thumb').removeClass('hidden');
              $('#description').val('');
              $('#image').val('');
              $('#categoryId').trigger('chosen:updated');
              $('#btnCreatePicture').removeClass('hidden');
              $('#btnCancelUpdate').addClass('hidden');
              $('#btnUpdatePicture').addClass('hidden');
              swal({
                title: 'OK',
                text: 'Picture updated successfully',
                type: 'success'
              });
            }
            else {
              swal({
                title: 'Error',
                text: res.result.category_id,
                type: 'error'
              });
            }
            $('#overlay').addClass('hidden');
          }
        });
      });
      
      // form cancel button 
      $(document).on('click', '#btnCancelUpdate', function(event) {
        event.preventDefault();
        $('#pictureId').val('');
        $('#pictureName').val('');
        $('#categoryId').val("");
        $('#description').val("");
        $('#image_thumb').val("");
        $('#categoryId').trigger('chosen:updated');
        $('#btnUpdatePicture').addClass('hidden');
        $('#btnCreatePicture').removeClass('hidden');
        $(this).addClass('hidden');
      });
      
      // search button
      $(document).on('click', '#btnSearchPicture', function(event) {
        event.preventDefault();
        $('#overlay').removeClass('hidden');
        
        var $picture_name = $('#table_search').val();
        
        $.ajax({
          url: '/admin/search-picture-by-name',
          method: 'POST',
          data: {
            name: $picture_name
          },
          success: function(res) {
            if (res.message == 'OK') {
              $('#overlay').addClass('hidden');
              pictures = res.result;
              updateTable(pictures);
            }
            else {
              $('#overlay').addClass('hidden');
              swal({
                title: 'Error',
                text: JSON.stringify(res.result),
                type: 'error'
              });
            }
          }
        });
      });
      
      // append new elements to table
      function updateTable(data) {
        var tbody = $('#pictureTable tbody');
        emptyTable();
        $(data).each(function(row, element) {
          var tr = $('<tr>');
          var tdId = "<td id='" + element.id + "'>" + element.id + "</td>";
          var tdName = "<td id='" + element.name + "'>" + element.name + "</td>";
          var tdCatName = "<td id='" + element.category_name + "'>" + element.category_name + "</td>";
          var tdActions = "<td><div class='dropdown'>" + "<button class='btn btn-xs btn-primary dropdown-toggle' data-toggle='dropdown'>" + "Actions <span class='caret'></span>" + "</button>" + "<ul class='dropdown-menu'>" + "<li role='presentation'><a id='btnEditPicture' picId='" + element.id + "' role='menuitem' tabindex='-1'><i class='fa fa-edit'></i> Edit</a></li>" + "<li role='presentation'><a id='btnDeletePicture' picId='" + element.id + "' role='menuitem' tabindex='-1'><i class='fa fa-remove'></i> Delete</a></li>" + "</ul>" + "</div></td>";
          tr.append(tdId, tdName, tdCatName, tdActions);
          tbody.append(tr);
        });
        pagginateTable();
      }
      
      // empty table
      function emptyTable(el) {
        if (typeof el != 'undefined') {
          el.innerHTML = "";
          return;
        }
        var tbody = $('#pictureTable tbody');
        tbody.empty();
        return;
      }
      
      // paginate table
      function pagginateTable() {
        $('#pictureTable').each(function() {
          var currentPage = 0;
              var numPerPage = 10;
              var $table = $(this);
              $table.bind('repaginate', function() {
                  $table.find('tbody tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
              });
              $table.trigger('repaginate');
              var numRows = $table.find('tbody tr').length;
              var numPages = Math.ceil(numRows / numPerPage);
              var $pager = $('<ul class="pagination"></ul>');
              
              for (var page = 0; page < numPages; page++) {
                  
                  var $beginLi = '<li pageNr="' + (page) + '"class="page">'  ;
                  var $anchor =  $beginLi + '<a href="#">'+ (page + 1) + '</a>';
                  var $endLi = '</li>';
                  var $line = $anchor + $endLi;
                  $pager.append($line);
              } 
              	
              $( ".pagination" ).remove();
              $('#nav-pag').append($pager).find('li.page:first').addClass('active');
              
              $(".page").click(function() {
                      var newPage = $(this).attr('pagenr');
                      currentPage = newPage;
                      $table.trigger('repaginate');
                      $(this).addClass('active').siblings().removeClass('active');
              })
        });
      }
      
      // get all categories 
      function getAllPictures() {
        $('#overlay').removeClass('hidden');
        $.ajax({
          url: '/admin/get-all-pictures',
          method: 'POST',
          success: function(res) {
            debugger;
            if (res.message == 'OK') {
              $('#overlay').addClass('hidden');
              for(var sc in res.result) {
                pictures.push(res.result[sc]);
              }
              updateTable(pictures);
            }
            else {
              swal({
                title: 'Error',
                text: res.result,
                type: 'error'
              });
            }
          }
        });
      }
      
      // get obj index in array and remove it
      function removePictureFromArray(id) {
        $.each(pictures, function(index, object) {
            if(object.id == parseInt(id)) {
                pictures.splice(index, 1);
                return false; // exit loop
            }
        })
      }
      
      // update object attribute in array
      function updatePictureInArray(id, name, category_name) {
        $.each(pictures, function(index, object) {
            if(object.id == parseInt(id)) {
                object.name = name;
                object.category_name = category_name;
                return false; // exit loop
            }
        })
      }
      
      // get input image base64
    function readImage() {
        if ( this.files && this.files[0] ) {
            var FR = new FileReader();
            FR.onload = function(e) {
                $('#image_thumb').removeClass('hidden');
                $('#image_thumb').attr( "src", e.target.result );
            };       
            FR.readAsDataURL( this.files[0] );
        }
    }
  
      
    }

  </script>
    
</div>
@stop