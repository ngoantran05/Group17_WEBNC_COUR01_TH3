<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
<<<<<<< HEAD:app/Http/Controllers/Admin/UserController.php
use Illuminate\Support\Facades\Hash; 

class UserController extends Controller
{

    public function index()
    {
 
        $users = User::latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }


    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }


    public function update(Request $request, User $user)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,user', 
            'password' => 'nullable|string|min:8|confirmed', 
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật người dùng thành công.');
    }

    public function destroy(User $user)
    {
        if (auth()->id() == $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Bạn không thể tự xóa chính mình.');
        }

        
        $user->delete();
        
        return redirect()->route('admin.users.index')->with('success', 'Xóa người dùng thành công.');
    }
}
=======

class UserController extends Controller
{
    public function index() {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function edit($id) {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
        $data = $request->validate(['name'=>'required','email'=>'required','role'=>'required']);
        $user->update($data);
        return redirect()->route('users.index');
    }

    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index');
    }
}

>>>>>>> beb7118925419201d7995865ab9e21a0f7c66f4a:bootstrap/App/Http/Controllers/Admin/UserController.php
