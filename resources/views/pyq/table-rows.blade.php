@foreach($test as $res)
    <tr>
        <th scope="row">{{ $loop->iteration }}</th>
        <td>{{ $res->created_at }}</td>
        <td>{{ $res->name }}<br /><span class="badge badge-success">{{ $res->test_code ?? "" }}</span></td>
        <td>{{ $res->test_paper_type ?? "" }}</td>
        <td>{{ $res->previous_year }}</td>
        <td>
            {{ $res->commission->name ?? "_" }} <br />
            {{ $res->category->name ?? "_" }}<br />
            <span class="text-success">{{ $res->subcategory->name ?? "_" }}</span>
        </td>
        <td>{{ $res->total_questions }}</td>
        <td>{{ $res->total_marks }}<br />
            <span class="badge badge-secondary">{{ $res->duration ?? "" }} mins</span>
        </td>
        <td>
            <a href="{{ route('test-papers.download', $res->id) }}" target="_blank">
                <img height="80px" src="{{ asset('img/pdficon.png') }}" />
            </a>

        </td>
        <td>Active</td>
        <td>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Actions
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="{{ route('test.paper.view', $res->id) }}">
                            <i class="fas fa-eye"></i> View
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('test.paper.edit', $res->id) }}">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </li>
                    <li>
                        <form action="{{ route('test.paper.delete', $res->id) }}" method="POST" class="delete-form"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="dropdown-item text-danger delete-btn">
                                <i class="fas fa-trash" style="color: #dc3545!important"></i> Delete
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </td>
    </tr>
@endforeach