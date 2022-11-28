<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Books;
use GuzzleHttp\Client;

class LoginController extends Controller
{
    public function authenticate(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        if (Auth::attempt(['email'=>$email,'password'=>$password])) {
            $user = User::where('email',$email)->first();
            $books = DB::table('books')->select('authors', 'title', 'subtitle', 'thumbnail', 'small_thumbnail')->get();
            Auth::login($user);
            if(count($books) == 0){
                $client = new Client();
                $storeBooks = new Books();
                $res = $client->get('https://run.mocky.io/v3/821d47eb-b962-4a30-9231-e54479f1fbdf', ['headers' =>  ['Authorization', 'AppRinger']]);

                $data = json_decode($res->getBody()->getContents());
                foreach ($data->items as $key => $value) {
                    $storeBooks = new Books();
                    $storeBooks->authors = $value->volumeInfo->authors[0];
                    $storeBooks->title = $value->volumeInfo->title;
                    $storeBooks->subtitle = isset($value->volumeInfo->subtitle) ? $value->volumeInfo->subtitle : '';
                    $storeBooks->thumbnail = $value->volumeInfo->imageLinks->thumbnail;
                    $storeBooks->small_thumbnail = $value->volumeInfo->imageLinks->smallThumbnail;
                    $storeBooks->save();
                }
                $books = DB::table('books')->select('authors', 'title', 'subtitle', 'thumbnail', 'small_thumbnail')->get();
            }
            return view('/home')->with('books' , $books);
        }else{
            return back()->withErrors(['Invalid credentials!']);
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
}
