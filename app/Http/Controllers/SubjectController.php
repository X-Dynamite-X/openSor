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
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:subjects,name,' . $subject->id,
                'mark' => 'required|numeric|min:0|max:100'
            ]);

            $subject->update($validated);
            $subject->refresh();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'subject' => $subject,
                    'message' => 'Subject updated successfully'
                ]);
            }

            return redirect()->back()->with('success', 'Subject updated successfully');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error updating subject: ' . $e->getMessage()
                ], 422);
            }

            return redirect()->back()
                ->withErrors(['error' => 'Error updating subject'])
                ->withInput();
        }
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

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:subjects,name',
                'mark' => 'required|numeric|min:0|max:100'
            ]);

            $subject = Subject::create($validated);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'subject' => $subject,
                    'message' => 'Subject added successfully'
                ]);
            }

            return redirect()->back()->with('success', 'Subject added successfully');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error adding subject: ' . $e->getMessage()
                ], 422);
            }

            return redirect()->back()
                ->withErrors(['error' => 'Error adding subject'])
                ->withInput();
        }
    }

}
