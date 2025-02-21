<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('dashboard', compact('users'));
    }

    public function getUsers(Request $request)
    {
        $search = $request->search ?? '';

        $users = User::where(function($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        })->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.users-table', compact('users'))->render(),
                'pagination' => view('partials.pagination', compact('users'))->render(),
                'users' => $users->items() // إضافة بيانات المستخدمين الكاملة
            ]);
        }

        return view('dashboard', compact('users'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate(rules: [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

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
