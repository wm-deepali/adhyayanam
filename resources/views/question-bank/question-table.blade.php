<table class="table table-striped mt-5">
    <thead>
        <tr>
            <!--th scope="col" width="1%">#</th-->
            <th scope="col">Date & Time</th>
            <th scope="col">Question</th>
            <th scope="col">Topic</th>
            <th scope="col">Cat / Sub Cat</th>
            
            <th scope="col">PYQ</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        
        @foreach($questionBanks as $data)
        <tr>
            <!--th scope="row">{{ $data->id }}</th-->
            <td style="width:12%;">{{ date('d/m/Y', strtotime($data->created_at))}}<br/>{{ date('g:i A', strtotime($data->created_at))}}</td>
            <td>{{ Helper::limitTextChars(strip_tags($data->question), 80) }}
                <br/><span class="badge badge-success">{{$data->question_type ?? ""}}</span>
            </td>
            <td>{{$data->topics->name ?? "_"}}<br/><span class="badge badge-secondary">{{$data->subject->name ?? "-"}}</span></td>
            <td><span class="text-success">{{$data->category->name ?? "-"}}</span><br/><span class="text-warning">{{$data->subcategory->name ?? "-"}}</span></td>
            
            <td>{{$data->show_on_pyq}}</td>
            <td>Active</td>
            <td>
                
                <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Actions
              </button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{route('question.bank.view',$data->id)}}"><i class="fas fa-eye"></i> View</a></li>
                <li><a class="dropdown-item" href="{{route('question.bank.edit',$data->id)}}"><i class="fas fa-edit"></i> Edit</a></li>
                <li>
                     <form action="{{ route('question.bank.delete', $data->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dropdown-item text-danger"><i class="fas fa-trash" style="color: #dc3545!important"></i> Delete</button>
                </form>
                    
              </ul>
            </div>
                
               
               
            </td>
        </tr>
        @endforeach
        
    </tbody>
</table>
{{$questionBanks->links()}}