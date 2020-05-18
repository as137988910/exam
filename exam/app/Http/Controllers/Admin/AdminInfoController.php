<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminInfoController extends Controller
{
    public function getAdminInfo(){
        $id=session('aid');
        $admin=new Admin();
        $data=$admin->where('id',$id)
                ->get();
        return $data;
    }

    public function saveAdminInfo(Request $request){
//        $data=json_decode($request->getContent(),true);
        $id=session('aid');
        $email=$request->input('email');
        $name=$request->input('name');
        $password=$request->input('password');
        $age=$request->input('age');
        $sex=$request->input('sex');
        $admin=new Admin();
        $admin=$admin->find($id);
        $admin->email=$email;
        $admin->name=$name;
        $admin->password=$password;
        $admin->age=$age;
        $admin->sex=$sex;
        return $admin->save();
    }
}
