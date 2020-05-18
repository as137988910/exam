<?php


namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Grade;
use App\Models\Paper;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnswerController extends Controller
{
    public function saveAnswer(Request $request){
        $data=json_decode($request->getContent(),true);
        $grade=new Grade();
        $paper=new Paper();
        $template=new Template();
        $template=$template->find($data[0]['template_id']);
        $status=0;
        $score=0;
        $paper=$paper->find($data[0]['paper_id']);
        $answer=$paper->problems()->orderBy('species','ASC')
            ->orderBy('id','ASC')->get();
        for ($i=0;$i<count($answer);$i++){
            if ($data[$i]['species']==4){
                $status=1;
                break;
            }
            if ((boolean)$data[$i]['a']==(boolean)$answer[$i]['a_selected']&&
                (boolean)$data[$i]['a']==(boolean)$answer[$i]['a_selected']&&
                (boolean)$data[$i]['a']==(boolean)$answer[$i]['a_selected']&&
                (boolean)$data[$i]['a']==(boolean)$answer[$i]['a_selected']){
                $score+=$answer[$i]['score'];
                $status=2;
            }
        }
        if ($status==2){
            $template->correct=1;
        }
        $gradeId=$grade->where('stu_id',$data[0]['stu_id'])
            ->where('template_id',$data[0]['template_id'])
            ->get();
        $grade=$grade->find($gradeId[0]['id']);
        $grade->status=$status;
        $grade->score=$score;
        $grade->joinflag=1;
        $template->paper_id=$data[0]['paper_id'];
        if (DB::table('answers')->insert($data)&&
            $grade->save()&&
            $template->save()){
            return "1";
        }
        return json_encode($data);
//        return $gradeId;
    }
}
