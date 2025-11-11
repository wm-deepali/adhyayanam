@extends('layouts.app')

@section('title')
    Test Series | Create
@endsection
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    .question-bank-main-page {
        width: 100%;
        height: auto;
        display: grid;
        grid-template-columns: 1fr 2fr 1fr;
        gap: 10px
    }

    .button-actns-questn {
        text-align: center;
        padding: 107px 0;
    }

    .button-actns-questn i {
        display: block;
        width: 100%;
        padding: 10px;
        color: #fff;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .box-questns ul li {
        padding: 2px 10px;
        border-bottom: 1px dashed #ccc;
    }

    .box-questns {
        border: 1px solid gray;
        border-radius: 10px;
    }

    .box-questns ul {
        padding: 0px;
        list-style: none;
        margin: 0;
        max-height: 300px;
        overflow: auto;
        height: 300px;
    }

    .form-section {
        border: 1px solid #ccc;
        padding: 20px;
        border-radius: 7px;
        /*background-color: #fafafa;*/
    }

    label {
        font-weight: bold;
        margin-bottom: 5px;
    }

    input[type="text"],
    input[type="number"],
    input[type="file"],
    select,
    textarea {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    input[type="checkbox"] {
        margin-right: 10px;
    }

    button {
        padding: 10px 15px;
        background-color: #28a745;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .question-bank {
        width: 100%;
        height: auto;
        display: flex;
        /*grid-template-columns:1fr 1fr 1fr;*/
        flex-direction: row;
        gap: 20px;
        border-top: 1px solid gray;
        margin-top: 30px;
        padding-top: 20px;
    }

    .hidden {
        display: none;
    }

    .right-side-question::-webkit-scrollbar {
        display: none;
    }

    #image-preview {
        width: 100%;
        max-width: 300px;
        height: auto;
    }
</style>

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="col">
                        <h5 class="card-title">Create</h5>
                        <h6 class="card-subtitle mb-2 text-muted"> Create Test Series here.</h6>
                    </div>
                </div>
                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>
                <form id="test-form" method="POST" action="{{ route('test.series.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">

                            <label>Select Language</label>
                            <select class="form-control" name="language" id="language">
                                <option value="1">Hindi</option>
                                <option value="2">English</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Select Examination Commission</label>
                            <select class="form-control" name="exam_com_id" id="exam_com_id">
                                <option value="">--Select--</option>
                                @foreach($commissions as $commission)
                                    <option value="{{ $commission->id }}">{{ $commission->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Select Category</label>
                            <select class="form-control" name="category_id" id="category_id">
                                <option value="">--Select--</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 sub-cat hidecls">
                            <label for="sub_category_id">Sub Category *</label>
                            <select name="sub_category_id" id="sub_category_id">
                            </select>
                            <div class="text-danger validation-err" id="sub_category_id-err"></div>

                        </div>
                        <div class="col-md-6">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="Title" required>
                            <div class="text-danger validation-err" id="title-err"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="title" class="form-label">Slug</label>
                            <input type="text" class="form-control" name="slug" id="slug" placeholder="Slug" required>

                        </div>
                        <div class="col-md-6">
                            <label for="logo" class="form-label">Upload Logo</label>
                            <input type="file" class="form-control" name="logo" id="image" accept="image/*" required>
                            <img id="image-preview" src="#" alt="Your Image" style="display:none;">
                            <div class="text-danger validation-err" id="logo-err"></div>

                        </div>
                        <div class="col-md-6">
                            <label for="fee_type" class="form-label">Fee Type</label>
                            <select class="form-control" name="fee_type" id="fee_type" required>
                                <option value="">Select</option>
                                <option value="free">Free</option>
                                <option value="paid">Paid</option>
                            </select>
                            <div class="text-danger validation-err" id="fee_type-err"></div>

                        </div>

                        <div class="col-md-6" id="mrp-div" style="display:none;">
                            <label for="mrp" class="form-label">MRP:</label>
                            <input type="number" class="form-control" id="mrp" name="mrp" value="0">
                            <div class="text-danger validation-err" id="mrp-err"></div>
                        </div>
                        <div class="col-md-6" id="discount-div" style="display:none;">
                            <label for="discount" class="form-label">Discount (%):</label>
                            <input type="number" class="form-control" id="discount" name="discount" value="0">
                            <div class="text-danger validation-err" id="discount-err"></div>
                        </div>
                        <div class="col-md-6" id="price-div" style="display:none;">
                            <label for="offered-price" class="form-label">Offered Price:</label>
                            <input type="text" class="form-control" id="offered-price" name="price" value="0" readonly>
                            <div class="text-danger validation-err" id="price-err"></div>

                        </div>


                        <div class="col-md-12">
                            <label for="description" class="form-label">Short Description</label>
                            <textarea class="form-control editor" id="short_description"
                                name="short_description"></textarea>
                        </div>
                        <div class="col-md-12">
                            <label for="description" class="form-label">Content</label>
                            <textarea class="form-control editor" id="content" name="description"></textarea>

                        </div>
                    </div>
                    <div class="form-group row question-selection-part master-question-item">
                        <div class="col-sm-12">
                            <div class="tab-pane-generated">
                                <div class="tab-content px-1 pt-1">
                                    <div class="tab-pane mcq-tab active" id="mcq-tab" role="tabpanel"
                                        aria-labelledby="base-mcq">
                                        <div class="customquestiondiv">
                                            <div id="question-rows">
                                                <div class="row question-row">
                                                    <div class="col-md-4">
                                                        <label>Test Type</label>
                                                        <select class="form-control test_type" name="type[]">
                                                            <option value="">Choose...</option>
                                                            <option value="1">Full Test</option>
                                                            <option value="2">Subject Wise</option>
                                                            <option value="3">Chapter Wise</option>
                                                            <option value="4">Topic Wise</option>
                                                            <option value="5">Current Affair</option>
                                                            <option value="6">Previous Year</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="test_generated_by">Test Selections</label>
                                                        <select id="test_generated_by" name="test_generated_by"
                                                            class="form-control test_generated_by">
                                                            <option value="">Choose...</option>
                                                            <option value="manual">Manual</option>
                                                            <option value="random">Random</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="title" class="form-label">No. of Paper</label>
                                                        <input type="text" class="form-control total_paper"
                                                            name="total_paper" placeholder="No. of Paper" required>
                                                    </div>

                                                    <div class="col-md-5">
                                                        <div class="box-area-questions">
                                                            <h4>Your Tests <span id="questioncountmcqshow"></span></h4>
                                                            <div class="box-questns">
                                                                <ul class="selected-questions customquestionselectedbox-mcq"
                                                                    id="customquestionselectedbox-mcq"></ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">

                                                        <div class="button-actns-questn">
                                                            <button class="btn btn-primary addquestiontoselected-mcq"
                                                                type="button" fdprocessedid="49r4zxe"><i
                                                                    class="fa fa-arrow-left"></i></button>
                                                            <i class="fa fa-exchange"></i>
                                                            <button class="btn btn-danger removequestionfromselected-mcq"
                                                                type="button" fdprocessedid="2x8rl7"><i
                                                                    class="fa fa-arrow-right"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="box-area-questions">
                                                            <h4>MCQ Test Papers <span id="questioncountshow"></span></h4>
                                                            <div class="box-questns">
                                                                <ul class="customquestionbox-mcq"
                                                                    id="customquestionbox-mcq">
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-5">
                                                        <div class="box-area-questions">
                                                            <h4>Your Tests <span id="questioncountpassageshow"></span></h4>
                                                            <div class="box-questns">
                                                                <ul class="selected-questions customquestionselectedbox-passage"
                                                                    id="customquestionselectedbox-passage"></ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">

                                                        <div class="button-actns-questn">
                                                            <button class="btn btn-primary addquestiontoselected-passage"
                                                                type="button" fdprocessedid="49r4zxe"><i
                                                                    class="fa fa-arrow-left"></i></button>
                                                            <i class="fa fa-exchange"></i>
                                                            <button
                                                                class="btn btn-danger removequestionfromselected-passage"
                                                                type="button" fdprocessedid="2x8rl7"><i
                                                                    class="fa fa-arrow-right"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="box-area-questions">
                                                            <h4>Passage Test Papers <span id="questioncountshow"></span>
                                                            </h4>
                                                            <div class="box-questns">
                                                                <ul class="customquestionbox-passage"
                                                                    id="customquestionbox-passage">
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-5">
                                                        <div class="box-area-questions">
                                                            <h4>Your Tests <span id="questioncountsubjectiveshow"></span>
                                                            </h4>
                                                            <div class="box-questns">
                                                                <ul class="selected-questions customquestionselectedbox-subjective"
                                                                    id="customquestionselectedbox-subjective"></ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">

                                                        <div class="button-actns-questn">
                                                            <button class="btn btn-primary addquestiontoselected-subjective"
                                                                type="button" fdprocessedid="49r4zxe"><i
                                                                    class="fa fa-arrow-left"></i></button>
                                                            <i class="fa fa-exchange"></i>
                                                            <button
                                                                class="btn btn-danger removequestionfromselected-subjective"
                                                                type="button" fdprocessedid="2x8rl7"><i
                                                                    class="fa fa-arrow-right"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="box-area-questions">
                                                            <h4>Subjective Test Papers <span id="questioncountshow"></span>
                                                            </h4>
                                                            <div class="box-questns">
                                                                <ul class="customquestionbox-subjective"
                                                                    id="customquestionbox-subjective">
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-5">
                                                        <div class="box-area-questions">
                                                            <h4>Your Tests <span id="questioncountcombinedshow"></span></h4>
                                                            <div class="box-questns">
                                                                <ul class="selected-questions customquestionselectedbox-combined"
                                                                    id="customquestionselectedbox-combined"></ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">

                                                        <div class="button-actns-questn">
                                                            <button class="btn btn-primary addquestiontoselected-combined"
                                                                type="button" fdprocessedid="49r4zxe"><i
                                                                    class="fa fa-arrow-left"></i></button>
                                                            <i class="fa fa-exchange"></i>
                                                            <button
                                                                class="btn btn-danger removequestionfromselected-combined"
                                                                type="button" fdprocessedid="2x8rl7"><i
                                                                    class="fa fa-arrow-right"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="box-area-questions">
                                                            <h4>Combined Test Papers <span id="questioncountshow"></span>
                                                            </h4>
                                                            <div class="box-questns">
                                                                <ul class="customquestionbox-combined"
                                                                    id="customquestionbox-combined">
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-12 text-right mt-2">
                                                        <button type="button"
                                                            class="btn btn-danger remove-row">Remove</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3 text-right">
                                                <button type="button" class="btn btn-primary" id="add-row">Add More</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">

                        </div>
                        <div class="col-md-2">
                            <button type="button" id="add-test-btn" class="btn btn-primary">Save</button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('test.series.index') }}" class="btn">Back</a>
                        </div>


                    </div>

                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

    <script>
        $(document).ready(function () {


            function calculateOfferedPrice() {
                var mrp = parseFloat($('#mrp').val());
                var discount = parseFloat($('#discount').val());

                if (isNaN(mrp) || isNaN(discount)) {
                    $('#offered-price').val(mrp);
                    return;
                }

                var offeredPrice = mrp - (mrp * (discount / 100));
                $('#offered-price').val(offeredPrice.toFixed(2));
            }

            $('#mrp, #discount').on('input', calculateOfferedPrice);
        })
        $(document).ready(function () {
            $('.editor').each(function () {
                CKEDITOR.replace(this);
            });
            $(document).on('click', '.question', function (event) {
                if ($(this).is(":checked")) {
                    $(this).parent().parent().parent().addClass('questn-selected');
                } else {
                    $(this).parent().parent().parent().removeClass('questn-selected');
                }
            });
        });

        // ✅ MCQ Section
        $(document).on('click', '.addquestiontoselected-mcq', function (event) {
            const questionRow = $(this).closest('.question-row');
            const selQuestions = questionRow.find('.customquestionbox-mcq li.questn-selected');
            const total = parseInt(questionRow.find(".total_paper").val(), 10);

            if (questionRow.find(".customquestionselectedbox-mcq .question").length + selQuestions.length > total) {
                alert(`You can select a maximum of ${total} questions.`);
                return false;
            }

            let temp = questionRow.find('.customquestionselectedbox-mcq').html();
            let testTemp = '';

            selQuestions.each(function () {
                $(this).removeClass('questn-selected');
                temp += this.outerHTML;
                testTemp += `<li>${$(this).find('span span').text()}</li>`;
                $(this).remove();
            });

            questionRow.find('.customquestionselectedbox-mcq').html(temp);
            questionRow.find('.slide-menu-mcq').append(testTemp);
        });

        $(document).on('click', '.removequestionfromselected-mcq', function (event) {
            const questionRow = $(this).closest('.question-row');
            const selQuestions = questionRow.find('.customquestionselectedbox-mcq li.questn-selected');
            let temp = questionRow.find('.customquestionbox-mcq').html();

            selQuestions.each(function () {
                $(this).removeClass('questn-selected');
                temp += this.outerHTML;
                $(this).remove();
            });

            questionRow.find('.customquestionbox-mcq').html(temp);
        });


        // ✅ Passage Section
        $(document).on('click', '.addquestiontoselected-passage', function (event) {
            const questionRow = $(this).closest('.question-row');
            const selQuestions = questionRow.find('.customquestionbox-passage li.questn-selected');
            const total = parseInt(questionRow.find(".total_paper").val(), 10);

            if (questionRow.find(".customquestionselectedbox-passage .question").length + selQuestions.length > total) {
                alert(`You can select a maximum of ${total} questions.`);
                return false;
            }

            let temp = questionRow.find('.customquestionselectedbox-passage').html();
            let testTemp = '';

            selQuestions.each(function () {
                $(this).removeClass('questn-selected');
                temp += this.outerHTML;
                testTemp += `<li>${$(this).find('span span').text()}</li>`;
                $(this).remove();
            });

            questionRow.find('.customquestionselectedbox-passage').html(temp);
            questionRow.find('.slide-menu-passage').append(testTemp);
        });

        $(document).on('click', '.removequestionfromselected-passage', function (event) {
            const questionRow = $(this).closest('.question-row');
            const selQuestions = questionRow.find('.customquestionselectedbox-passage li.questn-selected');
            let temp = questionRow.find('.customquestionbox-passage').html();

            selQuestions.each(function () {
                $(this).removeClass('questn-selected');
                temp += this.outerHTML;
                $(this).remove();
            });

            questionRow.find('.customquestionbox-passage').html(temp);
        });


        // ✅ Subjective Section
        $(document).on('click', '.addquestiontoselected-subjective', function (event) {
            const questionRow = $(this).closest('.question-row');
            const selQuestions = questionRow.find('.customquestionbox-subjective li.questn-selected');
            const total = parseInt(questionRow.find(".total_paper").val(), 10);

            if (questionRow.find(".customquestionselectedbox-subjective .question").length + selQuestions.length > total) {
                alert(`You can select a maximum of ${total} questions.`);
                return false;
            }

            let temp = questionRow.find('.customquestionselectedbox-subjective').html();
            let testTemp = '';

            selQuestions.each(function () {
                $(this).removeClass('questn-selected');
                temp += this.outerHTML;
                testTemp += `<li>${$(this).find('span span').text()}</li>`;
                $(this).remove();
            });

            questionRow.find('.customquestionselectedbox-subjective').html(temp);
            questionRow.find('.slide-menu-subjective').append(testTemp);
        });

        $(document).on('click', '.removequestionfromselected-subjective', function (event) {
            const questionRow = $(this).closest('.question-row');
            const selQuestions = questionRow.find('.customquestionselectedbox-subjective li.questn-selected');
            let temp = questionRow.find('.customquestionbox-subjective').html();

            selQuestions.each(function () {
                $(this).removeClass('questn-selected');
                temp += this.outerHTML;
                $(this).remove();
            });

            questionRow.find('.customquestionbox-subjective').html(temp);
        });

        // ✅ Combined Section
        $(document).on('click', '.addquestiontoselected-combined', function (event) {
            const questionRow = $(this).closest('.question-row');
            const selQuestions = questionRow.find('.customquestionbox-combined li.questn-selected');
            const total = parseInt(questionRow.find(".total_paper").val(), 10);

            if (questionRow.find(".customquestionselectedbox-combined .question").length + selQuestions.length > total) {
                alert(`You can select a maximum of ${total} questions.`);
                return false;
            }

            let temp = questionRow.find('.customquestionselectedbox-combined').html();
            let testTemp = '';

            selQuestions.each(function () {
                $(this).removeClass('questn-selected');
                temp += this.outerHTML;
                testTemp += `<li>${$(this).find('span span').text()}</li>`;
                $(this).remove();
            });

            questionRow.find('.customquestionselectedbox-combined').html(temp);
            questionRow.find('.slide-menu-combined').append(testTemp);
        });

        $(document).on('click', '.removequestionfromselected-combined', function (event) {
            const questionRow = $(this).closest('.question-row');
            const selQuestions = questionRow.find('.customquestionselectedbox-combined li.questn-selected');
            let temp = questionRow.find('.customquestionbox-combined').html();

            selQuestions.each(function () {
                $(this).removeClass('questn-selected');
                temp += this.outerHTML;
                $(this).remove();
            });

            questionRow.find('.customquestionbox-combined').html(temp);
        });

        $(document).ready(function () {
            $('#title').on('input', function () {
                var title = $(this).val();
                var slug = generateSlug(title);
                $('#slug').val(slug);
            });

            function generateSlug(text) {
                return text
                    .toLowerCase()            // Convert to lowercase
                    .replace(/[^a-z0-9 -]/g, '') // Remove invalid chars
                    .replace(/\s+/g, '-')       // Replace spaces with -
                    .replace(/-+/g, '-');       // Replace multiple - with single -
            }
        });

        document.getElementById('fee_type').addEventListener('change', function () {
            var offerDiv = document.getElementById('price-div');
            var mrpDiv = document.getElementById('mrp-div');
            var discountDiv = document.getElementById('discount-div');
            if (this.value == 'paid') {
                offerDiv.style.display = 'block';
                mrpDiv.style.display = 'block';
                discountDiv.style.display = 'block';
            } else {
                offerDiv.style.display = 'none';
                mrpDiv.style.display = 'none';
                discountDiv.style.display = 'none';
                document.getElementById('discount').value = 0;
                document.getElementById('mrp').value = 0;
                document.getElementById('offered-price').value = 0;
            }
        });

        $('#image').change(function (event) {
            var input = event.target;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#image-preview').attr('src', e.target.result);
                    $('#image-preview').show();
                }
                reader.readAsDataURL(input.files[0]);
            }
        });
        $(document).ready(function () {
            let rowIndex = 1;

            $('#add-row').on('click', function () {
                let $original = $('.question-row:first');
                let $clone = $original.clone();

                rowIndex++;

                // Clear all input fields
                $clone.find('input[type="text"], select').val('');
                $clone.find('ul').empty();
                $clone.find('span[id^="questioncount"]').text('');

                // Generate unique IDs for all repeated elements
                $clone.find('[id]').each(function () {
                    const oldId = $(this).attr('id');
                    $(this).attr('id', oldId + '-' + rowIndex);
                });

                // Also fix label 'for' attributes (optional)
                $clone.find('label[for]').each(function () {
                    const oldFor = $(this).attr('for');
                    $(this).attr('for', oldFor + '-' + rowIndex);
                });

                // Append the cloned block
                $('#question-rows').append($clone);
            });

            // Remove block
            $(document).on('click', '.remove-row', function () {
                if ($('.question-row').length > 1) {
                    $(this).closest('.question-row').remove();
                } else {
                    alert('At least one test section is required.');
                }
            });
        });


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

                                $('.sub-cat').addClass('hidecls');
                                $('#sub_category_id').attr("required", false);
                            }

                        } else {
                            toastr.error('error encountered ' + result.msgText);
                        }
                    },
                });
            }

        });



        $(document).on('change', '.test_type,.total_paper,.test_generated_by', function (event) {

            $(this).attr('disabled', true);
            var btn = $(this)
            var test_generated_by = $(this).closest('.question-row').find('.test_generated_by').val()
            $(".validation-err").html('');
            let total_paper = $(this).closest('.question-row').find('.total_paper').val()
            let formData = new FormData();
            formData.append('language', $('#language').val());
            formData.append('fee_type', $('#fee_type').val());
            formData.append('competitive_commission', (typeof $('#exam_com_id').val() == 'undefined') ? '' : $('#exam_com_id').val());
            formData.append('exam_category', (typeof $('#category_id').val() == 'undefined') ? '' : $('#category_id').val());
            formData.append('total_paper', total_paper);
            formData.append('test_type', $(this).closest('.question-row').find('.test_type').val());
            formData.append('test_generated_by', test_generated_by);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ URL::to('generate-test-paper-by-selections') }}",
                type: 'post',
                processData: false,
                contentType: false,
                dataType: 'json',
                data: formData,
                context: this,
                success: function (result) {
                    if (result.success) {
                        $(this).attr('disabled', false);
                            if (test_generated_by == 'manual') {
                                btn.closest('.question-row').find('.customquestionselectedbox-mcq').html('');
                                btn.closest('.question-row').find('.customquestionbox-mcq').html(result.mcq_html);

                                btn.closest('.question-row').find('.customquestionselectedbox-passage').html('');
                                btn.closest('.question-row').find('.customquestionbox-passage').html(result.passage_html);

                                btn.closest('.question-row').find('.customquestionselectedbox-subjective').html('');
                                btn.closest('.question-row').find('.customquestionbox-subjective').html(result.subjective_html);

                                btn.closest('.question-row').find('.customquestionselectedbox-combined').html('');
                                btn.closest('.question-row').find('.customquestionbox-combined').html(result.combined_html);
                            } else {
                                btn.closest('.question-row').find('.customquestionbox-mcq').html('');
                                btn.closest('.question-row').find('.customquestionselectedbox-mcq').html(result.mcq_html);

                                btn.closest('.question-row').find('.customquestionbox-passage').html('');
                                btn.closest('.question-row').find('.customquestionselectedbox-passage').html(result.passage_html);

                                btn.closest('.question-row').find('.customquestionbox-subjective').html('');
                                btn.closest('.question-row').find('.customquestionselectedbox-subjective').html(result.subjective_html);

                                btn.closest('.question-row').find('.customquestionbox-combined').html('');
                                btn.closest('.question-row').find('.customquestionselectedbox-combined').html(result.combined_html);
                            }

                    } else {
                        $(this).attr('disabled', false);
                        if (result.code == 422) {
                            for (const key in result.errors) {
                                $(`#${key}-err`).html(result.errors[key][0]);
                            }
                        } else {
                            toastr.error('error encountered -' + result.msgText);
                        }
                    }
                }
            })
        });
        $(document).on('click', '#add-test-btn', function (event) {
            $(this).attr('disabled', true);
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
            let formData = new FormData($("#test-form")[0]);
            let additionalData = {
                testType: [],
                testSelections: [],
                numPapers: [],
                mcqselectedtestpaper: [],
                passageselectedtestpaper: [],
                subjectiveselectedtestpaper: [],
                combinedselectedtestpaper: []
            };

            // Gather additional data from the form
            $('.question-row').each(function () {
                additionalData.testType.push($(this).find('.test_type').val());
                additionalData.testSelections.push($(this).find('.test_generated_by').val());
                additionalData.numPapers.push($(this).find('.total_paper').val());
                let d1 = [];
                let d2 = [];
                let d3 = [];
                let d4 = [];
                $(this).find('.customquestionselectedbox-mcq .question').each(function () {
                    d1.push($(this).val());
                });
                $(this).find('.customquestionselectedbox-passage .question').each(function () {
                    d2.push($(this).val());
                });
                $(this).find('.customquestionselectedbox-subjective .question').each(function () {
                    d3.push($(this).val());
                });
                $(this).find('.customquestionselectedbox-combined .question').each(function () {
                    d4.push($(this).val());
                });
                additionalData.mcqselectedtestpaper.push(d1)
                additionalData.passageselectedtestpaper.push(d2)
                additionalData.subjectiveselectedtestpaper.push(d3)
                additionalData.combinedselectedtestpaper.push(d4)
            });

            // Append additional data to formData
            formData.append('additionalData', JSON.stringify(additionalData));
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: $("#test-form").attr("action"),
                type: 'post',
                processData: false,
                contentType: false,
                dataType: 'json',
                data: formData,
                context: this,
                success: function (result) {
                    if (result.success) {
                        //toastr.success(result.msgText);
                        window.location = `{{ URL::to('test-series') }}`;
                    } else {
                        $(this).attr('disabled', false);
                        if (result.code == 422) {
                            for (const key in result.errors) {
                                $(`#${key}-err`).html(result.errors[key][0]);
                            }
                        } else {
                            toastr.error('error encountered -' + result.msgText);
                        }
                    }
                }
            })
        });

    </script>
@endsection