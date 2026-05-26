<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LearningHome;
use Illuminate\Http\Request;

class LearningHomeController extends Controller
{
    public function index()
    {
        $learningHomes = LearningHome::withCount('teachingSchedules')->latest()->paginate(15);
        return view('admin.learning_homes', compact('learningHomes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'pic_name' => ['required', 'string', 'max:255'],
            'contact_number' => ['required', 'string', 'max:20'],
            'student_count' => ['required', 'integer', 'min:0'],
        ]);

        LearningHome::create($request->only(['name', 'address', 'pic_name', 'contact_number', 'student_count']));

        \App\Models\ActivityLog::record('CREATE_LEARNING_HOME', "Menambahkan rumah belajar baru: {$request->name}");

        return redirect()->route('admin.learning-homes')->with('success', 'Rumah belajar berhasil ditambahkan.');
    }

    public function update(Request $request, LearningHome $learningHome)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'pic_name' => ['required', 'string', 'max:255'],
            'contact_number' => ['required', 'string', 'max:20'],
            'student_count' => ['required', 'integer', 'min:0'],
        ]);

        $learningHome->update($request->only(['name', 'address', 'pic_name', 'contact_number', 'student_count']));

        \App\Models\ActivityLog::record('UPDATE_LEARNING_HOME', "Memperbarui data rumah belajar: {$learningHome->name}");

        return redirect()->route('admin.learning-homes')->with('success', 'Rumah belajar berhasil diperbarui.');
    }

    public function destroy(LearningHome $learningHome)
    {
        $name = $learningHome->name;
        $learningHome->delete();
        
        \App\Models\ActivityLog::record('DELETE_LEARNING_HOME', "Menghapus rumah belajar: {$name}");

        return redirect()->route('admin.learning-homes')->with('success', 'Rumah belajar berhasil dihapus.');
    }
}
