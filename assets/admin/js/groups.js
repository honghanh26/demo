var save_method; //for save method string
var table;

$.get('/admin/groups/getListGroups',function(result){
    console.log('test get data',result);
})

$(document).ready(function() {
    //datatables
    table = $('#table').DataTable({
        "processing" : true,//Feature control the processing indicator.
        "serverSide" : true,//Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "pagingType": "full_numbers",
        "ajax": {
            "url": "/admin/person/ajax_list",
            "type": "POST"
        },
        "initComplete": function() {
        },
        "autoWidth": false,
        "responsive": true,
        "language": {
            "lengthMenu": "Hiển thị _MENU_ ",
            "search": "Tìm kiếm",
            "paginate": {
                "first": "<<",
                "last": ">>",
                "next": ">",
                "previous": "<"
            },
            emptyTable: 'Không có dữ liệu',
            processing: "Đang xử lý",
        },
        "dom": '<l<rt>p>',
        "columns": [
            {
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function(data, type, full, meta) {
                    return parseInt(meta.row) + meta.settings._iDisplayStart + 1;
                },
                width: '5%'
            },
            {
                "data": "id",
                className: 'text-left',
                render: function(obj, msg, data, col) {
                    var className = 'admin/groups/stt';
                    return '<input type="text" class="stt" value="' + data.stt + '" data-url="" data-id="' +data.id+ '"/>';
                },
                width: '5%'
            },
            {
                "data": "id",
                className: 'text-left',
                render: function(obj, msg, data, col) {
                    var className = 'admin/groups/stt';
                    return '<input type="text" class="stt" value="' + data.stt + '" data-url="" data-id="' +data.id+ '"/>';
                },
                width: '5%'
            },
            {
                "data": "id",
                className: 'text-left',
                render: function(obj, msg, data, col) {
                    var className = 'admin/groups/stt';
                    return '<input type="text" class="stt" value="' + data.stt + '" data-url="" data-id="' +data.id+ '"/>';
                },
                width: '5%'
            },
            {
                "data": "id",
                className: 'text-left',
                render: function(obj, msg, data, col) {
                    var className = 'admin/groups/stt';
                    return '<input type="text" class="stt" value="' + data.stt + '" data-url="" data-id="' +data.id+ '"/>';
                },
                width: '5%'
            },
            {
                "data": "id",
                className: 'text-left',
                render: function(obj, msg, data, col) {
                    var className = 'admin/groups/stt';
                    return '<input type="text" class="stt" value="' + data.stt + '" data-url="" data-id="' +data.id+ '"/>';
                },
                width: '5%'
            },
        ]
    });

    //datepicker
    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,
    });
});

function add_person()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Person'); // Set Title to Bootstrap modal title
}

function edit_person(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('/admin/person/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="id"]').val(data.id);
            $('[name="firstName"]').val(data.firstName);
            $('[name="lastName"]').val(data.lastName);
            $('[name="gender"]').val(data.gender);
            $('[name="address"]').val(data.address);
            $('[name="dob"]').datepicker('update',data.dob);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Person'); // Set title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax
}

function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('/admin/person/ajax_add')?>";
    } else {
        url = "<?php echo site_url('/admin/person/ajax_update')?>";
    }

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                reload_table();
            }

            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable

        }
    });
}

function delete_person(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('/admin/person/ajax_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });

    }
}