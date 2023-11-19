<?php

use App\Http\Controllers\GradeController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuestionTypeController;
use App\Http\Controllers\RuleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TestTypeController;
use App\Http\Controllers\UsersController;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('Index');
})->name('home');

Route::get('/about', function () {
    return Inertia::render('About');
})->name('about');

Route::get('/contact', function () {
    return Inertia::render('ContactUs');
})->name('contact');

Route::get('/dashboard', function () {
    if (! auth()->user()->hasRole('admin')) {
        abort(403);
    }
    return Inertia::render('Dashboard', [
        'users' => User::with(['tests', 'roles'])->get(),
        'teachers' => Teacher::count(),
        'students' => Student::count()
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/grades/{grade}/subject/{subject}', [GradeController::class, 'subject'])->name('grades.subject');

    Route::get('/tests/{test}/display', [TestController::class, 'display'])->name('tests.display');

    Route::resource('/questions/types', QuestionTypeController::class);

    // Adding grade for student user.
    Route::patch('/users/subject/add', [UsersController::class, 'addSubject'])->name('users.add_subject');
    // Adding subject for teacher user.
    Route::patch('/users/grade/add', [UsersController::class, 'addGrade'])->name('users.add_grade');

    // Teachers routes
    Route::get('/users/teachers', [TeacherController::class, 'index'])->name('teachers.index');
    Route::get('/users/teachers/exam', [TeacherController::class, 'exam'])->name('teachers.exam');
    Route::get('/users/teachers/{teacher}', [TeacherController::class, 'show'])->name('teachers.show');

    // Students routes
    Route::get('/users/students/subject/{subject}', [StudentController::class, 'subject'])->name('student.subject');
    Route::get('/users/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/users/students/{student}', [StudentController::class, 'show'])->name('students.show');
    Route::get('/users/students/exam/{exam}', [StudentController::class, 'attendExam'])->name('students.exam');
    Route::post('/users/students/exam/{exam}/correct', [StudentController::class, 'correctQuestions'])->name('students.exam-correct');

    // Parents routes
    Route::get('/users/parents', [ParentController::class, 'index'])->name('parents.index');
    Route::get('/users/parents/{parent}', [ParentController::class, 'show'])->name('parents.show');

    Route::post('/tests/testTypes/{testType}/rule', [RuleController::class, 'store'])->name('rule.store');
    Route::delete('/tests/testTypes/rule/{rule}', [RuleController::class, 'destroy'])->name('rule.destroy');

    Route::get('/tests/testTypes', [TestTypeController::class, 'index'])->name('testTypes.index');
    Route::get('/tests/testTypes/create', [TestTypeController::class, 'create'])->name('testTypes.create');
    Route::get('/tests/testTypes/{testType}', [TestTypeController::class, 'show'])->name('testTypes.show');
    Route::post('/tests/testTypes', [TestTypeController::class, 'store'])->name('testTypes.store');
    Route::delete('/tests/testTypes/{testType}', [TestTypeController::class, 'delete'])->name('testTypes.destroy');

    Route::resource('/users', UsersController::class);
    Route::resource('/subjects', SubjectController::class);
    Route::resource('/grades', GradeController::class);
    Route::resource('/lessons', LessonController::class);
    Route::resource('/questions', QuestionController::class);
    Route::resource('/tests', TestController::class);

    Route::get('/getSubjects/{grade}', [TestController::class, 'subjectsOfGrade'])->name('tests.subjectsOfGrade');
    Route::get('/getLessons/{grade}/{subject}', [TestController::class, 'lessonsOfSubject'])->name('tests.lessonsOfSubject');
    Route::get('/getTestTypes/{grade}/{subject}', [TestController::class, 'testTypesOfSubjectGrade'])->name('tests.testTypesOfSubjectGrade');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/edit', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
