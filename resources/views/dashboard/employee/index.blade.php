<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Employee Manager</title>

        @vite([ 'resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="container.fluid w-100 m-0 d-flex">
        <x-sidebar/>
        <div class="content w-100">
            <x-nav-bar title="Employee Manager"/>
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

            <main class="container.fluid p-3" >

                <div class="modal fade modal-lg"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div id="validation-errors" style="display: none;" class="position-absolute top-0 end-0  w-25" role="alert"></div>
                    <div class="modal-dialog ">
                      <div class="modal-content " style=" width: auto;">
                        <div class="modal-header py-2 justify-content-between">
                             <h4 class="fs-5 m-0" id="form-title"></h4>
                            <button type="button" id="btn-modal-close" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body m-0">
                            <form class="form-modal row  p-1">
                                @csrf
                                <div class="mb-2 col-3">
                                    <label for="name" class="form-label fw-bold ">Name:</label>
                                    <input type="text" class=" form-control py-1 " id="name" name="name" placeholder="Full Name" required>
                                </div>
                                <div class=" mb-2 col-3">
                                    <label class="form-label fw-bold" for="position">Position:</label>
                                    <input type="text" class=" form-control py-1 " id="position" name="position" placeholder="Position" required>
                                </div>
                                <div class="mb-2 col-3" >
                                    <label class="form-label fw-bold" for="dob">DOB:</label>
                                    <input type="date" class=" form-control py-1 " id="dob" name="dob" placeholder="DOB" required>
                                </div>
                                <div class=" mb-2 col-3">
                                    <label class="form-label fw-bold" for="email">Email:</label>
                                    <input type="email" class=" form-control py-1 " id="email" name="email" placeholder="Email" required>

                                </div>
                                <div class=" mb-2 col-3">
                                    <label class="form-label fw-bold" for="phone">Phone:</label>
                                    <input type="phone" class=" form-control py-1 " id="phone" name="phone" placeholder="Phone" required>

                                </div>
                                <div class="col-9">
                                    <label class="form-label fw-bold" for="address">Address:</label>
                                    <input type="text" class=" form-control py-1 " id="address" name="address" placeholder="Address" required>
                                </div>

                                <div class="mt-2 mb-2 col-6 d-inline">
                                    <label class="form-label fw-bold" for="select">Choose Company: </label>
                                    <select id="select" name="company_id" class="form-select form-control py-1  " aria-label="Default select example">
                                        <option hidden>Company</option>
                                        @foreach ( $companies  as $company )
                                            <option value="{{ $company->id }}" data-val="{{ $company->name }}" class="create-option {{ is_null($company->deleted_at) ? '' : 'trash' }}" data-branch="{{ $company->branch }}" > {{ $company->name }} </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mt-2 col-6">
                                    <label class="form-label fw-bold" for="company-branch">Branch:</label>
                                    <input type="text" class="form-control py-1 " id="company-branch" name="company_branch" placeholder="Branch" required disabled>
                                </div>

                                <input type="hidden" name="bank_id" id="bank-id">

                                <div class="mt-2 mb-2 col-6">
                                    <label class="form-label fw-bold" for="beneficiary-name">Beneficiary Name:</label>
                                    <input type="text" class=" form-control py-1 "  id="beneficiary-name" name="beneficiary_name" placeholder="Beneficiary Name" required>
                                </div>

                                <div class="mt-2 mb-2 col-6">
                                    <label class="form-label fw-bold" for="bank-name">Bank Name</label>
                                    <input type="text" class=" form-control py-1 " id="bank-name" name="bank_name" placeholder="Bank Name" required>
                                </div>

                                <div class="mb-2 col-6">
                                    <label class="form-label fw-bold" for="bank-branch">Branch</label>
                                    <input type="phone" class=" form-control py-1 " id="bank-branch" name="branch" placeholder="Branch" required>
                                </div>

                                <div class="mb-2 col-6">
                                    <label class="form-label fw-bold" for="account-no">Account No:</label>
                                    <input type="number" class=" form-control py-1 " id="account-no" name="account_no" placeholder="Account No" required>
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
                  <div class="modal fade" id="deletConfirmation" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deletConfirmationLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="deletConfirmationLabel">Are You Sure to Delete the Employee?? </h1>
                          <button type="button" class="btn-close btn-close-dlt" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          This Action wil Delete Employee and the records related to him Such as Bank Account of the employee
                        </div>
                        <div class="modal-footer">
                          <button type="button" id="btn-dlt"  class="btn btn-dlt btn-danger rounded-2 px-3 py-0">Delete</button>
                        </div>
                      </div>
                    </div>
                  </div>

                <div id="table-filters" class="row row-cols-auto gap-2 mt-4 ms-0">
                    <select id="filter-position" class="form-control-sm py-0 px-1 col-1" aria-label="Default select example">
                        <option hidden>Position</option>
                        @foreach ( $positions  as $position )
                            <option value="{{ $position }}" class="" > {{ $position }} </option>
                        @endforeach
                     </select>
                    <button id="btn-filter-clear" class="bi bi-filter btn btn-outline-secondary rounded-1 px-1 py-1 mx-0" title="Clear Filter">Clear</button>
                </div>

                <table id="myTable" class="table table-hover table-nowrap table-bordered shadow-sm"  width="100%"></table>

            </main>
        </div>

        <script type="module">
            $(function(){
                let table = $('#myTable').DataTable({
                    pageResize: true,
                    initComplete: function() {
                        const table = this.api();

                        table.columns().every(function() {
                            table.search('');
                            const column = this;
                            switch (this.title()) {
                                case 'Company':
                                    $('#select').clone().attr("id","filter-company").removeClass(['form-control' , 'form-select']).addClass(['form-control-sm' , 'col-1'])
                                    .insertBefore('#filter-position')
                                    .on('change', function() {
                                        const val = $(this).find(":selected").data("val");
                                        column.search(val).draw();
                                    });
                                    break;
                                case 'Position':
                                    $("#filter-position").on('change', function() {
                                        column.search( $(this).val()).draw();
                                    });
                                    break;
                                default:
                                    return;
                            }
                        });

                        $('#btn-filter-clear').click(function (e) {
                            $('#filter-company option:selected').prop("selected" , false);
                            $('#filter-position option:selected').prop("selected" , false);
                            table.columns().search('').draw();
                        });

                    },
                    scrollCollapse: true,
                    scrollX: true,
                    scrollY: 720,
                    responsive: true,
                    layout: {
                        topStart: null,
                        topEnd: null,
                        top1Start:{

                        },
                         top0Start:{
                            pageLength: {
                            placeholder: 'Filter'
                            },
                            search: {
                                placeholder: 'Type search here'
                            },
                        },
                        top0End:{
                            buttons: [{
                                text: 'New',
                                attr: {
                                    id: 'btn-add-record',
                                    'data-bs-toggle': 'modal',
                                    'data-bs-target': '.modal',
                                    class: 'bi bi-plus-lg btn btn-outline-primary rounded-2 px-3 py-0' ,
                                },
                                action: function (e, dt, node, config, cb) {
                                    storeEmployee()
                                }
                            }]
                        }
                    },
                    language: {
                        lengthMenu:  '_MENU_',
                        search: ' '
                    },
                    serverSide: true,
                    processing: true,
                    ajax: {
                        url: 'employee/draw',
                    },
                    columns: [
                          {
                            data: 'id',
                            title:'#' ,
                            name: 'id',

                        },
                        {
                            data: null ,
                            title: "Actions",
                            render: function (data, type, row) {
                                return `<button title="Edit" class="d-inline btn  btn-edit p-0 " id="btn-edit-${row.id}" data-id="${row.id}" data-bs-toggle="modal" data-bs-target=".modal" >
                                            <i class="bi bi-pencil-square" style="color:#1DB954"></i>
                                        </button>
                                        <button title="Delete" class="btn btn-dlt-modal d-inline p-0 ms-2" data-id="${row.id}" data-bs-toggle="modal" data-bs-target="#deletConfirmation" >
                                            <i class="bi bi-trash" style="color:red"></i>
                                        </button> `
                            },
                        },
                        {
                            data: 'company_id',
                            title:'Company' ,
                            name: 'company_id',
                            render: DataTable.render.ellipsis( 26 )

                        },
                        {

                            data: 'company.branch',
                            title:'Branch' ,
                            name: 'company_branch',
                            render: DataTable.render.ellipsis( 20 ),

                        },
                        {
                            data: 'name' ,
                            title: 'Name' ,
                            name: 'name',
                            render: DataTable.render.ellipsis( 26 )
                        },
                        {
                            data: 'position' ,
                            title:'Position' ,
                            name: 'position',
                            render: DataTable.render.ellipsis( 15 )
                        },
                        {
                            data: 'dob',
                            title:'DOB' ,
                            name: 'dob',

                        },
                        {
                            data: 'email' ,
                            title:'Email' ,
                            name: 'email',
                        },
                        {
                            data: 'phone',
                            title:'Phone' ,
                            name: 'phone',
                        },
                        {
                            data: 'address' ,
                            title:'Address' ,
                            render: DataTable.render.ellipsis( 26 ),
                            name: 'address',
                        },
                        {
                            data: 'bank_account.account_no',
                            title:'Bank Acc' ,
                            name: 'bank_account_no',
                        },
                    ],
                    columnDefs: [
                        { orderable: false, targets: 0 },
                        { className: 'dt-head-left py-0', targets: '_all' },
                    ],
                });

                //sidebar
                $('#sidebar-toggle').on('click', function() {
                    $('#sidebar-long').toggleClass('d-none');
                    $('main').toggleClass('main-l-sidebar');
                    $('#sidebar-short').toggleClass('d-none');
                    table.columns.adjust();
                    table.responsive.recalc();
                });

                const linkColor = $('.nav_link');
                linkColor.removeClass('active')
                $('.btn-employee').addClass('active');

                $('body').tooltip({
                    selector: '[data-bs-toggle="tooltip"]',
                });

                //dlt btn
                $('#myTable tbody').on('click' , '.btn-dlt-modal' ,function (e) {
                    $('#btn-dlt').text('Delete').attr('data-id' , table.row($(this).parents('tr')).data().id)
                });

                $('#deletConfirmation .modal-footer').on('click' , '#btn-dlt' , function (e) {
                    axios.delete(`employee/${$(this).attr('data-id')}`)
                    .then(function (response){
                        displayToast(response , "success")
                        $('.btn-close-dlt').click();
                    });
                    table.draw(false);
                });

                //Store Employee Axios
                function storeEmployee(){
                    $('.form-modal').attr("id","form-create");
                    $('#form-title').text("New Employee Details");
                    $('#btn-submit').text("Save");
                    $('.trash').toggleClass("d-none" , true);
                };

                $('.modal-body').on('submit' , '#form-create', function (e){
                    e.preventDefault();
                    let $data = $('#form-create').serialize()
                    axios.post('employee', $data )
                    .then(function (response){
                        $('#form-create').trigger("reset");
                        $('#btn-modal-close').click();
                        table.draw(false);
                        displayToast(response , "success")
                    })
                    .catch(function (response){
                        displayToast(response , "error")
                    });
                });

                // Edit Employee
                let id = null
                $('#myTable tbody').on('click', '.btn-edit', function (e) {
                    $('.form-modal').attr("id","form-edit");
                    $('#form-title').text("Edit Employee Details");
                    $('#btn-submit').text("Update");
                    $('.trash').toggleClass("d-none" , true);

                    id = table.row( $(this).parents('tr') ).data().id;
                    axios.get(`employee/${id}`)
                    .then(function (response){
                        const data = response.data[0];
                        $('#name').val(data.name)
                        $('#position').val(data.position)
                        $('#dob').val(data.dob)
                        $('#email').val(data.email)
                        $('#phone').val(data.phone)
                        $('#address').val(data.address)
                        $('#select').val(data.company.id)
                        $('#select option:selected').toggleClass('d-none' , false)
                        $('#company-branch').val(data.company.branch)
                        $('#bank-id').val(data.bank_account.id)
                        $('#beneficiary-name').val(data.bank_account.beneficiary_name)
                        $('#bank-name').val(data.bank_account.bank_name)
                        $('#bank-branch').val(data.bank_account.branch)
                        $('#account-no').val(data.bank_account.account_no)
                    });
                });

                $('.modal-body').on('submit' , '#form-edit', function (e){
                    e.preventDefault();
                    let dataSubmit = new FormData(this)
                    dataSubmit.append('_method', 'patch');

                    axios.post(`employee/${id}`, dataSubmit )
                    .then(function (response){
                        $('#form-edit').trigger("reset");
                        $('#btn-modal-close').click();
                        table.draw(false);
                        displayToast(response , "success")
                    })
                    .catch(function (response){
                        displayToast(response , "error")
                    });
                });

                // Clear Forms
                $('.btn-close').click(function (e) {
                    $('.form-modal').trigger("reset");
                });

                // Set Branch on Selct
                $('#select').on('click' , function (e) {
                    $('#company-branch').val($(this).find(':selected').data('branch'))
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

