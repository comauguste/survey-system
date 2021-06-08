<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuestionsOptions;
use App\Models\Survey;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;

class QuestionController extends Controller
{
    /**
     * Validate the question.
     */
    public function validateQuestion(Request $request)
    {
        /*Validator::extend('valid_question_options', function ($attribute, $value, $parameters, $validator) {
            return is_array($value) && (count($value) > 1 || array_search('free', array_column($value, 'type')) !== false);
        });*/
        $request->validate([
            'description' => 'required|max:1023|min:4'
        ]);
    }

    public function show(Survey $survey, $q_uuid)
    {
        $question = Question::getBySurvey($q_uuid, $survey->id);

        return view('backend.questions.edit', [
            'survey' => $survey,
            'question' => $question
        ]);
    }

    /**
     * Show the question creation page.
     *
     */
    public function create(Request $request, $uuid)
    {
        $survey = Survey::where('user_id', '=', $request->user()->id)->where('uuid', '=', $uuid)->limit(1)->get();

        if (count($survey) !== 1) {
            $request->session()->flash('warning', 'Survey "' . $uuid . '" not found.');

            return redirect()->route('surveys');
        }

        return view('backend.questions.create')->with([
            'survey' => $survey[0],
        ]);
    }

    /**
     * Create a new question.
     *
     */
    public function store(Request $request, Survey $survey)
    {
        if (Survey::isRunning($survey->uuid) === Survey::ERR_IS_RUNNING_SURVEY_OK) {
            $request->session()->flash('warning', 'Survey "' . $survey->uuid . '" cannot be updated because it is being run.');

            return redirect()->route('surveys.show', $survey->id);
        }

        $this->validateQuestion($request);
        if (!$survey) {
            $request->session()->flash('warning', 'Survey "' . $survey->uuid . '" not found.');

            return redirect()->route('dashboard');
        }

        $question = Question::createQuestion([
            'description' => $request->input('description'),
            'uuid' => Uuid::generate(4),
            'survey_id' => $survey->id,
            'order' => Question::getNextInOrder($survey->id),
        ]);

        $questions_options = "free";

        Question::createQuestionOptions($question, $questions_options);

        $request->session()->flash('success', 'Question ' . $question->uuid . ' successfully created!');

        return redirect()->route('surveys.show', $survey->id);
    }

    /**
     * Delete the question.
     *
     */
    public function delete(Request $request, Survey $survey, $q_uuid)
    {
        if (Survey::isRunning($survey->uuid) === Survey::ERR_IS_RUNNING_SURVEY_OK) {
            $request->session()->flash('warning', 'Survey "' . $survey->uuid . '" cannot be updated because it is being run.');

            return redirect()->route('surveys.show', $survey->id);
        }

        if (Question::deleteByOwner($survey->uuid, $q_uuid, $request->user()->id)) {
            $request->session()->flash('success', 'Question "' . $q_uuid . '" successfully removed!');

            return redirect()->route('surveys.show', $survey->id);
        }

        $request->session()->flash('warning', 'Question "' . $q_uuid . '" not found.');

        return redirect()->route('surveys.show', $survey->id);
    }

    /**
     * Display the question's editing page.
     *
     */
    public function edit($s_uuid, $q_uuid, Request $request)
    {
        $survey = Survey::getByOwner($s_uuid, $request->user()->id);
        if (!$survey) {
            $request->session()->flash('warning', 'Survey "' . $s_uuid . '" not found.');

            return redirect()->route('surveys');
        }

        if ($survey->is_running) {
            $request->session()->flash('warning', 'Survey "' . $s_uuid . '" is running.');

            return redirect()->route('survey.edit', $s_uuid);
        }

        $question = Question::getBySurvey($q_uuid, $survey->id);
        if (!$question) {
            $request->session()->flash('warning', 'Question "' . $q_uuid . '" not found.');

            return redirect()->route('survey.edit', $s_uuid);
        }

        $question_options = QuestionsOptions::getAllByQuestionIdAsJSON($question->id);

        return view('question.edit')->with([
            'survey' => $survey,
            'question' => $question,
            'question_options' => $question_options,
        ]);
    }

    /**
     * Update the question.
     *
     */
    public function update(Survey $survey, Question $question, Request $request)
    {
        $this->validateQuestion($request);

        if (!$survey) {
            $request->session()->flash('warning', 'Survey "' . $survey->uuid . '" not found.');

            return redirect()->route('dashboard');
        }

        if ($survey->is_running) {
            $request->session()->flash('warning', 'Survey "' . $survey->uuid . '" cannot be updated because it is running.');

            return redirect()->route('surveys.show', $survey->id);
        }

        if (!$question) {
            $request->session()->flash('warning', 'Question "' . $question->uuid . '" not found.');

            return redirect()->route('surveys.show', $survey->id);
        }

        $question->description = $request->input('description');
        $question->save();

        QuestionsOptions::saveArray($question->id, $request->input('questions_options'));

        $request->session()->flash('success', 'Question ' . $question->uuid . ' successfully updated!');

        return redirect()->route('surveys.show', $survey->id);
    }

    /**
     * Display the change Question' order page.
     *
     */
    public function showChangeOrder($s_uuid, Request $request)
    {
        $survey = Survey::getByOwner($s_uuid, $request->user()->id);
        if (!$survey) {
            $request->session()->flash('warning', 'Survey "' . $s_uuid . '" not found.');

            return redirect()->route('dashboard');
        }

        if ($survey->is_running) {
            $request->session()->flash('warning', 'Survey "' . $s_uuid . '" is running.');

            return redirect()->route('survey.edit', $s_uuid);
        }

        $questions = Question::getAllBySurveyIdUnpaginated($survey->id);

        return view('question.change_order')->with([
            'survey' => $survey,
            'Question' => $questions,
        ]);
    }

    /**
     * Update the questions' order.
     *
     */
    public function storeChangeOrder($s_uuid, Request $request)
    {
        $survey = Survey::getByOwner($s_uuid, $request->user()->id);
        if (!$survey) {
            $request->session()->flash('warning', 'Survey "' . $s_uuid . '" not found.');

            return redirect()->route('dashboard');
        }

        if ($survey->is_running) {
            $request->session()->flash('warning', 'Survey "' . $s_uuid . '" is running.');

            return redirect()->route('survey.edit', $s_uuid);
        }

        $questions = $request->input('questions');
        foreach ($questions as $order => $question) {
            Question::updateOrder($question['id'], $order + 1);
        }

        $request->session()->flash('success', 'Questions order updated!');

        return redirect()->route('survey.edit', $s_uuid);
    }
}
