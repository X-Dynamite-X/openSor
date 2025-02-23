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
                    'pagination' => view('partials.subjects.pagination_subject_user', ['paginator' => $users])->render(),
                    'html' => view('partials.subjects.subject-users-table', compact('users'))->render()

                ]
            ]);

    }
    // public function getSubjectUsers(Subject $subject, Request $request)
    // {
    //     try {
    //         $query = $subject->users();

    //         if ($request->filled('search')) {
    //             $searchTerm = $request->search;
    //             $query->where(function ($q) use ($searchTerm) {
    //                 $q->where('name', 'like', "%{$searchTerm}%")
    //                     ->orWhere('email', 'like', "%{$searchTerm}%");
    //             });
    //         }

    //         $users = $query->select('users.*', 'subject_user.mark')
    //                       ->paginate(10);

            // if ($users->isEmpty() && $request->filled('search')) {
            //     return response()->json([
            //         'success' => true,
            //         'data' => [
            //             'users' => [],
            //             'pagination' => '',
            //             'html' => view('partials.subjects.empty-search-results')->render()
            //         ]
            //     ]);
            // }

    //         return response()->json([
    //             'success' => true,
    //             'data' => [
    //                 'users' => $users->items(),
    //                 'pagination' => view('partials.users.pagination', ['paginator' => $users])->render(),
    //                 'html' => view('partials.subjects.subject-users-table', compact('users'))->render()
    //             ]
    //         ]);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Error loading users: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

}
