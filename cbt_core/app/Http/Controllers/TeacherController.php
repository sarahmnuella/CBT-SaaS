<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Exam;
use App\Models\Subject;
use App\Models\ExamResult;
use App\Models\Teacher;

class TeacherController extends Controller
{
    private function getTeacher()
    {
        return Teacher::where('user_id', auth()->id())->firstOrFail();
    }

    public function dashboard($slug)
    {
        $teacher = $this->getTeacher();
        $stats = [
            'questions' => Question::where('teacher_id', $teacher->id)->count(),
            'exams' => Exam::where('teacher_id', $teacher->id)->count(),
            'results' => ExamResult::whereHas('exam', function ($q) use ($teacher) {
                $q->where('teacher_id', $teacher->id);
            })->count(),
        ];

        return view('teacher.dashboard', compact('stats'));
    }

    // ==========================================
    // BANK SOAL (QUESTIONS) CRUD
    // ==========================================
    public function questions($slug)
    {
        $teacher = $this->getTeacher();
        $questions = Question::with('subject')->where('teacher_id', $teacher->id)->latest()->get();
        $subjects = Subject::all();
        return view('teacher.questions', compact('questions', 'subjects'));
    }

    public function storeQuestion(Request $request, $slug)
    {
        $teacher = $this->getTeacher();
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'type' => 'required|in:multiple_choice,essay',
            'question' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'option_a' => 'required_if:type,multiple_choice',
            'option_b' => 'required_if:type,multiple_choice',
            'option_c' => 'required_if:type,multiple_choice',
            'option_d' => 'required_if:type,multiple_choice',
            'option_e' => 'required_if:type,multiple_choice',
            'answer' => 'required_if:type,multiple_choice|in:A,B,C,D,E',
            'weight' => 'required|integer|min:1',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('questions', 'public');
        }

        Question::create([
            'teacher_id' => $teacher->id,
            'subject_id' => $request->subject_id,
            'type' => $request->type,
            'question' => $request->question,
            'image' => $imagePath,
            'option_a' => $request->option_a,
            'option_b' => $request->option_b,
            'option_c' => $request->option_c,
            'option_d' => $request->option_d,
            'option_e' => $request->option_e,
            'answer' => $request->answer,
            'weight' => $request->weight,
        ]);

        return back()->with('success', 'Soal berhasil ditambahkan ke Bank Soal.');
    }

    public function deleteQuestion($slug, $id)
    {
        $teacher = $this->getTeacher();
        Question::where('id', $id)->where('teacher_id', $teacher->id)->firstOrFail()->delete();
        return back()->with('success', 'Soal berhasil dihapus.');
    }

    // ==========================================
    // UJIAN (EXAMS) CRUD
    // ==========================================
    public function exams($slug)
    {
        $teacher = $this->getTeacher();
        $exams = Exam::with('subject')->where('teacher_id', $teacher->id)->latest()->get();
        $subjects = Subject::all();
        return view('teacher.exams', compact('exams', 'subjects'));
    }

    public function storeExam(Request $request, $slug)
    {
        $teacher = $this->getTeacher();
        
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'name' => 'required|string|max:200',
            'type' => 'required|in:multiple_choice,essay',
            'question_order' => 'required|in:random,sequential',
            'total_questions' => 'required|integer|min:1',
            'duration' => 'required|integer|min:1',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
        ]);

        // Verify that there are enough questions in the bank
        $questionCount = Question::where('subject_id', $request->subject_id)
            ->where('type', $request->type)
            ->count();

        if ($questionCount < $request->total_questions) {
            return back()->withErrors(['total_questions' => "Jumlah soal di bank untuk mata pelajaran ini ({$questionCount}) kurang dari jumlah soal ujian yang diminta ({$request->total_questions})."]);
        }

        Exam::create([
            'teacher_id' => $teacher->id,
            'subject_id' => $request->subject_id,
            'name' => $request->name,
            'type' => $request->type,
            'question_order' => $request->question_order,
            'total_questions' => $request->total_questions,
            'duration' => $request->duration,
            'token' => strtoupper(str_shuffle(substr(md5(microtime()), 0, 5))),
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
            'is_active' => true,
        ]);

        return back()->with('success', 'Ujian berhasil dijadwalkan.');
    }

    public function toggleExam($slug, $id)
    {
        $teacher = $this->getTeacher();
        $exam = Exam::where('id', $id)->where('teacher_id', $teacher->id)->firstOrFail();
        $exam->update(['is_active' => !$exam->is_active]);

        return back()->with('success', 'Status aktifitas ujian berhasil diubah.');
    }

    public function deleteExam($slug, $id)
    {
        $teacher = $this->getTeacher();
        Exam::where('id', $id)->where('teacher_id', $teacher->id)->firstOrFail()->delete();
        return back()->with('success', 'Jadwal ujian berhasil dihapus.');
    }

    // ==========================================
    // REKAP HASIL UJIAN
    // ==========================================
    public function results($slug)
    {
        $teacher = $this->getTeacher();
        $results = ExamResult::with(['exam', 'student'])
            ->whereHas('exam', function ($q) use ($teacher) {
                $q->where('teacher_id', $teacher->id);
            })
            ->latest()
            ->get();

        return view('teacher.results', compact('results'));
    }
}
