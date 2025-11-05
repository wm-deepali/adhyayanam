@if(isset($question) && !empty($question))
 <div class="col-md-12" style="display:flex;">
    {!! 'Q ' . ' ' . $question->question ?? "" !!}
    <span class="text-right"><strong>(Marks : {{$marks}})</strong></span>
    </div>

    @if(strip_tags($question->option_a) !="")
    <div class="col-md-12">
        <p><strong>A)</strong> {!! $question->option_a ?? "" !!}</p>
    </div>
    @endif
    @if(strip_tags($question->option_b) !="")
    <div class="col-md-12">
        <p><strong>B)</strong> {!! $question->option_b ?? "" !!}</p>
    </div>
    @endif
    @if(strip_tags($question->option_c) !="")
    <div class="col-md-12">
        <p><strong>C)</strong> {!! $question->option_c ?? "" !!}</p>
    </div>
    @endif
    @if(strip_tags($question->option_d) !="")
    <div class="col-md-12">
        <p><strong>D)</strong> {!! $question->option_d ?? "" !!}</p>
    </div>
    @endif
    @if(strip_tags($question->option_e) !="")
    <div class="col-md-12">
        <p><strong>E)</strong> {!! $question->option_e ?? "" !!}</p>
    </div>
    @endif
    @if(strip_tags($question->answer) !="")
    <div class="col-md-12">
        <p><strong>Answer: </strong> {!! $question->answer ?? "" !!}</p>
    </div>
    @endif
    @if(strip_tags($question->answer_format) !="")
    <div class="col-md-12">
        <p><strong>Answer Format: </strong> {!! strip_tags($question->answer_format) ?? "" !!}</p>
    </div>
    @endif
@endif