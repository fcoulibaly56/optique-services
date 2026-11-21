<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $members = User::team()
            ->orderByDesc('is_active')
            ->orderBy('name')
            ->get();

        return view('superadmin.users.index', compact('members'));
    }

    public function create()
    {
        return view('superadmin.users.create', [
            'member' => new User(['role' => 'opticien', 'is_active' => true]),
        ]);
    }

    public function store(UserRequest $request)
    {
        $member = new User($request->safe()->only(['name', 'email', 'phone', 'password']));
        $member->role = $request->validated('role');   // affecté explicitement, jamais en masse
        $member->is_active = true;
        $member->email_verified_at = now();
        $member->save();

        return redirect()->route('superadmin.users.index')
            ->with('success', "Le compte de {$member->name} a été créé.");
    }

    public function edit(User $user)
    {
        $this->ensureTeamMember($user);

        return view('superadmin.users.edit', ['member' => $user]);
    }

    public function update(UserRequest $request, User $user)
    {
        $this->ensureTeamMember($user);

        $data = $request->safe()->only(['name', 'email', 'phone']);
        if ($request->filled('password')) {
            $data['password'] = $request->validated('password');
        }

        $user->fill($data);
        $user->role = $request->validated('role');
        $user->is_active = $request->boolean('is_active');
        $user->save();

        return redirect()->route('superadmin.users.index')
            ->with('success', "Le compte de {$user->name} a été mis à jour.");
    }

    public function toggleActive(User $user)
    {
        $this->ensureTeamMember($user);

        $user->is_active = ! $user->is_active;
        $user->save();

        return back()->with('success', $user->is_active
            ? "Le compte de {$user->name} est réactivé."
            : "Le compte de {$user->name} est désactivé : il ne peut plus se connecter.");
    }

    public function destroy(User $user)
    {
        $this->ensureTeamMember($user);

        if ($this->hasActivity($user)) {
            return back()->with('error', "{$user->name} a déjà saisi des commandes, rendez-vous, achats ou messages : désactivez le compte plutôt que de le supprimer.");
        }

        $name = $user->name;
        $user->delete();

        return redirect()->route('superadmin.users.index')
            ->with('success', "Le compte de {$name} a été supprimé.");
    }

    // ---------- Helpers ----------

    /** Empêche de modifier un client ou un SuperAdmin en changeant l'id dans l'URL. */
    private function ensureTeamMember(User $user): void
    {
        abort_unless(array_key_exists($user->role, User::TEAM_ROLES), 404);
    }

    private function hasActivity(User $user): bool
    {
        return DB::table('orders')->where('created_by', $user->id)->exists()
            || DB::table('appointments')->where('created_by', $user->id)->exists()
            || DB::table('purchases')->where('created_by', $user->id)->exists()
            || DB::table('order_status_history')->where('changed_by', $user->id)->exists()
            || DB::table('messages')->where('sender_user_id', $user->id)->exists();
    }
}
