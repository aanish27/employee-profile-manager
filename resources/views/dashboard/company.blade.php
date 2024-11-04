@section('title', 'Company Manager')
@extends('layouts.module')
@section('main')

<div class="content w-100">
  <x-nav-bar title="Company Manager"/>
  <main class="container.fluid p-3">
    <div class="modal fade"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div id="validation-errors" style="display: none;" class="position-absolute top-0 end-0  w-25" role="alert"></div>
        <div class="modal-dialog ">
          <div class="modal-content" style=" width: auto;">
            <div class="modal-header py-2 justify-content-between">
              <h4 class="fs-5 m-0" id="form-title"></h4>
              <button type="button" id="btn-modal-close" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body m-0">
              <form class="form-modal row p-1">
                @csrf
                <div class="mb-2 col-6">
                  <label for="name" class="form-label fw-bold ">Name:</label>
                  <input type="text" class=" form-control py-1" id="name" name="name" placeholder="Name">
                </div>

                <div class="mb-2 col-6">
                  <label for="branch" class="form-label fw-bold ">Branch:</label>
                  <input type="text" class=" form-control py-1" id="branch" name="branch" placeholder="Branch">
                </div>

                <div class="mb-2 col-6">
                  <label for="branch" class="form-label fw-bold ">Country:</label>
                  <input type="text" class=" form-control py-1" id="country" name="country" placeholder="Country">
                </div>

                <div class="mb-2 col-6">
                  <label for="branch" class="form-label fw-bold ">Address:</label>
                  <input type="text" class=" form-control py-1" id="address" name="address" placeholder="Address">
                </div>

                <input type="hidden" class=" form-control py-1" id="company_id" name="company_id">

                <div class="mb-2 col-6">
                  <label for="projects" class="form-label project-label fw-bold d-none ">Projects:</label>
                  <input type="hidden" class=" form-control py-1 " id="projects" disabled>
                </div>

                <div class="mb-2 col-6">
                  <label for="employees" class="form-label employee-label fw-bold d-none ">Employees:</label>
                  <input type="hidden" class=" form-control py-1" id="employees" disabled>
                </div>

                <div class="modal-footer py-0 border-0 ">
                  <button type="submit" class="btn btn-primary rounded-2 px-3 py-1 m-0 " id="btn-submit"></button>
                </div>
                </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Delete Modal -->
      <x-delete-modal module="Company" message="This Action wil Delete Company and the records related to him Such as Employees and Projects" />

      <div id="table-filters" class="row row-cols-auto gap-2 mt-4 ms-0">
          <x-dropdown-filter id="filter-country" modal="Country" :collections="$countries" feild="null" />
          <button id="btn-filter-clear" class="bi bi-filter btn btn-outline-secondary rounded-1 px-1 py-1 mx-0 " title="Clear Filter">Clear</button>
        </div>
      <table id="myTable" class="table table-hover table-nowrap table-bordered shadow-sm"  width="100%" ></table>
  </main>
</div>

<script type="module">
  $(function () {

    // filter Country
    $("#filter-country").on('change', function() {
        table.search('').draw();
    });

    $('#btn-filter-clear').click(function (e) {
        $('#filter-country option:selected').prop("selected" , false);
        table.columns().search('').draw();
    });

    let table= $('#myTable').DataTable({
      pageResize: true,
      fixedColumns: true,
      scrollCollapse: true,
      scrollY: 7200,
      scrollX: true,
      responsive: true,
      layout: {
        topStart:{
            pageLength: {
            placeholder: 'Filter'
            },
            search: {
                placeholder: 'Type search here'
            },
        },
        topEnd:{
            buttons: [{
                text: 'New',
                attr: {
                    id: 'btn-add-record',
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '.modal',
                    class: 'bi bi-plus-lg btn btn-outline-primary rounded-2 px-3 py-0' ,
                },
                action: function (e, dt, node, config, cb) {
                    storeCompany()
                }
            }]
        }
      },
      language: {
          lengthMenu:  ' _MENU_',
          search: ' '
      },
      serverSide: true,
      processing: true,
      ajax: {
          url: 'company/draw',
          data: function (d) {
              const dropdowns = {};
              dropdowns['country'] = ($("#filter-country").val().length === 0 ) ?  dropdowns['country'] : $("#filter-country").val();
              d.dropdowns = dropdowns;
          }
      },
      columns: [
        {
          data: 'id',
          title:'#',
          name:'id',
        },
        {
          data: null ,
          title: 'Actions',
          render: function (data, type, row) {
              return `  <button title="Edit" class="d-inline btn  btn-edit p-0 " id="btn-edit-${row.id}" data-id="${row.id}" data-bs-toggle="modal" data-bs-target=".modal" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#1DB954" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                    </svg>
                                  </button>
                                    <button title="Delete" class="btn btn-dlt-modal d-inline p-0 ms-2" data-id="${row.id}" data-bs-toggle="modal" data-bs-target="#deletConfirmation" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                    </svg>
                                </button> `
            },
            sortable: false,
            orderable: false,
        },
        {
          data: 'name',
          title:'Company',
          name:'name',
          render: DataTable.render.ellipsis( 50 )
        },
        {
          data: 'branch',
          title:'Branch',
          name: 'branch',
          render: DataTable.render.ellipsis( 26 )
        },
        {
          data: 'country' ,
          title: 'Country' ,
          name: 'country',
          render: DataTable.render.ellipsis( 26 )
        },
        {
          data: 'address' ,
          title:'Address',
          name: 'address',
          render: DataTable.render.ellipsis( 100 )
        },
        {
          data: 'employees_count' ,
          title:'Employees',
          name: 'employees_count'
        },
        {
          data: 'projects_count',
          title:'Projects',
          name: 'projects_count'
        },
      ],
      columnDefs: [
        { orderable: false, targets: 0 },
        { className: 'dt-head-left py-0', targets: '_all' },
      ],
    });

    // sidebar
    $('#sidebar-toggle').on('click', function() {
        $('#sidebar-long').toggleClass('d-none');
        $('main').toggleClass('main-l-sidebar');
        $('#sidebar-short').toggleClass('d-none');
        table.responsive.recalc();
        table.columns.adjust();
    });

    const linkColor = $('.nav_link');
    linkColor.removeClass('active')
    $('.btn-company').addClass('active');

    $('body').tooltip({
        selector: '[data-bs-toggle="tooltip"]',
    });

    // Delete Company
    $('#myTable tbody').on('click' , '.btn-dlt-modal' ,function (e) {
        $('#btn-dlt').text('Delete').attr('data-id' , table.row($(this).parents('tr')).data().id)
    });
    $('#deletConfirmation .modal-footer').on('click' , '#btn-dlt' , function (e) {
        axios.delete(`companys/${$(this).attr('data-id')}`)
        .then(function (response){
            displayToast(response , "success")
              $('.btn-close-dlt').click();
        });
        table.draw(false);
    })

    //Store Company Axios
    function storeCompany(){
      $('.form-modal').attr("id","form-create");
      $('#form-title').text("New Company Details");
      $('#btn-submit').text("Save");
      $('#projects').prop("type" , "hidden")
      $('#employees').prop("type" , "hidden")
      $('.project-label').addClass('d-none')
      $('.employee-label').addClass('d-none')

    }
    $('.modal-body').on('submit' , '#form-create', function (e){
        e.preventDefault();
        let $data = new FormData(this)
        axios.post('companys', $data )
        .then(function (response){
          displayToast(response , "success")
          $('#form-create').trigger("reset");
          $('#btn-modal-close').click();
          table.draw(false);
        })
        .catch(function (response){
          displayToast(response , "error")
        });
    });

    // Clear Forms
    $('.btn-close').click(function (e) {
      $('.form-modal').trigger("reset");
    });

    // Edit Company
    let id = null
    $('#myTable tbody').on('click', '.btn-edit', function (e) {
        $('.form-modal').attr("id","form-edit");
        $('#form-title').text("Edit Company Details");
        $('#btn-submit').text("Update");
        id = table.row( $(this).parents('tr') ).data().id;
        axios.get(`companys/${id}/edit`)
        .then(function (response){
            const data = response.data;
            $('#name').val(data.name)
            $('#branch').val(data.branch)
            $('#country').val(data.country)
            $('#address').val(data.address)
            $('#company_id').val(data.id)
            $('#projects').val(data.projects_count).prop("type" , "text")
            $('#employees').val(data.employees_count).prop("type" , "text")
            $('.project-label').removeClass('d-none')
            $('.employee-label').removeClass('d-none')
        });
    });

    $('.modal-body').on('submit' , '#form-edit', function (e){
        e.preventDefault();
        let dataSubmit = new FormData(this)
        dataSubmit.append('_method', 'patch');
        axios.post( `companys/${id}` , dataSubmit)
        .then(function (response){
            displayToast(response , "success")
            $('#form-edit').trigger("reset");
            $('#btn-modal-close').click();
            table.draw(false);
        })
        .catch(function (response){
            displayToast(response , "error")
        });
    });

    //Toast Alerts
    function displayToast(response , type){
      const valErrorDiv = $('.toast-container')
      valErrorDiv.find('.show').remove();
      if (type == "error") {
        const errors = response.response.data
        for (const field in errors) {
          errors[field].forEach((error) => {
              let clone = $('#error-toast').clone();
              clone.addClass('show');
              clone.find('.toast-body').text(error)
              valErrorDiv.append(clone);
            });
        }
      } else {
        let clone = $('#success-toast').clone();
        clone.addClass('show');
        clone.find('.toast-body').text(response.data)
        valErrorDiv.append(clone);
      }
      valErrorDiv.fadeIn("slow").delay(5000).fadeOut("slow");
    }
  });
</script>
@endsection
