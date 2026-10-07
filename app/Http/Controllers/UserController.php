<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function adminIndex()
    {
        // Solo el admin puede ver esto
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        // LIMPIEZA: Si hay usuarios con el mismo nombre repetido, borrar los extras
        $duplicateNames = User::select('user_name')
            ->groupBy('user_name')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('user_name');

        foreach ($duplicateNames as $name) {
            $usersToKeep = User::where('user_name', $name)->orderBy('id', 'asc')->get();
            $first = $usersToKeep->shift(); // Quedarse con el primero
            foreach ($usersToKeep as $extra) {
                $extra->delete(); // Borrar los demás
            }
        }

        $users = User::with('person')->orderBy('created_at', 'desc')->get();
        return view('admin.users', compact('users'));
    }

    public function toggleAdmin(User $user)
    {
        // Evitar quitarse el admin a uno mismo
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'No puedes quitarte el permiso de administrador a ti mismo.');
        }

        $user->is_admin = !$user->is_admin;
        $user->save();

        return redirect()->back()->with('success', 'Rol de usuario actualizado correctamente.');
    }

    public function resetPassword(User $user)
    {
        $user->password = Hash::make('1234');
        $user->save();

        return redirect()->back()->with('success', 'Contraseña restablecida a "1234" para el usuario ' . $user->user_name);
    }
}
