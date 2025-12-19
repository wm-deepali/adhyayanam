@extends('layouts.app')

@section('title')
    Question Bank | Create
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="col">
                        <h5 class="card-title">Create</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Create Question section here.</h6>
                    </div>
                    <div class="justify-content-end">
                        <a href='{{route('question.bank.create')}}' class="btn btn-primary">&#43; Add</a>
                    </div>
                </div>
                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>

                <form id="form-question" action="{{ route('question.bank.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div id="questions-container">
                        <div class="question-block">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Select Language</label>
                                        <select class="form-control" name="language">
                                            <option value="1">Hindi</option>
                                            <option value="2">English</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Question Type</label>
                                        <select id="question-type" class="form-control" name="question_type" required>
                                            <option selected value="MCQ">MCQ</option>
                                            <option value="Subjective">Subjective</option>
                                            <option value="Story Based">Story Based</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Fee Type</label>
                                        <select id="fee-type" class="form-control" name="fee_type">
                                            <option value="Free">Free</option>
                                            <option value="Paid">Paid</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Question Category</label>
                                        <select id="question-category" class="form-control" name="question_category">
                                            <option value="0">Normal</option>
                                            <option value="1">Previous Year</option>
                                            <option value="2">Current Affair</option>
                                        </select>
                                    </div>
                                    <div class="form-group previous-year-group" id="previous-year" style="display: none;">
                                        <label>Previous Year</label>
                                        <input type="number" class="form-control" name="previous_year"
                                            placeholder="Ex. 2014">
                                    </div>
                                    <div class="form-group">
                                        <label>Select Examination Commission</label>
                                        <select class="form-control" name="commission_id" id="exam_com_id">
                                            <option value="">--Select--</option>
                                            @foreach($commissions as $commission)
                                                <option value="{{ $commission->id }}">{{ $commission->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Select Category</label>
                                        <select class="form-control" name="category_id" id="category_id">
                                            <option value="">--Select--</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group sub-cat hidecls">
                                        <label>Sub Category</label>
                                        <select class="form-control" name="sub_category_id" id="sub_category_id">
                                            <option value="">--Select--</option>

                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Select Subject</label>
                                        <select class="form-control" name="subject_id" id="subject_id">
                                            <option value="">--Select--</option>

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Select Chapter</label>
                                        <select class="form-control" name="chapter_id" id="chapter_id">
                                            <option value="">--Select--</option>

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Select Topic</label>
                                        <select class="form-control" name="topic" id="topic_id">
                                            <option value="">--Select--</option>

                                        </select>
                                    </div>
                                    <div class="form-check mt-2">
                                        <input id="has_instruction" type="checkbox" class="form-check-input has-instruction"
                                            name="has_instruction" onchange="toggleInstruction(this)">
                                        <label for="has_instruction">Has an Instruction</label>
                                    </div>
                                    <div class="form-group instruction-group" style="display: none;">
                                        <textarea class="form-control quill-editor ckeditor" name="instruction"
                                            id="instruction"></textarea>
                                        <label>Instruction</label>
                                    </div>
                                    <div class="form-group mt-2">
                                        <input type="checkbox" class="form-check-input has-option-e" name="has_option_e"
                                            onchange="toggleOptionE(this)">
                                        <label>Has option E</label>
                                    </div>
                                    <div class="form-group mt-2">
                                        <input type="checkbox" class="form-check-input has-solution" name="has_solution"
                                            onchange="toggleSolution(this)">
                                        <label>Has Solution</label>
                                    </div>
                                    <div class="form-group mt-2">
                                        <input type="checkbox" class="form-check-input" name="show_on_pyq" value="yes">
                                        <label for="show_on_pyq">Show on PYQ</label>
                                    </div>
                                </div>
                                <div class="col-md-6" id="mcq_question_form">
                                    <div class="question-count" class="form-group">
                                        <h4>Question 1</h4>
                                    </div>
                                    <div class="form-group">
                                        <label>Enter Question</label>
                                        <textarea class="form-control ckeditor quesckeditor" name="question[]"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Answer</label>
                                        <input type="text" class="form-control" name="answer[]" placeholder="Ex. a">
                                    </div>
                                    <div class="form-group">
                                        <label>Option A</label>
                                        <textarea class="form-control quill-editor2 ckeditor" name="option_a[]"
                                            id="option_a_1"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Option B</label>
                                        <textarea class="form-control quill-editor3 ckeditor" name="option_b[]"
                                            id="option_b_1"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Option C</label>
                                        <textarea class="form-control quill-editor4 ckeditor" name="option_c[]"
                                            id="option_c_1"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Option D</label>
                                        <textarea class="form-control quill-editor5 ckeditor" name="option_d[]"
                                            id="option_d_1"></textarea>
                                    </div>
                                    <div class="form-group option-e-group" style="display: none;">
                                        <label>Option E</label>
                                        <textarea class="form-control quill-editor6 ckeditor" name="option_e[]"
                                            id="option_e_1"></textarea>
                                    </div>
                                    <div class="form-group solution-group" style="display: none;">
                                        <label>Solution</label>
                                        <textarea class="form-control ckeditor" name="solution[]"
                                            id="mcq_solution_1"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6" id="subjective_question_form" style="display:none;">
                                    <div class="question-count" class="form-group">
                                        <h4>Question 1</h4>
                                    </div>
                                    <div class="form-group">
                                        <label>Enter Question</label>
                                        <textarea class="form-control ckeditor quesckeditor" name="question[]"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Answer Type</label>
                                        <select class="form-control" name="answer_format[]">
                                            <!-- <option value="">Select</option> -->
                                            <option value="text input" selected>Text Input</option>
                                            <option value="audio">Audio</option>
                                            <option value="video">Video</option>
                                            <option value="image">Image</option>
                                            <option value="document">Document</option>
                                        </select>
                                    </div>
                                    <div class="form-group solution-group" style="display: none;">
                                        <label>Solution</label>
                                        <textarea class="form-control ckeditor" name="solution[]"
                                            id="subjective_solution_1"></textarea>
                                    </div>

                                </div>
                                <div class="col-md-6" id="story_question_form" style="display:none;">

                                    <h4 class="mb-3">Story / Passage</h4>

                                    {{-- Main Passage --}}
                                    <div class="form-group">
                                        <label>Enter Story / Passage</label>
                                        <textarea class="form-control ckeditor quesckeditor" name="question[]"></textarea>
                                    </div>

                                    <hr>

                                    <h5>Sub Questions</h5>

                                    <div id="story-sub-questions">

                                        {{-- Sub Question Block --}}
                                        <div class="sub-question-block border p-3 mb-3">

                                            <div class="form-group">
                                                <label>Sub Question Type</label>
                                                <select class="form-control sub-question-type" name="sub_question_type[]">
                                                    <option value="mcq">MCQ</option>
                                                    <option value="reasoning">Reasoning / Subjective</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Question</label>
                                                <textarea class="form-control quesckeditor"
                                                    name="sub_question[]"></textarea>
                                            </div>

                                            {{-- MCQ Fields --}}
                                            <div class="mcq-fields">

                                                <div class="form-group">
                                                    <label>Option A</label>
                                                    <textarea class="form-control ckeditor" name="option_a[]"></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label>Option B</label>
                                                    <textarea class="form-control ckeditor" name="option_b[]"></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label>Option C</label>
                                                    <textarea class="form-control ckeditor" name="option_c[]"></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label>Option D</label>
                                                    <textarea class="form-control ckeditor" name="option_d[]"></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label>Correct Answer</label>
                                                    <select class="form-control" name="answer[]">
                                                        <option value="A">Option A</option>
                                                        <option value="B">Option B</option>
                                                        <option value="C">Option C</option>
                                                        <option value="D">Option D</option>
                                                    </select>
                                                </div>

                                            </div>

                                            {{-- Reasoning Fields --}}
                                            <div class="reasoning-fields" style="display:none;">

                                                <div class="form-group">
                                                    <label>Answer Format</label>
                                                    <select class="form-control" name="answer_format[]">
                                                        <!-- <option value="">Select</option> -->
                                                        <option value="text" selected>Text</option>
                                                        <option value="audio">Audio</option>
                                                        <option value="video">Video</option>
                                                        <option value="image">Image</option>
                                                        <option value="document">Document</option>
                                                    </select>
                                                </div>

                                            </div>

                                            {{-- Solution --}}
                                            <div class="form-group solution-group" style="display:none;">
                                                <label>Solution</label>
                                                <textarea class="form-control ckeditor" name="solution[]"></textarea>
                                            </div>

                                            <div class="text-end">
                                                <button type="button" class="btn btn-danger remove-sub-question">
                                                    Remove Sub Question
                                                </button>
                                            </div>

                                        </div>
                                    </div>

                                    <button type="button" id="add-sub-question" class="btn btn-primary mt-2">
                                        + Add Sub Question
                                    </button>

                                </div>

                                <div id="question-clone"></div>
                                <div class="col-md-12 d-flex justify-content-end mt-2" id="add-more-btn-dv">
                                    <button type="button" id="add-more" class="btn btn-secondary mb-3">Add More</button>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mb-3">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>

    <script>
        $(document).ready(function () {
            $(document).on('change', '#exam_com_id', function (event) {
                $('#category_id').html("");
                $('#subject_id').html("");
                $('#chapter_id').html("");
                $('#topic_id').html("");
                let competitive_commission = $(this).val();
                $.ajax({
                    url: `{{ URL::to('fetch-exam-category-by-commission/${competitive_commission}') }}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function (result) {
                        if (result.success) {
                            $('#category_id').html(result.html);
                        } else {
                            toastr.error('error encountered ' + result.msgText);
                        }
                    },
                });
            });

            $(document).on('change', '#category_id', function (event) {
                $('#sub_category_id').html("");
                let exam_category = $(this).val();
                if (exam_category != '') {
                    $.ajax({
                        url: `{{ URL::to('fetch-sub-category-by-exam-category/${exam_category}') }}`,
                        type: 'GET',
                        dataType: 'json',
                        success: function (result) {
                            if (result.success) {
                                if (result.html != '') {
                                    $('#sub_category_id').html(result.html);
                                    $('.sub-cat').removeClass('hidecls');
                                    $('#sub_category_id').attr("required", true);
                                }
                                else {
                                    $('#sub_category_id').val("").trigger('change');
                                    $('.sub-cat').addClass('hidecls');
                                    $('#sub_category_id').attr("required", false);
                                }

                            } else {
                                toastr.error('error encountered ' + result.msgText);
                            }
                        },
                    });
                }
                else {
                    $('#sub_category_id').val("").trigger('change');
                    $('.sub-cat').addClass('hidecls');
                    $('#sub_category_id').attr("required", false);
                }

            });

            $(document).on('change', '#exam_com_id,#category_id,#sub_category_id', function (e) {
                e.preventDefault(e);

                $('#subject_id').val("").trigger('change');
                let competitive_commission = $('#exam_com_id').val();
                let category_id = $('#category_id').val();
                let sub_category_id = $('#sub_category_id').val();
                $.ajax({
                    headers: { "Access-Control-Allow-Origin": "*" },
                    url: `{{ URL::to('fetch-subject-by-subcategory/${sub_category_id}') }}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function (result) {
                        if (result.success) {
                            $('#subject_id').html(result.html);
                        } else {
                            //alert(result.msgText);
                            //toastr.error('error encountered ' + result.msgText);
                        }
                    },
                });
            });

            $(document).on('change', '#subject_id', function (event) {

                $('#chapter_id').val("").trigger('change');
                let subject = $(this).val();
                if (subject != '') {
                    $.ajax({
                        url: `{{ URL::to('fetch-chapter-by-subject/${subject}') }}`,
                        type: 'GET',
                        dataType: 'json',
                        success: function (result) {
                            if (result.success) {
                                if (result.html != '') {
                                    $('#chapter_id').html(result.html);
                                }
                                else {
                                    $('#chapter_id').val("").trigger('change');
                                }

                            } else {
                                toastr.error('error encountered ' + result.msgText);
                            }
                        },
                    });
                }
                else {
                    // $('#sub_category_id').val("").trigger('change');
                    // $('.sub-cat').addClass('hidecls');
                    // $('#sub_category_id').attr("required", false);
                }

            });

            $(document).on('change', '#chapter_id', function (event) {

                $('#topic_id').val("").trigger('change');
                let chapter = $(this).val();
                if (chapter != '') {
                    $.ajax({
                        url: `{{ URL::to('fetch-topic-by-chapter/${chapter}') }}`,
                        type: 'GET',
                        dataType: 'json',
                        success: function (result) {
                            if (result.success) {
                                if (result.html != '') {
                                    $('#topic_id').html(result.html);
                                }
                                else {
                                    $('#topic_id').val("").trigger('change');
                                }

                            } else {
                                toastr.error('error encountered ' + result.msgText);
                            }
                        },
                    });
                }

            });
        });
    </script>

    <script>
        /* =========================================================
           GLOBAL HELPERS
        ========================================================= */

        function setFormInputsEnabled(section, isEnabled) {
            if (!section) return;
            section.querySelectorAll('input, select, textarea, button')
                .forEach(el => el.disabled = !isEnabled);
        }

        function destroyEditorsIn(container) {
            if (!container || typeof CKEDITOR === 'undefined') return;

            container.querySelectorAll('textarea.ckeditor, textarea.quesckeditor')
                .forEach(el => {
                    if (el.id && CKEDITOR.instances[el.id]) {
                        try {
                            CKEDITOR.instances[el.id].updateElement();
                            CKEDITOR.instances[el.id].destroy(true);
                        } catch (e) { }
                    }
                    el.removeAttribute('style');
                    el.removeAttribute('aria-hidden');
                });

            container.querySelectorAll('.cke').forEach(e => e.remove());
        }

        function initEditorsIn(container) {
            if (!container || typeof CKEDITOR === 'undefined') return;

            container.querySelectorAll('textarea').forEach(el => {

                // 🔥 THIS IS THE KEY
                if (!el.classList.contains('ckeditor') &&
                    !el.classList.contains('quesckeditor')) {
                    return;
                }

                if (!el.id) {
                    el.id = 'ckeditor_' + Math.random().toString(36).substr(2, 9);
                }

                if (!CKEDITOR.instances[el.id]) {
                    CKEDITOR.replace(el.id);
                }
            });
        }

        /* =========================================================
           TOGGLES
        ========================================================= */

        function toggleInstruction(chk) {
            chk.closest('.question-block')
                .querySelector('.instruction-group').style.display = chk.checked ? 'block' : 'none';
        }

        function toggleOptionE(chk) {
            chk.closest('.question-block')
                .querySelector('.option-e-group').style.display = chk.checked ? 'block' : 'none';
        }

        function toggleSolution(chk) {
            const block = chk.closest('.question-block');
            block.querySelectorAll('.solution-group').forEach(group => {
                if (chk.checked) {
                    group.style.display = 'block';
                    initEditorsIn(group);
                } else {
                    destroyEditorsIn(group);
                    group.style.display = 'none';
                }
            });
        }

        /* =========================================================
           QUESTION TYPE SWITCH (SINGLE SOURCE OF TRUTH)
        ========================================================= */

        document.getElementById('question-type').addEventListener('change', function () {

            const mcq = document.getElementById('mcq_question_form');
            const sub = document.getElementById('subjective_question_form');
            const story = document.getElementById('story_question_form');
            const addMore = document.getElementById('add-more-btn-dv');

            // Destroy everything first
            destroyEditorsIn(mcq);
            destroyEditorsIn(sub);

            mcq.style.display = 'none';
            sub.style.display = 'none';
            story.style.display = 'none';

            setFormInputsEnabled(mcq, false);
            setFormInputsEnabled(sub, false);
            setFormInputsEnabled(story, false);

            /* ===============================
               MCQ
            =============================== */
            if (this.value === 'MCQ') {
                mcq.style.display = 'block';
                addMore.style.display = 'block';
                setFormInputsEnabled(mcq, true);

                setTimeout(() => {
                    initEditorsIn(mcq);
                }, 0);
            }

            /* ===============================
               SUBJECTIVE
            =============================== */
            if (this.value === 'Subjective') {
                sub.style.display = 'block';
                addMore.style.display = 'block';
                setFormInputsEnabled(sub, true);

                setTimeout(() => {
                    initEditorsIn(sub);
                }, 0);
            }

            /* ===============================
               STORY BASED  ✅ FIX HERE
            =============================== */
            if (this.value === 'Story Based') {
                story.style.display = 'block';
                addMore.style.display = 'none';
                setFormInputsEnabled(story, true);

                // 🔥 CRITICAL: force reflow so browser "sees" elements
                story.offsetHeight;

                // 🔥 INIT AFTER VISIBILITY
                setTimeout(() => {
                    initEditorsIn(story);
                }, 100);
            }



            const chk = document.querySelector('.has-solution');
            if (chk) toggleSolution(chk);
        });

        /* =========================================================
           SUB QUESTION TYPE (MCQ / REASONING)
        ========================================================= */

        document.addEventListener('change', function (e) {
            if (!e.target.classList.contains('sub-question-type')) return;

            const block = e.target.closest('.sub-question-block');
            const isMcq = e.target.value === 'mcq';

            block.querySelector('.mcq-fields').style.display = isMcq ? 'block' : 'none';
            block.querySelector('.reasoning-fields').style.display = isMcq ? 'none' : 'block';

            // 🔥 IMPORTANT FIX
            setTimeout(() => {
                initEditorsIn(block);
            }, 50);

            const chk = block.closest('.question-block').querySelector('.has-solution');
            if (chk) toggleSolution(chk);
        });


        /* =========================================================
           ADD / REMOVE STORY SUB QUESTIONS
        ========================================================= */

        document.getElementById('add-sub-question').addEventListener('click', function () {
            const container = document.getElementById('story-sub-questions');
            const clone = container.children[0].cloneNode(true);

            // 1️⃣ Reset values
            clone.querySelectorAll('textarea, input').forEach(el => el.value = '');
            clone.querySelectorAll('select').forEach(select => {
                select.selectedIndex = 0; // default first option
            });

            // 2️⃣ FORCE DEFAULT SUB QUESTION TYPE = MCQ
            const typeSelect = clone.querySelector('.sub-question-type');
            typeSelect.value = 'mcq';

            // 3️⃣ FORCE VISIBILITY
            clone.querySelector('.mcq-fields').style.display = 'block';
            clone.querySelector('.reasoning-fields').style.display = 'none';

            // 4️⃣ CLEAN OLD CKEDITOR
            clone.querySelectorAll('.cke').forEach(e => e.remove());
            clone.querySelectorAll('textarea').forEach(t => t.removeAttribute('id'));

            container.appendChild(clone);

            // 5️⃣ INIT CKEDITOR AFTER DOM INSERT
            setTimeout(() => {
                initEditorsIn(clone);
            }, 50);
        });


        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-sub-question')) {
                const blocks = document.querySelectorAll('.sub-question-block');
                if (blocks.length > 1) {
                    destroyEditorsIn(e.target.closest('.sub-question-block'));
                    e.target.closest('.sub-question-block').remove();
                }
            }
        });

        /* =========================================================
           ADD MORE QUESTIONS
        ========================================================= */

        let questionIndex = 1;

        document.getElementById('add-more').addEventListener('click', function () {
            questionIndex++;

            const qType = document.getElementById('question-type').value;
            const source =
                qType === 'MCQ' ? document.getElementById('mcq_question_form') :
                    qType === 'Subjective' ? document.getElementById('subjective_question_form') :
                        document.getElementById('story_question_form');

            const clone = source.cloneNode(true);
            clone.classList.add('question-block');

            // Clear values
            clone.querySelectorAll('textarea, input').forEach(el => el.value = '');
            clone.querySelectorAll('.cke').forEach(e => e.remove());
            clone.querySelectorAll('textarea').forEach(t => t.removeAttribute('id'));

            // Update question count
            clone.querySelector('.question-count').innerHTML =
                `<h4 class="mt-4">Question ${questionIndex}</h4>`;

            /* ---------- ADD REMOVE BUTTON ---------- */
            const removeDiv = document.createElement('div');
            removeDiv.className = 'col-md-12 d-flex justify-content-end mt-2';

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'btn btn-danger remove-question';
            removeBtn.innerText = 'Remove Question';

            removeBtn.addEventListener('click', function () {
                destroyEditorsIn(clone);
                clone.remove();
                updateQuestionNumbers();
            });

            removeDiv.appendChild(removeBtn);
            clone.appendChild(removeDiv);
            /* -------------------------------------- */

            document.getElementById('question-clone').appendChild(clone);
            initEditorsIn(clone);
        });


        /* =========================================================
           RE-NUMBER QUESTIONS AFTER REMOVE
        ========================================================= */

        function updateQuestionNumbers() {
            const blocks = document.querySelectorAll(
                '#questions-container .question-block, #question-clone .question-block'
            );

            blocks.forEach((block, index) => {
                const count = block.querySelector('.question-count');
                if (count) {
                    count.innerHTML = `<h4 class="mt-4">Question ${index + 1}</h4>`;
                }
            });

            questionIndex = blocks.length;
        }



    </script>


@endsection