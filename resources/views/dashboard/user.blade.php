<x-app-layout>
<x-slot:title> User Manager </x-slot:title>

<div class="content w-100">
    <div class="container-fluid p-3">
        <table id="myTable" class="table table-hover table-nowrap table-bordered shadow-sm"  width="100%" ></table>
    </div>
  </div>

  <script type="module">
    $(function () {

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
                      storeUser()
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
            url: 'user/draw',
            data: function (d) {
                const dropdowns = {};
                // dropdowns['country'] = ($("#filter-country").val().length === 0 ) ?  dropdowns['country'] : $("#filter-country").val();
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
            title:'Name',
            name:'name',
            render: DataTable.render.ellipsis( 50 )
          },
          {
            data: 'email',
            title:'Email',
            name: 'Email',
            render: DataTable.render.ellipsis( 26 )
          },
          {
            data: 'is_active' ,
            title: 'Status' ,
            name: 'is_active',
            render: DataTable.render.ellipsis( 26 )
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
      $('.btn-user').addClass('active');

      $('body').tooltip({
          selector: '[data-bs-toggle="tooltip"]',
      });

    });
  </script>
</x-app-layout>




