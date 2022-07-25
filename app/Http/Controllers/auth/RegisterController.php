<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManagerStatic as Image;

class RegisterController extends Controller
{
    //

    public function index(){
        return view('auth.register');
    }

    public function store(Request $request){

        // dd($request->all());
        $request->validate([
            'name'=>'required|min:4',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|confirmed|min:4',
            'phone'=>'required|min:10',
        ]);

        $user = new User();
        if($request->hasfile('photo')){
            $fileName = date('YmdHis').'_'.$request->name.'_'.rand(10,10000).'.'.$request->photo->extension();
            
            $img = Image::make($request->file('photo'));
            $img->resize(300, 300);
            $img->save('storage/images/users/'.$fileName);
            // $request->photo->storeAs('images', $fileName, 'public');
            $user->photo = '/storage/images/users/'.$fileName;
        }
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role = 2;
        $user->password = bcrypt($request->password);
        $user->save();
        auth()->attempt($request->only('email', 'password'));

        return redirect()->route('admin');
    }
    
}
