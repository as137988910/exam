<?php


namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Paper;
use App\Models\Student;
use App\Models\Template;
use Illuminate\Http\Request;

class PaperController extends Controller
{
    public function getGoingPaper(){
        $template=new Template();
        $data=$template->where('templates.publish',1)
            ->leftjoin('papers','templates.paper_id','=','papers.id')
            ->where('templates.status',2)
            ->where('templates.public',1)
            ->take(4)
            ->get(['templates.id','templates.begin','templates.end','papers.title','papers.instruction']);
        return json_encode($data);
    }

    public function getGoingPaperList(){
        $template=new Template();
        $data=$template->where('templates.publish',1)
            ->leftjoin('papers','templates.paper_id','=','papers.id')
            ->where('templates.status',2)
            ->where('templates.public',1)
            ->paginate(8,['templates.id','templates.begin','templates.end','papers.title','papers.instruction']);
        return json_encode($data);
    }

    public function getOverPaper(){
        $template=new Template();
        $data=$template->where('templates.publish',1)
            ->leftjoin('papers','templates.paper_id','=','papers.id')
            ->where('templates.status',3)
            ->where('templates.public',1)
            ->take(4)
            ->get(['templates.id','templates.begin','templates.end','papers.title','papers.instruction']);
        return json_encode($data);
    }

    public function getOverPaperList(){
        $template=new Template();
        $data=$template->where('templates.publish',1)
            ->leftjoin('papers','templates.paper_id','=','papers.id')
            ->where('templates.status',3)
            ->where('templates.public',1)
            ->paginate(8,['templates.id','templates.begin','templates.end','papers.title','papers.instruction']);
        return json_encode($data);
    }

    public function getApplyPaper(Request $request){
        $id=$request->input('id');
        $grade=new Grade();
//        $grade=$grade->where('stu_id',$id)->get();
        $data=$grade
                ->where('stu_id',$id)
                ->leftJoin('templates','grades.template_id','=','templates.id')
                ->leftjoin('papers','templates.paper_id','=','papers.id')
                ->paginate(8,['grades.id','grades.publisher_id','grades.publisher_name','grades.addmission_id',
                              'grades.status as joinstatus','grades.score','grades.joinflag','papers.id as paper_id',
                              'papers.title','papers.instruction','templates.id as template_id','templates.status','templates.begin',
                              'templates.end','templates.public','templates.teacher_id']);
        return $data;
    }

//    public function showPaperDetail(){
//        return view('user/examDetail');
//    }

    public function getProblems(Request $request){
        $id=$request->input('id');
        $paper=new Paper();
        $data=$paper->find($id)->problems()
                ->get(['problems.id','a','b','c','d','species','score','description']);
        return $data;
    }

    public function getAnswer(Request $request){
        $id=$request->input('id');
        $paper=new paper();
        $data=$paper->find($id)
                ->problems()
//                ->leftjoin('answers','problems.id','=','answers.problem_id')
                ->get();
        return $data;
    }

//    public function savePaperAnswer(){
//
//    }
}
