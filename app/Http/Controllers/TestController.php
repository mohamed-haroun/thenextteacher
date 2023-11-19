<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Lesson;
use App\Models\QuestionType;
use App\Models\Subject;
use App\Models\Test;
use App\Models\TestLesson;
use App\Models\TestQuestion;
use App\Models\TestType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Response;

class TestController extends Controller
{

    public function index(): Response
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }

        return Inertia::render('Tests/Index', [
            'tests' => Test::with(['test_type.rules', 'user', 'subject', 'grade'])->paginate(15),
            'types' => TestType::all(),
            'examCount' => Test::whereIn('test_type_id', TestType::where('title', 'exam')->get(['id']))->count(),

            'quizCount' => Test::whereIn('test_type_id', TestType::where('title', 'quiz')->get(['id']))->count(),

            'revisionCount' => Test::whereIn('test_type_id', TestType::where('title', 'revision')->get(['id']))->count(),
        ]);
    }

    public function show(Test $test): Response
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        return Inertia::render('Tests/Show', [
            'test' => Test::with([
                    'subject',
                    'grade',
                    'test_type',
                    'user',
                    'lessons',
                ])->find($test->id),
        ]);
    }

    // display the exam
    public function display(Test $test)
    {
        return Inertia::render('Tests/Display', [
            'test' => Test::with([
                'subject',
                'grade',
                'user',
                'test_type',
                'lessons',
                'questions.type',
                'questions.choices',
                'questions.checks',
                'questions.completions',
                'questions.correct',
                'questions.answerImages',
            ])->find($test->id),
            'question_types' => QuestionType::all()
        ]);
    }

    public function create()
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        return Inertia::render('Tests/Create', [
            'grades' => Grade::all(),
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'grade' => 'required',
            'subject' => 'required',
            'lessons' => 'required',
            'type' => 'required',
            'duration' => 'required',
            'degree' => 'required',
        ]);

        $lessons = DB::table('lessons')
            ->whereIn('title', $request->lessons)
            ->get(['id'])
            ->pluck('id');

        $questions = collect([]);

        $testType = $request->type;

        $rules = null;

        if ($testType) {
            $rules = collect($testType['rules']);
        } else {
            return to_route('testTypes.create')->with('error', 'No test types for that kind!, create new one');
        }

        if ($rules->isNotEmpty()) {
            foreach($rules as $rule) {
                $questions = $questions->merge(DB::table('questions')
                    ->whereIn('lesson_id', $lessons)
                    ->where('question_type_id','=', $rule['question_type_id'])
                    ->inRandomOrder()
                    ->limit($rule['count'])
                    ->get());
            }
        } else {

            if (auth()->user()->type === 'student') {
                return back()->with('error', 'No rules for that type!');
            }

            return to_route('tests.create')->with('error', 'No rules for that type!');
        }

        $test = Test::create([
            'subject_id' => $testType['subject_id'],
            'grade_id' => $testType['grade_id'],
            'test_type_id' => $testType['id'],
            'duration' => $request['duration'],
            'degree' => $request['degree'],
            'user_id' => auth()->user()->id
        ]);

        foreach ($lessons as $lesson) {
            TestLesson::create([
                'lesson_id' => $lesson,
                'test_id' => $test->id
            ]);
        }
        if (count($questions) === $rules->pluck('count')->sum()) {
            foreach ($questions as $question) {
                TestQuestion::create([
                    'test_id' => $test->id,
                    'question_id' => $question->id
                ]);
            }
        } else {
            // Delete The exam
            $test->delete();

            if (auth()->user()->type === 'student') {
                return back()->with('error', 'Not enough question for those lessons!');
            }

            // Return the response
            return to_route('tests.create')->with('error', 'Not enough question for those lessons!');
        }

        if (auth()->user()->type === 'student') {
            return to_route('students.exam', ['exam' => $test])->with('message', 'Created Successfully');
        }

        if (auth()->user()->type === 'teacher' && auth()->user()->hasRole('user')) {
            return to_route('profile')->with('message', 'Created Successfully');
        }

        return to_route('tests.index')->with('message', 'Created Successfully');
    }

    public function destroy(Test $test)
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        $test->delete();

        return to_route('tests.index')->with('message', 'deleted successfully');
    }

    // Axios requested data
    public function subjectsOfGrade($grade): Collection|array
    {
        return Grade::with('subjects')->where('title', $grade)->get();
    }

    public function lessonsOfSubject($grade, $subject)
    {
        $grade_id = Grade::where('title', $grade)->first()->id;
        $subject_id = Subject::where('title', $subject)->first()->id;

        return Lesson::where('grade_id', $grade_id)->where('subject_id', $subject_id)->get();
    }

    // Getting the specified exams for the subject and grade
    public function testTypesOfSubjectGrade($grade, $subject)
    {
        $grade_id = Grade::where('title', $grade)->first()?->id;
        $subject_id = Subject::where('title', $subject)->first()?->id;
        return TestType::with(['rules.question_type'])
            ->where('subject_id', '=', $subject_id)
            ->where('grade_id', '=', $grade_id)
            ->get();
    }
}
