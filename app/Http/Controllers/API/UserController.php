<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends Controller
{
    //default success response status
    public $successStatus = 200;

    /**
     * Login api
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        if (Auth::attempt(['phone' => request('phone'), 'password' => request('password')]))
        {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            return response()->json(['success' => $success], $this->successStatus);
        } else
        {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    /**
     * Register Api
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required',
            'email'      => 'required|email',
            'phone'      => 'required|regex:/(01)[0-9]{9}/',
            'password'   => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails())
        {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        //Creating a random verification number
        $verification = rand(1000, 9999);

        //Creating the user data
        $user = User::create([
            'name'         => $input['name'],
            'email'        => $input['email'],
            'phone'        => $input['phone'],
            'password'     => $input['password'],
            'verification' => $verification,
        ]);

        if ($user)
        {
            //Sending SMS via Nexmo
            $basic = new \Nexmo\Client\Credentials\Basic(env('NEXMO_KEY'), env('NEXMO_SECRET'));
            $client = new \Nexmo\Client($basic);

            $message = $client->message()->send([
                'to'   => '2' . $input['phone'],
                'from' => 'My PHP Task App',
                'text' => 'Your phone verification number is: ' . $verification . ' .Please verify at task.build/api/verify'
            ]);
        }

        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;
        return response()->json(['success' => $success], $this->successStatus);
    }

    /**
     * Details api
     * @return \Illuminate\Http\JsonResponse
     */
    public function details()
    {
        //Get the user data
        $user = Auth::user();

        //Check if the user already verified or not
        if ($user['is_verified'] == 0)
        {
            return response()->json([
                'success' => $user,
                'info'    => 'Your phone number is not verified yet. Please visit "task.build/api/verify" to verify. ',
            ], $this->successStatus);
        } else
        {
            return response()->json(['success' => $user], $this->successStatus);
        }

    }

    /**
     * Verify users phone number
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request)
    {
        $user = Auth::user();

        //Check if the user already verified or not
        if ($user['is_verified'] == 1)
        {
            return response()->json(['error' => 'Your phone number is already verified.'], 401);
        } else
        {
            $validator = Validator::make($request->all(), [
                'v_code' => 'required|regex:/[0-9]{4}/'
            ]);

            if ($validator->fails())
            {
                return response()->json(['error' => $validator->errors()], 400);
            }

            if ($user['verification'] != null)
            {
                //Check if the verification code matches
                if ($request['v_code'] == $user['verification'])
                {
                    $user->update([
                        'verification' => 'verified',
                        'is_verified'  => 1
                    ]);
                } else
                {
                    return response()->json(['error' => 'Verification code doesn\'t match.'], 400);
                }
            }

            return response()->json(['success' => 'Your phone number verified successfully.'], $this->successStatus);
        }
    }

    /**
     * Logout User
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(){
        $user = Auth::user()->token();
        $user->revoke();
        return response()->json(['success'=>'You are now logged out.'],$this->successStatus);
    }

}
