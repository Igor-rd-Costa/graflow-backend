<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

final class AuthController extends Controller
{

  public function user(Request $request)
  {
    $user = Auth::user();
    if ($user == null) {
      return response(null, 401);
    }
    return response($user);
  }

  public function login(Request $request)
  {
    $credentials = $request->validate([
      'username' => ['required'],
      'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
      $request->session()->regenerate();
      return response(Auth::user(), 200);
    }
    return response(null, 401);
  }

  public function register(Request $request)
  {
    $credentials = $request->validate([
      'username' => ['required', 'string', 'unique:users,username'],
      'email' => ['required', 'email', 'unique:users,email'],
      'password' => ['required'],
    ]);

    $user = User::create($credentials);
    Auth::login($user);
    $request->session()->regenerate();
    return response($user, 201);
  }

  public function logout()
  {
    $user = Auth::user();
    if ($user != null) {
      Auth::logout();
      return response("");
    }
    return response("", 401);
  }
  
}