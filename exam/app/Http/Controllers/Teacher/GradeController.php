<?php


namespace App\Http\Controllers\Teacher;


use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Paper;
use App\Models\Student;
use App\Models\Template;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function searchStudent(Request $request){
        $key=$request->input('key');
//        return $key;
        $student=new Student();
        $data=$student->where('id','like','%'.$key.'%')
                ->orWhere('name','like','%'.$key.'%')
                ->paginate(8);
        return $data;
    }

    public function addGradeList(Request $request){
        $data=json_decode($request->getContent(),true) ;
        $tid=session('tid');
        $tname=session('tname');
        $len=count($data)-1;
        $pid=$data[$len]['pid'];
        $templateId=$data[$len]['tempid'];
        $x=0;
        for ($i=0;$i<$len;$i++){
            $grade=new Grade();
//            $template=new Template();
//            $templateId=$template->where('teacher_id',$tid)
//                            ->where('paper_id',$pid)
//                            ->get('id');
            $d=$grade->where('stu_id',$data[$i])
                ->where('template_id',$templateId)
                ->get();
            if (count($d)>0){
                $demo[$x]=$d;
                $x++;
                continue;
            }
            $grade->stu_id=$data[$i];
            $grade->template_id=$templateId;
            $grade->publisher_id=$tid;
            $grade->publisher_name=$tname;
            $grade->addmission_id=random_int(100000,999999);
//            $grade
            $grade->status=0;
            $grade->score=0;
            $grade->joinflag=0;
            if ($grade->save()){
                $x++;
            }
        }
//        return json_encode([$x=>$len]);
        if ((int)$x==(int)($len)){
            return true;
        }else{
            return "出错了";
        }
    }

    public function correctPaper(Request $request){
        $data=json_decode($request->getContent(),true);
//        return $data;
        $templateId=$data[0]['template_id'];
        $template=new Template();
        $template=$template->find($templateId);
        $x=0;
        for ($i=0;$i<count($data);$i++){
            $grade=new Grade();
            $gradeData=$grade->where('template_id',$templateId)
                        ->where('stu_id',$data[$i]['stu_id'])
                        ->get();
            $gradeId=$gradeData[0]['id'];
            $score=$gradeData[0]['score'];
            $grade=$grade->find($gradeId);
            $grade->score=$score+$data[$i]['score'];
            $grade->status=2;
            if ($grade->save())
            $x++;
        }
        if ($x==count($data)){
            $template->correct=1;
            return $template->save();
        }else{
            false;
        }
    }

    public function getGradeTable(Request $request){
        $id=$request->input('id');
        $grade=new Grade();
        $data=$grade->where('template_id',$id)
                    ->leftjoin('templates','grades.template_id','=','templates.id')
                    ->leftjoin('students','grades.stu_id','=','students.id')
                    ->leftjoin('papers','templates.paper_id','=','papers.id')
                    ->get(['papers.title','papers.score as total','papers.instruction','grades.addmission_id','students.name','students.email','grades.score']);
        return $data;
    }
}
