@extends('layouts.app')
@section('title')
Career Management
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Career</h5>
            <h6 class="card-subtitle mb-2 text-muted"> Manage your career section here.</h6>
            
            
            <div class="mt-2">
                @include('layouts.includes.messages')
               
            </div>
            <table class="table table-striped mt-5 data-table" id="careerTable">
                <thead>
                    <tr>
                        <th class="text-center">
                            <input type="checkbox" class="group_check checkbox" >
                        </th>
                        <th scope="col" width="15%">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Mobile</th>
                        <th scope="col" width="10%">Gender</th>
                        <th scope="col">DOB</th>
                        <th scope="col">Experience</th>
                        <th scope="col">Qualification</th>
                        <th scope="col">Details</th>
                        <th scope="col">CV/Resume</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@push('after-scripts')
<script type="text/javascript">
        $(function() {
            gb_DataTable = $("#careerTable").DataTable({
                autoWidth: false,
                order: [0, "ASC"],
                processing: true,
                serverSide: true,
                searchDelay: 2000,
                paging: true,
                ajax: "{{ route('cm.career') }}",
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
                     { extend: 'copy', className: 'btn bg-teal color-palette btn-flat',footer: true, exportOptions: { columns: [1,2,3,4,5,6,7,8,9]} },
                     { extend: 'excel', className: 'btn bg-teal color-palette btn-flat',footer: true, exportOptions: { columns: [1,2,3,4,5,6,7,8,9]} },
                     { extend: 'pdf', className: 'btn bg-teal color-palette btn-flat',footer: true, exportOptions: { columns: [1,2,3,4,5,6,7,8,9]} },
                     { extend: 'print', className: 'btn bg-teal color-palette btn-flat',footer: true, exportOptions: { columns: [1,2,3,4,5,6,7,8,9]} },
                     { extend: 'csv', className: 'btn bg-teal color-palette btn-flat',footer: true, exportOptions: { columns: [1,2,3,4,5,6,7,8,9]} },
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
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'mobile', name: 'mobile' },
                    { data: 'gender', name: 'gender' },
                    { data: 'dob', name: 'dob' },
                    { data: 'experience', name: 'experience' },
                    { data: 'qualification', name: 'qualification' },
                    { data: 'message', name: 'message' },
                    { data: 'cv', name: 'cv' },
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
                    url:"{{ route('ajaxdata.bulk-delete')}}",
                    method:"get",
                    data:{id:id},
                    success:function(data)
                    {
                        alert(data);
                        $('#careerTable').DataTable().ajax.reload();
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