<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExpenseSharingController extends Controller
{
    public function createGroup()
    {
        return view('expense-sharing.create-group');
    }

    public function editGroup()
    {
        return view('expense-sharing.edit-group');
    }

    public function index()
    {
        return view('expense-sharing.index');
    }

    public function addParticipant()
    {
        return view('expense-sharing.add-participant');
    }

    public function editUser()
    {
        return view('expense-sharing.edit-user');
    }
}
