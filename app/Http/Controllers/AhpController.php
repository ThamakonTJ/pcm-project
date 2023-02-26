<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class AhpController extends Controller
{
    public function index()
    {
        return view('ahp.index');
    }
    public function criteria()
    {
        return view('ahp.criteria');
    }
    public function edit(){
        return view('ahp.edit');
    }

    
    public function tambah()
    {
        return view('ahp.tambah');
    }


    public function alternative()
    {
        return view('ahp.alternative');
    }

    public function bobot_criteria()
    {
        return view('ahp.bobot_criteria');
    }
    public function proses(){
        return view('ahp.proses');
    }

    public function bobot_hasil(){
        return view('ahp.bobot_hasil');
    }


    public function bobot()
    {
        return view('ahp.bobot');
    }
    public function output()
    {
        return view('ahp.output');
    }

    
}
