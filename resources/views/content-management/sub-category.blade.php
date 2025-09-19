@extends('layouts.app')

@section('title')
Sub Category
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <div class="col">
                    <h5 class="card-title">Sub Category</h5>
                    <h6 class="card-subtitle mb-2 text-muted"> Manage your Sub-Category section here.</h6>
                </div>
                <div class="justify-content-end">
                    <a href='{{route('cm.sub-category.create')}}' class="btn btn-primary">&#43; Add</a>
                </div>
            </div>
            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>
            <table class="table table-striped mt-5" id="subcat">
                <thead>
                    <tr>
                        <th class="text-center">
                            <input type="checkbox" class="group_check checkbox" >
                        </th>
                        <th scope="col">Category</th>
                        <th scope="col">Name</th>
                        <th scope="col">Meta Title</th>
                        <th scope="col">Meta Keywords</th>
                        <th scope="col">Meta Description</th>
                        <th scope="col">Canonical Url</th>
                        <th scope="col">Image</th>
                        <th scope="col">Alt Tag</th>
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
@endsection
@push('after-scripts')
<script type="text/javascript">
        $(function() {
            gb_DataTable = $("#subcat").DataTable({
                autoWidth: false,
                order: [0, "ASC"],
                processing: true,
                serverSide: true,
                searchDelay: 2000,
                paging: true,
                ajax: "{{ route('cm.sub.category') }}",
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
                    { data: 'category', name: 'category' },
                    { data: 'name', name: 'name' },
                    { data: 'meta_title', name: 'meta_title' },
                    { data: 'meta_keyword', name: 'meta_keyword' },
                    { data: 'meta_description', name: 'meta_description' },
                    { data: 'meta_description', name: 'meta_description' },
                    { data: 'canonical_url', name: 'canonical_url', orderable: false, searchable: false},
                    { data: 'image', name: 'image' , orderable: false, searchable: false},
                    { data: 'alt_tag', name: 'alt_tag' , orderable: false, searchable: false},
                    { data: 'status', name: 'status' , orderable: false, searchable: false},
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
                    url:"{{ route('cm.sub-category.bulk-delete')}}",
                    method:"get",
                    data:{id:id},
                    success:function(data)
                    {
                        alert(data);
                        $('#subcat').DataTable().ajax.reload();
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