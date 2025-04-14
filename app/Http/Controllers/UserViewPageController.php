<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserViewPageController extends Controller
{
    public function viewUserLoginPage(){
        return view('users.pages.auth.user_login_page');
    }
}
