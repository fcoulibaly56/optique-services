<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customer;
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

        // 1. Sécurité : On bloque si c'est un membre de l'équipe
        if (User::where('phone', $phone)->where('role', '!=', 'client')->exists()) {
            return back()->withErrors(['phone' => "Ce numéro est réservé à l'équipe."])->withInput();
        }

        // 2. On vérifie si le client existe déjà dans la base
        $customer = Customer::where('phone', $phone)->first();

        if (!$customer) {
            return back()->withErrors(['phone' => "Aucun compte client trouvé avec ce numéro. Veuillez passer en boutique pour créer votre fiche."])->withInput();
        }

        // 3. Si la fiche client existe mais n'a pas de compte User (ex: import Excel ou RDV public)
        // On lui crée son compte User automatiquement et on le lie.
        $user = User::where('phone', $phone)->first();
        if (!$user) {
            $user = User::create([
                'name' => $customer->first_name . ' ' . $customer->last_name,
                'phone' => $phone,
                'email' => $customer->email ?? $phone . '@optique.local',
                'password' => bcrypt(Str::random(16)),
                'role' => 'client'
            ]);
            $customer->update(['user_id' => $user->id]);
        }

        // 4. Code OTP
        $otp = rand(100000, 999999);
        Session::put('otp_code', $otp);
        Session::put('otp_phone', $phone);

        return redirect()->route('login.phone.verify')->with('otp_debug', $otp);
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
            $user = User::where('phone', Session::get('otp_phone'))->where('role', 'client')->first();

            if ($user) {
                Auth::login($user);
                Session::forget(['otp_code', 'otp_phone']);
                return redirect()->route('client.dashboard');
            }
        }

        return back()->withErrors(['code' => 'Le code est incorrect.']);
    }
}
