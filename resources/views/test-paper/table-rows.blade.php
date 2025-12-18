@foreach($test as $bank)
    <tr>

        <td style="width:12%;">
            {{ date('d/m/Y', strtotime($bank->created_at))}}<br />{{ date('g:i A', strtotime($bank->created_at))}}</td>

        <td>{{ $bank->name }}<br /><span class="badge badge-success">{{$bank->test_code ?? ""}}</span></td>

        @php
            if ($bank->paper_type == 2) {
                // Current Affair
                $typeName = 'Current Affair';
            } elseif ($bank->paper_type == 1) {
                // Previous Year
                $typeName = 'Previous Year';
            } elseif ($bank->paper_type == 0) {
                // Full / Subject / Chapter / Topic based on null checks
                if (is_null($bank->topic_id) && is_null($bank->subject_id) && is_null($bank->chapter_id)) {
                    $typeName = 'Full Test';
                } elseif (is_null($bank->topic_id) && !is_null($bank->subject_id) && is_null($bank->chapter_id)) {
                    $typeName = 'Subject Wise';
                } elseif (is_null($bank->topic_id) && !is_null($bank->chapter_id)) {
                    $typeName = 'Chapter Wise';
                } elseif (!is_null($bank->topic_id)) {
                    $typeName = 'Topic Wise';
                } else {
                    $typeName = '-';
                }
            } else {
                $typeName = '-';
            }
        @endphp


        <td> {{ $typeName}}
            <br />({{$bank->test_paper_type ?? ""}})
        </td>

        <td>{{$bank->category->name ?? "_"}}<br /><span class="text-success">{{$bank->subcategory->name ?? "_"}}</span></td>

        @php 
                                if ($bank->test_type == 'paid') {
                $colorClass = "warning";
            } else {
                $colorClass = "success";
            }
        @endphp
                                <td>{{$bank->language == 1 ? 'Hindi' : 'English'}}<br/><span class="badge badge-{{$colorClass}}">{{ucfirst($bank->test_type) ?? ""}}</span></td>


                                           <td>{{$bank->total_questions}}</td>

                            <td>{{$bank->total_marks}}<br/><span class="badge badge-secondary">{{$bank->duration ?? ""}} mins</span></td>

                            <td>Active</td>
                            <td>{{ $bank->creator ? $bank->creator->name : 'N/A' }}</td>
                               <td>
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle btn-sm" type="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                Actions
            </button>

            <ul class="dropdown-menu">

                @if(\App\Helpers\Helper::canAccess('manage_test_bank'))
                    <li>
                        <a class="dropdown-item" href="{{ route('test.paper.view', $bank->id) }}">
                            <i class="fas fa-eye"></i> View
                        </a>
                        </li>
                @endif

                @if(\App\Helpers\Helper::canAccess('manage_test_bank_edit'))
                    <li>
                        <a class="dropdown-item" href="{{ route('test.paper.edit', $bank->id) }}">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </li>
                @endif

                @if(\App\Helpers\Helper::canAccess('manage_test_bank_delete'))
                                        <li>
                                        <form action="{{ route('test.paper.delete', $bank->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                <i class="fas fa-trash" style="color:#dc3545!important"></i> Delete
                        </button>
                    </form>
                                    </li>
                @endif

            </ul>
        </div>
    </td>

                        </tr>
@endforeach