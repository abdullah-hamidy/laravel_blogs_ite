<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('admin.profile.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, User $user)
    {
    /*     return view('admin.profile.index')
                ->with('user', $user); */
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user) //NOT WORKING FROM PROFILE UPDATE PAGE, HOWEVER SAME CODE WORKING IN REGISTER CONTROLLER
    {
        $data = $request->validate([
            'name'=>'required|min:3',
            'phone'=>'required',
            'email'=>'required|email',
        ]);
        if($request->hasfile('photo')){
            if(file_exists($user->photo)){
                @unlink($user->photo);
                // @unlink(public_path().'/'.$user->photo);
            }
            
            $fileName = date('YmdHis').'_'.$request->name.'_'.rand(10,10000).'.'.$request->photo->extension();
            
            $img = Image::make($request->file('photo'));
            $img->resize(300, 300);
            $img->save('storage/images/users/'.$fileName);
            // $request->photo->storeAs('images', $fileName, 'public');
            $photo = '/storage/images/users/'.$fileName;
            $user->photo = $photo;

        }
        
        // dd($user);
        // dd($data);
        $user->update([
        'name' => $data['name'],
        'phone' => $data['phone'], 
        'photo' => $request->hasFile('photo') ? $photo : $user->photo,
        'email' => $data['email'],
        ]);
        
/*         $user->name = $data->name;
        $user->email = $data->email;
        $user->phone = $data->phone; */
        // if($user->save()){
        //     return back()->with('success', 'Profile successfully updated Mr.'.auth()->user()->name);
        // }else{
        //     return back()->with('error', 'Update failed');
        // }
        
        return back()->with('success', 'Profile successfully updated Mr.'.auth()->user()->name);
        //  auth()->login($user);
         //auth()->attempt($user);
        // return back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
