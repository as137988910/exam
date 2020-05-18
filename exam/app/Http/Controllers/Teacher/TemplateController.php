<?php


namespace App\Http\Controllers\Teacher;


use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
{

    public function publishTemplate(Request $request)
    {
        $id = $request->input('id');
        $begin = $request->input('begin');
        $end = $request->input('end');
        $teacher = new Teacher();
        return $teacher->publishPapers()->attach($id, ['begin' => $begin, 'end' => $end, 'teacher_id' => session('tid')]);
//        $title=$request->input('title');
//        $instruction=$request->input('instruction');
//        $score=$request->input('score');
//        $paper=new Paper();
//        $paper=$paper->find($id);
//        $paper->teacher_id=session('tid');
//        $paper->title=$title;
//        $paper->instruction=$instruction;
//        $paper->score=$score;
//        $paper->begin=$begin;
//        $paper->end=$end;
//        $paper->publish=1;
//        return $paper->save();
    }

    public function savePublishTime(Request $request)
    {
        $id = $request->input('id');
        $begin = $request->input('begin');
        $end = $request->input('end');
        $template = new Template();
        $template = $template->find($id);
        $template->begin = $begin;
        $template->end = $end;
//        return $id;
        return $template->save();
    }

    public function showPublishPaper(Request $request)
    {
        $teacher = new Teacher();
        $teacher = $teacher->find(session('tid'));
        $data = $teacher->publishPapers()->paginate(10);
        return $data;
    }

    public function getCorrectPaper(Request $request)
    {
        $tid = session('tid');
        $teacher = new Teacher();
        $teacher = $teacher->find($tid);
        $data = $teacher->publishPapers()
            ->where('templates.teacher_id', $tid)
            ->where(function ($q) {
                $q->where('templates.status', 3)
                    ->orWhere('templates.status', 2);
            })
            ->where('templates.publish', '1')
            ->where('templates.correct', 0)
//                ->left
            ->paginate(10);
        return $data;
    }

    public function getGradePaper(Request $request)
    {
        $template = new Template();
        $data = $template
            ->where('templates.status', 3)
            ->where('correct',1)
            ->where('templates.teacher_id', session('tid'))
            ->leftjoin('papers', 'templates.paper_id', '=', 'papers.id')
            ->paginate(10,['templates.id','templates.begin','templates.end','papers.id as paper_id','papers.title','papers.instruction',
                'papers.score as total','papers.created_at','papers.updated_at']);
        return $data;
    }
}
