<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    public function userLogin(Request $request){
        $validatedData = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'max:30']
        ], [
            'email.email' => 'Mtindo sio wa barua pepe (example@gmal.com)',
            'email.required' => 'Barua pepe inahitajika',
            'password.required' => 'Neno siri linahitajika',
            'password.min' => 'Neno siri angalau liwe herufi 8',
            'password.max' => 'Neno siri liwe herufi chini ya 30',
        ]);

        // Attempt to authenticate
        if (Auth::attempt($validatedData)) {
            $user = Auth::user();

            if ($user->user_type == 'admin'){
                return redirect()->route('admin.dashboard.page')->with('success', 'Mhusika Amefanikiwa Kuingia');
            } elseif ($user->user_type == 'katibu'){
                return redirect('/katibu/test');
            }

            // session()->flash('success', 'User Login Successfully');
        } else {
            // session()->flash('error', 'User Login Failed');
            return redirect()->back()->withInput()->with('error', 'Mhusika Ameshindwa Kuingia (Angalia Barua Pepe au Neno Siri)');
        }

    }

    public function userLogout ()
    {
        Auth::logout();
        auth()->logout();
        return redirect()->route('login')->with('success', 'Umefanikiwa Kutoka Kwenye Mfumo');
    }
}



//<!-- Button trigger modal -->
//<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
//    Launch demo modal
//</button>
//
//<!-- Modal -->
//<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
//  <div class="modal-dialog">
//    <div class="modal-content">
//      <div class="modal-header">
//        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
//        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
//      </div>
//      <div class="modal-body">
//        ...
//      </div>
//      <div class="modal-footer">
//        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
//        <button type="button" class="btn btn-primary">Save changes</button>
//      </div>
//    </div>
//  </div>
//</div>

//
//<link href="https://cdn.datatables.net/v/bs4/jq-3.7.0/jszip-3.10.1/dt-2.2.2/af-2.7.0/b-3.2.2/b-colvis-3.2.2/b-html5-3.2.2/b-print-3.2.2/cr-2.0.4/kt-2.12.1/r-3.0.4/rg-1.5.1/rr-1.5.0/sc-2.4.3/sb-1.8.2/sp-2.3.3/sl-3.0.0/sr-1.4.1/datatables.min.css" rel="stylesheet" integrity="sha384-xeAmUsZ8F5nV9aZ3D8iSwWL5qATxW0p1Q7fdrgVz0L0Ds+xmGAdCgbymHUhCxAzi" crossorigin="anonymous">
//
//<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js" integrity="sha384-VFQrHzqBh5qiJIU0uGU5CIW3+OWpdGGJM9LBnGbuIH2mkICcFZ7lPd/AAtI7SNf7" crossorigin="anonymous"></script>
//<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js" integrity="sha384-/RlQG9uf0M2vcTw3CX7fbqgbj/h8wKxw7C3zu9/GxcBPRKOEcESxaxufwRXqzq6n" crossorigin="anonymous"></script>
//<script src="https://cdn.datatables.net/v/bs4/jq-3.7.0/jszip-3.10.1/dt-2.2.2/af-2.7.0/b-3.2.2/b-colvis-3.2.2/b-html5-3.2.2/b-print-3.2.2/cr-2.0.4/kt-2.12.1/r-3.0.4/rg-1.5.1/rr-1.5.0/sc-2.4.3/sb-1.8.2/sp-2.3.3/sl-3.0.0/sr-1.4.1/datatables.min.js" integrity="sha384-NoCtko15BpDEWSDN6aVC4AIKheJUvnqchIvK2BsSZLTglTtVDFBkTUT/ucgFIrPU" crossorigin="anonymous"></script>
