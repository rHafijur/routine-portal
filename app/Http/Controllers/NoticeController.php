<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notice;
class NoticeController extends Controller
{
    public function  index(){
        $notices=Notice::all();
        return view('notice',compact('notices'));
    }
    public function add(){
        return view("admin.add_notice");
    }
    public function save(Request $request){
        // dd($request);
        $paths=[];
        foreach($request->documents as $document){
            $paths[]= $document->store('notices','public');
        }
        // dd($paths);
        Notice::create([
            'subject'=>$request->subject,
            'file_path'=>\json_encode($paths),
        ]);
    }
    public function edit(){

    }
    public function update(Request $request){

    }
    
}
