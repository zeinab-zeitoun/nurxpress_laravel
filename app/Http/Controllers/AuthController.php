<?php

namespace App\Http\Controllers;

use App\Models\RegularUser;
use App\Models\Nurse;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Firebase\Auth\Token\Exception\InvalidToken;
use Lcobucci\JWT\Token\Plain;
use Lcobucci\JWT\Token\Parser;

class AuthController extends Controller
{

    public function login(Request $request)
    {

        // Launch Firebase Auth
        $auth = app('firebase.auth');
        // Retrieve the Firebase credential's token
        $idTokenString = $request->input('Firebasetoken');


        try { // Try to verify the Firebase credential token with Google

            $verifiedIdToken = $auth->verifyIdToken($idTokenString);
        } catch (\InvalidArgumentException $e) { // If the token has the wrong format

            return response()->json([
                'message' => 'Unauthorized - Can\'t parse the token: ' . $e->getMessage()
            ], 401);
        } catch (InvalidToken $e) { // If the token is invalid (expired ...)

            return response()->json([
                'message' => 'Unauthorized - Token is invalide: ' . $e->getMessage()
            ], 401);
        }

        // Retrieve the UID (User ID) from the verified Firebase credential's token
        $uid = $verifiedIdToken->getClaim('sub');

        // Retrieve the user model linked with the Firebase UID
        $user = User::where('UID', $uid)->first();

        // Once we got a valid user model
        // Create a Personnal Access Token
        $tokenResult = $user->createToken('Personal Access Token');

        // Store the created token
        $token = $tokenResult->token;

        // handle remember me
        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addDays(30);
        } else {
            // Add a expiration date to the token
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        // Save the token to the user
        $token->save();

        $info = '';
        // get the corresponding regular user info
        if ($user->role == "regular")
            $info = RegularUser::where('user_id', $user->id)->get()->first();
        else $info = Nurse::where('user_id', $user->id)->get()->first();

        // Return a JSON object containing the token datas
        // You may format this object to suit your needs
        return response()->json([
            'user_id' => $user->id,
            'access_token' => $tokenResult->accessToken,
            'role' => $user->role,
            'info' => $info,
        ]);
    }
    public function register(Request $request)
    {

        // validate request data
        $validatedRequest = $request->validate([
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
            'c_password' => 'same:password',
            'role' => 'required|string',
            'remember_me' => 'boolean',
            'Firebasetoken' => 'required',
        ]);

        // encrypt password
        $validatedRequest['password'] = bcrypt($validatedRequest['password']);
        //return ($validatedRequest);

        // Launch Firebase Auth
        $auth = app('firebase.auth');
        // Retrieve the Firebase credential's token
        $idTokenString = $validatedRequest['Firebasetoken'];


        try { // Try to verify the Firebase credential token with Google

            $verifiedIdToken = $auth->verifyIdToken($idTokenString);
        } catch (\InvalidArgumentException $e) { // If the token has the wrong format

            return response()->json([
                'message' => 'Unauthorized - Can\'t parse the token: ' . $e->getMessage()
            ], 401);
        } catch (InvalidToken $e) { // If the token is invalid (expired ...)

            return response()->json([
                'message' => 'Unauthorized - Token is invalide: ' . $e->getMessage()
            ], 401);
        }

        // Retrieve the UID (User ID) from the verified Firebase credential's token
        $uid = $verifiedIdToken->getClaim('sub');

        // create user object
        $user = User::create([
            'email' => $validatedRequest['email'],
            'password' => $validatedRequest['password'],
            'role' => $validatedRequest['role'],
            'remember_me' => $validatedRequest['remember_me'],
            'UID' => $uid
        ]);

        // Once we got a valid user model
        // Create a Personnal Access Token
        $tokenResult = $user->createToken('Personal Access Token');

        // Store the created token
        $token = $tokenResult->token;

        // handle remember me
        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addDays(30);
        } else {
            // Add an expiration date to the token
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        // Save the token to the user
        $token->save();

        // Return a JSON object containing the token datas
        // You may format this object to suit your needs
        return response()->json([
            'user_id' => $user->id,
            'access_token' => $tokenResult->accessToken,
            'role' => $user->role,
        ]);
    }

    public function logout(Request $request)
    {
        // get authenticated user
        $current_user = auth()->user();
        // confirm that the authentucated user is an instance of User to be able to use token() method
        if ($current_user instanceof User)
            // revoke user token
            $current_user->token()->revoke();

        return response()->json('Successfully logged out');
    }
}
