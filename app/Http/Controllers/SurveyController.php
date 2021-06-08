<?php

namespace App\Http\Controllers;

use App\Models\Helper;
use App\Models\Question;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Webpatser\Uuid\Uuid;

class SurveyController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Validate the survey.
     */
    public function validateSurvey(Request $request)
    {
        $request->validate([
            'name' => 'required|max:127|min:3'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $surveys = Survey::getAllByOwner(Auth::user()->id);
        return view('backend.surveys.index', compact('surveys'));
    }

    public function create()
    {
        return view('backend.surveys.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function store(Request $request)
    {
        $this->validateSurvey($request);

        $survey = new Survey();
        $survey->user_id = $request->user()->id;
        $survey->name = $request->input('name');
        $survey->uuid = Uuid::generate(4);
        $survey->description = $request->input('description');
        $survey->shareable_link = Helper::generateRandomString(8);
        $survey->save();
        $request->session()->flash('success', 'Survey ' . $survey->uuid . ' successfully created!');

        //return redirect()->route('survey.edit', $survey->uuid);
        return Redirect::route('surveys');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Survey $survey)
    {
        return view('backend.surveys.edit', [
            'survey' => $survey,
            'questions' => Question::getAllBySurveyIdPaginated($survey->id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, Survey $survey)
    {
        if (Survey::isRunning($survey->uuid) === Survey::ERR_IS_RUNNING_SURVEY_OK) {
            $request->session()->flash('warning', 'Survey "' . $survey->uuid . '" cannot be updated because it is being run.');

            return redirect()->route('survey.edit', $survey->uuid);
        }

        $this->validateSurvey($request);

        $survey = Survey::getByOwner($survey->uuid, $request->user()->id);

        if (!$survey) {
            $request->session()->flash('warning', 'Survey "' . $survey->uuid . '" not found.');

            return redirect()->route('surveys');
        }

        $survey->name = $request->input('name');
        $survey->description = $request->input('description');
        $survey->save();
        $request->session()->flash('success', 'Survey ' . $survey->uuid . ' successfully updated!');

        return redirect()->route('surveys.show', $survey->id);
    }

    /**
     * Run the survey.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function run($uuid, Request $request)
    {
        $survey = Survey::getByOwner($uuid, $request->user()->id);
        if (!$survey) {
            $request->session()->flash('warning', 'Survey "' . $uuid . '" does not exist.');

            return redirect()->route('surveys');
        }

        $questions = Question::getAllBySurveyId($survey->id);
        if (!($questions && count($questions) > 0)) {
            $request->session()->flash('warning', 'Survey "' . $uuid . '" must have at least one question.');

            return redirect()->route('surveys.show', $survey->id);
        }

        $status = Survey::run($uuid, $request->user()->id);

        $mocked_survey_not_found = Helper::getTestEnvMockVar('Surveys::ERR_RUN_SURVEY_NOT_FOUND', $status === Survey::ERR_RUN_SURVEY_NOT_FOUND);
        $mocked_survey_invalid_status = Helper::getTestEnvMockVar('Surveys::ERR_RUN_SURVEY_INVALID_STATUS', $status === Survey::ERR_RUN_SURVEY_INVALID_STATUS);
        $mocked_survey_already_running = Helper::getTestEnvMockVar('Surveys::ERR_RUN_SURVEY_ALREADY_RUNNING', $status === Survey::ERR_RUN_SURVEY_ALREADY_RUNNING);

        if ($mocked_survey_not_found) {
            $request->session()->flash('warning', 'Survey "' . $uuid . '" not found.');

            return redirect()->route('surveys');
        } elseif ($mocked_survey_invalid_status) {
            $request->session()->flash('warning', 'Survey "' . $uuid . '" invalid status, it should be "draft".');

            return redirect()->route('surveys.show', $survey->id);
        } elseif ($mocked_survey_already_running) {
            $request->session()->flash('warning', 'Survey "' . $uuid . '" already running.');

            return redirect()->route('surveys.show', $survey->id);
        }

        $request->session()->flash('success', 'Survey "' . $uuid . '" is now running.');

        return redirect()->route('surveys.show', $survey->id);
    }

    /**
     * Pause the survey.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function pause($uuid, Request $request)
    {
        $survey = Survey::getByOwner($uuid, $request->user()->id);
        if (!$survey) {
            $request->session()->flash('warning', 'Survey "' . $uuid . '" not found.');

            return redirect()->route('surveys');
        }

        $questions_next_version = Survey::generateQuestionsNextVersion($survey);
        foreach ($questions_next_version as $question_next_version) {
            $question_created = Question::createQuestion($question_next_version);

            Question::createQuestionOptions($question_created, $question_next_version['questions_options']);
        }

        $status = Survey::pause($uuid, $request->user()->id);

        $mocked_survey_invalid_status = Helper::getTestEnvMockVar('Surveys::ERR_PAUSE_SURVEY_INVALID_STATUS', $status === Survey::ERR_PAUSE_SURVEY_INVALID_STATUS);

        if ($mocked_survey_invalid_status) {
            $request->session()->flash('warning', 'Survey "' . $uuid . '" invalid status, it should be "ready".');

            return redirect()->route('surveys.show', $survey->id);
        } elseif ($status === Survey::ERR_PAUSE_SURVEY_ALREADY_PAUSED) {
            $request->session()->flash('warning', 'Survey "' . $uuid . '" is already paused.');

            return redirect()->route('surveys.show', $survey->id);
        }

        $request->session()->flash('success', 'Survey "' . $uuid . '" is now paused.');

        return redirect()->route('surveys.show', $survey->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
    public function destroy(Survey $survey)
    {
        $survey->delete();
        return Redirect::route('surveys');
    }
}
