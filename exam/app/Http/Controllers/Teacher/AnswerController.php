<?php


namespace App\Http\Controllers\Teacher;


use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;

class AnswerController extends Controller
{

    public function getAnswer(Request $request){
        $templateId=$request->input('templateId');
//        return json_encode($templateId);
        $template=new Template();
//        $template=$template->find($templateId);
        $data=$template->where('templates.id',$templateId)
            ->leftjoin('answers','templates.id','=','answers.template_id')
            ->leftjoin('problems','answers.problem_id','=','problems.id')
            ->where('problems.species',4)
            ->leftjoin('students','answers.stu_id','=','students.id')
            ->get(['answers.content as answer','answers.stu_id','problems.description','problems.score','students.name']);
//                ->groupBy('answers.stu_id')
//            ->count();
//            ->get();
        return $data;
    }

    public function getAnswerProNum(Request $request){
        $templateId=$request->input('templateId');
        $template=new Template();
        $data=
//        $template=$template->find($templateId);
        $data=$template->where('templates.id',$templateId)
            ->leftjoin('answers','templates.id','=','answers.template_id')
            ->leftjoin('problems','answers.problem_id','=','problems.id')
            ->where('problems.species',4)
            ->leftjoin('students','answers.stu_id','=','students.id')
//            ->get('answers.stu_id')
                ->groupBy('answers.stu_id')
            ->count();
        return $data;
    }
}
