<?php


namespace App\Http\Controllers\Teacher;


use App\Http\Controllers\Controller;
use App\Models\Paper;
use App\Models\Teacher;
use App\Models\Template;
use Illuminate\Http\Request;


class PaperController extends Controller
{
    public function showPaper(){
        $paper=new Paper();
        $data=$paper->where('teacher_id',session('tid'))
                ->paginate(10);
        return json_encode($data);
    }

    public function showTemplate(Request $request){
        $paper=new Paper();
        $data=$paper->where('public',1)
//            ->orWhere('teacher_id',session('id'))
            ->paginate(6);
        return json_encode($data);
    }

    public function searchTemplate(Request $request){
        $key=$request->input('key');
        $paper=new Paper();
        $data=$paper->where('public',1)
                    ->where(function ($query) use ($key){
                       $query->where('title','like','%'.$key.'%')
                           ->orWhere('instruction','like','%'.$key.'%');
                    })
//                    ->orWhere('teacher_id',session('id'))
                    ->paginate(6);
        return json_encode($data);
    }

    public function getPaper(Request $request){
        $id=$request->input('id');
        $paper=new Paper();
        $data=$paper->problems()->orWhere('paper_id',$id)->get();
        return json_encode($data);
    }

    public function savePaper(Request $request){
        $data=json_decode($request->getContent(),true) ;
        $len=count($data)-1;
        $conFlag=false;
        $paper=new Paper();
        $template=new Template();
        $paper->title=$data[$len]['title'];
        $paper->instruction=$data[$len]['instruction'];
        $paper->score=$data[$len]['score'];
        $paper->public=$data[$len]['public'];
        $paper->teacher_id=session('tid');
        $flag=$paper->save();
        if ($flag){
            $template->teacher_id=session('tid');
            $template->paper_id=$paper->id;
            $conFlag=$template->save();
        }
        for ($i=0;$i<$len;$i++){
            $paper->problems()->attach($data[$i]['id']);
        }
        return $conFlag;
    }

    public function publishPaper(Request $request){
        $id=$request->input('id');
        $public=$request->input('public');
        $template=new Template();
        $template=$template->find($id);
        $template->publish=1;
        $template->public=$public;
        return $template->save();
    }

    public function changePaperStatus(Request $request){
        $id=$request->input('id');
        $status=$request->input('status');
        $template=new Template();
        $template=$template->find($id);
        $template->status=$status;
        return $template->save();
    }
}
