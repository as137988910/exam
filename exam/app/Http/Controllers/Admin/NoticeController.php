<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function getNoticeList(){
        $notice=new Notice();
        $data=$notice->paginate(10);
        return $data;
    }

    public function saveNotice(Request $request){
        $title=$request->input('title');
        $content=$request->input('content');
        $notice=new Notice();
        $notice->title=$title;
        $notice->content=$content;
        return $notice->save();
    }
}
