<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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


    public function getAvailableUsers(Subject $subject, Request $request)
    {

            $query = User::query()
                ->whereDoesntHave('subjects', function ($query) use ($subject) {
                    $query->where('subjects.id', $subject->id); // تحديد الجدول بوضوح
                })
                ->whereDoesntHave('roles', function ($query) {
                    $query->where('roles.name', 'admin'); // تحديد الجدول بوضوح
                });

            if ($request->filled('search')) {
                $searchTerm = $request->search;
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('users.name', 'like', "%{$searchTerm}%")  // تحديد الجدول بوضوح
                        ->orWhere('users.email', 'like', "%{$searchTerm}%"); // تحديد الجدول بوضوح
                });
            }

            $users = $query->select(['users.id', 'users.name', 'users.email']) // تحديد الجدول بوضوح
                ->withCount(['permissions as is_active' => function ($query) {
                    $query->where('permissions.name', 'active'); // تحديد الجدول بوضوح
                }])
                ->paginate(10);

            $users->getCollection()->transform(function ($user) {
                $user->is_active = $user->is_active > 0;
                return $user;
            });

            return response()->json([
                'users' => $users->items(),
                'pagination' => view('components.pagination', ['paginator' => $users])->render()
            ]);

       
    }

    /**
     * Add multiple users to a subject
     */
    public function addUsers(Subject $subject, Request $request)
    {
        try {
            $validated = $request->validate([
                'user_ids' => 'required|array',
                'user_ids.*' => 'exists:users,id'
            ]);

            DB::beginTransaction();

            foreach ($validated['user_ids'] as $userId) {
                // التحقق من أن المستخدم ليس لديه المادة بالفعل
                if (!$subject->users()->where('user_id', $userId)->exists()) {
                    $subject->users()->attach($userId, [
                        'mark' => 0, // علامة افتراضية
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Users added successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to add users to subject'
            ], 500);
        }
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
