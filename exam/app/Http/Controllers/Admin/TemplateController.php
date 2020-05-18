<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function getTemplateList(){
        $template=new Template();
        $data=$template->leftjoin('papers','templates.paper_id','=','papers.id')
            ->leftjoin('teachers','papers.teacher_id','=','teachers.id')
            ->paginate(10,['templates.id','papers.id as paper_id','papers.title','papers.score','teachers.name',
                'templates.begin','templates.end']);
        return $data;
    }

    public function updateTemplate(Request $request){
        $id=$request->input('id');
        $begin=$request->input('begin');
        $end=$request->input('end');
//        $status=$request->input('status');
        $template=new Template();
        $template=$template->find($id);
        $template->begin=$begin;
        $template->end=$end;
//        $template->status=$status;
        return $template->save();
    }
}
