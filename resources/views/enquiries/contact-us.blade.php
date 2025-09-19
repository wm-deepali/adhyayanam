@extends('layouts.app')

@section('title')
Contact Us Inquiries
@endsection

@section('content')
<div class="bg-light rounded p-2">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Contact Us Inquiries</h5>
            <h6 class="card-subtitle mb-2 text-muted"> Manage Contact Us Inquiries here.</h6>

            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>
            <div class="container mt-4">
                <table class="table table-striped mt-5" id="contact">
                    <thead>
                        <tr>
                            <th class="text-center">
                                <input type="checkbox" class="group_check checkbox" >
                            </th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Subject</th>
                            <th scope="col">Message</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
          
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
@push('after-scripts')
<script type="text/javascript">
        $(function() {
            gb_DataTable = $("#contact").DataTable({
                autoWidth: false,
                order: [0, "ASC"],
                processing: true,
                serverSide: true,
                searchDelay: 2000,
                paging: true,
                ajax: "{{ route('enquiries.contact.us') }}",
                iDisplayLength: "10",
                dom:'<"row margin-bottom-12"<"col-sm-12"<"pull-left"l><"pull-right"fr><"pull-right margin-left-10 "B>>>tip',
                buttons: {
                 buttons: [
                     {
                         className: 'btn bg-red color-palette btn-flat hidden delete_btn pull-left',
                         text: 'Bulk Delete',
                         action: function ( e, dt, node, config ) {
                             multi_delete();
                         }
                     },
                     { extend: 'copy', className: 'btn bg-teal color-palette btn-flat',footer: true, exportOptions: { columns: [1,2,3,4,5,6]} },
                     { extend: 'excel', className: 'btn bg-teal color-palette btn-flat',footer: true, exportOptions: { columns: [1,2,3,4,5,6]} },
                     { extend: 'pdf', className: 'btn bg-teal color-palette btn-flat',footer: true, exportOptions: { columns: [1,2,3,4,5,6]} },
                     { extend: 'print', className: 'btn bg-teal color-palette btn-flat',footer: true, exportOptions: { columns: [1,2,3,4,5,6]} },
                     { extend: 'csv', className: 'btn bg-teal color-palette btn-flat',footer: true, exportOptions: { columns: [1,2,3,4,5,6]} },
                     { extend: 'colvis', className: 'btn bg-teal color-palette btn-flat',footer: true, text:'Columns' },  
         
                     ]
                 },
                columnDefs: [
                    {
                        'targets': 0,
                        'checkboxes': {
                            'selectRow': true
                        }
                    }
                ],
                select: {
                    'style': 'multi'
                },
                columns: [
                    {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
                    { data: 'created_at', name: 'created_at' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'website', name: 'website' },
                    { data: 'message', name: 'message' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                lengthMenu: [10, 50, 100],
            });
        });


    function multi_delete(){
        var id = [];
        if(confirm("Are you sure you want to Delete this data?"))
        {
            $('.career_checkbox:checked').each(function(){
                id.push($(this).attr('id'));
            });
            if(id.length > 0)
            {
                $.ajax({
                    url:"{{ route('enquiries.contact.bulk-delete')}}",
                    method:"get",
                    data:{id:id},
                    success:function(data)
                    {
                        alert(data);
                        $('#contact').DataTable().ajax.reload();
                    }
                });
            }
            else
            {
                alert("Please select atleast one checkbox");
            }
        }
    }
    </script>


<script type="text/javascript">

$('.group_check').on('change', function(event) {
    if(event.target.checked){
      $(".column_checkbox").prop("checked",true);
    }
    else{
      $(".column_checkbox").prop("checked",false);
    }
});

</script>
  @endpush