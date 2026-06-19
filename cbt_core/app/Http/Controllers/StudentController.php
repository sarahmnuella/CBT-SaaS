<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\Question;

class StudentController extends Controller
{
    private function getStudent()
    {
        return Student::where('user_id', auth()->id())->firstOrFail();
    }

    public function dashboard($slug)
    {
        $student = $this->getStudent();
        
        $stats = [
            'taken' => ExamResult::where('student_id', $student->id)->where('status', 'done')->count(),
            'average_score' => ExamResult::where('student_id', $student->id)->where('status', 'done')->avg('score') ?? 0,
            'upcoming' => Exam::where('is_active', true)
                ->where('start_at', '>', now())
                ->count(),
        ];

        return view('student.dashboard', compact('stats'));
    }

    public function exams($slug)
    {
        $student = $this->getStudent();
        
        // Find exams that are active and the student hasn't completed
        $exams = Exam::with('subject')
            ->where('is_active', true)
            ->where('start_at', '<=', now())
            ->where('end_at', '>=', now())
            ->get();

        $completedExamIds = ExamResult::where('student_id', $student->id)
            ->where('status', 'done')
            ->pluck('exam_id')
            ->toArray();

        $ongoingExamResults = ExamResult::where('student_id', $student->id)
            ->where('status', 'ongoing')
            ->get()
            ->keyBy('exam_id');

        return view('student.exams', compact('exams', 'completedExamIds', 'ongoingExamResults'));
    }

    public function startExam(Request $request, $slug, $id)
    {
        $student = $this->getStudent();
        $exam = Exam::findOrFail($id);

        $request->validate([
            'token' => 'required',
        ]);

        if (strtoupper($request->token) !== $exam->token) {
            return back()->withErrors(['token' => 'Token ujian salah.']);
        }

        // Check if already finished
        $existing = ExamResult::where('student_id', $student->id)
            ->where('exam_id', $exam->id)
            ->first();

        if ($existing && $existing->status === 'done') {
            return redirect()->route('student.exams', ['slug' => $slug])->with('error', 'Anda telah menyelesaikan ujian ini.');
        }

        if (!$existing) {
            // Get questions
            $questions = Question::where('subject_id', $exam->subject_id)
                ->where('type', $exam->type);

            if ($exam->question_order === 'random') {
                $questions = $questions->inRandomOrder();
            } else {
                $questions = $questions->orderBy('id', 'asc');
            }

            $questionIds = $questions->take($exam->total_questions)->pluck('id')->toArray();

            if (empty($questionIds)) {
                return back()->withErrors(['token' => 'Gagal memulai ujian: bank soal untuk mata pelajaran ini kosong.']);
            }

            $existing = ExamResult::create([
                'exam_id' => $exam->id,
                'student_id' => $student->id,
                'question_list' => $questionIds,
                'answers' => [],
                'correct_count' => 0,
                'score' => 0,
                'started_at' => now(),
                'status' => 'ongoing',
            ]);
        }

        return redirect()->route('student.exam.page', ['slug' => $slug, 'id' => $exam->id]);
    }

    public function examPage($slug, $id)
    {
        $student = $this->getStudent();
        $exam = Exam::findOrFail($id);
        $result = ExamResult::where('student_id', $student->id)
            ->where('exam_id', $exam->id)
            ->where('status', 'ongoing')
            ->firstOrFail();

        // Calculate time remaining in seconds
        $elapsedSeconds = now()->diffInSeconds($result->started_at);
        $durationSeconds = $exam->duration * 60;
        $timeRemaining = $durationSeconds - $elapsedSeconds;

        if ($timeRemaining <= 0) {
            return $this->autoSubmit($result);
        }

        $questions = Question::whereIn('id', $result->question_list)->get()->keyBy('id');
        
        // Order questions according to original layout list
        $orderedQuestions = [];
        foreach ($result->question_list as $qId) {
            if (isset($questions[$qId])) {
                $orderedQuestions[] = $questions[$qId];
            }
        }

        return view('student.exam_engine', compact('exam', 'result', 'orderedQuestions', 'timeRemaining'));
    }

    public function saveAnswer(Request $request, $slug, $id)
    {
        $student = $this->getStudent();
        $result = ExamResult::where('student_id', $student->id)
            ->where('exam_id', $id)
            ->where('status', 'ongoing')
            ->firstOrFail();

        $answers = $result->answers ?? [];
        $answers[$request->question_id] = $request->answer;

        $result->update([
            'answers' => $answers,
        ]);

        return response()->json(['success' => true]);
    }

    public function submitExam(Request $request, $slug, $id)
    {
        $student = $this->getStudent();
        $result = ExamResult::where('student_id', $student->id)
            ->where('exam_id', $id)
            ->where('status', 'ongoing')
            ->firstOrFail();

        if ($request->has('cheating') && $request->cheating == 'true') {
            $result->update([
                'status' => 'cheating',
                'finished_at' => now(),
            ]);
            return redirect()->route('student.exams', ['slug' => $slug])
                             ->with('error', 'Ujian Anda otomatis dibatalkan karena terdeteksi melakukan pelanggaran (membuka halaman/aplikasi lain).');
        }

        return $this->autoSubmit($result);
    }

    private function autoSubmit($result)
    {
        $exam = $result->exam;
        $questions = Question::whereIn('id', $result->question_list)->get()->keyBy('id');
        $answers = $result->answers ?? [];

        $correctCount = 0;
        $totalWeight = 0;
        $studentWeight = 0;

        foreach ($result->question_list as $qId) {
            $q = $questions[$qId] ?? null;
            if ($q) {
                $totalWeight += $q->weight;
                $studentAnswer = $answers[$qId] ?? null;
                if ($studentAnswer && strtoupper($studentAnswer) === strtoupper($q->answer)) {
                    $correctCount++;
                    $studentWeight += $q->weight;
                }
            }
        }

        $score = ($exam->total_questions > 0) ? ($correctCount / $exam->total_questions) * 100 : 0;
        $weightedScore = ($totalWeight > 0) ? ($studentWeight / $totalWeight) * 100 : 0;

        $result->update([
            'correct_count' => $correctCount,
            'score' => round($score, 2),
            'weighted_score' => round($weightedScore, 2),
            'status' => 'done',
            'finished_at' => now(),
        ]);

        return redirect()->route('student.exams', ['slug' => session('tenant_slug')])
                         ->with('success', 'Ujian berhasil dikirim dan selesai.');
    }
}
