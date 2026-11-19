<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ClientAuthController extends Controller
{
    public function showPhoneLogin()
    {
        return view('auth.login-phone');
    }

        public function sendCode(Request $request)
    {
        $phone = preg_replace('/[^0-9]/', '', $request->phone);

        if (strlen($phone) < 8) {
            return back()->withErrors(['phone' => 'Le numéro doit contenir au moins 8 chiffres.'])->withInput();
        }

        try {
            // 1. Création ou récupération de l'utilisateur
            $user = User::firstOrCreate(
                ['phone' => $phone],
                [
                    'name' => 'Client ' . substr($phone, -4),
                    'email' => $phone . '@optique.local',
                    'password' => bcrypt(Str::random(16)),
                    'role' => 'client'
                ]
            );

                       // 2. Création du profil client
            $user->customer()->firstOrCreate(
                ['user_id' => $user->id],
                [
                    'first_name' => 'Client',
                    'last_name'  => substr($phone, -4),
                    'phone'      => $phone,
                    'email'      => $user->email,
                    'contact_preference' => 'whatsapp',
                ]
            );

            // 3. Code OTP
            $otp = rand(100000, 999999);
            Session::put('otp_code', $otp);
            Session::put('otp_phone', $phone);

            return redirect()->route('login.phone.verify')->with('otp_debug', $otp);

        } catch (\Exception $e) {
            return back()->withErrors(['phone' => 'Erreur base de données : ' . $e->getMessage()])->withInput();
        }
    }

    public function showVerify()
    {
        if (!Session::has('otp_phone')) {
            return redirect()->route('login.phone')->withErrors(['phone' => 'Veuillez entrer votre numéro.']);
        }
        return view('auth.login-verify');
    }

    public function verifyCode(Request $request)
    {
        $request->validate(['code' => 'required|numeric']);

        if ($request->code == Session::get('otp_code')) {
            $user = User::where('phone', Session::get('otp_phone'))->first();

            if ($user) {
                Auth::login($user);
                Session::forget(['otp_code', 'otp_phone']);
                return redirect()->route('client.dashboard');
            }
        }

        return back()->withErrors(['code' => 'Le code est incorrect.']);
    }
}
