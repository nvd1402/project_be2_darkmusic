<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public $data = [];
//dashboard
    public function adminindex()
    {
        return view('admin.dashboard', $this->data);
    }


//song
    public function createsong()
    {
        return view('admin.songs.create', $this->data);
    }

    public function indexsong()
    {
        return view('admin.songs.index', $this->data);
    }

    function editsong(){

        return view('admin.songs.edit', $this->data);
    }


//user
    public function indexuser(){
        return view('admin.users.index', $this->data);
    }
    public function createuser(){
        return view('admin.users.create', $this->data);
    }
    public function edituser(){
        return view('admin.users.edit', $this->data);
    }

    //doanh thu
    public function revenue(){
        return view('admin.revenue.index', $this->data);
    }
  }
