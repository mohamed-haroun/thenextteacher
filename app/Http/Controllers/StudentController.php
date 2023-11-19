<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use App\Models\Grade;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\QuestionType;
use App\Models\Student;
use App\Models\StudentAnswer;
use App\Models\Subject;
use App\Models\Test;
use App\Models\TestType;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class StudentController extends Controller
{
    public function index(): Response
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        return Inertia::render('Users/Students/Index', [
            'students' => Student::with('user', 'grade')->get()
        ]);
    }

    public function show(Student $student)
    {

        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        return Inertia::render('Users/Students/Show', [
            'student' => $student->with(['user.tests.test_type', 'user.tests.studentAnswers', 'user.tests.questions', 'grade.subjects'])->find($student->id),
            'grades' => Grade::all()
        ]);
    }

    public function subject(string $subject): Response
    {
        if (! auth()->user()->hasRole('student')) {
            abort(403);
        }
        return Inertia::render('Users/Students/Subject', [
            'lessons' => Lesson::with(['subject', 'grade'])
                ->where('subject_id', '=', $subject)
                ->where('grade_id', '=', auth()->user()->student->grade_id)
                ->get(),
            'subject' => Subject::find($subject),
            'grade' => Grade::find(auth()->user()->student->grade_id),
            'testTypes' => TestType::with('rules')->where('subject_id', '=', $subject)
                ->where('grade_id', '=', auth()->user()->student->grade_id)->get()
        ]);
    }

    public function attendExam(Test $exam): Response
    {
        if (! auth()->user()->hasRole('student')) {
            abort(403);
        }

        return Inertia::render('Users/Students/Exam', [
            'test' => Test::with([
                'subject',
                'studentAnswers',
                'grade',
                'user',
                'lessons',
                'questions.type',
                'questions.choices',
                'questions.checks',
                'questions.completions',
                'questions.correct',
                'questions.answerImages',
            ])->find($exam->id),
            'question_types' => QuestionType::all()
        ]);
    }

    public function correctQuestions(string $test, Request $request)
    {
        $answers = $request->all()['testQuestions'];

        foreach ($answers as $answer) {
            $question = Question::with(['correct', 'choices', 'type'])->find($answer['question']);

            if ($question->type->title === 'mcq') {
                $correctChoice = Choice::where('question_id', $question->id)->where('check', 1)->first();
                StudentAnswer::create([
                    'test_id' => $test,
                    'question_id' => $answer['question'],
                    'answer' => $answer['answer'],
                    'correctness' => $correctChoice->answer === $answer['answer']
                ]);
            }
        }

        return to_route('profile')->with('message', 'Exam submitted successfully');
    }
}
