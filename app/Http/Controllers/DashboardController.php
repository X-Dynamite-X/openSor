<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = User::query()
                ->whereDoesntHave('roles', function ($q) {
                    $q->where('name', 'admin');
                });

            if ($request->has('search')) {
                $searchTerm = $request->search;
                $query->whereAny(['name', 'email'], 'like', "%{$searchTerm}%");
            }

            // إذا كان الطلب للحصول على مستخدم جديد بعد الحذف
            if ($request->get('get_next_user')) {
                $currentPage = $request->get('current_page', 1);
                $offset = ($currentPage * 10); // نحسب الـ offset بناءً على الصفحة الحالية

                $nextUser = $query->skip($offset - 1)->first();

                if ($nextUser) {
                    return response()->json([
                        'success' => true,
                        'new_user_html' => view('partials.users.user-row', ['user' => $nextUser])->render()
                    ]);
                }

                return response()->json(['success' => true]);
            }

            $users = $query->with([
                'roles:id,name',
                'permissions:id,name'
            ])
                ->select(['id', 'name', 'email', 'created_at'])
                ->paginate(10);

            if ($request->has('search')) {
                return response()->json([
                    'html' => view('partials.users.users-table', ['users' => $users])->render(),
                    'pagination' => view('partials.users.pagination', ['users' => $users])->render()
                ]);
            }

            return view('partials.users.users-table', ['users' => $users]);
        }

        // للطلبات غير Ajax
        $users = User::whereDoesntHave('roles', function ($q) {
            $q->where('name', 'admin');
        })
            ->with([
                'roles:id,name',
                'permissions:name'
            ])
            ->select(['id', 'name', 'email', 'created_at'])
            ->paginate(10);

        return view('admin.users', ['users' => $users]);
    }
    public function store(Request $request)
    {
        
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
                'is_active' => 'required|in:active,not_active',
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
            ]);

            // Set permissions based on active status

            $user->givePermissionTo($validated['is_active']);



            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'user' => $user,
                    'message' => 'User added successfully'
                ]);
            }

            return redirect()->back()->with('success', 'User added successfully');

    }
    public function update(Request $request, User $user)
    {
        $validated = $request->validate(rules: [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);
        $user->syncPermissions($request->is_active);
        $user->update($validated);
        $user->save();
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'user' => $user
            ]);
        }

        return redirect()->back()->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true
            ]);
        }

        return redirect()->back()->with('success', 'User deleted successfully');
    }
}
