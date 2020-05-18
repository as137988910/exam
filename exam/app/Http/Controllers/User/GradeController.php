<?php


namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function apply(Request $request){
//        if (session('verify')){
//            return "请登录";
//        }
        $grade=new Grade();
        $grade->stu_id=$request->input('sid');
        $grade->template_id=$request->input('id');
        $grade->addmission_id=random_int(100000,999999);
        return $grade->save();
    }

    public function getApplyInfo(Request $request){
        $id=$request->input('id');
//        $id=session('id');
        $grade=new Grade();
        $data= $grade->where('stu_id',$id)->get();
        return json_decode($data);
    }

    public function getGradeReport(Request $request){
        $addmissionId=$request->input('addmissionId');
        $grade=new Grade();
//        $gradeId=$grade->where('addmission_id',$addmissionId)
//                ->get();
//        $grade=$grade->find($gradeId[0]['id']);
        $data=$grade->where('addmission_id',$addmissionId)
                    ->leftjoin('students','grades.stu_id','=','students.id')
                    ->leftjoin('templates','grades.template_id','=','templates.id')
                    ->leftjoin('papers','templates.paper_id','=','papers.id')
                    ->get(['grades.id','grades.addmission_id','grades.score','grades.joinflag',
                        'students.name','students.sex','students.age',
                        'papers.title','papers.score as total',
                        'templates.begin','templates.end']);
//        $msg=[];
        if (count($data)==0){
            $msg=[
                'status'=>-1,
                'data'=>'没有查到信息'
            ];
            return $msg;
        }
        if ($data[0]['joinflag']==0){
            $msg=[
                'status'=>9,
                'data'=>'你还未参加此次考试，没有成绩'
            ];
            return $msg;
        }
        if ($data[0]['stu_id']!=session('id')){
            if (session('id')==null){
                $msg=[
                    'status'=>0,
                    'data'=>'登录失效，请重新登录'
                ];
            }else{
                $msg=[
                    'status'=>1,
                    'data'=>'这不是你的成绩单，无权查看'
                ];
            }
        }else{
            $msg=[
                'status'=>2,
                'data'=>$data
            ];
        }
        return $msg;
    }

    public function getJoinPaper(Request $request){
        $id=$request->input('id');
        $grade=new Grade();
        $data=$grade->where('stu_id',$id)
                ->leftjoin('templates','grades.template_id','templates.id')
                ->leftjoin('papers','templates.paper_id','papers.id')
                ->paginate(8,['grades.id','papers.title','grades.addmission_id','grades.publisher_name','templates.begin','templates.end']);
        return $data;
    }


}
