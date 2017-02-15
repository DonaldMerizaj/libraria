@extends('layouts.prime')
@section('main_container')

<div class="row">
  <div class="col-xs-12 col-md-6">
    <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">Krijo nje kategori te re</h3> </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form role="form" name="categoryForm">
        <div class="box-body">
          <div class="form-group">
            <label for="name">Kategoria</label>
            <input type="categoryId" class="form-control hidden" id="categoryId">
            <input type="categoryName" class="form-control" id="categoryName" placeholder="Enter category name"> </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button id="btnCreateCategory" type="submit" class="btn btn-success">Krijo</button>
          <button id="btnUpdateCategory" type="submit" class="btn btn-warning hidden">Perditeso</button>
          <button id="btnCancelUpdate" type="submit" class="btn btn-danger hidden">Anullo</button>
        </div>
      </form>
    </div>
  </div>
  <div class="col-xs-12 col-md-6">
    <div class="box box-dafault">
      <div class="box-header with-border">
        <h3 class="box-title">Lista e kategorive</h3>
        <div class="box-tools pull-right">
          <div class="input-group" style="width: 150px;">
            <input type="text" name="table_search" id="table_search" class="form-control input-sm pull-right" placeholder="Search">
            <div class="input-group-btn">
              <button id="btnSearchCategory" class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
            </div>
          </div>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table class="table table-responsive table-condensed table-hover" id="categoryTable">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
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
  </style>
    
  <script>
  
    // send csrf token on every ajax request
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    
    /* global swal */
    
    // array of categories to manipulate
    var categories = [];
    
    // run
//    getAllCategories();
    
    // form create button
    $('#btnCreateCategory').click(function(event) {
      event.preventDefault();
      
      $('#overlay').removeClass('hidden');
      
      $.ajax({
        url: '/create-category',
        method: 'POST',
        data: {
          category_name: $('#categoryName').val()
        },
        success: function(data) {
          if (data.status == 1) {
            $('#overlay').addClass('hidden');
            categories.unshift(data.data[]);
            updateTable(categories);
            $('#categoryName').val('');
            swal({
              title: 'Category created successfully',
              type: 'success'
            });
          }
          else {
            $('#overlay').addClass('hidden');
            swal({
              title: 'Error',
              text: data.error,
              type: 'error'
            });
          }
        }
      });
    });
    
    // action delete button
    $(document).on('click','#btnDeleteCategory', function(event) {
      
      event.preventDefault();
      
      var $cat_id = this.getAttribute('catId');
      
      swal({
        title: "Are you sure?",
        text: "You will not be able to recover this category!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: true
      }, function() {
        $('#overlay').removeClass('hidden');
        
        $.ajax({
          url: '',
          method: 'POST',
          data: {
            category_id: $cat_id
          },
          success: function(res) {
            if (res.message == 'OK') {
              $('#overlay').addClass('hidden');
              removeCategoryFromArray($cat_id);
              updateTable(categories);
              swal({
                title: 'Category deleted successfully',
                type: 'success'
              });
            }
            else {
              $('#overlay').addClass('hidden');
              swal({
                title: 'Error',
                text: res.result.category_id,
                type: 'error'
              });
            }
          }
        });
      });
    });
    
    // action edit button
    $(document).on('click', '#btnEditCategory', function(event) {
      event.preventDefault();
      $('#overlay').removeClass('hidden');
      var $cat_id = this.getAttribute('catId');
      
      $.ajax({
        url: '',
        method: 'POST',
        data: {
          category_id: $cat_id
        },
        success: function(res) {
          if (res.message == 'OK') {
            $('#overlay').addClass('hidden');
            $('#categoryId').val(res.result.id);
            $('#categoryName').val(res.result.name);
            $('#btnCreateCategory').addClass('hidden');
            $('#btnCancelUpdate').removeClass('hidden');
            $('#btnUpdateCategory').removeClass('hidden');
          }
          else {
            $('#overlay').addClass('hidden');
            swal({
              title: 'Error',
              text: res.result.category_id,
              type: 'error'
            });
          }
        }
      });
    });
    
    // form update button
    $(document).on('click', '#btnUpdateCategory', function(event) {
      event.preventDefault();
      $('#overlay').removeClass('hidden');
      
      var $cat_id = $('#categoryId').val();
      var $cat_name = $('#categoryName').val();
      
      $.ajax({
        url: '',
        method: 'POST',
        data: {
          category_id: $cat_id,
          category_name: $cat_name
        },
        success: function(res) {
          if (res.message == 'OK') {
            debugger;
            updateCategoryInArray(res.result.id, res.result.name);
            updateTable(categories);
            $('#overlay').addClass('hidden');
            $('#categoryId').val('');
            $('#categoryName').val('');
            $('#btnCreateCategory').removeClass('hidden');
            $('#btnCancelUpdate').addClass('hidden');
            $('#btnUpdateCategory').addClass('hidden');
          }
          else {
            $('#overlay').addClass('hidden');
            swal({
              title: 'Error',
              text: res.result.category_id,
              type: 'error'
            });
          }
        }
      });
    });
    
    // form cancel button 
    $(document).on('click', '#btnCancelUpdate', function(event) {
      event.preventDefault();
      $('#categoryId').val('');
      $('#categoryName').val('');
      $('#btnUpdateCategory').addClass('hidden');
      $('#btnCreateCategory').removeClass('hidden');
      $(this).addClass('hidden');
    });
    
    // search button
    $(document).on('click', '#btnSearchCategory', function(event) {
      event.preventDefault();
      $('#overlay').removeClass('hidden');
      
      var $cat_name = $('#table_search').val();
      
      $.ajax({
        url: '',
        method: 'POST',
        data: {
          name: $cat_name
        },
        success: function(res) {
          if (res.message == 'OK') {
            $('#overlay').addClass('hidden');
            categories = res.result;
            updateTable(categories);
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
      var tbody = $('#categoryTable tbody');
      emptyTable();
      $(data).each(function(row, element) {
        var tr = $('<tr>');
        var tdId = "<td id='" + element.id + "'>" + element.id + "</td>";
        var tdName = "<td id='" + element.emri + "'>" + element.emri + "</td>";
        var tdActions = "<td><div class='dropdown'>" + "<button class='btn btn-xs btn-primary dropdown-toggle' data-toggle='dropdown'>" + "Actions <span class='caret'></span>" + "</button>" + "<ul class='dropdown-menu'>" + "<li role='presentation'><a id='btnEditCategory' catId='" + element.id + "' role='menuitem' tabindex='-1'><i class='fa fa-edit'></i> Edit</a></li>" + "<li role='presentation'><a id='btnDeleteCategory' catId='" + element.id + "' role='menuitem' tabindex='-1'><i class='fa fa-remove'></i> Delete</a></li>" + "</ul>" + "</div></td>";
        tr.append(tdId, tdName, tdActions);
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
      var tbody = $('#categoryTable tbody');
      tbody.empty();
      return;
    }
    
    // paginate table
    function pagginateTable() {
      $('#categoryTable').each(function() {
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
    function getAllCategories() {
      $('#overlay').removeClass('hidden');
      $.ajax({
        url: '/create-category',
        method: 'POST',
        success: function(data) {
          if (data.status == 1) {
            $('#overlay').addClass('hidden');
            for(var c in data.data) {
              categories.push(data.data[c]);
            }
            updateTable(categories);
          }
          else {
            swal({
              title: 'Error',
              text: data.error,
              type: 'error'
            });
          }
        }
      });
    }
    
    // get obj index in array
    function removeCategoryFromArray(id) {
      $.each(categories, function(index, object) {
          if(object.id == parseInt(id)) {
              categories.splice(index, 1);
              return false; // exit loop
          }
      })
    }
    
    // update object attribute in array
    function updateCategoryInArray(id, name) {
      $.each(categories, function(index, object) {
          if(object.id == parseInt(id)) {
              object.name = name;
              return false; // exit loop
          }
      })
    }
    
    
  </script>
    
</div>

@stop