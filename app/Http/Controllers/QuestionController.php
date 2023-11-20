<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\AnswerImage;
use App\Models\Check;
use App\Models\Choice;
use App\Models\Completion;
use App\Models\Correct;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\QuestionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class QuestionController extends Controller
{
    public function index()
    {
//        if (! auth()->user()->hasRole('admin')) {
//            abort(403);
//        }
        return Inertia::render('Questions/Index', [
            'questions' => Question::with(['lesson.subject', 'lesson.grade', 'type'])->get(),
        ]);
    }

    public function show(Question $question)
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        return Inertia::render('Questions/Show', [
            'question' => Question::with([
                'lesson.subject',
                'lesson.grade',
                'type',
                'choices',
                'completions',
                'checks',
                'correct',
                'answer'
            ])->find($question->id),
        ]);
    }

    public function create(Request $request)
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        return Inertia::render('Questions/Create', [
            'lesson' => Lesson::find($request->lesson),
            'types' => QuestionType::all()
        ]);
    }

    public function edit(Question $question)
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        $question = Question::with([
            'lesson.subject',
            'lesson.grade',
            'type',
            'choices',
            'completions',
            'checks',
            'correct',
            'answer'
        ])->find($question->id);

        $lessons = Lesson::with(['grade'])->where('subject_id', '=', $question->lesson->subject->id)->get(['id', 'title']);
        return Inertia::render('Questions/Edit', [
            'question' => $question,
            'types' => QuestionType::get(['id', 'title']),
            'lessons' => $lessons
        ]);
    }

    /*
     *
     * Updating the question data
     *
     * */

    public function update(Question $question, Request $request)
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        $question = Question::with([
            'type',
            'checks',
            'completions',
            'choices',
            'answer',
            'answerImages'
        ])->find($question->id);

        $validated = $request->validate([
            'data.type' => ['required', 'string', 'max:255'],
            'data.title' => ['required', 'string'],
            'data.answer' => ['nullable'],
            'data.image' => ['nullable', 'image', 'mimes:jpg,png,jpeg,gif,svg', 'max:2048'],
            'data.answerImages' => ['nullable'],
            'data.lesson' => ['required', 'string', 'max:255'],
            'data.rating' => ['required', 'numeric', 'max:5', 'min:1'],
        ]);
        $data = $validated['data'];
        $imageName = null;
        if (array_key_exists('image', $data) && $data['image']) {
            // Delete the existent image if found
            if ($question->image) {
                File::delete(storage_path('app/questions/' . $question->image));
            }
            $imageName = time() . '.' . $data['image']->extension();
            $data['image']->move(storage_path('app/questions/'), $imageName);
        }

        //        Adding photos to the answers if exists
        if (array_key_exists('answerImages', $data)) {
            $answerImages = AnswerImage::where('question_id', '=', $question->id)->get();
            if ($answerImages) {
                foreach ($answerImages as $image) {
                    File::delete(storage_path('app/answers/' . $image->image_path));
                }
                AnswerImage::where('question_id', '=', $question->id)->delete();
            }
            foreach ($data['answerImages'] as $image) {
                $imageName = time() * rand(0, 100) . '.' . $image->extension();
                $image->move(storage_path('app/answers/'), $imageName);

                AnswerImage::create([
                    'image_path' => $imageName,
                    'question_id' => $question->id
                ]);
            }
        }

        if ($question->type->title !== $data['type']) {

            if ($question->type->title === 'check') {
                Check::where('question_id', '=', $question->id)->delete();
            }elseif ($question->type->title === 'complete') {
                Completion::where('question_id', '=', $question->id)->delete();
            }elseif ($question->type->title === 'mcq') {
                Choice::where('question_id', '=', $question->id)->delete();
            }else {
                Answer::where('question_id', '=', $question->id)->delete();
            }

            if ($question->type->title !== 'mcq' || $question->type->title !== 'generic') {
                $answerImages = AnswerImage::where('question_id', '=', $question->id)->get();
                if ($answerImages) {
                    foreach ($answerImages as $image) {
                        File::delete(storage_path('app/answers/' . $image->image_path));
                    }
                    AnswerImage::where('question_id', '=', $question->id)->delete();
                }
            }
        }

        //Updating
        if ($data['type'] === 'check') {
            Check::where('question_id', '=', $question->id)?->delete();
            Check::create([
                'answer' => $data['answer'],
                'question_id' => $question->id
            ]);
        } else if ($data['type'] === 'complete') {
            Completion::where('question_id', '=', $question->id)?->delete();
            foreach ($data['answer'] as $answer) {
                Completion::create([
                    'answer' => $answer,
                    'question_id' => $question->id
                ]);
            }
        } else if ($data['type'] === 'mcq') {
            Choice::where('question_id', '=', $question->id)?->delete();
            for ($i = 0; $i < count($data['answer']); $i++) {
                Choice::create([
                    'answer' => $data['answer'][$i],
                    'check' => $i === 0,
                    'question_id' => $question->id
                ]);
            }
        } else if ($data['type'] === 'correct') {
            Correct::where('question_id', '=', $question->id)?->delete();
            Correct::create([
                'right' => $data['answer'][0],
                'wrong' => $data['answer'][1],
                'question_id' => $question->id
            ]);
        } else {
            Answer::where('question_id', '=', $question->id)?->delete();
            Answer::create([
                'title' => $data['answer'],
                'question_id' => $question->id
            ]);
        }

        $question->update([
            'title' => $data['title'],
            'rating' => $data['rating'],
            'image' => $imageName ?? $question->image,
            'question_type_id' => QuestionType::where('title', $data['type'])->first()->id,
            'lesson_id' => Lesson::where('title', $data['lesson'])->first()->id,
        ]);

        return to_route('questions.show', ['question' => $question]);

    }

    /*
     * Storing the question data
     *
     * */

    public function store(Request $request)
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $request->validate([
            'type' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'min:3', Rule::unique('questions', 'title')],
            'image' => ['nullable', 'image', 'mimes:jpg,png,jpeg,gif,svg', 'max:2048'],
            'answer' => ['required'],
            'lesson' => ['required', 'string', 'max:255'],
            'rating' => ['required', 'numeric', 'max:5', 'min:1'],
        ]);


        $imageName = null;
        if ($request->image) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(storage_path('app/questions/'), $imageName);
        }

        $question = Question::create([
            'title' => $request->title,
            'rating' => $request->rating,
            'image' => $imageName,
            'question_type_id' => QuestionType::where('title', $request->type)->first()->id,
            'lesson_id' => Lesson::where('title', $request->lesson)->first()->id,
            'user_id' => auth()->user()->id
        ]);

        if ($request->type === 'check') {
            Check::create([
                'answer' => $request->answer,
                'question_id' => $question->id
            ]);
        } else if ($request->type === 'complete') {
            foreach ($request->answer as $answer) {
                Completion::create([
                    'answer' => $answer,
                    'question_id' => $question->id
                ]);
            }
        } else if ($request->type === 'mcq') {

            $choices = [];

            for ($i = 0; $i < count($request->answer); $i++) {
                $choices[$i] = ['answer' => $request->answer[$i], 'check' => $i === 0, 'question_id' => $question->id];
            }

            shuffle($choices);

            for ($i = 0; $i < count($choices); $i++) {
                Choice::create($choices[$i]);
            }
        } else if ($request->type === 'correct') {
            Correct::create([
                'right' => $request->answer[0],
                'wrong' => $request->answer[1],
                'question_id' => $question->id
            ]);
        } else {
            Answer::create([
                'title' => $request->answer,
                'question_id' => $question->id
            ]);
        }
//        Adding photos to the answers if exists
        if (array_key_exists('answerImages', $request->all())) {
            foreach ($request->answerImages as $image) {
                $imageName = time() . '.' . $image->extension();
                $image->move(storage_path('app/answers/'), $imageName);

                AnswerImage::create([
                    'image_path' => $imageName,
                    'question_id' => $question->id
                ]);
            }
        }

        return to_route('questions.create', ['lesson' => $question->lesson_id])
            ->with('message', 'Question created successfully');
    }

    /*
     *
     * Delete The question
     *
     * */

    public function destroy(Question $question)
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        if ($question->image) {
            File::delete(storage_path('app/public/images/' . $question->image));
        }

        $question->delete();

        return to_route('questions.index')->with('message', 'deleted successfully');
    }
}
