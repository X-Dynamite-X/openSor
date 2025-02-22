<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Subject::query();

            if ($request->has('search')) {
                $searchTerm = $request->search;

                $query->whereAny(['name'],'like', "%{$searchTerm}%");
            }

            // إذا كان الطلب للحصول على مستخدم جديد بعد الحذف
            if ($request->get('get_next_subject')) {
                $currentPage = $request->get('current_page', 1);
                $offset = ($currentPage * 10); // نحسب الـ offset بناءً على الصفحة الحالية

                $nextSubject = $query->skip($offset - 1)->first();

                if ($nextSubject) {
                    return response()->json([
                        'success' => true,
                        'new_subject_html' => view('partials.subjects.subject-row', ['subject' => $nextSubject])->render()
                    ]);
                }

                return response()->json(['success' => true]);
            }

            $subjects = $query->paginate(10);

            if ($request->has('search')) {
                return response()->json([
                    'html' => view('partials.subjects.subjects-table', ['subjects' => $subjects])->render(),
                    'pagination' => view('partials.subjects.pagination', ['subjects' => $subjects])->render()
                ]);
            }

            return view('partials.subjects.subjects-table', ['subjects' => $subjects]);
        }

        $subjects = Subject::paginate(10);
        return view('admin.subject', ['subjects' => $subjects]);
    }

    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate(rules: [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $subject->id,
        ]);

        $subject->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'subject' => $subject
            ]);
        }

        return redirect()->back()->with('success', 'Subject updated successfully');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true
            ]);
        }

        return redirect()->back()->with('success', 'Subject deleted successfully');
    }

}
