<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $user = Auth::guard('api')->user();
        if ($user)
            return $this->sendResponse($user, 'User retrieved successfully');

        return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $storeData = $request->all();
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => 'required',
            'address' => 'required',
            'telephone' => 'required|numeric',
            'dob' => 'required|date_format:Y-m-d|before:today'
        ]);
        if($validator->fails())
            return $this->sendError('Validation error', $validator->errors());

        $storeData['password'] = bcrypt($storeData['password']);
        $storeData['activation_token'] = Str::random(30);

        $user = User::create($storeData);

        return $this->sendResponse($user, 'User registered');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        $user = User::find($id);

        if ($user)
            return $this->sendResponse($user, 'User retrieved successfully');

        return $this->sendError("User not found");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id)
    {
        $user = User::find($id);

        if (is_null($user))
            return $this->sendError('User not found');

        $storeData = $request->all();
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'address' => 'required',
            'telephone' => 'required|numeric',
            'dob' => 'required|date_format:Y-m-d|before:today'
        ]);
        if($validator->fails())
            return $this->sendError('Validation error', $validator->errors());

        $user->name = $storeData['name'];
        $user->address = $storeData['address'];
        $user->telephone = $storeData['telephone'];
        $user->dob = $storeData['dob'];

        $user->save();

        return $this->sendResponse($user, 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        $user = User::find($id);

        if (is_null($user))
            return $this->sendError('User not found');

        $user->delete();

        return $this->sendResponse(null, 'User deleted successfully.');
    }

    public function verify(string $token)
    {
        $user = User::where('activation_token', $token)->first();

        if (is_null($user))
            return $this->sendError('User not found');

        $user->is_active = true;
        $user->save();

        return $this->sendResponse(null, 'User verified successfully.');
    }

    public function login(Request $request)
    {
        $storeData = $request->all();
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:rfc,dns',
            'password' => 'required',
        ]);
        if($validator->fails())
            return $this->sendError('Validation error', $validator->errors());

        if (Auth::attempt(['email' => $storeData['email'], 'password' => $storeData['password']])) {
            $user = Auth::user();

            if (!$user->is_active) {
                return $this->sendError('Email not verified yet');
            }

            $success['user'] = $user;
            $success['token'] = $user->createToken('alamart')->accessToken;

            return $this->sendResponse($success, 'User login success');
        }
        return $this->sendError('Unauthorised');
    }
}
