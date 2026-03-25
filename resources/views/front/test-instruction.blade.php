<!DOCTYPE html>
<html>

<head>
    <title>{{ $test->name }} - Instructions</title>

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6fb;
            margin: 0;
        }

        .wrapper {
            max-width: 800px;
            margin: 60px auto;
            background: white;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-bottom: 10px;
        }

        ul {
            line-height: 1.8;
            padding-left: 18px;
        }

        .start-btn {
            margin-top: 25px;
            display: inline-block;
            background: #4a6fff;
            color: white;
            padding: 12px 25px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
        }

        .start-btn:hover {
            background: #324ed0;
        }

        .info-box {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 20px;
        }

        .info-box div {
            background: #f6f8ff;
            padding: 10px;
            border-radius: 6px;
        }
    </style>

</head>

<body>

    <div class="wrapper">

        <h2>{{ $test->name }}</h2>

        <hr>

        <!-- TEST INFO -->

        <div class="info-box">

            <div>
                <b>Total Questions</b><br>
                {{ $total_questions }}
            </div>

            <div>
                <b>Duration</b><br>
                {{ $test->duration }} Minutes
            </div>

            <div>
                <b>Total Marks</b><br>
                {{ $test->total_marks }}
            </div>

            <div>
                <b>Subject</b><br>
                {{ $test->subject->name ?? '-' }}
            </div>

        </div>

        <h3>Instructions</h3>

      @if($continueTest)

    <div style="background:#ffe5e5;color:#b30000;padding:12px;border-radius:6px;margin-bottom:15px;">
        You already have an active test in progress.

        <div style="margin-top:10px;">
            <a href="{{ route('live-test', $continueTest) }}"
               style="display:inline-block;background:#004085;color:#fff;padding:8px 15px;border-radius:5px;text-decoration:none;">
                ▶ Continue Previous Test
            </a>
        </div>
    </div>

@endif

        @if($test->test_instruction)

            {!! $test->test_instruction !!}

        @else

            <ul>

                <li>Read each question carefully before answering.</li>

                <li>Each question may carry positive and negative marks.</li>

                <li>Do not refresh or close the browser during the test.</li>

                <li>Only one test attempt can run at a time.</li>

                <li>The test will automatically submit when time expires.</li>

                <li>Make sure you click <b>Submit Test</b> before leaving.</li>

            </ul>

        @endif


        <div style="text-align:center">

            <a href="{{ route('live-test', base64_encode($test->id)) }}" class="start-btn">
                Start Test
            </a>

        </div>

    </div>

</body>

</html>