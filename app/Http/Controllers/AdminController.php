<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use File;
use App\User;
use DB;
use App\Mail\NewAdminVarification;
use Illuminate\Support\Facades\Mail;


class AdminController extends Controller {

    public function __construct() {
        $this->middleware(['auth', 'lock']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('admin.profile')
                        ->with('title', 'User Profile');
    }
    
    public function profilePost(Request $request) {
        $user_id = Auth::user()->id;
        $input = [];
        $input['first_name']     = $request->input('firstName');
        $input['last_name']      = $request->input('lastName');
        $input['mobile']         = $request->input('mobileNumber');
        $input['email']          = $request->input('email');
        $input['note']           = $request->input('note');
        DB::table('admin')->where('id',$user_id)->update($input);
        return Response::json(array('success' => true), 200);
    }
    
    public function addprofilepic(Request $request) {
        
        $rules = array(
             'profile_pic' => 'required|max:5000|mimes: png,jpg,jpeg,JPG,JPEG,gif,bmp'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Response::json(array(
                        'success' => false,
                        'errors' => $validator->getMessageBag()->toArray()
                            ), 200); // 400 being the HTTP code for an invalid request.
        }
        
        $upload_file = 'profile_pic';
        $request->file($upload_file)->getClientOriginalExtension();
        if ($request->hasFile($upload_file)) {
            $extension = $request->file($upload_file)->getClientOriginalExtension();
            $new_name = md5(microtime(true));
            $new_name_lower_case_with_ext = strtolower("$new_name.$extension");
            $year = date('Y');
            $month = strtolower(date('F'));
            $day = date('d');
            $file_path = "/uploads/$year/$month/$day/";
            $upload_path = base_path() . $file_path;
            $temp_file = $upload_path . $new_name_lower_case_with_ext;
            $request->file($upload_file)->move($upload_path, $new_name_lower_case_with_ext);
        } else {
            $new_name_lower_case_with_ext = '';
        }
        $img_save = $file_path . $new_name_lower_case_with_ext;
        User::where('id', Auth::user()->id)
                ->update(['profile_pic' => $img_save]);
        return Response::json(array('success' => true,'path'=> $img_save), 200); // 400 being the HTTP code for an invalid request.
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request) {
        $rules = array('password' => 'required|confirmed',
                       'password_confirmation' =>'required');
        $validator = Validator::make($request->all(), $rules);
        // Validate the input and return correct response
        if ($validator->fails()) {
            return Response::json(array(
                        'success' => false,
                        'errors' => $validator->getMessageBag()->toArray()
                            ), 200); // 400 being the HTTP code for an invalid request.
        } 
        User::where('id', Auth::user()->id)
                ->update(['password' => bcrypt($request->input('password'))]);
        return Response::json(array('success' => true), 200);
        }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function newUser() {
        return view('user.form')
               ->with('title', 'Add New User');
    }
    
    public function storeNewUser(Request $request) {
        $data =[];
        $data['email']          = $request->input('email');
        $data['email_token']    = base64_encode($request->input('email'));
        $this->validate($request, [
                    'first_name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:admin',
                    'password' => 'required|string|min:6|confirmed',
        ]);
        User::create([
                    'first_name'    =>    $request->input('first_name'),
                    'last_name'     =>    $request->input('last_name'),
                    'email'         =>    $data['email'],
                    'password'      =>    bcrypt(123456),
                    'email_token'   =>    $data['email_token']
        ]); 
        Mail::to('farhad1556@gmail.com')->send(new NewAdminVarification($data['email_token']));
        Session::flash('success', "<span class=text-green> &nbsp; &nbsp; Data Updated Successfully</span>");
        return back()->withInput($request->input());
    }
    
    public function userList() {

        $users = User::select('id','email',DB::raw("CONCAT(first_name, ' ', last_name) as customer_name"), 
                'created_at','status')
                ->get();
        return view('user.user-list')
               ->with('title', 'Users List')
               ->with('i', 1)
               ->with('main', $users);
    }
    public function userStatus(Request $request){
        $input = []; 
        $input['id'] =         $request->input('id');                
        $input['status'] =     $request->input('status');                
        $rules = array(
                'id' => 'required|confirmed',
                'status' =>'required'
               );
        $validator = Validator::make($request->all(), $rules);
        
        // Validate the input and return correct response
        if($input['status'] == 1){
            User::where('id', $input['id'])
                ->update(['status' => $input['status']]);
            return Response::json(array('success' => true), 200);    
        } else {
            User::where('id', $input['id'])
                ->update(['status' => $input['status']]);
            return Response::json(array('success' => false), 200);
        }
    }
    
}
