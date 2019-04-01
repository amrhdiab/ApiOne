<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('admin.users.index');
    }

    public function fetchData()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        foreach ($users as $user)
        {
            if ($user['is_verified'] == 1)
            {
                $user['is_verified'] = '<label class="label label-success">Verified</label>';
            } else
            {
                $user['is_verified'] = '<label class="label label-warning">Not Verified</label>';
            }
        }
        return DataTables::of($users)->addColumn('actions', function ($user)
        {
            return '<button class="btn btn-xs btn-default view" id="' . $user->id . '"><i class="glyphicon glyphicon-eye-open"></i> View</button>
            <button class="btn btn-xs btn-primary edit" id="' . $user->id . '"><i class="glyphicon glyphicon-edit"></i> Edit</button>
            <button class="btn btn-xs btn-danger delete" id="' . $user->id . '"><i class="glyphicon glyphicon-trash"></i> Delete</button>';
        })
            ->addColumn('checkboxes', '<input type="checkbox" name="user_checkbox[]" class="user_checkbox"  value="{{$id}}" />')
            ->rawColumns(['actions', 'checkboxes', 'is_verified'])->make(true);
    }

    public function fetch_single(Request $request)
    {
        $user = User::find($request['id']);
        return response()->json($user);
    }


    public function store(Request $request)
    {
        $errors_output = [];
        $success_output = '';

        if ($request['form_action'] == 'insert')
        {
            $validator = Validator::make($request->all(), [
                'name'       => 'required',
                'email'      => 'required|email',
                'phone'      => 'required|regex:/(01)[0-9]{9}/',
                'password'   => 'required|string|min:6',
                'c_password' => 'required|same:password',
            ]);

            if ($validator->fails())
            {
                foreach ($validator->messages()->getMessages() as $field_name => $messages)
                {
                    $errors_output[] = $messages[0];
                }
            } else
            {
                //Creating a random verification number
                $verification = rand(1000, 9999);

                //Sending SMS via Nexmo
                $basic = new \Nexmo\Client\Credentials\Basic('0aa32b60', '8SO52s8TMUX31NCa');
                $client = new \Nexmo\Client($basic);

                $message = $client->message()->send([
                    'to'   => '2' . $request['phone'],
                    'from' => 'My PHP Task App',
                    'text' => 'Your phone verification number is: ' . $verification . ' .Please verify at task.build/api/verify'
                ]);

                User::create([
                    'name'     => $request['name'],
                    'email'    => $request['email'],
                    'phone'    => $request['phone'],
                    'password' => bcrypt($request['password']),
                    'verification' => $verification,
                ]);
                $success_output = "<div class='alert alert-success'>Created new user successfully.</div>";
            }
        } elseif ($request['form_action'] == 'update')
        {
            $validator = Validator::make($request->all(), [
                'name'       => 'required',
                'email'      => 'required|email',
                'phone'      => 'required|regex:/(01)[0-9]{9}/',
            ]);
            if ($validator->fails())
            {
                foreach ($validator->messages()->getMessages() as $field_name => $messages)
                {
                    $errors_output[] = $messages[0];
                }
            } else
            {
                $user = User::find($request['user_id']);
                $user->update([
                    'name'     => $request['name'],
                    'email'    => $request['email'],
                    'phone'    => $request['phone'],
                    'password' => $user['password'],
                ]);
                $success_output = "<div class='alert alert-success'>Updated user successfully.</div>";

            }
        }
        $output = [
            'error'   => $errors_output,
            'success' => $success_output,
        ];

        return response()->json($output);
    }


    public function view(Request $request)
    {
        $user = User::find($request['id']);
        if ($user['is_verified'] == 1){
            $user['is_verified'] = '<label class="label label-success">Verified</label>';
        }else{
            $user['is_verified'] = '<label class="label label-warning">Not Verified</label>';
        }
        $data = '
                  <td>'.$user->name.'</td>
                  <td>'.$user->email.'</td>
                  <td>'.$user->phone.'</td>
                  <td>'.$user->is_verified.'</td>
        ';
        return response()->json($data);
    }


    public function removeData(Request $request)
    {
        $user = User::find($request['id']);

        if ($user->delete())
        {
            return response()->json('Successfully deleted.');
        }else{
            return response()->json(['error' => 'Can not delete the user.'], 401);
        }
    }

    public function removeBulk(Request $request)
    {
        $user_id_array = $request['id'];
        foreach ($user_id_array as $user_id)
        {
            $user = User::find($user_id)->delete();
        }
        return response()->json('Data deleted successfully.');
    }
}
