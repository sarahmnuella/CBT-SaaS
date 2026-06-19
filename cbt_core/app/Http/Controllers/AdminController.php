<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Major;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\User;
use App\Models\Tenant;

class AdminController extends Controller
{
    public function dashboard($slug)
    {
        $tenant = Tenant::where('slug', $slug)->firstOrFail();
        
        $stats = [
            'majors' => Major::count(),
            'classes' => SchoolClass::count(),
            'subjects' => Subject::count(),
            'teachers' => Teacher::count(),
            'students' => Student::count(),
            'max_students' => $tenant->max_students,
            'max_teachers' => $tenant->max_teachers,
        ];

        return view('admin.dashboard', compact('stats', 'tenant'));
    }

    // ==========================================
    // JURUSAN (MAJORS) CRUD
    // ==========================================
    public function majors($slug)
    {
        $majors = Major::latest()->get();
        return view('admin.majors', compact('majors'));
    }

    public function storeMajor(Request $request, $slug)
    {
        $request->validate(['name' => 'required|string|max:100']);
        Major::create(['name' => $request->name]);
        return back()->with('success', 'Jurusan berhasil ditambahkan.');
    }

    public function deleteMajor($slug, $id)
    {
        Major::findOrFail($id)->delete();
        return back()->with('success', 'Jurusan berhasil dihapus.');
    }

    // ==========================================
    // KELAS (CLASSES) CRUD
    // ==========================================
    public function classes($slug)
    {
        $classes = SchoolClass::with('major')->latest()->get();
        $majors = Major::all();
        return view('admin.classes', compact('classes', 'majors'));
    }

    public function storeClass(Request $request, $slug)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'major_id' => 'nullable|exists:majors,id',
        ]);
        SchoolClass::create([
            'name' => $request->name,
            'major_id' => $request->major_id,
        ]);
        return back()->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function deleteClass($slug, $id)
    {
        SchoolClass::findOrFail($id)->delete();
        return back()->with('success', 'Kelas berhasil dihapus.');
    }

    // ==========================================
    // MATAPELAJARAN (SUBJECTS) CRUD
    // ==========================================
    public function subjects($slug)
    {
        $subjects = Subject::latest()->get();
        return view('admin.subjects', compact('subjects'));
    }

    public function storeSubject(Request $request, $slug)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'nullable|string|max:20',
        ]);
        Subject::create([
            'name' => $request->name,
            'code' => $request->code,
        ]);
        return back()->with('success', 'Mata Pelajaran berhasil ditambahkan.');
    }

    public function deleteSubject($slug, $id)
    {
        Subject::findOrFail($id)->delete();
        return back()->with('success', 'Mata Pelajaran berhasil dihapus.');
    }

    // ==========================================
    // GURU (TEACHERS) CRUD WITH SAAS LIMIT VALIDATION
    // ==========================================
    public function teachers($slug)
    {
        $teachers = Teacher::with('user')->latest()->get();
        return view('admin.teachers', compact('teachers'));
    }

    public function storeTeacher(Request $request, $slug)
    {
        $tenant = Tenant::where('slug', $slug)->firstOrFail();
        
        // Check teacher limits
        if (Teacher::count() >= $tenant->max_teachers) {
            return back()->withErrors(['error' => 'Kuota guru Anda telah mencapai batas maksimal paket (' . $tenant->max_teachers . ' Guru). Harap upgrade paket Anda.']);
        }

        $request->validate([
            'name' => 'required|string|max:100',
            'nip' => 'nullable|string|max:30|unique:teachers,nip,NULL,id,tenant_id,' . $tenant->id,
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone' => 'nullable|string|max:20',
        ]);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'teacher',
            'tenant_id' => $tenant->id,
        ]);

        // Create teacher profile
        Teacher::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'nip' => $request->nip,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return back()->with('success', 'Guru berhasil ditambahkan.');
    }

    public function deleteTeacher($slug, $id)
    {
        $teacher = Teacher::findOrFail($id);
        if ($teacher->user) {
            $teacher->user->delete();
        }
        $teacher->delete();
        return back()->with('success', 'Guru berhasil dihapus.');
    }

    // ==========================================
    // SISWA (STUDENTS) CRUD WITH SAAS LIMIT VALIDATION
    // ==========================================
    public function students($slug)
    {
        $students = Student::with(['user', 'class'])->latest()->get();
        $classes = SchoolClass::all();
        return view('admin.students', compact('students', 'classes'));
    }

    public function storeStudent(Request $request, $slug)
    {
        $tenant = Tenant::where('slug', $slug)->firstOrFail();

        // Check student limits
        if (Student::count() >= $tenant->max_students) {
            return back()->withErrors(['error' => 'Kuota siswa Anda telah mencapai batas maksimal paket (' . $tenant->max_students . ' Siswa). Harap upgrade paket Anda.']);
        }

        $request->validate([
            'name' => 'required|string|max:100',
            'nisn' => 'nullable|string|max:30|unique:students,nisn,NULL,id,tenant_id,' . $tenant->id,
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'class_id' => 'required|exists:classes,id',
            'gender' => 'required|in:L,P',
        ]);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'student',
            'tenant_id' => $tenant->id,
        ]);

        // Create student profile
        Student::create([
            'user_id' => $user->id,
            'class_id' => $request->class_id,
            'name' => $request->name,
            'nisn' => $request->nisn,
            'email' => $request->email,
            'gender' => $request->gender,
        ]);

        return back()->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function deleteStudent($slug, $id)
    {
        $student = Student::findOrFail($id);
        if ($student->user) {
            $student->user->delete();
        }
        $student->delete();
        return back()->with('success', 'Siswa berhasil dihapus.');
    }
}
