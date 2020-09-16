<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notice;
class NoticeController extends Controller
{
    public function  index(){
        $notices=Notice::latest()->paginate(15);
        return view('notice',compact('notices'));
    }
    public function details($id){
        $notice=Notice::find($id);
        $notice->views++;
        $notice->save();
        return view('notice_details',compact('notice'));
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
        return redirect("notices");
    }
    public function edit($id){
        $notice=Notice::find($id);
        return view('admin.edit_notice',compact('notice'));
    }
    public function update(Request $request){
        // dd($request->paths);
        $paths=[];
        if($request->paths!=null){
            $paths=$request->paths;
        }
        if($request->documents!=null){
            foreach($request->documents as $document){
                $paths[]= $document->store('notices','public');
            }
        }
        $notice=Notice::find($request->id);
        $notice->subject=$request->subject;
        $notice->file_path=\json_encode($paths);
        $notice->save();
        return redirect("notices");
    }
    public function delete($id){
        Notice::find($id)->delete();
        return redirect()->back();
    }
    
}
