<?php


namespace App\Http\Controllers\Teacher;


use App\Http\Controllers\Controller;
use App\Models\Problem;
use Illuminate\Http\Request;

class ProblemController extends Controller
{
    public function create(Request $request){
        $data=json_decode($request->getContent(),true);
        $x=0;
        for ($i=0; $i<count($data);$i++){
            $problem=new Problem();
            $problem->description=$data[$i]['title'];
            $problem->species=$data[$i]['type'];
            switch ($data[$i]['type']){
                case '1':
                    $selected=$data[$i]['selected'];
                    $keySel=$selected.'_selected';
                    $problem->$keySel='checked';
                    break;
                case '2':
                    $problem->a_selected=$data[$i]['ay'];
                    $problem->b_selected=$data[$i]['by'];
                    $problem->c_selected=$data[$i]['cy'];
                    $problem->d_selected=$data[$i]['dy'];
                    break;
                case '3':
                    $selected=$data[$i]['selected'];
                    $keySel=$selected.'_selected';
                    $problem->$keySel='checked';
                    break;
                case '4':
                    break;
                default:
                    return json_encode('出错');
                    break;
            }
            $problem->a=$data[$i]['a'];
            $problem->b=$data[$i]['b'];
            $problem->c=$data[$i]['c'];
            $problem->d=$data[$i]['d'];
            $problem->score=$data[$i]['score'];
            $problem->subject=session('subject');
            if ($problem->save()){
                $x++;
            }else{
                $x++;
            }
        }
        if ($x==count($data)){
            return '插入成功';
        }else{
            return '添加失败';
        }
    }
    public function show(Request $request){
        $key=$request->input('key');
        $problem=new Problem();
        $data=$problem->where('subject',session('subject'))
            ->where('public','=',1)
            ->where(function ($query)use ($key){
                $query->where('id',$key)
                    ->orWhere('description','like','%'.$key.'%')
                    ->orWhere('a','like','%'.$key.'%')
                    ->orWhere('b','like','%'.$key.'%')
                    ->orWhere('c','like','%'.$key.'%')
                    ->orWhere('d','like','%'.$key.'%');
            })
            ->orWhere('teacher_id',session('tid'))
                      ->paginate(10);
        return json_encode($data);
    }
//    public showByKey
    public function showById(Request $request){
        $key=$request->input('key');
//        return json_encode($key);
        $problem=new Problem();
        $data=$problem->where('subject',session('subject'))
            ->where('public','=',1)
            ->where(function ($query)use ($key){
                $query->where('id',$key)
                    ->orWhere('description','like','%'.$key.'%')
                    ->orWhere('a','like','%'.$key.'%')
                    ->orWhere('b','like','%'.$key.'%')
                    ->orWhere('c','like','%'.$key.'%')
                    ->orWhere('d','like','%'.$key.'%');
            })
            ->orWhere('teacher_id',session('tid'))
            ->paginate(5);
//            ->get();
//        $data=$problem->find($id);
        return json_encode($data);
    }
    public function update(Request $request){
        $problem=new Problem();
        $id=$request->input('qid');
        $title=$request->input('title');
        $a=$request->input('a');
        $b=$request->input('b');
        $c=$request->input('c');
        $d=$request->input('d');
        $aSelected=$request->input('a_selected');
        $bSelected=$request->input('b_selected');
        $cSelected=$request->input('c_selected');
        $dSelected=$request->input('d_selected');
        $problem=$problem->find($id);
        $problem->description=$title;
        $problem->a=$a;
        $problem->b=$b;
        $problem->c=$c;
        $problem->d=$d;
        $problem->a_selected=$aSelected;
        $problem->b_selected=$bSelected;
        $problem->c_selected=$cSelected;
        $problem->d_selected=$dSelected;
        return json_encode($problem->save());
    }
    public function destroy(){

    }
}
