<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Logout the user and redirect to the homepage.
     */
    public function logout()
    {
        Auth::logout(); // Déconnecte l'utilisateur
        return redirect('home'); // Redirige vers la page d'accueil
    }
}

