<!DOCTYPE html> <html lang="en"> 
        <head> <meta charset="UTF-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>Online Test</title> 
        <style> * { box-sizing: border-box; margin: 0; padding: 0; } 
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; display: flex; justify-content: center; } 
        .container { width: 90%; max-width: 1200px; background-color: white; padding: 20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); margin-top: 70px; } 
        header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; } 
        header h1 { font-size: 18px; flex: 1; } 
        .time-left { font-size: 16px; } 
        .full-screen { padding: 5px 10px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; } 
        main { display: flex; } 
        .question-panel { flex: 2; margin-right: 20px; } 
        .question-panel h2 { font-size: 20px; margin-bottom: 10px; } 
        .question { background-color: #f9f9f9; padding: 15px; border-radius: 5px; margin-bottom: 20px; } 
        .question p { margin-bottom: 10px; } 
        .question form label { display: block; margin-bottom: 10px; } 
        .buttons { display: flex; justify-content: space-between; } 
        .buttons button { padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; } 
        .side-panel { flex: 1; background-color: #a5aeb815; padding: 10px; } 
        .student-info { /* background-color: #f9f9f9; */ padding: 10px; border-radius: 5px; margin-bottom: 20px; } 
        .student-info h3 { font-size: 16px; margin-bottom: 10px; } 
        .question-grid { margin-bottom: 20px; } 
        .section-title { font-size: 16px; margin-bottom: 10px; } 
        .grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 10px; } 
        .grid button { padding: 10px; background-color: gray; color: white; border: none; border-radius: 4px; cursor: pointer; } 
        .grid button.visited { background-color: red; } 
        .grid button.answered { background-color: green; } 
        .action-buttons { display: flex; flex-direction: column; } 
        .action-buttons button { margin-bottom: 10px; padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; } 
        </style> 
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    </head> 
    <body> 
        @php
        $questionData =[];
        foreach($questions as $question)
        {
            $text = strip_tags($question->question);
            $text = str_replace(['"',"'"], "", $text);
            $anskey = 'option_'.strtolower(strip_tags($question->answer));
            $answer = strip_tags($question->$anskey);
            
            if($question->option_e != NULL)
            {
                $options=array(strip_tags($question->option_a),strip_tags($question->option_b),strip_tags($question->option_c),strip_tags($question->option_d),strip_tags($question->option_e));
            }
            else{
                $options=array(strip_tags($question->option_a),strip_tags($question->option_b),strip_tags($question->option_c),strip_tags($question->option_d));
            }
            $questionData[]=array('id'=>$question->id, 'text'=>$text, 'answer'=>$answer, 'options'=>$options);
        }
        $setques = json_encode($questionData);
        
        @endphp
        <div class="container "> 
            <header> 
                <h1>{{$test->name}}</h1> 
                <div class="time-left">Time Left: <span id="time"></span></div> 
                <!-- <button class="full-screen">Switch Full Screen</button> --> 
            </header> 
            <main> 
                <section class="question-panel"> 
                    <h2>{{$test->test_code}}</h2> 
                    <div class="question" id="question-container"> 
                        <input type="hidden" id="test_id" name="test_id" value="{{$test->id }}">
                        <input type="hidden" id="student_id" name="student_id" value="{{auth()->user()->id}}">
                        <input type="hidden" id="total_question" name="total_question" value="{{count($questions)}}">
                        <input type="hidden" id="duration" name="duration" value="{{$test->duration }}">
                        <input type="hidden" id="left_time" name="left_time" value="">
                        <p><strong>Question No. 1</strong></p> 
                        <p id="question-text">{{ strip_tags($questions[0]->question) }}</p><br/> 
                        <form id="answer-form"> 
                            @csrf
                            @php
                            $anskey1 = 'option_'.strtolower($questions[0]->answer);
                            $answer1 = $questions[0]->$anskey1;
                            @endphp
                            <input type="hidden" id="answer" name="answer" value="{{$answer1 }}">
                            <input type="hidden" id="question_id" name="question" value="{{$questions[0]->id }}">
                            <label><input type="radio" name="answer" value="{{ $questions[0]->option_a }}"> {!! $questions[0]->option_a !!}</label> 
                            <label><input type="radio" name="answer" value="{{ $questions[0]->option_b }}"> {!! $questions[0]->option_b !!}</label> 
                            <label><input type="radio" name="answer" value="{{ $questions[0]->option_c }}"> {!! $questions[0]->option_c !!}</label> 
                            <label><input type="radio" name="answer" value="{{ $questions[0]->option_d }}"> {!! $questions[0]->option_d !!}</label> 
                            @if($questions[0]->option_e != NULL)
                            <label><input type="radio" name="answer" value="{{ $questions[0]->option_e }}"> {!! $questions[0]->option_e !!}</label> 
                            @endif
                        </form> 
                    </div> 
                    <div class="buttons"> 
                        <button id="save-next">Save & Next</button> 
                        <button id="clear-response">Clear Response</button> 
                    </div> 
                </section> 
                <aside class="side-panel"> 
                    <div class="student-info"> 
                        <h3>{{auth()->user()->name}}</h3> 
                        <p id="summary">0 Answered | 0 Marked | {{count($questions)}} Not Visited | 0 Marked and answered | 0 Not Answered</p> 
                    </div> 
                    <div class="question-grid"> 
                        <div class="section-title">SECTION : {{$test->test_code}}</div> 
                        <div class="grid" id="question-buttons"> 
                            @for($i=0;$i < count($questions);$i++)
                            <button onclick="navigateToQuestion({{$i}})">{{$i+1}}</button> 
                            @endfor
                        </div> 
                    </div> 
                    <div class="action-buttons"> 
                        <button type="submit" id="actionSub">Submit Test</button>
                    </div> 
                </aside> 
            </main> 
        </div> 
        <script> 
        var storeQuestion=[];
        var attempted;
            let setques = "{{$setques}}";
            setques = JSON.parse(setques.replace(/&quot;/g,'"'));
            
            const questions =setques; //[ { text: "Which of the following best describes rangelands?", options: [ "Urban areas used for industrial purposes.", "Natural or semi-natural ecosystems grazed by livestock or wild animals.", "Regions exclusively used for crop farming.", "Protected forest areas with no human activity." ] }, { text: "What is the capital of France?", options: [ "Berlin", "Madrid", "Paris", "Rome" ] }, { text: "Which planet is known as the Red Planet?", options: [ "Earth", "Mars", "Jupiter", "Saturn" ] }, { text: "Who wrote 'Hamlet'?", options: [ "Charles Dickens", "William Shakespeare", "Leo Tolstoy", "Mark Twain" ] }, { text: "What is the boiling point of water?", options: [ "90°C", "100°C", "110°C", "120°C" ] } ]; 
            let currentQuestionIndex = 0; 
            const questionState = questions.map(() => ({ visited: false, answered: false, })); 
            document.getElementById("save-next").addEventListener("click", () => { saveAnswer(); 
            navigateToQuestion(currentQuestionIndex + 1); }); 
            document.getElementById("clear-response").addEventListener("click", () => { clearResponse(); }); 
            function navigateToQuestion(index) { if (index >= 0 && index < questions.length) { questionState[currentQuestionIndex].visited = true; 
            updateQuestionButtonState(currentQuestionIndex); 
            currentQuestionIndex = index; displayQuestion(index); 
            updateQuestionButtonState(index); } } 
            function displayQuestion(index) { 
                const question = questions[index]; 
                document.querySelector(".question strong").innerText = `Question No. ${index + 1}`; 
                document.getElementById("question-text").innerText = question.text; 
                const form = document.getElementById("answer-form"); 
                form.innerHTML = ""; 
                $("<input>").attr("type", "hidden").attr('value','{{csrf_field()}}').appendTo("#answer-form");
                $("<input>").attr("type", "hidden").attr("id", "question_id").attr("name", "question").attr('value',question.id).appendTo("#answer-form");
                $("<input>").attr("type", "hidden").attr("id", "answer").attr('value',question.answer).appendTo("#answer-form");    
                
                question.options.forEach((option, i) => { 
                    const label = document.createElement("label"); 
                    label.innerHTML = `<input type="radio" name="answer" value="${option}"> ${option}`; form.appendChild(label); form.appendChild(document.createElement("br")); }); updateSummary(); } 
                    function saveAnswer() { const selectedOption = document.querySelector('input[name="answer"]:checked');if (selectedOption) { storeQuestion.push({'id': $('#question_id').val(),'answer': $('#answer').val(),'option': selectedOption.value});questionState[currentQuestionIndex].answered = true; } updateQuestionButtonState(currentQuestionIndex); } 
                    function clearResponse() { document.querySelectorAll('input[name="answer"]').forEach(input => input.checked = false); questionState[currentQuestionIndex].answered = false; updateQuestionButtonState(currentQuestionIndex); } 
                    function updateQuestionButtonState(index) { const button = document.querySelectorAll('.grid button')[index]; if (questionState[index].answered) { button.className = 'answered'; } else if (questionState[index].visited) { button.className = 'visited'; } else { button.className = ''; } updateSummary(); } 
                    function updateSummary() { const summary = questionState.reduce((acc, q) => { if (q.answered) acc.answered++; else if (q.visited) acc.visited++; else acc.notVisited++; return acc; }, { answered: 0, visited: 0, notVisited: 0 }); 
                    document.getElementById("summary").innerText = `${summary.answered} Answered | ${summary.visited} Marked | ${summary.notVisited} Not Visited`; attempted = summary.answered;} // Initialize the first question displayQuestion(currentQuestionIndex); 

                    function tick(time) {
                        let settime = '{{$test->duration}}';
                        setTimeout(() => {
                        const newTime = new Date();
                        const diff = Math.floor((newTime.getTime() - time.getTime()) / 1000);
                        const timeFrom15 = (settime * 60) - diff; 
                        const secs = timeFrom15 % 60;
                        const mins = ((timeFrom15 - secs) / 60);
                        document.getElementById('time').innerText = `${mins}:${secs < 10 ? '0' : ''}${secs}`;
                        $('#left_time').val(mins);
                        if (secs >= 0) {
                        tick(time);
                        } else {
                        document.getElementById('time').innerText = '0:00';
                        finalsubmitform();
                        }
                    }, 1000);
                    }

                    tick(new Date());
                    
                    
                    $("#actionSub").click(function () {
                        console.log(storeQuestion);
                        finalsubmitform()
                    });

                    function finalsubmitform()
                    {
                        var totalQues = $('#total_question').val();
                        var student_id = $('#student_id').val();
                        var test_id = $('#test_id').val();
                        var duration = $('#duration').val();
                        var left_time = $('#left_time').val();
                         
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url:"{{route('submit-test')}}",
                            method:"post",
                            data:{total_question:totalQues, student_id:student_id, test_id:test_id, storeQuestion:storeQuestion,duration:duration,left_time:left_time,attempted:attempted},
                            success: function(result) {
                                if (result.success) {
                                    window.location.href= `{{url('/result')}}/`+result.id
                                }
                                else{
                                    alert(result.message);
                                }
                        }
                        });
                    }
        </script>
    </body> 
</html>