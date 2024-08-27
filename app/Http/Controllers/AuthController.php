<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * @group Authentication
 *  API Auth + Change PassWord
 *
 **/
class AuthController extends Controller
{

    /**
     * USER REGISTER
     *
     * @bodyParam name string required The name of the user. Example: Jon
     * @bodyParam surname string required The surname of the user. Example: Gates
     * @bodyParam email email required The email of the user. Example: user@example.com
     * @bodyParam phone numeric required The phone of the user. Example:+38087659800
     * @bodyParam password string required The password of the user. Example: adjan213bb134
     * @bodyParam password_confirmation string required The confirmation password. The exactly same as password. Example: adjan213bb134
     *
     * @response {
     *   "message": "User registered successfully"
     *  }
     *
     */

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'User registered successfully']);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $auth = Auth::user();

        /** @var \App\Models\User $user */
        $user = User::find($auth->getAuthIdentifier());

        $user->password = Hash::make($request->password);

        $user->save();
        $this->logout($request);
        return response()->json(['message' => "Password has been changed!"]);
    }

    /**
     * USER LOG IN
     *
     * For user who successfully registered before.
     *
     * @bodyParam email email required The email of the user. Example: user@example.com
     * @bodyParam password string required The password of the user. Example: adjan213bb134
     *
     * @response {
     *    "access_token": "3|9p3RVbiyIVMXpA49OcWWbmO5eLJ3QfKIHFR2ODeW86a8ece2",
     *    "token_type": "Bearer"
     *   }
     */

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $permissions = auth()->user()
            ->hasAnyRole(Roles::ADMIN->value, Roles::MODERATOR->value) ? ['full'] : ['read'];

        $token = auth()->user()->createToken(
            $request->device_name ?? 'api',
            $permissions,
            now()->addMinutes(240)
        );

        return response()->json(['access_token' => $token->plainTextToken, 'token_type' => 'Bearer']);
    }


    /**
     * USER LOG OUT
     *
     * The key word Bearer void and token.
     *
     * @header Authorization Bearer 3|9p3RVbiyIVMXpA49OcWWbmO5eLJ3QfKIHFR2ODeW86a8ece2
     *
     * @header Content-Type application/xml
     *
     * @response {
     *    "user": "Jon",
     *    "surname": "Gates",
     *    "message": "Logged out successfully"
     *   }
     */

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['user'=>$request->user()->name, 'surname'=>$request->user()->surname, 'message' => "Logged out successfully"]);
    }
}
