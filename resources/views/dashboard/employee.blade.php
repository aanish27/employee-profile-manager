<x-app-layout>
<x-slot:title> Employee Manger </x-slot:title>
<div class="content w-100">
    <div class="container-fluid " >
        <div class="modal fade modal-lg"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div id="validation-errors" style="display: none;" class="position-absolute top-0 end-0  w-25" role="alert"></div>
            <div class="modal-dialog ">
                <div class="modal-content " style=" width: auto;">
                <div class="modal-header py-2 justify-content-between">
                        <h4 class="fs-5 m-0" id="form-title"></h4>
                    <button type="button" id="btn-modal-close" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body m-0 ">
                    <form class="form-modal row  p-1  needs-validation"  novalidate>
                        @csrf
                        <div class="mb-2 col-3">
                            <label for="name" class="form-label fw-bold ">Name:</label>
                            <input type="text" class="form-control py-1 " id="name" name="name" placeholder="Full Name" required>
                            <div class="invalid-feedback">Please Enter the Name</div>
                            <div class="valid-feedback">Name Valid</div>
                        </div>
                        <div class=" mb-2 col-3">
                            <label class="form-label fw-bold" for="position">Position:</label>
                            <input type="text" class=" form-control py-1 " id="position" name="position" placeholder="Position" required>
                            <div class="invalid-feedback">Please Enter the Position</div>
                            <div class="valid-feedback">Position Valid</div>
                        </div>
                        <div class="mb-2 col-3" >
                            <label class="form-label fw-bold" for="dob">DOB:</label>
                            <input type="date" class=" form-control py-1 " id="dob" name="dob" placeholder="DOB" required>
                            <div class="invalid-feedback">Please Enter the DOB</div>
                            <div class="valid-feedback">DOB Valid</div>
                        </div>
                        <div class=" mb-2 col-3">
                            <label class="form-label fw-bold" for="email">Email:</label>
                            <input type="email" class=" form-control py-1 " id="email" name="email" placeholder="Email" required>
                            <div class="invalid-feedback">Please Enter the Email</div>
                            <div class="valid-feedback">Email Valid</div>
                        </div>
                        <div class=" mb-2 col-3">
                            <label class="form-label fw-bold" for="phone">Phone:</label>
                            <input type="phone" class=" form-control py-1 " id="phone" name="phone" placeholder="Phone" required>
                            <div class="invalid-feedback">Please Enter the Phone Number</div>
                            <div class="valid-feedback">Phone Number Valid</div>
                        </div>
                        <div class="col-9">
                            <label class="form-label fw-bold" for="address">Address:</label>
                            <input type="text" class=" form-control py-1 " id="address" name="address" placeholder="Address" required>
                            <div class="invalid-feedback">Please Enter the Address</div>
                            <div class="valid-feedback">Address Valid</div>
                        </div>

                        <div class="mt-2 mb-2 col-6 d-inline">
                            <label class="form-label fw-bold" for="select">Choose Company: </label>
                            <select id="select" name="company_id" class="form-select py-1" required>
                                <option hidden value="">Company</option>
                                @foreach ( $companies  as $company )
                                    <option value="{{ $company->id }}" data-val="{{ $company->name }}" class="create-option {{ is_null($company->deleted_at) ? '' : 'trash' }}" data-branch="{{ $company->branch }}" > {{ $company->name }} </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please Choose A Compnay</div>
                            <div class="valid-feedback">Company Valid</div>
                        </div>

                        <div class="mt-2 col-6">
                            <label class="form-label fw-bold" for="company-branch">Branch:</label>
                            <input type="text" class="form-control py-1 " id="company-branch" name="company_branch" placeholder="Branch" required disabled>
                        </div>

                        <input type="hidden" name="bank_id" id="bank-id">

                        <div class="mt-2 mb-2 col-6">
                            <label class="form-label fw-bold" for="beneficiary-name">Beneficiary Name:</label>
                            <input type="text" class=" form-control py-1 "  id="beneficiary-name" name="beneficiary_name" placeholder="Beneficiary Name" required>
                            <div class="invalid-feedback">Please Enter the Name</div>
                            <div class="valid-feedback">Name Valid</div>
                        </div>

                        <div class="mt-2 mb-2 col-6">
                            <label class="form-label fw-bold" for="bank-name">Bank Name</label>
                            <input type="text" class=" form-control py-1 " id="bank-name" name="bank_name" placeholder="Bank Name" required>
                            <div class="invalid-feedback">Please Enter the Bank Name</div>
                            <div class="valid-feedback">Bank Name Valid</div>
                        </div>

                        <div class="mb-2 col-6">
                            <label class="form-label fw-bold" for="bank-branch">Branch</label>
                            <input type="phone" class=" form-control py-1 " id="bank-branch" name="branch" placeholder="Branch" required>
                            <div class="invalid-feedback">Please Enter the Branch</div>
                            <div class="valid-feedback">Branch Valid</div>
                        </div>

                        <div class="mb-2 col-6">
                            <label class="form-label fw-bold" for="account-no">Account No:</label>
                            <input type="number" class=" form-control py-1 " id="account-no" name="account_no" placeholder="Account No" required>
                            <div class="invalid-feedback">Please Enter the Account No</div>
                            <div class="valid-feedback">Account No Valid</div>
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
            <x-delete-modal/>

            <div id="table-filters" class="row row-cols-auto gap-2 mt-4 ms-0">
            <x-dropdown-filter id="filter-company" name="Company" :collections="$companies" modal_id="id"  modal_name="name" />
            <x-dropdown-filter id="filter-position" name="Position" :collections="$positions"/>
            </div>

        <table id="myTable" class="table table-hover table-nowrap table-bordered shadow-sm"  width="100%"></table>

    </div>
</div>

<script type="module">
    $(function(){

        //Dropdown filter Initialize
        $('.select2-filter').val(null);
        $(".select2-filter").select2({
            theme: 'bootstrap-5',
            multiple: true,
            width: 'resolve',
            placeholder: 'Select',
            allowClear: true,
        });

        let table = $('#myTable').DataTable({
            pageResize: true,
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
                data: function (d) {
                    const dropdowns = {};
                    dropdowns['position'] = ($("#filter-position").val().length === 0 ) ?  dropdowns['position'] : $("#filter-position").val();
                    dropdowns['company'] = ($("#filter-company").val().length === 0) ? dropdowns['company'] : $("#filter-company").val();
                    d.dropdowns = dropdowns;
                }
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
                    name: 'action',
                    orderable: false,
                    sortable: false,
                },
                {
                    data: 'company.name',
                    title:'Company' ,
                    name: 'company.name',
                    render: DataTable.render.ellipsis( 26 )
                },
                {
                    data: 'company.branch',
                    title:'Branch' ,
                    name: 'company.branch',
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
                    name: 'phone'
                },
                {
                    data: 'address' ,
                    title:'Address' ,
                    name: 'address',
                    render: DataTable.render.ellipsis( 26 )
                },
                {
                    data: 'bank_account.account_no',
                    title:'Bank Acc' ,
                    name: 'bank_account.account_no'
                },
            ],
            columnDefs: [
                { className: 'dt-head-left py-0', targets: '_all' },
            ],
        });

        //Dropdown filter
        $('.select2-filter').on('select2:clear', function () {
            table.draw();
        })

        $('.select2-filter').on('change', function () {
            if($(this).val().length == 0) return;

            const select = $(this)
            const ul = select.siblings('span.select2').find('ul')
            const count = select.select2('data').length

            if(select.val().includes("btn_select_all")) {
                const options = select.find('option')
                options.prop('selected', true);
                ul.html("<span>" + (options.length - 1) + " items selected</span>")

                let values  = select.val()
                values.splice(0,1)
                select.val(values)
            }
            else if(count > 1){
                ul.html("<span>" +count+ " items selected</span>")
            }
            table.draw();
        })

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

        //Dlt Modal Open
        $('#myTable tbody').on('click' , '.btn-dlt-modal' ,function (e) {
            const data = table.row($(this).parents('tr')).data();
            $('#deletConfirmationLabel').text('Are you sure to delete the Details of ' + data.name )
            $('.delete-modal-body').text('This action will delete the details of ' + data.name + ' and the bank account details associated with him/her.' )
            $('#btn-dlt').attr('data-id' , data.id)
        });

        //Dlt Modal Btn
        $('#deletConfirmation .modal-footer').on('click' , '#btn-dlt' , function (e) {
            axios.delete(`employee/${$(this).attr('data-id')}`)
            .then(function (response){
                table.draw(false);
                displayToast(response , "success")
                $('.btn-close-dlt').click();
            });
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

        //Forms
        $('.needs-validation').on('submit', function (e) {
            if (!this.checkValidity()) {
                e.preventDefault()
                e.stopPropagation()
            }
            $(this).addClass('was-validated')
        });

        $('.btn-close').click(function (e) {
            $('.form-modal').trigger("reset").toggleClass('was-validated' , false);
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
</x-app-layout>
