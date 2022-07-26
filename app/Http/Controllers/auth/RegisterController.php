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

    public function updatePassword(Request $request, User $user){

        if(Hash::check($request->old_password, $user->password)){
            $request->validate([
                'old_password' => 'required',
                'password' => 'required|confirmed',
            ]);
            
            $user->password = Hash::make($request->password);
            $user->save();

            // $user->update(['password' => bcrypt($request['password'])]);
            auth()->login($user);
            return back()->with('success', 'Password changed successfully');
        }else{
            return back()->with('error', 'Password does not match');
            
        }
    }
        public function UpdateUser(Request $request, User $user){
            $data = $request->validate([
                'name'=>'required|min:3',
                'phone'=>'required',
                'email'=>'required|email',
            ]);
            if($request->hasfile('photo')){
                if(file_exists(public_path().'/'.$user->photo)){
                    // dd($user->photo);
                    // @unlink($user->photo);
                    @unlink(public_path().'/'.$user->photo);
                }
                
                $fileName = date('YmdHis').'_'.$request->name.'_'.rand(10,10000).'.'.$request->photo->extension();
                
                $img = Image::make($request->file('photo'));
                $img->resize(300, 300);
                $img->save('storage/images/users/'.$fileName);
                // $request->photo->storeAs('images', $fileName, 'public');
                $photo = '/storage/images/users/'.$fileName;
                $user->photo = $photo;
    
            }

            $user->update([
            'name' => $data['name'],
            'phone' => $data['phone'], 
            'photo' => $request->hasFile('photo') ? $photo : $user->photo,
            'email' => $data['email'],
            ]);
            
    /*         $user->name = $data->name;
            $user->email = $data->email;
            $user->phone = $data->phone; */
            // user->save();
            
            
            auth()->login($user);
            return back()->with('success', 'Profile successfully updated Mr. '.auth()->user()->name);
             //auth()->attempt($user);
            // return back();
    
        
    }
    
}
