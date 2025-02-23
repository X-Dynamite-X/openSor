<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectUserController extends Controller
{
    public function getSubjectUsers(Subject $subject, Request $request)
    {
        $query = $subject->users();

            if ($request->filled('search')) {
                $searchTerm = $request->search;
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('name', 'like', "%{$searchTerm}%")
                        ->orWhere('email', 'like', "%{$searchTerm}%");
                });
            }

            $users = $query->select('users.*', 'subject_users.mark')
                ->paginate(10);

                if ($users->isEmpty() && $request->filled('search')) {
                    return response()->json([
                        'success' => true,
                        'data' => [
                            'users' => [],
                            'pagination' => '',
                            'html' => view('partials.subjects.empty-search-results')->render()
                        ]
                    ]);
                }

            return response()->json([
                'success' => true,
                'data' => [
                    'users' => $users->items(),
                    'pagination' => view('partials.subjects.users.pagination_subject_user', ['paginator' => $users])->render(),
                    'html' => view('partials.subjects.users.subject-users-table', compact('users'))->render()

                ]
            ]);

    }
    public function updateMark(Request $request, Subject $subject, $userId)
    {
        $validated = $request->validate([
            'mark' => 'required|numeric|min:0|max:100',
        ]);

        $subject->users()->updateExistingPivot($userId, ['mark' => $validated['mark']]);

        return response()->json([
            'success' => true,
            'message' => 'Mark updated successfully',
        ]);
    }
    public function removeUser(Subject $subject, $userId)
    {
        $subject->users()->detach($userId);

        return response()->json([
            'success' => true,
            'message' => 'User removed successfully',
        ]);
    }





}
