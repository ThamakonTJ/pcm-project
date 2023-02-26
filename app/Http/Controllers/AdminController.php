<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class AdminController extends Controller
{
    function index(){
        return view('dashboards.admins.index');
    }
    function profile(){
        return view('dashboards.admins.profile');
    }
    function setting(){
        return view('dashboards.admins.setting');
    }
    function manage_user_index(){
        $data['users'] = User::orderBy('id','asc')->paginate(5);
        return view('manage_user.index', $data);
    }

    public function create() {

        return view('manage_user.create');
    }
    
    public function store(Request $request){
        $request ->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
            'password' => 'required',
        ],[
            
            'name.required' => "กรุณาใส่ชื่อผู้ใช้",
            'email.required' => "กรุณาใส่อีเมล",
            'role.required' => "กรุณาใส่ตำแหน่ง",
            'password.required' => "กรุณาใส่รหัสผ่าน",
         
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->password = \Hash::make($request->password);
        $user->email_verified_at = Carbon::now();
        $user->save();
        return redirect()->route('manage_user.index')->with('success' ,"เพิ่มข้อมูลสำเร็จ");
    }

    public function edit(User $user) {
        return view('manage_user.edit', compact('user'));

    }

    public function update(Request $request, User $user) {
        $request ->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
            'password' => 'required'
           
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->password = $request->password;

        $user->save();
        return redirect()->route('manage_user.index')->with('success' ,"แก้ไข้ข้อมูลสำเร็จ");
    }

    public function destroy($id){
        User::find($id)->delete();
        return redirect()->route('manage_user.index')->with('success' ,"ลบข้อมูลสำเร็จ");
    }

    function updateInfo(Request $request){
           
        $validator = \Validator::make($request->all(),[
            'name'=>'required',
            'email'=> 'required|email|unique:users,email,'.Auth::user()->id,
        ]);

        if(!$validator->passes()){
            return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
             $query = User::find(Auth::user()->id)->update([
                  'name'=>$request->name,
                  'email'=>$request->email,
             ]);

             if(!$query){
                 return response()->json(['status'=>0,'msg'=>'Something went wrong.']);
             }else{
                 return response()->json(['status'=>1,'msg'=>'Your profile info has been update successfuly.']);
             }
        }
    }

    public function updatePicture(Request $request){
        $path = 'users/images/';
        $file = $request->file('admin_image');
        $new_name = 'UIMG_'.date('Ymd').uniqid().'.jpg';
    
        //Upload new image
        $upload = $file->move(public_path($path), $new_name);
        
        if( !$upload ){
            return response()->json(['status'=>0,'msg'=>'Something went wrong, upload new picture failed.']);
        }else{
            //Get Old picture
            $oldPicture = User::find(Auth::user()->id)->getAttributes()['picture'];
    
            if( $oldPicture != '' ){
                if( \File::exists(public_path($path.$oldPicture))){
                    \File::delete(public_path($path.$oldPicture));
                }
            }
    
            //Update DB
            $update = User::find(Auth::user()->id)->update(['picture'=>$new_name]);
    
            if( !$upload ){
                return response()->json(['status'=>0,'msg'=>'Something went wrong, updating picture in db failed.']);
            }else{
                return response()->json(['status'=>1,'msg'=>'Your profile picture has been updated successfully']);
            }
        }
        }


    function changePassword(Request $request){
    //Validate form
    $validator = \Validator::make($request->all(),[
        'oldpassword'=>[
            'required', function($attribute, $value, $fail){
                if( !\Hash::check($value, Auth::user()->password) ){
                    return $fail(__('The current password is incorrect'));
                }
            },
            'min:8',
            'max:30'
         ],
         'newpassword'=>'required|min:8|max:30',
         'cnewpassword'=>'required|same:newpassword'
     ],[
         'oldpassword.required'=>'Enter your current password',
         'oldpassword.min'=>'Old password must have atleast 8 characters',
         'oldpassword.max'=>'Old password must not be greater than 30 characters',
         'newpassword.required'=>'Enter new password',
         'newpassword.min'=>'New password must have atleast 8 characters',
         'newpassword.max'=>'New password must not be greater than 30 characters',
         'cnewpassword.required'=>'ReEnter your new password',
         'cnewpassword.same'=>'New password and Confirm new password must match'
     ]);

    if( !$validator->passes() ){
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
    }else{
         
     $update = User::find(Auth::user()->id)->update(['password'=>\Hash::make($request->newpassword)]);

     if( !$update ){
         return response()->json(['status'=>0,'msg'=>'Something went wrong, Failed to update password in db']);
     }else{
         return response()->json(['status'=>1,'msg'=>'Your password has been changed successfully']);
         }
        }
    }
}



