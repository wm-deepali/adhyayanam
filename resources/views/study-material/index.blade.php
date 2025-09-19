@extends('layouts.app')

@section('title')
Study Material
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <div class="col">
                    <h5 class="card-title">Study Material</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Manage your Study Material section here.</h6>
                </div>
                <div class="justify-content-end">
                    <a href='{{route('study.material.create')}}' class="btn btn-primary">&#43; Add</a>
                </div>
            </div>
            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>

            <!-- Tabs -->
            <ul class="nav nav-tabs" id="studyMaterialTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="free-tab" data-bs-toggle="tab" data-bs-target="#free" type="button" role="tab" aria-controls="free" aria-selected="true">Free</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="paid-tab" data-bs-toggle="tab" data-bs-target="#paid" type="button" role="tab" aria-controls="paid" aria-selected="false">Paid</button>
                </li>
            </ul>
            <div class="tab-content mt-4" id="studyMaterialTabsContent">
                <!-- Free Study Materials Tab -->
                <div class="tab-pane fade show active" id="free" role="tabpanel" aria-labelledby="free-tab">
                    <table class="table table-striped table-responsive table-bordered" id="freeMaterial">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    <input type="checkbox" class="group_check checkbox" >
                                </th>
                                <th scope="col" width="15%">Date & Time</th>
                                <th scope="col">Title</th>
                                <th scope="col">Topic</th>
                                <th scope="col">Category</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>

                <!-- Paid Study Materials Tab -->
                <div class="tab-pane fade" id="paid" role="tabpanel" aria-labelledby="paid-tab">
                    <table class="table table-striped table-responsive table-bordered" id="paidMaterial">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    <input type="checkbox" class="group_check checkbox" >
                                </th>
                                <th scope="col" width="15%">Date & Time</th>
                                <th scope="col">Title</th>
                                <th scope="col">Topic</th>
                                <th scope="col">Category</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('after-scripts')
<script type="text/javascript">
        $(function() {
            gb_DataTable = $("#freeMaterial").DataTable({
                autoWidth: false,
                order: [0, "ASC"],
                processing: true,
                serverSide: true,
                searchDelay: 2000,
                paging: true,
                ajax: "{{ route('study.material.index') }}",
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
                    { data: 'title', name: 'title' },
                    { data: 'category', name: 'category' },
                    { data: 'topic', name: 'topic' },
                    {data: 'status', name: 'status', orderable: false, searchable: false},
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
                    url:"{{ route('study.material.bulk-delete')}}",
                    method:"get",
                    data:{id:id},
                    success:function(data)
                    {
                        $('#freeMaterial').DataTable().ajax.reload();
                        alert(data);
                       
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

$(document).ready(function()
{   
    $('#paid-tab').click(function() {
            event.preventDefault();
            gb_DataTable = $("#paidMaterial").DataTable({
                autoWidth: false,
                order: [0, "ASC"],
                processing: true,
                serverSide: true,
                searchDelay: 2000,
                paging: true,
                ajax:{
                    url: "{{ route('study.material.index') }}",
                    data: {'type': 1},
                },
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
                    { data: 'title', name: 'title' },
                    { data: 'category', name: 'category' },
                    { data: 'topic', name: 'topic' },
                    {data: 'status', name: 'status', orderable: false, searchable: false},
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                lengthMenu: [10, 50, 100],
            });

    });
});
</script>
@endpush
