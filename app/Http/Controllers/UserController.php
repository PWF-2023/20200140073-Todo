<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function index()
    {
        $search = request('search');
        if ($search) {
            $users = User::where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            })
                ->orderBy('name')
                ->where('id', '!=', '1')
                ->paginate(20)
                // ->simplePaginate(10)
                ->withQueryString();
        } else {

            $users = User::where('id', '!=', '1')
                ->orderBy('name')
                ->paginate(10);
            // ->simplePaginate(10);
            //->cursorPaginate(10);
        }
        return view('user.index', compact('users'));
    }

    public function makeadmin(User $user)
    {
        $user->timestamps = false;
        $user->is_admin = true;
        $user->save();
        //return back()->with('success', 'Make admin successfulyy!');
        return back()->with('success', $user->name . '- Make admin Successfully!');
    }

    public function removeadmin(User $user)
    {
        if ($user->id != 1) {
            $user->timestamps = false;
            $user->is_admin = false;
            $user->save();
            return back()->with('success', 'Remove admin successfully!');
        } else {
            return redirect()->route('user.index');
        }
    }

    public function destroy(User $user)
    {
        if ($user->id != 1) {
            $user->delete();
            // return back()->with('success', 'Delete user successfully!');
            return back()->with('success' . '- Delete User Successfully!');
        } else {
            return redirect()->route('user.index')->with('danger', 'Delete user failed !');
        }
    }
}
