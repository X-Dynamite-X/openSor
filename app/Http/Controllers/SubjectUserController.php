<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectUserController extends Controller
{
    public function getSubjectUsers(Subject $subject, Request $request)
    {
        try {
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

            return response()->json([
                'success' => true,
                'users' => $users ,
                'pagination' => view('partials.users.pagination', ['users' => $users])->render()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading users: ' . $e->getMessage()
            ], 500);
        }
    }
}
