<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Mail\Message;

class MainController extends Controller
{
    public function receive()
    {

        return with('success', 'Adopted profiles updated succefully');
    }
}
