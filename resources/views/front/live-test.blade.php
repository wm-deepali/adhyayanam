<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $test->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script>

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            background: #f4f6fb;
        }

        /* HEADER */

        header {
            background: linear-gradient(90deg, #1e2a55, #283b8a);
            color: white;
            padding: 15px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        }

        .time-box {
            background: rgba(255, 255, 255, 0.15);
            padding: 8px 14px;
            border-radius: 6px;
            font-weight: 600;
        }


        /* MAIN LAYOUT */

        .main-wrapper {
            display: flex;
            gap: 20px;
            padding: 20px;
        }

        .left-panel {
            width: 70%;
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        .right-panel {
            width: 30%;
        }


        /* QUESTION */

        .question-header {
            background: #eef2ff;
            padding: 12px 16px;
            border-radius: 8px;
            font-weight: 600;
            margin-bottom: 15px;
            border-left: 5px solid #4a6fff;
        }

        .question-block {
            background: white;
            padding: 10px;
            margin-bottom: 10px;
        }

        #question-text {
            font-size: 17px;
            font-weight: 600;
            line-height: 1.6;
            margin-bottom: 15px;
        }


        /* OPTION CARD STYLE */

        .options {
            display: block;
            border: 1px solid #dcdcdc;
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: 0.3s;
            background: white;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .options:hover {
            border-color: #4a6fff;
            background: #f5f8ff;
            transform: translateY(-1px);
        }

        .options input {
            margin-right: 10px;
        }

        .options input:checked+span {
            font-weight: 600;
        }


        /* BUTTONS */

        .btn-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .action-btn {
            background: #4a6fff;
            color: white;
            border: none;
            font-size: 18px;
            padding: 10px 18px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
        }

        .clear-btn {
            background: #ff4b4b;
            color: white;
            border: none;
            font-size: 18px;
            padding: 10px 18px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
        }

        .action-btn:hover {
            background: #314dcf;
        }

        .clear-btn:hover {
            background: #d73535;
        }


        /* RIGHT PANEL */

        .right-panel-card {
            background: linear-gradient(135deg, #ffffff, #f7f8ff);
            border-radius: 14px;
            padding: 18px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        .right-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
            text-align: center;
            color: #2a335a;
        }


        /* COUNT BOX */

        .count-box {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .count-box div {
            background: white;
            padding: 8px;
            border-radius: 6px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }


        /* QUESTION GRID */

        .question-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 6px;
            margin-top: 10px;
        }

        .question-grid button {
            border: none;
            padding: 8px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
        }

        .notVisited {
            background: #d9dce6;
        }

        .visited {
            background: #ffc857;
        }

        .answered {
            background: #41c96d;
            color: white;
        }

        .question-grid button:hover {
            transform: scale(1.05);
        }


        /* SUBMIT BUTTON */

        .submit-btn {
            width: 100%;
            margin-top: 15px;
            padding: 12px;
            background: #12b76a;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background: #0e9f5a;
        }


        /* SUBJECTIVE WRAPPER */

        .subjective-wrapper {
            margin-top: 20px;
        }


        /* LABEL */

        .sub-label {
            display: block;
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }


        /* TEXTAREA */

        .sub-textarea {
            width: 100%;
            min-height: 140px;
            border: 1px solid #dcdcdc;
            border-radius: 8px;
            padding: 12px;
            font-size: 14px;
            resize: vertical;
            outline: none;
            transition: 0.3s;
        }

        .sub-textarea:focus {
            border-color: #4a6fff;
            box-shadow: 0 0 5px rgba(74, 111, 255, 0.3);
        }


        /* UPLOAD BOX */

        .upload-box {
            background: #f7f9ff;
            border: 1px dashed #cfd7ff;
            padding: 12px;
            border-radius: 8px;
        }


        /* INPUT */

        .upload-input {
            margin-top: 5px;
        }


        /* NOTE */

        .upload-note {
            font-size: 12px;
            color: #777;
            margin-top: 5px;
        }



        @media (max-width: 768px) {
            .right-panel-card {
                display: none;
            }

            .left-panel {
                width: 100%;
                background: white;
                border-radius: 12px;
                padding: 15px;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            }

            .main-wrapper {
                display: flex;
                flex-direction: column;
                gap: 20px;
                padding: 20px;
            }

            .action-btn {
                background: #4a6fff;
                color: white;
                border: none;
                font-size: 14px;
                padding: 5px 14px;
                border-radius: 6px;
                cursor: pointer;
                font-weight: 600;
            }

            .clear-btn {
                background: #ff4b4b;
                color: white;
                border: none;
                font-size: 14px;
                padding: 5px 14px;
                border-radius: 6px;
                cursor: pointer;
                font-weight: 600;
            }

            .question-header {
                background: #eef2ff;
                padding: 8px 8px;
                border-radius: 8px;
                font-weight: 600;
                margin-bottom: 0px;
                border-left: 5px solid #4a6fff;
            }

            .mobile-t {
                display: none;
            }

            .question-header div {
                flex-direction: column !important;
                gap: 10px !important;
            }

        }
    </style>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- ✅ ADD HERE -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

    <header>
        <div class="mobile-t">{{ $test->name }}</div>
        <div class="time-box">Time Left: <span id="time"></span></div>
        <div class="togolmenu" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
            aria-controls="offcanvasExample"> View More</div>
    </header>

    <div class="main-wrapper">

        <!-- LEFT PANEL -->
        <div class="left-panel">

            <input type="hidden" id="test_id" value="{{ $test->id }}">
            <input type="hidden" id="student_id" value="{{ auth()->id() }}">
            <input type="hidden" id="duration" value="{{ $test->duration }}">
            <input type="hidden" id="remaining_time">
            <input type="hidden" id="attempt_id" value="{{ $attempt_id }}">
            <input type="hidden" id="questionIndex" value="0">
            <input type="hidden" id="questionIds" value="{{ json_encode($question_id_list) }}">
            <input type="hidden" id="answeredIds" value="{{ json_encode($answered_ids) }}">

            <div class="question-header">
                <div style="display:flex; justify-content:space-between;">
                    <span id="qNo"></span>

                    <span id="qMeta" style="font-size:13px;color:#111;">
                        <!-- Dynamic -->
                    </span>
                </div>
            </div>

            <div class="question-block">
                <div id="question-text"></div>
                <form id="answer-form" style="margin-top:10px">@csrf</form>
            </div>

            <div class="btn-footer">
                <button id="prevBtn" class="action-btn">⟵ Previous</button>
                <button id="clearBtn" class="clear-btn">Clear</button>
                <button id="saveNextBtn" class="action-btn">Save & Next ⟶</button>
            </div>

        </div>

        <!-- RIGHT PANEL -->
        <div class="right-panel">
            <!--<div class="right-title">{{ auth()->user()->name }}</div>-->

            <div class="right-panel-card">

                <div class="count-box">

                    <div>
                        <b class="ansCount">{{ $answered_count }}</b><br>
                        Answered
                    </div>

                    <div>
                        <b class="notAnsCount">{{ $pending_count }}</b><br>
                        Not Answered
                    </div>

                    <div>
                        <b class="visitCount">0</b><br>
                        Visited
                    </div>

                    <div>
                        <b class="notVisitCount">0</b><br>
                        Not Visited
                    </div>

                </div>



                <hr>

                <div style="font-weight:600;margin-bottom:5px;">Question Navigator</div>

                <div class="question-grid btnGrid"></div>

                <button class="submitTestBtn submit-btn">Submit Test</button>
            </div>


            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample"
                aria-labelledby="offcanvasExampleLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasExampleLabel">Offcanvas</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div class="count-box">

                        <div>
                            <b class="ansCount">{{ $answered_count }}</b><br>
                            Answered
                        </div>

                        <div>
                            <b class="notAnsCount">{{ $pending_count }}</b><br>
                            Not Answered
                        </div>

                        <div>
                            <b class="visitCount">0</b><br>
                            Visited
                        </div>

                        <div>
                            <b class="notVisitCount">0</b><br>
                            Not Visited
                        </div>

                    </div>



                    <hr>

                    <div style="font-weight:600;margin-bottom:5px;">Question Navigator</div>

                    <div class="question-grid btnGrid"></div>

                    <button class="submitTestBtn submit-btn">Submit Test</button>
                </div>
            </div>
        </div>

    </div>

    <script>

        let answers = [];
        let states = [];
        const questionIds = JSON.parse(document.getElementById('questionIds').value);
        const totalQuestions = questionIds.length;

        // Initial States
        states = questionIds.map(() => ({ visited: false, answered: false }));

        let answeredIds = JSON.parse(document.getElementById('answeredIds').value);

        // initialize states based on answered from DB
        states = questionIds.map(qid => ({
            visited: answeredIds.includes(qid),
            answered: answeredIds.includes(qid)
        }));

        // Render Grid
        questionIds.forEach((qid, i) => {
            let btnClass = "notVisited";

            if (answeredIds.includes(qid)) btnClass = "answered";

            $(".btnGrid").append(`<button onclick="goTo(${i})" class="${btnClass}">${i + 1}</button>`);
        });


        // Load first question
        loadQuestion(0);

        //========================== FETCH QUESTION ==========================
        function loadQuestion(index) {

            const qid = questionIds[index];

            $.post("{{ url('/fetch-question') }}", {
                question_id: qid,
                attempt_id: $("#attempt_id").val(),
                test_id: $("#test_id").val(),
                _token: "{{ csrf_token() }}"
            }, function (res) {
                if (res.success) {
                    renderQuestion(res.question, {
                        main: res.main_marks,
                        child: res.child_marks
                    }, index);
                    restoreSavedAnswers(res.saved_main_answer, res.saved_child_answers);


                }
            });

        }

        function restoreSavedAnswers(main, children) {

            const form = $("#answer-form");

            let index = parseInt($("#questionIndex").val());
            let updated = false;

            // MAIN ANSWER RESTORE
            if (main) {

                if (main.answer_key) {
                    form.find(`input[data-key="${main.answer_key}"]`).prop("checked", true);
                    updated = true;
                }

                if (main.answer_text) {
                    form.find("textarea[name='answer_text']").val(main.answer_text);
                    updated = true;
                }

                if (main.answer_file) {
                    // append file view link
                    form.append(`
        <div style="margin-top:8px;">
            <a href="/storage/student_attempts/${main.answer_file}" target="_blank"
                style="color:#007bff;text-decoration:underline;font-size:14px;">
                View Previously Uploaded File
            </a>
        </div>
    `);

                    updated = true;
                }

            }

            // CHILD ANSWERS RESTORE
            if (children && Object.keys(children).length > 0) {

                Object.keys(children).forEach(childId => {

                    let child = children[childId];

                    if (child.answer_key) {
                        form.find(`input[name='child_${childId}'][data-key="${child.answer_key}"]`)
                            .prop("checked", true);
                        updated = true;
                    }

                    if (child.answer_text) {
                        form.find(`textarea[name='child_${childId}']`).val(child.answer_text);
                        updated = true;
                    }

                    if (child.answer_file) {
                        let selector = form.find(`[name='child_${childId}']`).parent();

                        form.append(`
        <div style="margin-top:6px;">
            <a href="/storage/student_attempts/${child.answer_file}" target="_blank"
                style="color:#007bff;text-decoration:underline;font-size:14px;">
                View Uploaded File
            </a>
        </div>
    `);

                        updated = true;
                    }


                });
            }

            // UPDATE STATE BACK
            if (updated) {
                states[index].answered = true;
                updatePanel();
            }
        }


        //========================== RENDER QUESTION ==========================
        function renderQuestion(q, marks, index) {

            $("#questionIndex").val(index);
            $("#qNo").text("Question " + (index + 1));
            let type = q.question_type;

            let positive = marks?.main?.positive_mark ?? 0;
            let negative = marks?.main?.negative_mark ?? 0;


            $("#qMeta").html(`
   Type: <b>${type}</b> &nbsp;&nbsp;
   Marks: <b>${positive}</b> &nbsp;&nbsp;
   Negative: <b>${negative}</b>
`);

            $("#question-text").html(q.question);

            const form = $("#answer-form");
            form.html("");

            form.append(`<input type="hidden" name="qid" value="${q.id}">`);

            // MCQ
            if (q.question_type === "MCQ") {
                loadMCQ(form, q);
            }

            // Subjective
            if (q.question_type === "Subjective") {
                loadSubjective(form, q);
            }

            // Story Based
            if (q.question_type === "Story Based") {
                loadStory(form, q, marks.child);
            }

            restoreAnswer(q.id);

            states[index].visited = true;
            updatePanel();
        }

        //===================== UI MCQ Loader =====================
        function loadMCQ(form, q) {

            let keyMap = {
                option_a: "A",
                option_b: "B",
                option_c: "C",
                option_d: "D",
                option_e: "E"
            };

            ["option_a", "option_b", "option_c", "option_d", "option_e"].forEach(o => {

                if (q[o]) {
                    let key = keyMap[o];
                    let opt = strip(q[o]);

                    form.append(`
                <label class="options">

<input type="radio" name="mcq" value="${opt}" data-key="${key}">

<span>${key}. ${opt}</span>

</label>

            `);
                }

            });
        }


        //===================== SUBJECTIVE UI ======================
        // function loadSubjective(form, q) {

        //     switch (q.answer_format) {

        //         case "text input":
        //             form.append(`
        //         <textarea name="answer_text" placeholder="Type your answer here..."></textarea>
        //     `);
        //             break;

        //         case "audio":
        //             form.append(`
        //         <label style="font-size:14px;font-weight:600;">Upload Audio</label>
        //         <input type="file" name="answer_file" accept="audio/*">
        //         <small style="color:#777">Allowed: mp3, wav</small>
        //     `);
        //             break;

        //         case "video":
        //             form.append(`
        //         <label style="font-size:14px;font-weight:600;">Upload Video</label>
        //         <input type="file" name="answer_file" accept="video/*">
        //         <small style="color:#777">Allowed: mp4, mov</small>
        //     `);
        //             break;

        //         case "image":
        //             form.append(`
        //         <label style="font-size:14px;font-weight:600;">Upload Image</label>
        //         <input type="file" name="answer_file" accept="image/*">
        //         <small style="color:#777">Allowed: jpg, png, jpeg</small>
        //     `);
        //             break;

        //         case "document":
        //             form.append(`
        //         <label style="font-size:14px;font-weight:600;">Upload Document</label>
        //         <input type="file" name="answer_file" accept=".pdf,.doc,.docx">
        //         <small style="color:#777">Allowed: PDF, DOC, DOCX</small>
        //     `);
        //             break;
        //     }

        // }

        function loadSubjective(form, q) {

            let html = `<div class="subjective-wrapper">`;

            switch (q.answer_format) {

                case "text input":
                    html += `
                <label class="sub-label">Write Your Answer</label>

                <textarea 
                    name="answer_text"
                    class="sub-textarea"
                    placeholder="Type your answer here..."
                ></textarea>
            `;
                    break;


                case "audio":
                    html += `
                <label class="sub-label">Upload Audio Answer</label>

                <div class="upload-box">

                    <input 
                        type="file" 
                        name="answer_file" 
                        accept="audio/*"
                        class="upload-input"
                    >

                    <div class="upload-note">
                        Allowed: mp3, wav
                    </div>

                </div>
            `;
                    break;


                case "video":
                    html += `
                <label class="sub-label">Upload Video Answer</label>

                <div class="upload-box">

                    <input 
                        type="file" 
                        name="answer_file" 
                        accept="video/*"
                        class="upload-input"
                    >

                    <div class="upload-note">
                        Allowed: mp4, mov
                    </div>

                </div>
            `;
                    break;


                case "image":
                    html += `
                <label class="sub-label">Upload Image Answer</label>

                <div class="upload-box">

                    <input 
                        type="file" 
                        name="answer_file" 
                        accept="image/*"
                        class="upload-input"
                    >

                    <div class="upload-note">
                        Allowed: jpg, png, jpeg
                    </div>

                </div>
            `;
                    break;


                case "document":
                    html += `
                <label class="sub-label">Upload Document</label>

                <div class="upload-box">

                    <input 
                        type="file" 
                        name="answer_file" 
                        accept=".pdf,.doc,.docx"
                        class="upload-input"
                    >

                    <div class="upload-note">
                        Allowed: PDF, DOC, DOCX
                    </div>

                </div>
            `;
                    break;
            }

            html += `</div>`;

            form.append(html);

        }


        //===================== STORY QUESTIONS ======================
        function loadStory(form, q, childMarks) {

            q.question_deatils.forEach(child => {

                let childDetails = childMarks[child.id] ?? null;

                let pos = childDetails?.positive_mark ?? 0;
                let neg = childDetails?.negative_mark ?? 0;

                form.append(`
            <div style="padding:8px;border:1px solid #eee;border-radius:6px;margin-bottom:10px;">
                <p style="margin-bottom:5px;font-weight:600">${child.question}</p>

                <small style="background:#dff3ff;padding:4px 8px;
                    border-radius:4px;margin-bottom:6px;display:inline-block;">
                    Marks +${pos} | -${neg}
                </small>
        `);

                if (child.answer_format === null) {

                    let keyMap = {
                        option_a: "A",
                        option_b: "B",
                        option_c: "C",
                        option_d: "D",
                        option_e: "E"
                    };

                    ["option_a", "option_b", "option_c", "option_d", "option_e"].forEach(o => {

                        if (child[o]) {
                            let key = keyMap[o];
                            let opt = strip(child[o]);

                            form.append(`
                <label class="options">
                    <input type="radio" name="child_${child.id}" value="${opt}" data-key="${key}">
                    ${key}. ${opt}
                </label>
            `);
                        }

                    });

                }
                else {
                    switch (child.answer_format) {
                        case "text input":
                            form.append(`
                        <textarea name="child_${child.id}" placeholder="Type your answer"></textarea>
                    `);
                            break;

                        case "audio":
                            form.append(`
                        <input type="file" name="child_${child.id}" accept="audio/*">
                    `);
                            break;

                        case "video":
                            form.append(`
                        <input type="file" name="child_${child.id}" accept="video/*">
                    `);
                            break;

                        case "image":
                            form.append(`
                        <input type="file" name="child_${child.id}" accept="image/*">
                    `);
                            break;

                        case "document":
                            form.append(`
                        <input type="file" name="child_${child.id}" accept=".pdf,.doc,.docx">
                    `);
                            break;
                    }
                }

                form.append("</div>");
            });
        }

        function strip(html) {
            return $("<div>").html(html).text();
        }

        //===================== SAVE ANSWER ======================
        function saveAnswer(callback = null) {

            let index = parseInt($("#questionIndex").val());
            let qid = questionIds[index];
            let form = $("#answer-form");

            // Prepare object to store state
            let obj = {
                id: qid,
                test_id: $("#test_id").val(),
                children: []
            };

            let updated = false;

            // ---- Main MCQ Answer ----
            let selected = form.find("input[name='mcq']:checked");
            if (selected.length) {
                obj.answer_text = selected.val();
                obj.answer_key = selected.attr("data-key"); // A/B...
                updated = true;
            }

            // ---- Subjective text ----
            let text = form.find("textarea[name='answer_text']").val();
            if (text && text.trim() !== '') {
                obj.answer_text = text;
                obj.answer_key = null;
                updated = true;
            }

            // ---- For file answer ----
            let fileInput = form.find("input[name='answer_file']")[0];
            let fileObject = null;
            if (fileInput && fileInput.files.length > 0) {
                fileObject = fileInput.files[0];
                updated = true;
            }

            // ---- CHILD ANSWERS ---- Story Based ----
            form.find("input,textarea").each(function () {
                console.log('here')

                let nm = $(this).attr("name");

                if (!nm || !nm.startsWith("child_")) return;

                let childId = nm.replace("child_", "");

                // If already exists in array skip
                let existing = obj.children.find(x => x.child_id == childId);
                if (!existing) {
                    obj.children.push({
                        child_id: childId,
                        answer_text: null,
                        answer_key: null,
                        answer_file: null
                    });
                }

                let childObj = obj.children.find(x => x.child_id == childId);

                // MCQ child
                if ($(this).attr("type") === "radio" && $(this).is(":checked")) {
                    childObj.answer_text = $(this).val();
                    childObj.answer_key = $(this).data("key") ?? null;
                    updated = true;
                }

                // TEXTAREA child
                if ($(this).is("textarea") && $(this).val().trim() !== '') {
                    childObj.answer_text = $(this).val();
                    updated = true;
                }

                // FILE child
                let f = this.files?.[0];
                if (f) {
                    childObj.answer_file = f;
                    updated = true;
                }

            });


            if (!updated) {
                if (callback) callback();
                return;
            }

            // Store in UI memory
            answers = answers.filter(a => a.id !== qid);
            answers.push(obj);

            states[index].answered = true;
            updatePanel();

            // ---- SEND TO BACKEND USING FORM DATA ----
            let formData = new FormData();
            formData.append("_token", "{{ csrf_token() }}");
            formData.append("attempt_id", $("#attempt_id").val());
            formData.append("student_id", $("#student_id").val());
            formData.append("test_id", obj.test_id);
            formData.append("question_id", obj.id);

            if (obj.answer_text) formData.append("answer_text", obj.answer_text);
            if (obj.answer_key) formData.append("answer_key", obj.answer_key);

            if (fileObject) formData.append("answer_file", fileObject);
            console.log('here', obj.children.length)

            let childDataPayload = [];

            obj.children.forEach((c, i) => {
                childDataPayload.push({
                    child_id: c.child_id,
                    answer_text: c.answer_text,
                    answer_key: c.answer_key,
                });

                if (c.answer_file) {
                    formData.append(`child_files[${i}]`, c.answer_file);
                    formData.append(`child_file_ids[${i}]`, c.child_id);
                }
            });

            formData.append("child_answers", JSON.stringify(childDataPayload));

            $.ajax({
                url: "{{ url('/save-answer') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    if (callback) callback();
                }
            });

        }

        //===================== RESTORE ANSWER ======================
        function restoreAnswer(qid) {

            let rec = answers.find(a => a.id == qid);
            if (!rec) return;

            const form = $("#answer-form");

            if (rec.answer) {
                form.find(`input[value='${rec.answer}']`).prop("checked", true);
                form.find("textarea[name='answer_text']").val(rec.answer);
            }

            if (rec.children) {
                rec.children.forEach(c => {
                    form.find(`textarea[name='child_${c.child_id}']`).val(c.answer);
                    form.find(`input[name='child_${c.child_id}'][value='${c.answer}']`).prop("checked", true);
                });
            }
        }

        //===================== PANEL UPDATION ======================
        function updatePanel() {

            let answered = states.filter(s => s.answered).length;
            let visited = states.filter(s => s.visited).length;
            let notVisited = totalQuestions - visited;
            let notAnswered = visited - answered;

            $(".ansCount").text(answered);
            $(".visitCount").text(visited);
            $(".notVisitCount").text(notVisited);
            $(".notAnsCount").text(notAnswered);

            $(".btnGrid").each(function () {

                $(this).find("button").each(function (i) {

                    $(this).removeClass();

                    if (!states[i]) return; // ✅ prevent crash

                    if (states[i].answered) $(this).addClass("answered");
                    else if (states[i].visited) $(this).addClass("visited");
                    else $(this).addClass("notVisited");

                });

            });
        }


        //===================== BUTTON ACTIONS ======================
        function goTo(index) {
            saveAnswer(() => loadQuestion(index));
        }


        $("#saveNextBtn").click(() => {

            let cur = parseInt($("#questionIndex").val());

            // ✅ LAST QUESTION
            if (cur === questionIds.length - 1) {

                saveAnswer(() => {

                    Swal.fire({
                        title: "Submit Test?",
                        text: "You are on last question. Do you want to submit?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Yes, Submit",
                        cancelButtonText: "Review Again"
                    }).then((result) => {

                        if (result.isConfirmed) {

                            $.post("{{ url('/finalize-test') }}", {
                                attempt_id: $("#attempt_id").val(),
                                remaining_time: timeLeft,
                                _token: "{{ csrf_token() }}"
                            }, function (res) {

                                if (res.success) {
                                    window.location.href = "{{ url('/test-result') }}/" + res.result_id;
                                } else {
                                    alert("Error submitting test: " + res.message);
                                }

                            });

                        }

                    });

                });

            } else {
                goTo(cur + 1);
            }

        });

        $("#prevBtn").click(() => {
            let cur = parseInt($("#questionIndex").val());
            goTo(cur - 1);
        });

        $("#clearBtn").click(() => {
            let index = parseInt($("#questionIndex").val());
            let qid = questionIds[index];

            $.post("{{ url('/clear-answer') }}", {
                attempt_id: $("#attempt_id").val(),
                question_id: qid,
                _token: "{{ csrf_token() }}"
            }, function () {
                answers = answers.filter(a => a.id !== qid);
                states[index].answered = false;
                loadQuestion(index);
                updatePanel();
            });
        });


        //===================== TIMER ======================
        //===================== TIMER ======================
        let timeLeft = parseInt($("#duration").val()) * 60;

        let timer = setInterval(() => {

            timeLeft--;

            let m = Math.floor(timeLeft / 60);
            let s = timeLeft % 60;

            $("#time").text(m + ":" + (s < 10 ? "0" + s : s));

            if (timeLeft <= 0) {
                clearInterval(timer);

                // auto call without alert
                autoSubmitTest();
            }

        }, 1000);


        function autoSubmitTest() {

            saveAnswer(() => {

                $.post("{{ url('/finalize-test') }}", {
                    attempt_id: $("#attempt_id").val(),
                    remaining_time: 0,
                    _token: "{{ csrf_token() }}"
                },
                    function (res) {

                        if (res.success) {
                            window.location.href = "{{ url('/test-result') }}/" + res.result_id;
                        } else {
                            alert("An error occurred! Could not auto submit test.");
                        }

                    });

            });

        }

        //===================== FINAL SUBMIT ======================
        $(document).on("click", ".submitTestBtn", function () {

            saveAnswer(() => {

                $.post("{{ url('/finalize-test') }}", {
                    attempt_id: $("#attempt_id").val(),
                    remaining_time: timeLeft,
                    _token: "{{ csrf_token() }}"
                }, function (res) {

                    if (res.success) {
                        alert("Test Submitted Successfully!");

                        window.location.href = "{{ url('/test-result') }}/" + res.result_id;
                    } else {
                        alert("Error submitting test: " + res.message);
                    }

                });

            });

        });


        function findMarks(qid) {
            try {
                let details = {!! json_encode(json_decode($test->question_marks_details, true) ?? []) !!};
                return details.find(x => x.question_id == qid);
            } catch (e) {
                return null;
            }
        }


    </script>

</body>

</html>