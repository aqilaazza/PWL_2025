<?php
namespace App\Http\Controllers;
use App\Models\UserModel;
use App\Models\LevelModel;
use Laravolt\Avatar\Avatar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = UserModel::with('level')->find(Auth::id());
        if (!$user->avatar) {
            $avatar = new Avatar();
            $filename = md5($user->username) . '.png';
            $path = 'avatars/' . $filename;
            $fullPath = public_path($path);
            if (!file_exists(public_path('avatars'))) {
                mkdir(public_path('avatars'), 0755, true);
            }
            $avatar->create($user->nama)
                ->setDimension(209)
                ->setFontSize(100)
                ->save($fullPath);
            $user->update(['avatar' => $path]);
            $user->refresh();
        }
        $breadcrumb = (object) [
            'title' => 'Profile Setting',
            'list' => ['Home', 'User', 'Profile Setting'],
        ];
        $page = (object) [
            'title' => 'Profile Setting',
        ];
        $activeMenu = 'profile';

        return view('profile.index', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'page' => $page, 'user' => $user]);
    }

    public function update(Request $request)
    {
        $id = Auth::id();
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
            'nama' => 'required|string|max:100',
        ]);

        UserModel::find($id)->update([
            'username' => $request->username,
            'nama' => $request->nama,

        ]);
        return redirect('/profile')->with('success', 'Data user berhasil diubah');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        $user = UserModel::find(Auth::id());

        if ($request->hasFile('avatar')) {
            if ($user->avatar && file_exists(public_path($user->avatar))) {
                unlink(public_path($user->avatar));
            }

            $filename = md5($user->username) . '.' . $request->avatar->extension();
            $path = 'avatars/' . $filename;
            $request->avatar->move(public_path('avatars'), $filename);
            $user->update(['avatar' => $path]);
            return redirect('/profile')->with('success', 'Avatar berhasil diubah');
        }
        return redirect('/profile')->with('error', 'Avatar gagal diubah');
    }
}