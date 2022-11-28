<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Books;
use GuzzleHttp\Client;

class RegisterController extends Controller
{
    public function store(Request $request){
        $request->validate(
            [
                'name'=>'required',
                'email'=>'required',
                'password'=>'required|confirmed'

            ]
            );

        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make( $request->input('password'));
        if($user->save()){
            $books = DB::table('books')->select('authors', 'title', 'subtitle', 'thumbnail', 'small_thumbnail')->get();
            Auth::login($user);
            if (count($books) == 0) {
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
        }

        Auth::login($user);
        return view('/home')->with('books', $books);

    }
}
