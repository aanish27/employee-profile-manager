<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>

        @vite([ 'resources/css/app.css', 'resources/js/app.js',  'resources/css/custom.data-table.css', 'resources/css/custom.sidebar.css' ])

    </head>

    <body class="container.fluid w-100 d-flex " style="background-color: rgb(249, 249, 249) ">

      <x-sidebar/>

  <div class="content w-100">
          <x-nav-bar/>
          <div class="toast-container position-absolute top-0 end-0  m-2">
          <div id="success-toast" class="toast success-toast align-items-center bg-success-subtle  shadow-sm " role="alert" aria-live="assertive" aria-atomic="true">
              <div class="d-flex">
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-check-lg p-0 mx-1 mt-2 mb-2" viewBox="0 0 16 16">
                  <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z"/>
                </svg>
                <div class="toast-body">
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
              </div>
          </div>
          <div id="error-toast"  class="toast error-toast align-items-center bg-warning-subtle shadow-sm top-0 end-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
              <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-info-circle p-0 mx-1 mt-2 mb-2 " viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
              </svg>
              <div class="toast-body">
              </div>
              <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
          </div>
        </div>
        <main class="containe.fluid">
          <h1 class="h1 p-3  py-4 bg-white shadow-sm" >Manage Company Profiles</h1>
          <div class="modal fade"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div id="validation-errors" style="display: none;" class="position-absolute top-0 end-0  w-25" role="alert"></div>
              <div class="modal-dialog modal-dialog-centered ">
                <div class="modal-content ">
                  <button type="button" id="btn-modal-close" class="btn-close m-1" data-bs-dismiss="modal" aria-label="Close"></button>
                  <h3 class="text-center text-dark m-0" id="form-title"></h3>
                  <div class="modal-body m-0">
                      <form class="form-modal">
                          @csrf
                          <label class="form-label fw-bold">Company Details</label>
                          <input type="text" class=" form-control m-2" id="name" name="name" placeholder="Name">
                          <input type="text" class=" form-control m-2" id="branch" name="branch" placeholder="Branch">
                          <input type="text" class=" form-control m-2" id="country" name="country" placeholder="Country">
                          <input type="text" class=" form-control m-2" id="address" name="address" placeholder="Address">
                          <input type="hidden" class=" form-control m-2" id="company_id" name="company_id">
                          <input type="hidden" class=" form-control m-2" id="projects" disabled>
                          <input type="hidden" class=" form-control m-2" id="employees" disabled>
                          <button type="submit" class="btn btn-primary m-2" id="btn-submit"></button>
                      </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- Delete Modal -->
            <div class="modal fade" id="deletConfirmation" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deletConfirmationLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deletConfirmationLabel">Are You Sure to Delete the Company?? </h1>
                    <button type="button" class="btn-close btn-close-dlt" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    This Action wil Delete Company and the records related to him Such as Employees and Projects
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="btn-dlt"  class="btn btn-danger btn-dlt">Delete</button>
                  </div>
                </div>
              </div>
            </div>
            <table id="myTable" class="table table-hover  " style="width: 100%"> </table>
        </main>
</div>
      <script type="module">
        $(function () {
          let table= $('#myTable').DataTable({
                fixedColumns: true,
                scrollCollapse: true,
                scrollY: 500,
                scrollX: true,
                responsive: true,
                layout: {
                  topStart: null,
                  topEnd: null,
                  top1Start:{
                      pageLength: {
                      placeholder: 'Filter'
                      },
                      search: {
                          placeholder: 'Type search here'
                      },
                  },
                  top1End:{
                      buttons: [{
                          text: '<i class="bi bi-plus-lg"></i> New',
                          attr: {
                              id: 'btn-add-record',
                              'data-bs-toggle': 'modal',
                              'data-bs-target': '.modal'
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
              },
              columns: [
                {
                  data: null ,
                  title: 'Actions',
                  render: function (data, type, row) {
                      return `  <button class="d-inline btn  btn-edit p-0 " id="btn-edit-${row.id}" data-id="${row.id}" data-bs-toggle="modal" data-bs-target=".modal" >
                                  <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#1DB954" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                      <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                      <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                  </svg>
                                </button>
                                  <button class="btn btn-dlt-modal p-0 d-inline" data-id="${row.id}" data-bs-toggle="modal" data-bs-target="#deletConfirmation" >
                                  <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="red" class="bi bi-trash" viewBox="0 0 16 16">
                                      <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                      <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                  </svg>
                              </button> `
                    },
                    width: '6%',
                },
                {
                  data: 'name',
                  title:'Company',
                  render: DataTable.render.ellipsis( 50 )
                },
                {
                  data: 'branch',
                  title:'Branch',
                  render: DataTable.render.ellipsis( 26 )
                },
                {
                  data: 'country' ,
                  title: 'Country' ,
                  render: DataTable.render.ellipsis( 26 )
                },
                {
                  data: 'address' ,
                  title:'Address',
                  render: DataTable.render.ellipsis( 100 )
                },
                {
                  data: 'employees_count' ,
                  title:'Employees',
                  className: 'dt-center'
                },
                {
                  data: 'projects_count',
                  title:'Projects',
                  className: 'dt-center'
                },
              ],
            });

            // sidebar
                $('#sidebar-toggle').on('click', function() {
                    $('#nav-bar').toggleClass('show');
                    $('#sidebar').toggleClass('sidebar-pd');
                    $('#btn-company').toggleClass('nav_link-show');
                });

                const linkColor = $('.nav_link');
                linkColor.removeClass('active');
                $('#btn-company').addClass('active');

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
                });
                table.draw(false);
                $('.btn-close-dlt').click();
            })
            //Store Company Axios
            function storeCompany(){
              $('.form-modal').attr("id","form-create");
              $('#form-title').text("New Company Details");
              $('#btn-submit').text("Add Company");
              $('#projects').prop("type" , "hidden")
              $('#employees').prop("type" , "hidden")
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
                $('#btn-submit').text("Update Company");
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
    </body>
</html>
