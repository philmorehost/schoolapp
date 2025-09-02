<?php
foreach ($sample_create_exam_json_decode["quiz"] as $index => $question_json) {
    $question_numbering = ($index + 1);
    $each_question_json = $question_json;
    $each_question_text_word = !empty(trim(base64_decode($each_question_json["question"]))) ? str_replace(["\r\n"], "\n", base64_decode($each_question_json["question"])) : "";
    $each_question_correct_answer_text_word = !empty(trim(base64_decode($each_question_json["answers"]["correct"]))) ? str_replace(["\r\n"], "\n", base64_decode($each_question_json["answers"]["correct"])) : "";
    $each_question_wrong_answer_1_text_word = !empty(trim(base64_decode($each_question_json["answers"]["wrong"][0] ?? ''))) ? str_replace(["\r\n"], "\n", base64_decode($each_question_json["answers"]["wrong"][0] ?? '')) : "";
    $each_question_wrong_answer_2_text_word = !empty(trim(base64_decode($each_question_json["answers"]["wrong"][1] ?? ''))) ? str_replace(["\r\n"], "\n", base64_decode($each_question_json["answers"]["wrong"][1] ?? '')) : "";
    $each_question_wrong_answer_3_text_word = !empty(trim(base64_decode($each_question_json["answers"]["wrong"][2] ?? ''))) ? str_replace(["\r\n"], "\n", base64_decode($each_question_json["answers"]["wrong"][2] ?? '')) : "";

    echo
        '<span class="color-5 text-bold-600 mobile-font-size-18 system-font-size-20">QUESTION ' . $question_numbering . '</span><br>
        <div class="form-group mobile-width-90 system-width-95 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-1 system-margin-bottom-1 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
            <textarea id="question-' . $question_numbering . '-textarea" name="exam_question[]"  placeholder="" hidden required>' . $each_question_text_word . '</textarea>
            <div id="editor-question-' . $question_numbering . '" class="pell"></div>
            <span id="question-' . $question_numbering . '-textarea-empty" class="form-span mobile-font-size-12 system-font-size-14">Exam Question*</span>
        </div><br>

        <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-1 system-margin-top-1 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
            <textarea id="option-1-' . $question_numbering . '-textarea" name="option_1[]" placeholder="Correct Answer" class="" style="" hidden required>' . $each_question_correct_answer_text_word . '</textarea>
            <div id="editor-option-1-' . $question_numbering . '" class="pell"></div>
            <span id="option-1-' . $question_numbering . '-textarea-empty" class="form-span mobile-font-size-12 system-font-size-14">Option 1 - Correct*</span>
        </div>

        <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-1 system-margin-top-1 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
            <textarea id="option-2-' . $question_numbering . '-textarea" name="option_2[]" placeholder="Wrong Answer" class="" style="" hidden required>' . $each_question_wrong_answer_1_text_word . '</textarea>
            <div id="editor-option-2-' . $question_numbering . '" class="pell"></div>
            <span id="option-2-' . $question_numbering . '-textarea-empty" class="form-span mobile-font-size-12 system-font-size-14">Option 2 - Wrong*</span>
        </div>

        <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-1 system-margin-top-1 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
            <textarea id="option-3-' . $question_numbering . '-textarea" name="option_3[]" placeholder="Wrong Answer" class="" style="" hidden required>' . $each_question_wrong_answer_2_text_word . '</textarea>
            <div id="editor-option-3-' . $question_numbering . '" class="pell"></div>
            <span id="option-3-' . $question_numbering . '-textarea-empty" class="form-span mobile-font-size-12 system-font-size-14">Option 3 - Wrong*</span>
        </div>

        <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-1 system-margin-top-1 mobile-margin-bottom-4 system-margin-bottom-4 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
            <textarea id="option-4-' . $question_numbering . '-textarea" name="option_4[]" placeholder="Wrong Answer" class="" style="" hidden required>' . $each_question_wrong_answer_3_text_word . '</textarea>
            <div id="editor-option-4-' . $question_numbering . '" class="pell"></div>
            <span id="option-4-' . $question_numbering . '-textarea-empty" class="form-span mobile-font-size-12 system-font-size-14">Option 4 - Wrong*</span>
        </div>
        ';
}
?>