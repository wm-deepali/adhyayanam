 @foreach($test_series as $test)
                    
                        @php 
                        if($test->fee_type == 'paid')
                        {
                         $colorClass="warning";
                        }
                        else
                        {
                        $colorClass="success";
                        }
                        @endphp
                        <tr>
                           <td style="width:12%;">{{ date('d/m/Y', strtotime($test->created_at))}}<br/>{{ date('g:i A', strtotime($test->created_at))}}</td>
                           
                            <td>{{$test->language == 1 ? 'Hindi' : 'English'}}</td>
                            
                            <td>{{ $test->title }} <br/><span class="badge badge-{{$colorClass}}">{{ucfirst($test->fee_type) ?? ""}}</span></td>
                            <td>{{ $test->commission->name  ?? "" }}
                            <br/><span class="text-success">{{ $test->category->name  ?? "" }}</span>
                            </td>
                            
                          @php
if (isset($test->testseries) && count($test->testseries) > 0) {
    $types = $test->testseries->pluck('test_paper_type')->unique()->filter()->toArray();
    $type = count($types) ? '(' . implode(', ', $types) . ')' : '';
} else {
    $type = '';
}
@endphp

                            
                            <td>{{ $test->subcategory->name ?? "" }}<br/>{{$type}}</td>
                            
                            @php
                            $subjectiveCount = 0;
                            $mcqCount = 0;
                            $combinedCount = 0;
                            $passageCount = 0;
                            if(isset($test->testseries) && count($test->testseries) >0)
                            {
                                $subjectiveCount = $test->testseries->where('test_paper_type', 'Subjective')->count();
                                $mcqCount = $test->testseries->where('test_paper_type', 'MCQ')->count();
                                $passageCount = $test->testseries->where('test_paper_type', 'Passage')->count();
                                $combinedCount = $test->testseries->where('test_paper_type', 'Combined')->count();
                            }
                            @endphp
                            
                            <td>{{count($test->testseries)}}
                            <br/>
                            {{$subjectiveCount > 0 ? 'Subjective: '.$subjectiveCount : ''}}<br/>
                            {{$mcqCount > 0 ? 'MCQ: '.$mcqCount : ''}}<br/>
                            {{$passageCount > 0 ? 'Passage: '.$passageCount : ''}}<br/>
                            {{$combinedCount > 0 ? 'Combined: '.$combinedCount : ''}}<br/>
                            
                            </td>
                            
                            <td>{{ $test->price }}</td>
                           
                            <td>
                               <div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle btn-sm" type="button"
        data-bs-toggle="dropdown" aria-expanded="false">
        Actions
    </button>

    <ul class="dropdown-menu">

        @if(\App\Helpers\Helper::canAccess('manage_test_series_package'))
            <li>
                <a class="dropdown-item" href="{{ route('test.series.view', $test->id) }}">
                    <i class="fas fa-eye"></i> View
                </a>
            </li>
        @endif

        @if(\App\Helpers\Helper::canAccess('manage_test_series_package_edit'))
            <li>
                <a class="dropdown-item" href="{{ route('test.series.edit', $test->id) }}">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </li>
        @endif

        @if(\App\Helpers\Helper::canAccess('manage_test_series_package_delete'))
            <li>
                <form action="{{ route('test.series.delete', $test->id) }}" method="POST" style="display:inline;">
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