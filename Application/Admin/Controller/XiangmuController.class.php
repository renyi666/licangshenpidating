<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------
namespace Admin\Controller;

use Think\Controller;
use Think\Model;
use Think\Upload;


/**
 * 后台用户控制器
 *
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
class XiangmuController extends AdminController
{

    /*
     * /* /**
     * 用户管理首页
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function index()
    {
        $this->select_man();
        $this->select_company();

        //筛选

        
        $xiangmu_fenlei = D('Xiangmu_fenlei');
        $list_fenlei = $xiangmu_fenlei->select();
        $this->assign('fenlei', $list_fenlei);

        $uid = session('user_auth.uid');

        
        $xiangmu = D('Xiangmu');
        $id['id'] = I('id');
        
        if (! empty($id['id'])) {
            
            $list = $xiangmu->where($id)->select();
            
            $this->assign('_list', $list);
        } else {
            
            // 使用onethink自带的分页效果 在Config.index里
            $list = $this->lists('Xiangmu', '', 'create_time desc');
            // $list = $xiangmu->select();
            $nu = count($list);
            
            for ($i = 0; $i < $nu; $i ++) {
              
                
                $list[$i]['time'] = substr($list[$i]['time'], 0, 10);
            }
            $this->assign('_list', $list);
        }

        $this->display();
    }

    public function select_man()
    {
        $xiangmu = D('Xiangmu');
        $a = $xiangmu->select();
        
        $b = count($a);
        
        for ($i == 0; $i < $b + 1; $i ++) {
            
            $c[$i] = $a[$i - 1]['man'];
            
            $c['0'] = $a['0']['man'];
           
            $d = array_filter($c);
            
            $q = array_unique($d);
            
            
            $r = count($q);
            
            $l = Array();
            foreach ($q as $key => $value) {
                $l[] = Array(
                    'aa' => $key,
                    'man' => $value
                );
            }
            $this->assign('q', $l);
        }
    }

    public function select_company()
    {
        $xiangmu = D('Duty');
        $a = $xiangmu->select();
        
        $b = count($a);
        
        for ($i =0; $i < $b + 1; $i ++) {
            
            $c[$i] = $a[$i - 1]['name'];
            
            $c['0'] = $a['0']['name'];
            $d = array_filter($c);
            
            $q = array_unique($d);
            
            $r = count($q);
            
            $l = Array();
            foreach ($q as $key => $value) {
                $l[] = Array(
                    'aa' => $key,
                    'company' => $value
                );
            }


        }
        $this->assign('company', $l);

    }

    public function tianjia_fenlei()
    {
        $xiangmu_fenlei = D('Xiangmu_fenlei');
        $list = $this->lists('Xiangmu_fenlei', '', '');
        
        $this->assign('_list', $list);
        
        $this->display();
    }

    public function add_fenlei()
    {
        $res['name'] = I('name');
        $res['zhushi'] = I('zhushi');
        if (IS_POST) {
            if (! empty($res['name']) && ! empty($res['zhushi'])) {
                $xiangmu_fenlei = D('Xiangmu_fenlei');
                
                $xiangmu_fenlei->add($res);
                $this->redirect('Xiangmu/tianjia_fenlei');
            } else {
                $this->error('请输入完整信息');
            }
        }
        $this->display();
    }

    public function fenlei_delete()
    {
        $res['id'] = I('id');
        $xiangmu_fenlei = D('Xiangmu_fenlei');
        $xiangmu_fenlei->where($res)->delete();
        $this->redirect('Xiangmu/tianjia_fenlei');
    }

    Public function xinjian()
    {

        // 获取session中的用户昵称
        $nickname = session('user_auth.username');
        $uid = session('user_auth.uid');
        if (IS_POST && ! empty($_FILES['biaoge'])) {
            

            $Upload = new Upload();
            
            $res = $Upload->uploadOne($_FILES['biaoge']);
            // 如果没上传文件，则上传路径为空 即$res为空
            
            if (! empty($res)) {
                $xinjian['biaoge_dizhi'] = 'Uploads/' . $res['savepath'] . $res['savename'];
                // echo $xinjian['biaoge_dizhi'];
                // 导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
                import("Org.Util.PHPExcel");
                // 要导入的xls文件，位于根目录下的Public文件夹
                
                // $filename="./Public/1.xls";
                $filename = $xinjian['biaoge_dizhi'];
                // 创建PHPExcel对象，注意，不能少了\
                $PHPExcel = new \PHPExcel();
                // 如果excel文件后缀名为.xls，导入这个类
                // import("Org.Util.PHPExcel.Reader.Excel5");
                // 如果excel文件后缀名为.xlsx，导入这下类
                import("Org.Util.PHPExcel.Reader.Excel2007");
                $PHPReader = new \PHPExcel_Reader_Excel2007();
                
                // $PHPReader = new \PHPExcel_Reader_Excel5();
                // 载入文件
                $PHPExcel = $PHPReader->load($filename);
                // 获取表中的第一个工作表，如果要获取第二个，把0改为1，依次类推
                $currentSheet = $PHPExcel->getSheet(0);
                // 获取总列数
                $allColumn = $currentSheet->getHighestColumn();
                // 获取总行数
                $allRow = $currentSheet->getHighestRow();
                // 循环获取表中的数据，$currentRow表示当前行，从哪行开始读取数据，索引值从0开始
//                for ($currentRow = 1; $currentRow <= $allRow; $currentRow ++) {
//                    // 从哪列开始，A表示第一列
//                    for ($currentColumn = 'A'; $currentColumn <= $allColumn; $currentColumn ++) {
//                        // 数据坐标
//                        $address = $currentColumn . $currentRow;
//                        // 读取到的数据，保存到数组$arr中
//                        $arr[$currentRow][$currentColumn] = $currentSheet->getCell($address)->getValue();
//                    }
//                }

                for ($i = 2; $i <=$allRow; $i ++) {
                    
                    $add1['id'] = $currentSheet->getCell('A'.$i)->getValue();

                    $add['name'] = $currentSheet->getCell('B'.$i)->getValue();;
                    $add['construction_year'] = $currentSheet->getCell('C'.$i)->getValue();;
                    $add['fenlei'] = $currentSheet->getCell('D'.$i)->getValue();;

                    $add['location'] = $currentSheet->getCell('E'.$i)->getValue();;
                    $add['construction_content'] = $currentSheet->getCell('F'.$i)->getValue();;

                    $add['company'] = $currentSheet->getCell('G'.$i)->getValue();;
                    $add['man'] = $currentSheet->getCell('H'.$i)->getValue();;
                    $add['phone'] = $currentSheet->getCell('I'.$i)->getValue();;
                    $add['work_progress'] = $currentSheet->getCell('J'.$i)->getValue();;
                    $add['current_week'] = $currentSheet->getCell('K'.$i)->getValue();;

                    $add['next_plan'] = $currentSheet->getCell('L'.$i)->getValue();;
                    $add['problem'] = $currentSheet->getCell('M'.$i)->getValue();;
                    $add['help'] = $currentSheet->getCell('N'.$i)->getValue();;
                    $add['action'] = $currentSheet->getCell('O'.$i)->getValue();;
                    $add['major'] = $currentSheet->getCell('P'.$i)->getValue();;
                    $add['major2'] =$currentSheet->getCell('Q'.$i)->getValue();;
                    $add['major3'] = $currentSheet->getCell('R'.$i)->getValue();;
                    $add['major4'] = $currentSheet->getCell('S'.$i)->getValue();;

                    $add['finish_time1'] =$currentSheet->getCell('T'.$i)->getValue();;
                    $add['finish_time2'] = $currentSheet->getCell('U'.$i)->getValue();;
                    $add['finish_time3'] =$currentSheet->getCell('V'.$i)->getValue();;
                    $add['finish_time4'] = $currentSheet->getCell('W'.$i)->getValue();;
                    $add['finish_time5'] = $currentSheet->getCell('X'.$i)->getValue();;
                    $add['finish_time6'] = $currentSheet->getCell('Y'.$i)->getValue();;
                    $add['finish_time7'] = $currentSheet->getCell('Z'.$i)->getValue();;
                    $add['finish_time8'] = $currentSheet->getCell('AA'.$i)->getValue();;
                    $add['finish_time9'] = $currentSheet->getCell('AB'.$i)->getValue();;
                    $add['finish_time10'] = $currentSheet->getCell('AC'.$i)->getValue();;
                    $add['finish_time11'] = $currentSheet->getCell('AD'.$i)->getValue();;
                    $add['plan_01'] = $currentSheet->getCell('AE'.$i)->getValue();;
                    $add['plan_02'] = $currentSheet->getCell('AF'.$i)->getValue();;
                    $add['plan_03'] =$currentSheet->getCell('AG'.$i)->getValue();;
                    $add['plan_04'] = $currentSheet->getCell('AH'.$i)->getValue();;
                    $add['plan_05'] = $currentSheet->getCell('AI'.$i)->getValue();;
                    $add['plan_06'] = $currentSheet->getCell('AJ'.$i)->getValue();;
                    $add['plan_07'] = $currentSheet->getCell('AK'.$i)->getValue();;
                    $add['money_need'] = $currentSheet->getCell('AL'.$i)->getValue();;
                    $add['next_year_plan'] =$currentSheet->getCell('AM'.$i)->getValue();;
                    $add['money_need_next'] = $currentSheet->getCell('AN'.$i)->getValue();;




                    $xiangmu = D('Xiangmu');
                    $xiangmu_first = D('Xiangmu_first');
                    if (! empty($add['name'])) {
                        
                        if (! empty($add1['id'])) {
                            
                            $add2['name'] =  $add['location'];

                            
                            $res = $xiangmu->where($add1)->select();
                            
                            if (! empty($res)) {
                                if (1 == 1) {
                                    

                                    $xiangmu->where($add1)->save($add);
                                    
                                    $xiangmu_copy = D('Xiangmu_copy');
                                    $add['xiangmu_id'] = $add1['id'];

                                    $res2 = $xiangmu->where($add1)
                                        ->field('user_uid')
                                        ->select();

                                    $add['user_uid'] = $res2['0']['user_uid'];

                                    $xiangmu_copy->create($add);
                                    $xiangmu_copy->add();
                                    
                                    $add = null;
                                    
                                    if ($i == $allRow) {
                                        $this->redirect('Xiangmu/index');
                                    }
                                } else {
                                    
                                    $this->error('您的编号不正确，请确认编号');
                                }
                            } else {
                                $this->error('您的编号不正确，请确认编号');
                            }
                        } else {
                            
                            $add2['name'] =  $add['location'];
                            

                            
                            $add['user_uid'] = $uid;


                            $xiangmu_first->create($add);
                            $xiangmu_first->add();

                        //使用create方法 调用model模型里的自动完成方法 获取create_time当前时间戳

                            $data1 = $xiangmu->create($add);
                        //add方法的返回值是当前插入对象的id
                            $data2=$xiangmu->add();
                            $add['xiangmu_id'] = $data2;
                            $aa = $xiangmu->select();

                            $xiangmu_copy = D('Xiangmu_copy');

                           $xiangmu_copy->create($add);
                         
                            $id1=$xiangmu_copy->add();
                           
                            $add = null;
                            if ($i == $allRow) {
                               $this->redirect('Xiangmu/index');
                            }
                            //
                        }
                    } else {
                        $this->error('请输入完整信息');
                    }
                }
            }
        }
        
        $this->display();
    }


    public  function  new_1(){


        $xiangmu = D('Xiangmu');
        $xiangmu_copy = D('Xiangmu_copy');
        $xiangmu_first = D('Xiangmu_first');
        $this->select_company();


        $xiangmu_fenlei = D('Xiangmu_fenlei');
        $list_fenlei = $xiangmu_fenlei->select();
        $this->assign('fenlei', $list_fenlei);

        $uid = session('user_auth.uid');

        if (IS_POST) {

            $update['help'] = I('help');
            if (empty($update['help'])) {
                $update['help'] = "否";
            } else {
                $update['help'] = "是";
            }

            $update['action'] = I('action');
            if (empty($update['action'])) {
                $update['action'] = "否";
            } else {
                $update['action'] = "是";
            }
            $update['shenpi'] = I('shenpi');
            if (empty($update['shenpi'])) {
                $update['shenpi'] = "否";
            } else {
                $update['shenpi'] = "是";
            }

            $update['major'] = I('major');
            if (empty($update['major'])) {
                $update['major'] = "否";
            } else {
                $update['major'] = "是";
            }

            $update['major2'] = I('major2');

            if (empty($update['major2'])) {
                $update['major2'] = "否";
            } else {
                $update['major2'] = "是";
            }

            $update['major3'] = I('major3');
            if (empty($update['major3'])) {
                $update['major3'] = "否";
            } else {
                $update['major3'] = "是";
            }
            $update['haimian'] = I('haimian');
            if (empty($update['haimian'])) {
                $update['haimian'] = "否";
            } else {
                $update['haimian'] = "是";
            }

            $update['major4'] = I('major4');
            if (empty($update['major4'])) {
                $update['major4'] = "否";
            } else {
                $update['major4'] = "是";
            }
            $update['user_uid'] = $uid;

            $fenlei['fenlei_name']=$update['fenlei'] = I('fenlei');

            //从分类表里查询出具体分类的详细信息  一个分类对应的各个阶段


            $update['name'] = I('name');
            $update['next_plan'] = I('next_plan');
            $update['location'] = I('location');
            $update['total_money'] = I('total_money');
            $update['company'] = I('company');
            $up1['company']=I('shuru');
            if(!empty($up1['company'])){
                $update['company']=$up1['company'];
            }
            $update['man'] = I('man');
            $update['phone'] = I('phone');
            $update['work_progress'] = I('work_progress');

            $update['problem'] = I('problem');

            $update['construction_year'] = I('construction_year');
            $update['construction_content'] = I('construction_content');
            $update['current_week'] = I('current_week');
            $update['finish_time1'] = I('finish_time1');
            $update['finish_time2'] = I('finish_time2');
            $update['finish_time3'] = I('finish_time3');
            $update['finish_time4'] = I('finish_time4');
            $update['finish_time5'] = I('finish_time5');
            $update['finish_time6'] = I('finish_time6');
            $update['finish_time7'] = I('finish_time7');
            $update['finish_time8'] = I('finish_time8');
            $update['finish_time9'] = I('finish_time9');
            $update['finish_time10'] = I('finish_time10');
            $update['finish_time11'] = I('finish_time11');
            $update['plan_01'] = I('plan_01');
            $update['plan_02'] = I('plan_02');
            $update['plan_03'] = I('plan_03');
            $update['plan_04'] = I('plan_04');
            $update['plan_05'] = I('plan_05');
            $update['plan_06'] = I('plan_06');
            $update['plan_07'] = I('plan_07');
            $update['money_need'] = I('money_need');
            $update['next_year_plan'] = I('next_year_plan');
            $update['money_need_next'] = I('money_need_next');

            $add2['name'] = I('company');

            if (! empty($update['name'])) {
                if (! empty($add2['name'])) {



                    $xiangmu_first->create($update);

                    $xiangmu_first->add();


                    $xiangmu->create($update);
                    $xiangmu_id=$list = $data = $xiangmu->add();




                    $update['xiangmu_id'] = $list;

                    $xiangmu_copy->create($update);
                    $cscs=$xiangmu_copy->add();
                    $fenlei_stage=M('FenleiStage');
                    $a=$fenlei_stage->where($fenlei)->select();




                    $item_name=M('ItemName');
                    $b=count($a);

                    //帅选出对应的分类id
                    for($i=0;$i<$b;$i++){
                        $c=$a[$i]['fenlei_id'];

                    }
                    $d['fenlei_id']=$c;


                    //从item_stage表里选出本想分类所对应的详细明细事项
                    $d=$item_name->where($d)->select();
                    $e=count($d);

                    $first_stage=M('FirstStage');
                    //帅选出的每一个事项添加到first——stage表里
                    for($i=0;$i<$e;$i++){


                        $data3['xiangmu_id']=$xiangmu_id;
                        $data3['stage']=$d[$i]['stage'];
                        $data3['item_name']=$d[$i]['name'];

                        $first_stage->add($data3);


                    }



                    $update = null;
                    $this->redirect('Xiangmu/index');
                } else {

                    $this->error('请输入完整信息');
                }
            } else {
                $this->error('信息错误');
            }
        } else {  }

        $this->display();
    }
        public function bianji()
    {

        $duty = D('Duty');
        $a = $duty->select();
        // var_dump($a);
        $b = count($a);

        for ($i = 0; $i < $b + 1; $i ++) {

            $c[$i] = $a[$i - 1]['name'];

            $c['0'] = $a['0']['name'];
            // var_dump($c);
            $d = array_filter($c);

            $q = array_unique($d);


            $r = count($q);

            $l = Array();
            foreach ($q as $key => $value) {
                $l[] = Array(
                    'aa' => $key,
                    'company' => $value
                );
            }
            //  dump($l);

            $this->assign('com', $l);

        }
        $duty_result    =   $duty->select();
        $this->assign('duty_result',$duty_result);

        $id['id'] = I('id');
        $xiangmu = D('Xiangmu');

        $result_1 = $xiangmu->where($id)->select();




        $aa['fenlei_name']=$result_1['0']['fenlei'];
        $fenlei_stage=M('FenleiStage');
        //根据id从fenlei_stage里获得stage_id
        $b=$fenlei_stage->field('stage_id')->where($aa)->select();
        $c=array_column($b,stage_id);
        $c=implode(',',$c);
        $ceshi['id']=array('in',$c);

        $stage=M('Stage');
        $data=$stage->where($ceshi)->select();


        $nu=count($data);
        $first_stage=M('FirstStage');
        //使用foreach
        foreach ($data as $k => $v){
            $shaixuan['xiangmu_id']=$id['id'];
            $shaixuan['stage']=$v['id'];
            //  dump($v['id']);
            $cc=$first_stage->where($shaixuan)->select();
            $data[$k]['item'] = $cc;
            unset($cc);
        }


        $this->assign('data',$data);




        $this->assign('result_1', $result_1);


        $update['user_uid'] = $result_1['0']['user_uid'];


        $xiangmu_fenlei = D('Xiangmu_fenlei');
        $list_fenlei = $xiangmu_fenlei->select();
        $this->assign('list_fenlei', $list_fenlei);


        $uid = session('user_auth.uid');

        $xiangmu = D('Xiangmu');
        $id['id'] = I('id');

        $result1 = $xiangmu->where($id)
            ->field('user_uid')
            ->select();






        if (IS_POST) {
            $id['id'] = I('id');

            $update['help'] = I('help');


            $update['action'] = I('action');


            $update['major'] = I('major');


            $update['haimian'] = I('haimian');

            $update['shenpi'] = I('shenpi');



            $update['major3'] = I('major3');


            $update['major4'] = I('major4');
            $update['major2'] = I('major2');


            $update['fenlei'] = I('fenlei');


            $update['name'] = I('name');
            $update['next_plan'] = I('next_plan');
            $update['location'] = I('location');
            $update['company'] = I('company');

            $update['total_money'] = I('total_money');
            $up1['company']=I('shuru');

            $update['man'] = I('man');
            $update['phone'] = I('phone');
            $update['work_progress'] = I('work_progress');
            $update['problem'] = I('problem');

            $add2['name'] = I('company');


            $return_result  =   $xiangmu->where($id)->find();

            if($return_result['fenlei']==$update['fenlei']){


            }else{

                $first_stage_where['xiangmu_id']    =   $id['id'];

                $first_stage->where($first_stage_where)->delete();
                $fenlei['fenlei_name']  =   $update['fenlei'];
                $a=$fenlei_stage->where($fenlei)->select();



                $item_name=M('ItemName');
                $b=count($a);

                //帅选出对应的分类id
                for($i=0;$i<$b;$i++){
                    $c=$a[$i]['fenlei_id'];

                }
                $d1['fenlei_id']=$c;

                $d1=$item_name->where($d1)->select();
                $e=count($d1);


                //帅选出的每一个事项添加到first——stage表里
                for($i=0;$i<$e;$i++){


                    $data3['xiangmu_id']=$id['id'];

                    $data3['stage']=$d1[$i]['stage'];
                    $data3['item_name']=$d1[$i]['name'];

                    $first_stage->add($data3);



                }

            }
            $xiangmu->where($id)->save($update);




            $this->redirect('Xiangmu/index');
        } else {}

        $this->display();
    }
    public  function xiugai($id='',$start_time='',$end_time=''){
        $first_stage=M('FirstStage');
        $where['id']=$id;

        if($start_time!=''){

            $updata['start_time']=$start_time;

        }
        if($end_time!=''){
            $updata['end_time']=$end_time;
//            $updata['end_time']=strtotime( $updata['end_time']);

        }

        $first_stage->where($where)->save($updata);
        $data="ok";
        $this->ajaxReturn($data);

    }
    public  function second(){

        $q['id']=I('id');

        $uid['user_uid'] = session('user_auth.uid');
        $xiangmu=M('Xiangmu');
        $list=$xiangmu->where($q)->select();
        $this->assign('result_1',$list);
        if (IS_POST) {

            $where['id']=I('id');
            $updata['construction_year']=I('construction_year');
            $updata['construction_content']=I('construction_content');
            $updata['current_week']=I('current_week');
            $updata['plan_01']=I('plan_01');
            $updata['plan_02']=I('plan_02');
            $updata['plan_03']=I('plan_03');
            $updata['plan_04']=I('plan_04');
            $updata['plan_05']=I('plan_05');
            $updata['plan_06']=I('plan_06');
            $updata['plan_07']=I('plan_07');
            $updata['money_need']=I('money_need');
            $updata['next_year_plan']=I('next_year_plan');
            $updata['money_need_next']=I('money_need_next');
            $xiangmu->where($where)->save($updata);
            $this->redirect('Xiangmu/index');

        }









        $this->display();




    }

    public function city_project()
    {
        $xiangmu = D('Xiangmu');
        $major['major'] = "是";
        $data = $this->lists('Xiangmu', $major, 'create_time');
        $this->assign('_list', $data);
        $this->display();
    }

    public function major2()
    {
        $xiangmu = D('Xiangmu');
        $major['major2'] = "是";
        $data = $this->lists('Xiangmu', $major, 'create_time');
        $this->assign('_list', $data);
        $this->display();
    }

    public function major3()
    {
        $xiangmu = D('Xiangmu');
        $major['major3'] = "是";
        $data = $this->lists('Xiangmu', $major, 'create_time');
        $this->assign('_list', $data);
        $this->display();
    }

    public function major4()
    {
        $xiangmu = D('Xiangmu');
        $major['major4'] = "是";
        $data = $this->lists('Xiangmu', $major, 'create_time');
        
        $this->assign('_list', $data);
        $this->display();
    }

    public function bianji2()
    {
        $this->select_company();
        $id['id'] = I('id');
        $xiangmu = D('Xiangmu');
        $result_1 = $xiangmu->where($id)->select();
       
        $this->assign('result_1', $result_1);
        $xiangmu_fenlei = D('Xiangmu_fenlei');
        $list_fenlei = $xiangmu_fenlei->select();
        $this->assign('fenlei', $list_fenlei);
      
        $user['user_id'] = session('user_auth.uid');
        if (IS_POST) {
            $id['id'] = I('id');
            echo $id['id'];
            
            $update['help'] = I('help');
            if (empty($update['help'])) {
                $update['help'] = "否";
            } else {
                $update['help'] = "是";
            }
            
            $update['action'] = I('action');
            if (empty($update['action'])) {
                $update['action'] = "否";
            } else {
                $update['action'] = "是";
            }
            
            $update['major'] = I('major');
            if (empty($update['major'])) {
                $update['major'] = "否";
            } else {
                $update['major'] = "是";
            }
            
            $update['major2'] = I('major2');
            
            if (empty($update['major2'])) {
                $update['major2'] = "否";
            } else {
                $update['major2'] = "是";
            }
            
            $update['major3'] = I('major3');
            if (empty($update['major3'])) {
                $update['major3'] = "否";
            } else {
                $update['major3'] = "是";
            }
            
            $update['major4'] = I('major4');
            if (empty($update['major4'])) {
                $update['major4'] = "否";
            } else {
                $update['major4'] = "是";
            }
            $update['fenlei'] = I('fenlei');
            $update['next_plan'] = I('next_plan');
            $update['name'] = I('name');
            $update['location'] = I('location');
            $update['company'] = I('company');
            $update['man'] = I('man');
            $update['phone'] = I('phone');
            $update['work_progress'] = I('work_progress');
            $update['next_plan"'] = I('next_plan"');
            $update['problem'] = I('problem');
            
            $xiangmu = D('Xiangmu');
            $xiangmu->where($id)->save($update);
            
            $xiangmu_copy = D('xiangmu_copy');
            $update['xiangmu_id'] = I('id');
           
            $xiangmu_copy->create($update);
            $xiangmu_copy->add();
            
            $this->redirect('Xiangmu/index');
        } else {}
        
        $this->display();
    }



    public function delete()
    {
        $xiangmu = D('Xiangmu');

        
        $id['id'] = I('id');
       
        $xiangmu->where($id)->delete();


        


        $this->redirect('Xiangmu/index');
    }

    public function sousuo()
    {

        $this->select_man();
        $this->select_company();
        
        $xiangmu_fenlei = D('Xiangmu_fenlei');
        $list_fenlei = $xiangmu_fenlei->select();
        $this->assign('fenlei', $list_fenlei);



        
        $xiangmu = D('Xiangmu');
        $xiangmu_first = D('Xiangmu_first');
        $fenlei = $sousuo['fenlei'] = I('fenlei');
        if (! empty($fenlei)) {
            $where['fenlei'] = array(
                'like',
                '%' . $fenlei . '%'
            );
        }
        $name = $sousuo['name'] = I('name');
        if (! empty($name)) {
            $where['name'] = array(
                'like',
                '%' . $name . '%'
            );
        }
        $company = $sousuo['company'] = I('company');
        if (! empty($sousuo['company'])) {
            
            $company = trim($company);
            
            $where['company'] = array(
                'like',
                '%' . $company . '%'
            );
        }

        $time1 = I('time1');
        $time2 = I('time2');
        
        if (! empty($time1) && ! empty($time2)) {
           $time1= strtotime($time1);
            $time2= strtotime($time2);

            $where['create_time'] = array(
                'between',
                $time1 . ',' . $time2
            );
        }
        if (empty($time1) && ! empty($time2)) {
            $time2= strtotime($time2);
            $where['create_time'] = array(
                'elt',
                $time2
            );
        }
        
        if (empty($time2) && ! empty($time1)) {
            $time1= strtotime($time1);
            $where['create_time'] = array(
                'egt',
                $time1
            );
        }
        
        $man = $sousuo['man'] = I('man');
        if (! empty($sousuo['man'])) {
            $man = trim($man); // 首先去掉头尾空格
            $where['man'] = array(
                'like',
                '%' . $man . '%'
            );
        }
        
        $help = $sousuo['help'] = I('help');
        
        if (! empty($help)) {
            
            $where['help'] = $help;
        }
        $major=$sousuo['major']=I('major');
        if(!empty($major)){
            $where['major']=$major;
        }
        $haimian=$sousuo['haimian']=I('haimian');
        if(!empty($haimian)){
            $where['haimian']=$haimian;
        }

        $shenpi=$sousuo['shenpi']=I('shenpi');
        if(!empty($shenpi)){
            $where['shenpi']=$shenpi;
        }

        $major4=$sousuo['major4']=I('major4');
        if(!empty($major4)){
            $where['major4']=$major4;
        }
        $major2=$sousuo['major2']=I('major2');
        if(!empty($major2)){
            $where['major2']=$major2;
        } $major3=$sousuo['major3']=I('major3');
        if(!empty($major3)){
            $where['major3']=$major3;
        }
        $action = $sousuo['action'] = I('action');
        
        if (! empty($action)) {
            $where['action'] = $action;
        }
        
        $where['id'] = array(
            'egt',
            - 100
        );

        session('where', $where);


            
            $Model = D('Xiangmu');
            $list = $this->lists($Model, $where, 'create_time');
            $nu = count($list);
            
            for ($i = 0; $i < $nu; $i ++) {
                // echo $nu;
                
                $list[$i]['time'] = substr($list[$i]['time'], 0, 10);
            }
            
            $this->assign('_list', $list);
            session('dayin_sousuo',$list);
        
        $this->display();
    }

    public function xiangmu_copy_chakan()
    {
        $id['xiangmu_id'] = I('id');
        $xiangmu_copy = D('xiangmu_copy');
        

        $list = $this->lists('Xiangmu_copy', $id, '');

        $count1 = count($list);
        $count2 = 0;

        $a = $list[$count2];
        $b = $list[$count2];

        
        $this->assign('a', $a);
        $this->assign('b', $b);

        $this->assign('_list', $list);
        
        $this->display();
    }

    public function xiangmu_copy_delete()
    {
        $xiangmu_copy = D('Xiangmu_copy');
        $id['id'] = I('id');
     $a=$xiangmu_copy->where($id)->field('xiangmu_id')->select();
        $b['xiangmu_id']=$a['0']['xiangmu_id'];

        $c=$xiangmu_copy->where($b)->select();

        if(count($c)>1){
            $xiangmu_copy->where($id)->delete();
            $this->redirect('Xiangmu/index');
        }else{
            $this->error('请至少保留一条更新记录');

        }


        $this->display();
    }

    public function out()
    {
        $data = array(
            array(
                'username' => 'zhangsan',
                'password' => "123456"
            ),
            array(
                'username' => 'lisi',
                'password' => "abcdefg"
            ),
            array(
                'username' => 'wangwu',
                'password' => "111111"
            )
        );
        // 导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
        import("Org.Util.PHPExcel");
        import("Org.Util.PHPExcel.Writer.Excel5");
        import("Org.Util.PHPExcel.IOFactory.php");
        
        $filename = "test_excel";
        $headArr = array(
            "用户名",
            "密码"
        );
        $this->getExcel($filename, $headArr, $data);
    }

    private function getExcel($data,$result_1)
    {
        $headArr = array(
            "项目编号",
            "项目名称",
            "项目分类",
            '项目位置',
            '责任单位',
            '责任人',
            '联系电话',
            '目前工作进展情况',
            '下一步工作打算',
            '存在问题',
            '是否需要协调',
            '是否开工',
            '市重点项目',
            '市政务办现场会项目',
            '区重点项目',
            '区局联席会项目',
            '海绵城市项目',

            '是否通过审批',

            '项目建设年度',
            '建设内容',
            '本月周进度计划安排',

            '2016年6月计划安排',
            '2016年7月计划安排',
            '2016年8月计划安排',
            '2016年9月计划安排',
            '2016年10月计划安排',
            '2016年11月计划安排',
            '2016年12月计划安排',
            '2016年年度资金需求',
            '2017年计划安排',
            '2017年资金需求',
            '投资额',

        );
        $fileName="excel";

        // 对数据进行检验
        if (empty($data) || ! is_array($data)) {
            die("data must be a array");
        }
        // 检查文件名
        if (empty($fileName)) {
            exit();
        }
        
        $date = date("Y_m_d", time());
        $fileName .= "_{$date}.xls";
        
        // 创建PHPExcel对象，注意，不能少了\
        $objPHPExcel = new \PHPExcel();
        $objProps = $objPHPExcel->getProperties();
        $arr            =   array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ');
        // 设置表头

        foreach ($headArr as $k => $v) {
            $colum = $arr[$k];


            //dump($colum);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colum . '1', $v);

        }
        $row = 2;
        $a=0;
        $objActSheet = $objPHPExcel->getActiveSheet();

        foreach ($data as $key => $rows) { // 行写入

            foreach ($rows as $keyName => $value) { // 列写入

               $colum = $arr[$a];

                $objActSheet->setCellValue($colum.$row, $value);
                if($a<(count($arr)-12)){
                    $a++;
                }else{
                    $a=0;
                }


            }

            $row ++;
        }
        
        $fileName = iconv("utf-8", "gb2312", $fileName);
        // 重命名表
         $objPHPExcel->getActiveSheet()->setTitle('test');
        // 设置活动单指数到第一个表,所以Excel打开这是第一个表
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=\"$fileName\"");
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output'); // 文件通过浏览器下载
        exit();
    }



//    private function getExcel1($data,$result_1)
//    {
//        $headArr = array(
//            "项目编号",
//            "项目名称",
//            "项目分类",
//            '项目位置',
//            '责任单位',
//            '责任人',
//            '联系电话',
//            '目前工作进展情况',
//            '下一步工作打算',
//            '存在问题',
//            '是否需要协调',
//            '是否开工',
//            '市重点项目',
//            '市政务办现场会项目',
//            '区重点项目',
//            '区局联席会项目',
//            '海绵城市项目',
//
//            '是否通过审批',
//
//            '项目建设年度',
//            '建设内容',
//            '本月周进度计划安排',
//            '立项手续完成时间及文号',
//            '可研手续完成时间及文号',
//            '初步设计手续完成时间及文号',
//            '水土保持手续完成时间及文号',
//            '土地手续完成时间及文号',
//            '规划手续完成时间及文号',
//            '环保手续完成时间及文号',
//            '施工图预算审核完成时间',
//            '完成设计招标时间',
//            '完成施工监理招标时间',
//            '建设周期',
//            '2016年6月计划安排',
//            '2016年7月计划安排',
//            '2016年8月计划安排',
//            '2016年9月计划安排',
//            '2016年10月计划安排',
//            '2016年11月计划安排',
//            '2016年12月计划安排',
//            '2016年年度资金需求',
//            '2017年计划安排',
//            '2017年资金需求',
//            '阶段名称',
//            '序号',
//            '事项名称',
//            '办理时间',
//
//
//        );
//        $fileName="excel";
//
//
//        // 对数据进行检验
//        if (empty($data) || ! is_array($data)) {
//            die("data must be a array");
//        }
//        // 检查文件名
//        if (empty($fileName)) {
//            exit();
//        }
//
//        $date = date("Y_m_d", time());
//        $fileName .= "_{$date}.xls";
//
//
//
//        // 创建PHPExcel对象，注意，不能少了\
//        $objPHPExcel = new \PHPExcel();
//        $objProps = $objPHPExcel->getProperties();
//        $arr            =   array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB');
//        // 设置表头
//
//        $maxColumn = count($data[0]);
//        $maxRow    = count($data);
//
////        for ($i = 0; $i < $maxColumn; $i++) {
////            for ($j = 0; $j < $maxRow; $j++) {
////                $pCoordinate = \PHPExcel_Cell::stringFromColumnIndex($i) . '' . ($j + 1);
////                $pValue      = $data[$j][$i];
////                $objPHPExcel->getActiveSheet()->setCellValue($pCoordinate, $pValue);
////
////            }
////        }
//
//
////        foreach ($headArr as $k => $v) {
////            $colum = $arr[$k];
////
////
////
////            //从第几行开始写入信息
////
////            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colum . '4', $v);
////
////        }
//        $row = 5;
//        $a=0;
//        $b=44;
//        $row1 = 5;
//        $objActSheet = $objPHPExcel->getActiveSheet();
//
//        foreach ($data as $key => $rows) { // 行写入
//
//
//
//            foreach ($rows as $keyName => $value) { // 列写入
//
//                $colum = $arr[$a];
//
//                $objActSheet->setCellValue($colum.$row, $value);
//                if($a<(count($arr)-13)){
//                    $a++;
//                }else{
//                    $a=0;
//                }
//
//            }
//
//            foreach ($headArr as $k => $v) {
//                $colum = $arr[$k];
//                //从第几行开始写入信息
//                $objPHPExcel->setActiveSheetIndex($key)->setCellValue($colum . '4', $v);
//            }
//
//
//
//            $objPHPExcel->getActiveSheet()->mergeCells('A1:AV2');
//            $objPHPExcel->getActiveSheet()->setCellValue('A1','李沧区综合建设业务平台');
//            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER	);
//            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
//
//            $objPHPExcel->getActiveSheet()->mergeCells('A3:AP3');
//            $objPHPExcel->getActiveSheet()->setCellValue('A3','基本信息');
//            $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER	);
//            $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
//
//
//            $objPHPExcel->getActiveSheet()->mergeCells('AQ3:AV3');
//            $objPHPExcel->getActiveSheet()->setCellValue('AQ3',$rows['fenlei']);
//            $objPHPExcel->getActiveSheet()->getStyle('AQ3')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER	);
//            $objPHPExcel->getActiveSheet()->getStyle('AQ3')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
//
//            //$objPHPExcel->getActiveSheet()->mergeCells('AT4:AU4');
//            $objPHPExcel->getActiveSheet()->setCellValue('AT4','受理时间');
//            $objPHPExcel->getActiveSheet()->setCellValue('AU4','结束时间');
//            $objPHPExcel->getActiveSheet()->getStyle('AT4')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER	);
//            $objPHPExcel->getActiveSheet()->getStyle('AT4')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
//
//
//
//            $objPHPExcel->getSheet($key)->setTitle($data[$key]['name']);
//
//
//
//            $objPHPExcel->createSheet();//创建一个新的sheet
//            $objPHPExcel->setActiveSheetIndex($key+1);
//            $objActSheet = $objPHPExcel->getActiveSheet($key+1);
//
//
//
//           // $row ++;
//        }
//        $objPHPExcel->getActiveSheet()->mergeCells('AQ3:AV3');
//        //表格右侧写入
//        $objPHPExcel->setActiveSheetIndex(0);
//        $objActSheet = $objPHPExcel->getActiveSheet(0);
//        $x=0;
//
//        foreach ($result_1 as $key1 =>$rows1){//筛选出来总共多少个项目
//            $n1='5';
//            foreach ($rows1 as $key2 =>$v){//筛选出每个项目对应的阶段有几个
//
//                $number='0';
//                //$n1=$number+$n1;
//                $number=count($v['item']);
//                $n2=$n1+$number;
//                if($number >1){
//                    $n2--;
//                }
//
//
//                $objPHPExcel->getActiveSheet()->mergeCells('AQ'.$n1.':AQ'.$n2);
//                $objPHPExcel->getActiveSheet()->setCellValue('AQ'.$n1,$v['name']);
//                $n1=$n2+1;
//                foreach ($v['item'] as $key3 =>$value1){
//
//                    $x+=1;
//                    $objPHPExcel->getActiveSheet()->setCellValue('AR'.$row1,$x);
//
//                    foreach ($value1 as $key4 =>$value){
//
//
//                        $colum1=$arr[$b];
//                        $objActSheet->setCellValue($colum1.$row1, $value);
//
//
//                        if($b<(count($arr)-8)){
//                            $b++;
//                        }else{
//                            $b=44;
//                        }
//                    }
//                    $row1++;
//
//                }
//
//
//            }
//
//
//            $row1 = 5;
//            $objPHPExcel->setActiveSheetIndex($key1+1);
//            $objActSheet = $objPHPExcel->getActiveSheet($key1+1);
//            $x=0;
//
//        }
//
//
//
////
////        $objPHPExcel->setActiveSheetIndex(0);
////        $objPHPExcel->getActiveSheet()->setTitle('Simple');
////        $objActSheet->getStyle ('A1' )
////            ->getFont ()
////            ->getColor()
////            ->setARGB(\PHPExcel_Style_Color::COLOR_BLACK);
////        $objPHPExcel->getActiveSheet()->getStyle('E4')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);
////        $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('E4'), 'E5:E13' );
////        $objActSheet ->getStyle ('A')
////            ->getNumberFormat()
////            ->setFormatCode ( \PHPExcel_Style_NumberFormat::FORMAT_TEXT );
//        //设置单元格宽度
////        $objActSheet ->getColumnDimension ('A')
////            ->setWidth(9);
////        $objActSheet ->getColumnDimension ('E')
////            ->setWidth(10);
////        $objActSheet ->getColumnDimension ('J')
////            ->setWidth(20);
////        $objActSheet ->getColumnDimension ('B')
////            ->setAutoSize(true);
////        $objActSheet ->getColumnDimension ('D')
////            ->setAutoSize(true);
////
////        $objActSheet ->getColumnDimension ('F')
////            ->setAutoSize(true);
////        //调整字体大小
////        $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('微软雅黑')->setSize(11);
////        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('微软雅黑')->setSize(26)->setBold(true);
////        $objPHPExcel->getActiveSheet()->getStyle('A:AQ4')->getFont()->setName('微软雅黑')->setSize(15)->setBold(true);
////
////        //设置背景颜色
////        $objPHPExcel->getActiveSheet()->getStyle('A4:AQ4')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6fc144');
////        $objPHPExcel->getActiveSheet()->getStyle('A5:AQ999')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('CAE1FF');
////        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('EBEBEB');
////
////
////        $objPHPExcel->getActiveSheet()->getStyle('A1:AQ999')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
////        //设置自动换行
////        $objPHPExcel->getActiveSheet()->getStyle('A5:AQ999')->getAlignment()->setWrapText(true);
//
//
//
//
//
////题目
//        $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
//        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&C&HPlease treat this document as confidential!');
//        $objPHPExcel->getActiveSheet()->getStyle('E4')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);
//        $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
////        $objPHPExcel->getActiveSheet()->setTitle('Simple');
//
//      //  $objPHPExcel->getActiveSheet()->mergeCells('A1:E2');
//
//        $fileName = iconv("utf-8", "gb2312", $fileName);
//        // 重命名表
//      //  $objPHPExcel->getActiveSheet()->setTitle('test');
//        // 设置活动单指数到第一个表,所以Excel打开这是第一个表
//        $objPHPExcel->setActiveSheetIndex(0);
//        header('Content-Type: application/vnd.ms-excel');
//        header("Content-Disposition: attachment;filename=\"$fileName\"");
//        header('Cache-Control: max-age=0');
//
////        $objPHPExcel->createSheet();//创建一个新的sheet
////        $objPHPExcel->setActiveSheetIndex(1);   //设置第2个表为活动表，提供操作句柄   活动表就是打开表格式焦点所在的表格
////        $objPHPExcel->getSheet(1)->setTitle( '测试2');   //直接得到第二个表进行设置,将工作表重新命名为测试2
//      //  $objPHPExcel->getActiveSheet()->getTabColor()->setARGB( 'FF0094FF');     //设置标签颜色
//
//        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//        $objWriter->save('php://output'); // 文件通过浏览器下载
//        exit();
//    }
    private function getExcel1($data,$result_1)
    {

        $headArr = array(
            "项目编号",
            "项目名称",
            "项目分类",
            '项目位置',
            '责任单位',
            '责任人',
            '联系电话',
            '目前工作进展情况',
            '下一步工作打算',
            '存在问题',
            '是否需要协调',
            '是否开工',
            '市重点项目',
            '市政务办现场会项目',
            '区重点项目',
            '区局联席会项目',
            '海绵城市项目',

            '是否通过审批',

            '项目建设年度',
            '建设内容',
            '本月周进度计划安排',

            '2016年6月计划安排',
            '2016年7月计划安排',
            '2016年8月计划安排',
            '2016年9月计划安排',
            '2016年10月计划安排',
            '2016年11月计划安排',
            '2016年12月计划安排',
            '2016年年度资金需求',
            '2017年计划安排',
            '2017年资金需求',
            '投资额',
            '阶段名称',
            '序号',
            '事项名称',
            '办理时间',


        );
        $fileName="excel";


        // 对数据进行检验
        if (empty($data) || ! is_array($data)) {
            die("data must be a array");
        }
        // 检查文件名
        if (empty($fileName)) {
            exit();
        }

        $date = date("Y_m_d", time());
        $fileName .= "_{$date}.xls";



        // 创建PHPExcel对象，注意，不能少了\
        $objPHPExcel = new \PHPExcel();
        $objProps = $objPHPExcel->getProperties();
        $arr            =   array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ');
        // 设置表头

        $maxColumn = count($data[0]);
        $maxRow    = count($data);

//        for ($i = 0; $i < $maxColumn; $i++) {
//            for ($j = 0; $j < $maxRow; $j++) {
//                $pCoordinate = \PHPExcel_Cell::stringFromColumnIndex($i) . '' . ($j + 1);
//                $pValue      = $data[$j][$i];
//                $objPHPExcel->getActiveSheet()->setCellValue($pCoordinate, $pValue);
//
//            }
//        }


//        foreach ($headArr as $k => $v) {
//            $colum = $arr[$k];
//
//
//
//            //从第几行开始写入信息
//
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colum . '4', $v);
//
//        }
        $row = 5;
        $a=0;
        $b=34;
        $row1 = 5;
        $objActSheet = $objPHPExcel->getActiveSheet();

        foreach ($data as $key => $rows) { // 行写入



            foreach ($rows as $keyName => $value) { // 列写入

                $colum = $arr[$a];

                $objActSheet->setCellValue($colum.$row, $value);


                if($a<(count($arr)-12)){
                    $a++;
                }else{
                    $a=0;
                }

            }


            foreach ($headArr as $k => $v) {
                $colum = $arr[$k];
                //从第几行开始写入信息
                $objPHPExcel->setActiveSheetIndex($key)->setCellValue($colum . '4', $v);
            }



            $objPHPExcel->getActiveSheet()->mergeCells('A1:AK2');
            $objPHPExcel->getActiveSheet()->setCellValue('A1','李沧区综合建设业务平台');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER	);
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);

            $objPHPExcel->getActiveSheet()->mergeCells('A3:AE3');
            $objPHPExcel->getActiveSheet()->setCellValue('A3','基本信息');
            $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER	);
            $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);


            $objPHPExcel->getActiveSheet()->mergeCells('AG3:AK3');
            $objPHPExcel->getActiveSheet()->setCellValue('AG3',$rows['fenlei']);
            $objPHPExcel->getActiveSheet()->getStyle('AG3')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER	);
            $objPHPExcel->getActiveSheet()->getStyle('AG3')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);

            //$objPHPExcel->getActiveSheet()->mergeCells('AT4:AU4');
            $objPHPExcel->getActiveSheet()->setCellValue('AJ4','受理时间');
            $objPHPExcel->getActiveSheet()->setCellValue('AK4','结束时间');
            $objPHPExcel->getActiveSheet()->getStyle('AJ4')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER	);
            $objPHPExcel->getActiveSheet()->getStyle('AN4')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);



            $objPHPExcel->getSheet($key)->setTitle($data[$key]['name']);



            $objPHPExcel->createSheet();//创建一个新的sheet
            $objPHPExcel->setActiveSheetIndex($key+1);
            $objActSheet = $objPHPExcel->getActiveSheet($key+1);



            // $row ++;
        }
        $objPHPExcel->getActiveSheet()->mergeCells('AG3:AL3');
        //表格右侧写入
        $objPHPExcel->setActiveSheetIndex(0);
        $objActSheet = $objPHPExcel->getActiveSheet(0);
        $x=0;

        foreach ($result_1 as $key1 =>$rows1){//筛选出来总共多少个项目
            $n1='5';
            $n2='0';
            foreach ($rows1 as $key2 =>$v){//筛选出每个项目对应的阶段有几个

                $number='0';
                //$n1=$number+$n1;
                $number=count($v['item']);
//                dump($number);
//                exit();
                $n2=$n1+$number;
                if($number >1){
                    $n2--;
                }



                $objPHPExcel->getActiveSheet()->mergeCells('AG'.$n1.':AG'.$n2);
                ;

                $objPHPExcel->getActiveSheet()->setCellValue('AG'.$n1,$v['name']);
                $n1=$n2+1;
                foreach ($v['item'] as $key3 =>$value1){

                    $x+=1;
                    $objPHPExcel->getActiveSheet()->setCellValue('AH'.$row1,$x);

                    foreach ($value1 as $key4 =>$value){


                        $colum1=$arr[$b];
                        $objActSheet->setCellValue($colum1.$row1, $value);


                        if($b<(count($arr)-7)){
                            $b++;
                        }else{
                            $b=34;
                        }
                    }
                    $row1++;

                }


            }


            $row1 = 5;
            $objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setWidth(50);
            $objPHPExcel->setActiveSheetIndex($key1+1);
            $objActSheet = $objPHPExcel->getActiveSheet($key1+1);
            $x=0;


        }



//
//        $objPHPExcel->setActiveSheetIndex(0);
//        $objPHPExcel->getActiveSheet()->setTitle('Simple');
//        $objActSheet->getStyle ('A1' )
//            ->getFont ()
//            ->getColor()
//            ->setARGB(\PHPExcel_Style_Color::COLOR_BLACK);
//        $objPHPExcel->getActiveSheet()->getStyle('E4')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);
//        $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('E4'), 'E5:E13' );
//        $objActSheet ->getStyle ('A')
//            ->getNumberFormat()
//            ->setFormatCode ( \PHPExcel_Style_NumberFormat::FORMAT_TEXT );
        //设置单元格宽度
//        $objActSheet ->getColumnDimension ('A')
//            ->setWidth(9);
//        $objActSheet ->getColumnDimension ('E')
//            ->setWidth(10);
//        $objActSheet ->getColumnDimension ('J')
//            ->setWidth(20);
//        $objActSheet ->getColumnDimension ('B')
//            ->setAutoSize(true);
//        $objActSheet ->getColumnDimension ('D')
//            ->setAutoSize(true);
//
//        $objActSheet ->getColumnDimension ('F')
//            ->setAutoSize(true);
//        //调整字体大小
//        $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('微软雅黑')->setSize(11);
//        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('微软雅黑')->setSize(26)->setBold(true);
//        $objPHPExcel->getActiveSheet()->getStyle('A:AQ4')->getFont()->setName('微软雅黑')->setSize(15)->setBold(true);
//
//        //设置背景颜色
//        $objPHPExcel->getActiveSheet()->getStyle('A4:AQ4')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6fc144');
//        $objPHPExcel->getActiveSheet()->getStyle('A5:AQ999')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('CAE1FF');
//        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('EBEBEB');
//
//
//        $objPHPExcel->getActiveSheet()->getStyle('A1:AQ999')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
//        //设置自动换行
//        $objPHPExcel->getActiveSheet()->getStyle('A5:AQ999')->getAlignment()->setWrapText(true);





//题目
        $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&C&HPlease treat this document as confidential!');
        $objPHPExcel->getActiveSheet()->getStyle('E4')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);
        $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
//        $objPHPExcel->getActiveSheet()->setTitle('Simple');

        //  $objPHPExcel->getActiveSheet()->mergeCells('A1:E2');

        $fileName = iconv("utf-8", "gb2312", $fileName);
        // 重命名表
        //  $objPHPExcel->getActiveSheet()->setTitle('test');
        // 设置活动单指数到第一个表,所以Excel打开这是第一个表
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=\"$fileName\"");
        header('Cache-Control: max-age=0');

//        $objPHPExcel->createSheet();//创建一个新的sheet
//        $objPHPExcel->setActiveSheetIndex(1);   //设置第2个表为活动表，提供操作句柄   活动表就是打开表格式焦点所在的表格
//        $objPHPExcel->getSheet(1)->setTitle( '测试2');   //直接得到第二个表进行设置,将工作表重新命名为测试2
        //  $objPHPExcel->getActiveSheet()->getTabColor()->setARGB( 'FF0094FF');     //设置标签颜色

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output'); // 文件通过浏览器下载
        exit();
    }
    public function dayin_all1()
    {
        $xiangmu = D('Xiangmu');
       $list=session('dayin_sousuo');
        $nu = count($list);

        for($i=0;$i<$nu;$i++){

            $where['id']=$list[$i]['id'];
            $data[] = $xiangmu->field('user_uid,time,create_time,xiangmu_uid,finish_time1,finish_time2,finish_time3,finish_time4,finish_time5,finish_time6,finish_time7,finish_time8,finish_time9,finish_time10,finish_time11',true)->where($where)->find();



        }



        if (! empty($data)) {

            // 导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
            import("Org.Util.PHPExcel");
            import("Org.Util.PHPExcel.Writer.Excel5");
            import("Org.Util.PHPExcel.IOFactory.php");

            $filename = "test_excel";
            $result_1='';

            $this->getExcel($data,$result_1);

        } else {
            $this->error('没有要打印的报表');
        }
    }
    public function dayin_all()
    {
        $first_stage=M('FirstStage');
        $xiangmu = D('Xiangmu');
        $fenlei_stage=M('FenleiStage');
        $stage=M('Stage');


        $data = $xiangmu->field('user_uid,time,create_time,xiangmu_uid,finish_time1,finish_time2,finish_time3,finish_time4,finish_time5,finish_time6,finish_time7,finish_time8,finish_time9,finish_time10,finish_time11',true)->select();

      $number=count($data);



        for ($i=0;$i<$number;$i++){


            $shaixuan['fenlei_name']=$data[$i]['fenlei'];
            $cc=$fenlei_stage->field('stage_id')->where($shaixuan)->select();
            $c=array_column($cc,stage_id);
            $c=implode(',',$c);
            $ceshi['id']=array('in',$c);
            $result_1[$i]=$stage->where($ceshi)->select();

            $where1[$i]=$data[$i]['id'];


        }
//        $where1=implode(',',$where1);

       // dump($result_1);



              foreach ($result_1 as $k => $v) {
                  $where['xiangmu_id']=$where1[$k];

                  foreach ($v as $keyName => $value){

                       $where['stage']=$value['id'];


                      $ccc=$first_stage->field('item_name,start_time,end_time')->where($where)->select();
                      $nu=count($ccc);
//                    for($z=0;$z<$nu;$z++){
//                        //$ccc[$z]['id']=$z+1;
//                        array_unshift( $ccc[$z],$z+1);
//                    }

                       $result_1[$k][$keyName]['item']=$ccc;
                      unset($cc);
                  }


                  unset($cc);

              }










        if (! empty($data)) {

            // 导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
            import("Org.Util.PHPExcel");
            import("Org.Util.PHPExcel.Writer.Excel5");
            import("Org.Util.PHPExcel.IOFactory.php");
            
            $filename = "test_excel";

            $this->getExcel($data,$result_1);
        } else {
            $this->error('没有要打印的报表');
        }
    }

    public function dayin_major()
    {
        $xiangmu = D('Xiangmu');
        $where['major'] = "是";
        $data = $xiangmu->where($where)
            ->field('user_uid,time,create_time,xiangmu_uid', true)
            ->select();

        $number = count($data);
        if (! empty($data)) {
            // var_dump($data);
            /*
             * $data=array(
             * array('username'=>'zhangsan','password'=>"123456"),
             * array('username'=>'lisi','password'=>"abcdefg"),
             * array('username'=>'wangwu','password'=>"111111"),
             * );
             */
            // var_dump($data);
            // 导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
            import("Org.Util.PHPExcel");
            import("Org.Util.PHPExcel.Writer.Excel5");
            import("Org.Util.PHPExcel.IOFactory.php");
            

            $this->getExcel($data);
        } else {
            $this->error('没有要打印的报表');
        }
    }
    public function dayin_disan($company="")
    {   $stage=M('Stage');
        $fenlei_stage=M('FenleiStage');
        $first_stage=M('FirstStage');
$result1['company']=$company;


    $xiangmu=D('Xiangmu');


    $data = $xiangmu->where($result1)
        ->field('user_uid,time,create_time,xiangmu_uid,finish_time1,finish_time2,finish_time3,finish_time4,finish_time5,finish_time6,finish_time7,finish_time8,finish_time9,finish_time10,finish_time11', true)
        ->select();

        $number=count($data);



        for ($i=0;$i<$number;$i++){


            $shaixuan['fenlei_name']=$data[$i]['fenlei'];
            $cc=$fenlei_stage->field('stage_id')->where($shaixuan)->select();
            $c=array_column($cc,stage_id);
            $c=implode(',',$c);
            $ceshi['id']=array('in',$c);
            $result_1[$i]=$stage->where($ceshi)->select();

            $where1[$i]=$data[$i]['id'];


        }


        foreach ($result_1 as $k => $v) {
            $where['xiangmu_id']=$where1[$k];

            foreach ($v as $keyName => $value){

                $where['stage']=$value['id'];


                $ccc=$first_stage->field('item_name,start_time,end_time')->where($where)->select();
                $nu=count($ccc);
//                    for($z=0;$z<$nu;$z++){
//                        //$ccc[$z]['id']=$z+1;
//                        array_unshift( $ccc[$z],$z+1);
//                    }

                $result_1[$k][$keyName]['item']=$ccc;
                unset($cc);
            }


            unset($cc);

        }


        if (! empty($data)) {

        // 导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
        import("Org.Util.PHPExcel");
        import("Org.Util.PHPExcel.Writer.Excel5");
        import("Org.Util.PHPExcel.IOFactory.php");


        $this->getExcel($data,$result_1);
    } else {
        $this->error('没有要打印的报表');
    }

    }
    public function dayin_major2()
    {
        $xiangmu = D('Xiangmu');
        $where['major2'] = "是";
        $data = $xiangmu->where($where)
            ->field('user_uid,time,create_time,xiangmu_uid', true)
            ->select();
        $number = count($data);
        if (! empty($data)) {

            // 导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
            import("Org.Util.PHPExcel");
            import("Org.Util.PHPExcel.Writer.Excel5");
            import("Org.Util.PHPExcel.IOFactory.php");
            
            $filename = "test_excel";
            $headArr = array(
                "项目编号",
                "项目名称",
                "项目分类",
                '项目位置',
                '责任单位',
                '责任人',
                '联系电话',
                '目前工作进展情况',
                '下一步工作打算',
                '存在问题',
                '是否需要协调',
                '是否开工',
                '市重点项目',
                '市政务办现场会项目',
                '区重点项目',
                '区局联席会项目',
                '海绵城市建设项目',
                '是否通过审批',

                '项目建设年度',
                '建设内容',
                '本月周进度计划安排',
                '立项手续完成时间及文号',
                '可研手续完成时间及文号',
                '初步设计手续完成时间及文号',
                '水土保持手续完成时间及文号',
                '土地手续完成时间及文号',
                '规划手续完成时间及文号',
                '环保手续完成时间及文号',
                '施工图预算审核完成时间',
                '完成设计招标时间',
                '完成施工监理招标时间',
                '建设周期',
                '2016年6月计划安排',
                '2016年7月计划安排',
                '2016年8月计划安排',
                '2016年9月计划安排',
                '2016年10月计划安排',
                '2016年11月计划安排',
                '2016年12月计划安排',
                '2016年年度资金需求',
                '2017年计划安排',
                '2017年资金需求',

            );
            $this->getExcel($filename, $headArr, $data);
        } else {
            $this->error('没有要打印的报表');
        }
    }

    public function dayin_major3()
    {
        $xiangmu = D('Xiangmu');
        $where['major3'] = "是";
        $data = $xiangmu->where($where)
            ->field('user_uid,time,create_time,xiangmu_uid', true)
            ->select();
        $number = count($data);
        if (! empty($data)) {

            // 导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
            import("Org.Util.PHPExcel");
            import("Org.Util.PHPExcel.Writer.Excel5");
            import("Org.Util.PHPExcel.IOFactory.php");
            
            $filename = "test_excel";
            $headArr = array(
                "项目编号",
                "项目名称",
                "项目分类",
                '项目位置',
                '责任单位',
                '责任人',
                '联系电话',
                '目前工作进展情况',
                '下一步工作打算',
                '存在问题',
                '是否需要协调',
                '是否开工',
                '市重点项目',
                '市政务办现场会项目',
                '区重点项目',
                '区局联席会项目',
                '海绵城市建设项目',
                '是否通过审批',

                '项目建设年度',
                '建设内容',
                '本月周进度计划安排',
                '立项手续完成时间及文号',
                '可研手续完成时间及文号',
                '初步设计手续完成时间及文号',
                '水土保持手续完成时间及文号',
                '土地手续完成时间及文号',
                '规划手续完成时间及文号',
                '环保手续完成时间及文号',
                '施工图预算审核完成时间',
                '完成设计招标时间',
                '完成施工监理招标时间',
                '建设周期',
                '2016年6月计划安排',
                '2016年7月计划安排',
                '2016年8月计划安排',
                '2016年9月计划安排',
                '2016年10月计划安排',
                '2016年11月计划安排',
                '2016年12月计划安排',
                '2016年年度资金需求',
                '2017年计划安排',
                '2017年资金需求',

            );
            $this->getExcel($filename, $headArr, $data);
        } else {
            $this->error('没有要打印的报表');
        }
    }

    public function dayin_major4()
    {
        $xiangmu = D('Xiangmu');
        $where['major4'] = "是";
        $data = $xiangmu->where($where)
            ->field('user_uid,time,create_time,xiangmu_uid', true)
            ->select();
        $number = count($data);
        if (! empty($data)) {
            // var_dump($data);
            /*
             * $data=array(
             * array('username'=>'zhangsan','password'=>"123456"),
             * array('username'=>'lisi','password'=>"abcdefg"),
             * array('username'=>'wangwu','password'=>"111111"),
             * );
             */
            // var_dump($data);
            // 导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
            import("Org.Util.PHPExcel");
            import("Org.Util.PHPExcel.Writer.Excel5");
            import("Org.Util.PHPExcel.IOFactory.php");
            
            $filename = "test_excel";
            $headArr = array(
                "项目编号",
                "项目名称",
                "项目分类",
                '项目位置',
                '责任单位',
                '责任人',
                '联系电话',
                '目前工作进展情况',
                '下一步工作打算',
                '存在问题',
                '是否需要协调',
                '是否开工',
                '市重点项目',
                '市政务办现场会项目',
                '区重点项目',
                '区局联席会项目',
                '海绵城市建设项目',
                '是否通过审批',

                '项目建设年度',
                '建设内容',
                '本月周进度计划安排',
                '立项手续完成时间及文号',
                '可研手续完成时间及文号',
                '初步设计手续完成时间及文号',
                '水土保持手续完成时间及文号',
                '土地手续完成时间及文号',
                '规划手续完成时间及文号',
                '环保手续完成时间及文号',
                '施工图预算审核完成时间',
                '完成设计招标时间',
                '完成施工监理招标时间',
                '建设周期',
                '2016年6月计划安排',
                '2016年7月计划安排',
                '2016年8月计划安排',
                '2016年9月计划安排',
                '2016年10月计划安排',
                '2016年11月计划安排',
                '2016年12月计划安排',
                '2016年年度资金需求',
                '2017年计划安排',
                '2017年资金需求',

            );
            $this->getExcel($filename, $headArr, $data);
        } else {
            $this->error('没有要打印的报表');
        }
    }

    public function dayin_current()
    {

        $id['id']=I('id');

        $first_stage=M('FirstStage');
        $xiangmu = D('Xiangmu');
        $fenlei_stage=M('FenleiStage');
        $stage=M('Stage');


        $data = $xiangmu->field('user_uid,time,create_time,xiangmu_uid,finish_time1,finish_time2,finish_time3,finish_time4,finish_time5,finish_time6,finish_time7,finish_time8,finish_time9,finish_time10,finish_time11',true)->where($id)->select();

        $number=count($data);



        for ($i=0;$i<$number;$i++){


            $shaixuan['fenlei_name']=$data[$i]['fenlei'];
            $cc=$fenlei_stage->field('stage_id')->where($shaixuan)->select();
            $c=array_column($cc,stage_id);
            $c=implode(',',$c);
            $ceshi['id']=array('in',$c);
            $result_1[$i]=$stage->where($ceshi)->select();

            $where1[$i]=$data[$i]['id'];


        }


        foreach ($result_1 as $k => $v) {
            $where['xiangmu_id']=$where1[$k];

            foreach ($v as $keyName => $value){

                $where['stage']=$value['id'];


                $ccc=$first_stage->field('item_name,start_time,end_time')->where($where)->select();
                $nu=count($ccc);
//                    for($z=0;$z<$nu;$z++){
//                        //$ccc[$z]['id']=$z+1;
//                        array_unshift( $ccc[$z],$z+1);
//                    }

                $result_1[$k][$keyName]['item']=$ccc;
                unset($cc);
            }


            unset($cc);

        }

        if (! empty($data)) {

            // 导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
            import("Org.Util.PHPExcel");
            import("Org.Util.PHPExcel.Writer.Excel5");
            import("Org.Util.PHPExcel.IOFactory.php");

            $filename = "test_excel";

            $this->getExcel1($data,$result_1);
        } else {
            $this->success('没有要打印的报表', 'Xiangmu/index');
        }







    }
public function dayin_all2(){
    $this->select_man();
    $this->select_company();

    //筛选


    $xiangmu_fenlei = D('Xiangmu_fenlei');
    $list_fenlei = $xiangmu_fenlei->select();
    $this->assign('fenlei', $list_fenlei);
    $uid = session('user_auth.uid');


    $xiangmu = D('Xiangmu');
    $id['id'] = I('id');

    if (! empty($id['id'])) {

        $list = $xiangmu->where($id)->select();

        $this->assign('_list', $list);
    } else {

        // 使用onethink自带的分页效果 在Config.index里
        $list =$xiangmu->select();
        // $list = $xiangmu->select();
        $nu = count($list);

        for ($i = 0; $i < $nu; $i ++) {


            $list[$i]['time'] = substr($list[$i]['time'], 0, 10);
        }

        $this->assign('_list', $list);
    }
    
    $this->display();
}
    public function dayin_sousuo()
    {
        /*
         * 从session中获取where对象的各个值，使用where来查询
         */
        $result = '';
        
        if (session('where.id')!=null) {
            
            $where['id'] = session('where.id');
        }
        
        if (session('where.create_time')!=null) {
            
            $where['create_time'] = session('where.create_time');
        }
        
        if (session('where.fenlei')!=null) {
            
            $where['fenlei'] = session('where.fenlei');
        }
        if (session('where.company')!=null) {
            
            $where['company'] = session('where.company');
        }
        
        if (session('where.man')!=null) {
            
            $where['man'] = session('where.man');
        }
        
        if (session('where.help')!=null) {
            
            $where['help'] = session('where.help');
        }
        
        if (session('where.action')!=null) {
            
            $where['action'] = session('where.action');
        }
        if (session('where.major')!=null) {

            $where['major'] = session('where.major');
        }
        if (session('where.major2')!=null) {

            $where['major2'] = session('where.major2');
        }
        if (session('where.haimian')!=null) {

            $where['haimian'] = session('where.haimian');
        }
        if (session('where.shenpi')!=null) {

            $where['shenpi'] = session('where.shenpi');
        }
        if (session('where.major3')!=null) {

            $where['major3'] = session('where.major3');
        }
        if (session('where.major4')!=null) {

            $where['major4'] = session('where.major4');
        }

        if ($result == "1") {
            
            $xiangmu = D('Xiangmu');
            $data = $xiangmu->where($where)
                ->field('user_uid,time,create_time,xiangmu_uid', true)
                ->select();
        } else {
            $xiangmu_first = D('Xiangmu_first');
            
            $data = $xiangmu_first->where($where)
                ->field('user_uid,time,create_time,xiangmu_uid', true)
                ->select();
        }
        
        $number = count($data);
        if (! empty($data)) {
            // var_dump($data);
            /*
             * $data=array(
             * array('username'=>'zhangsan','password'=>"123456"),
             * array('username'=>'lisi','password'=>"abcdefg"),
             * array('username'=>'wangwu','password'=>"111111"),
             * );
             */
            // var_dump($data);
            // 导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
            import("Org.Util.PHPExcel");
            import("Org.Util.PHPExcel.Writer.Excel5");
            import("Org.Util.PHPExcel.IOFactory.php");
            
            $filename = "test_excel";
            $headArr = array(
                "项目编号",
                "项目名称",
                "项目分类",
                '项目位置',
                '责任单位',
                '责任人',
                '联系电话',
                '目前工作进展情况',
                '下一步工作打算',
                '存在问题',
                '是否需要协调',
                '是否开工',
                '市重点项目',
                '市政务办现场会项目',
                '区重点项目',
                '区局联席会项目',
                '海绵城市建设项目',
                '是否通过审批',

                '项目建设年度',
                '建设内容',
                '本月周进度计划安排',
                '立项手续完成时间及文号',
                '可研手续完成时间及文号',
                '初步设计手续完成时间及文号',
                '水土保持手续完成时间及文号',
                '土地手续完成时间及文号',
                '规划手续完成时间及文号',
                '环保手续完成时间及文号',
                '施工图预算审核完成时间',
                '完成设计招标时间',
                '完成施工监理招标时间',
                '建设周期',
                '2016年6月计划安排',
                '2016年7月计划安排',
                '2016年8月计划安排',
                '2016年9月计划安排',
                '2016年10月计划安排',
                '2016年11月计划安排',
                '2016年12月计划安排',
                '2016年年度资金需求',
                '2017年计划安排',
                '2017年资金需求',

            );
            $this->getExcel($filename, $headArr, $data);
            session('where', null);
        } else {
            $this->error('没有要打印的报表', U('Xiangmu/index'));
        }
    }

    public function sousuo_xiangmu_copy()
    {
        $xiangmu_copy = D('Xiangmu_copy');
        $bb = I('xiangmu_id');
        session('xiangmu_id', $bb);
        $bbb = I('xiangmu_id');
      
        $time1 = I('time1');
        $time2 = I('time2');
        if (! empty($time1) && ! empty($time2)) {
            $time = " and create_time between '$time1'  and '$time2' ";
            // echo $time;
        }
        
        if (empty($time1) && ! empty($time2)) {
            $time2= strtotime($time2);

            $time = " and create_time <= '$time2' ";
            // echo $time;
        }
        
        if (empty($time2) && ! empty($time1)) {
            $time1= strtotime($time1);
            $time = " and create_time >= '$time1' ";
            // echo $time;
        }
        if (! empty($time1) || ! empty($time2)) {
            $time1= strtotime($time1);
            $time2= strtotime($time2);
            if (! empty($bb)) {
                
                session('xiangmu_id', $bb);

                $chaxun = "xiangmu_id=$bb " . $time;

                
                $list = $this->lists('Xiangmu_copy', $chaxun, 'create_time desc');

                $chaxun1 = $xiangmu_copy->where($bb)
                    ->order('create_time desc')
                    ->select();

               session('chazhao_sql',$chaxun);
                $nu = count($list);
                
                for ($i = 0; $i < $nu; $i ++) {
                    // echo $nu;
                    
                    $list[$i]['time'] = substr($list[$i]['time'], 0, 10);
                }
				$list1=$bb;
                $this->assign('bb', $bb);
                $this->assign('_list', $list);
				$this->assign('list1', $list1);
             
			

            } else {
                
                $bb = session('xiangmu_id');
                $chaxun = "xiangmu_id=$bb " . $time; // echo $chaxun;
                $chaxun1 = $xiangmu_copy->where($bb)
                    ->order('create_time desc')
                    ->select();
                

                $chaxun = "xiangmu_id=$bb " . $time;

				session('chazhao_sql',$chaxun);
                $list = $this->lists('Xiangmu_copy', $chaxun, 'create_time desc');
                $nu = count($list);
                
                for ($i = 0; $i < $nu; $i ++) {
                    // echo $nu;
                    
                    $list[$i]['time'] = substr($list[$i]['time'], 0, 10);
                }
				
                $this->assign('bb', $bb);
				$list1=$bb;
                $this->assign('_list', $list);
				$this->assign('list1', $list1);
                $this->assign('chazhao', $chazhao);
            }
        } else {
            
            $this->error('请输入时间', U('Xiangmu/index'));
        }
        $this->display();
    }

    public function dayin_sousuo_xiangmu_copy()
    {
        $sql = session('chazhao_sql');
		
        $xiangmu_copy = D('Xiangmu_copy');
        if(!empty($sql)){
        $data = $xiangmu_copy->where($sql)
            ->field('id,user_uid,time,create_time,xiangmu_uid', true)
            ->select();
           // dump($data);
			session('chazhao_sql', null);
			$number = count($data);
			if (! empty($data)) {
				
				// 导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
				import("Org.Util.PHPExcel");
				import("Org.Util.PHPExcel.Writer.Excel5");
				import("Org.Util.PHPExcel.IOFactory.php");

				$filename = "test_excel";
				$headArr = array(
					"项目编号",
					"项目名称",
					"项目分类",
					'项目位置',
					'责任单位',
					'责任人',
					'联系电话',
					'目前工作进展情况',
					'下一步工作打算',
					'存在问题',
					'是否需要协调',
					'是否开工',
					'市重点项目',
					'市政务办现场会项目',
					'区重点项目',
                    '区局联席会项目',
                    '海绵城市建设项目',
                    '是否通过审批',

                    '项目建设年度',
                    '建设内容',
                    '本月周进度计划安排',
                    '立项手续完成时间及文号',
                    '可研手续完成时间及文号',
                    '初步设计手续完成时间及文号',
                    '水土保持手续完成时间及文号',
                    '土地手续完成时间及文号',
                    '规划手续完成时间及文号',
                    '环保手续完成时间及文号',
                    '施工图预算审核完成时间',
                    '完成设计招标时间',
                    '完成施工监理招标时间',
                    '建设周期',
                    '2016年6月计划安排',
                    '2016年7月计划安排',
                    '2016年8月计划安排',
                    '2016年9月计划安排',
                    '2016年10月计划安排',
                    '2016年11月计划安排',
                    '2016年12月计划安排',
                    '2016年年度资金需求',
                    '2017年计划安排',
                    '2017年资金需求',

                );
				$this->getExcel($filename, $headArr, $data);
			} else {
				$this->error('没有打印的报表', U('Xiangmu/index'));
			}


			}
	else
{
	$this->error('没有要打印的表');
}
    }

    public function sousuo_xiangmu_copy1()
    {
        $xiangmu_copy = D('Xiangmu_copy');
        $bb = I('xiangmu_id');
        
        $time1 = I('time1');
        $time2 = I('time2');
        
        if (! empty($time1) && ! empty($time2)) {
            $time2= strtotime($time2);
            $time1= strtotime($time1);

            $chaxun = "xiangmu_id=$bb and create_time between '$time1'  and '$time2' ";
            // echo $chaxun;
            
            $chazhao['0'] = $chaxun;
            $list = $this->lists('Xiangmu_copy', $chaxun, 'create_time');
            
            $this->assign('bb', $bb);
            $this->assign('_list', $list);
            $this->assign('a', $chazhao);
            $this->display();
        } else {
            echo "aa";
        }
    }
	
	
	
	public  function  dayin_xuanze(){
       $id=I('id');

//        $id=implode(',',$id);
        $con['id']=array('in',$id);


        $first_stage=M('FirstStage');
        $xiangmu = D('Xiangmu');
        $fenlei_stage=M('FenleiStage');
        $stage=M('Stage');


        $data = $xiangmu->field('user_uid,time,create_time,xiangmu_uid,finish_time1,finish_time2,finish_time3,finish_time4,finish_time5,finish_time6,finish_time7,finish_time8,finish_time9,finish_time10,finish_time11',true)->where($con)->select();

        $number=count($data);



        for ($i=0;$i<$number;$i++){


            $shaixuan['fenlei_name']=$data[$i]['fenlei'];
            $cc=$fenlei_stage->field('stage_id')->where($shaixuan)->select();
            $c=array_column($cc,stage_id);
            $c=implode(',',$c);
            $ceshi['id']=array('in',$c);
            $result_1[$i]=$stage->where($ceshi)->select();

            $where1[$i]=$data[$i]['id'];


        }


        foreach ($result_1 as $k => $v) {
            $where['xiangmu_id']=$where1[$k];

            foreach ($v as $keyName => $value){

                $where['stage']=$value['id'];


                $ccc=$first_stage->field('item_name,start_time,end_time')->where($where)->select();
                $nu=count($ccc);
//                    for($z=0;$z<$nu;$z++){
//                        //$ccc[$z]['id']=$z+1;
//                        array_unshift( $ccc[$z],$z+1);
//                    }

                $result_1[$k][$keyName]['item']=$ccc;
                unset($cc);
            }


            unset($cc);

        }







        if (! empty($data)) {

            // 导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
            import("Org.Util.PHPExcel");
            import("Org.Util.PHPExcel.Writer.Excel5");
            import("Org.Util.PHPExcel.IOFactory.php");

            $filename = "test_excel";

            $this->getExcel($data,$result_1);
        } else {
            $this->error('没有要打印的报表');
        }


    }
	public function bianji3(){
	    $this->select_company()
;
		$xiangmu_fenlei = D('Xiangmu_fenlei');
		$list_fenlei = $xiangmu_fenlei->select();
		$this->assign('fenlei', $list_fenlei);
		$re['xiangmu_id']=I('xiangmu_id');
		$xiangmu_copy=M('Xiangmu_copy');
		$data=$xiangmu_copy->where($re)->order('create_time desc')->select();
		
		$fin_data=$data['0'];
		$this->assign('fin',$fin_data);

		if (IS_POST) {
			$id['id'] = I('id');
			echo $id['id'];

			$update['help'] = I('help');
			if (empty($update['help'])) {
				$update['help'] = "否";
			} else {
				$update['help'] = "是";
			}

			$update['action'] = I('action');
			if (empty($update['action'])) {
				$update['action'] = "否";
			} else {
				$update['action'] = "是";
			}

			$update['major'] = I('major');
			if (empty($update['major'])) {
				$update['major'] = "否";
			} else {
				$update['major'] = "是";
			}

			$update['major2'] = I('major2');

			if (empty($update['major2'])) {
				$update['major2'] = "否";
			} else {
				$update['major2'] = "是";
			}

			$update['major3'] = I('major3');
			if (empty($update['major3'])) {
				$update['major3'] = "否";
			} else {
				$update['major3'] = "是";
			}

			$update['major4'] = I('major4');
			if (empty($update['major4'])) {
				$update['major4'] = "否";
			} else {
				$update['major4'] = "是";
			}
			$update['fenlei'] = I('fenlei');
			$update['next_plan'] = I('next_plan');
			$update['name'] = I('name');
			$update['location'] = I('location');
			$update['company'] = I('company');
			$update['man'] = I('man');
			$update['phone'] = I('phone');
			$update['work_progress'] = I('work_progress');
			$update['next_plan"'] = I('next_plan"');
			$update['problem'] = I('problem');

			$xiangmu = D('Xiangmu');
			$xiangmu->where($id)->save($update);

			$xiangmu_copy = D('xiangmu_copy');
			$update['xiangmu_id'] = I('id');
			

            $xiangmu_copy->create($update);
            $xiangmu_copy->add();

			$this->redirect('Xiangmu/index');


		}else{

		}








		$this->display();
	}

    public function company(){
        $duty=D('Duty');
        $member=D('Member');
        $dumem=D('Duty_member');

        //查询单位表中的所有数据
        $res=$duty->select();
        $nu=count($res);

        //循环  根据单位表中的单位uid获得用户表中的昵称
        for($i=0;$i<$nu;$i++){
       $res1['duty_id']=$res[$i]['id'];
        $ceshi['uid']=$res[$i]['user_uid'];
            $res[$i]['nickname']=$member->where($ceshi)->field('nickname')->select();
        }
      //遍历输出
        $this->assign('_list',$res);
        
        $this->display();
    }
    
    //删除单位表中的相关单位
    public function company_delete(){
        $duty=D('Duty');
        $data['id']=I('id');
        $duty->where($data)->delete();
        $this->redirect('Xiangmu/company');

    }
    
    //对单位进行相应的编辑
    public  function company_bianji(){
        $urlshang = $_SERVER['HTTP_REFERER'];
        $duty=D('Duty');
        $data['id']=I('id');
        $res=$duty->where($data)->select();
        
        $this->assign('res',$res);
        //获取前台传递的数据
        if(IS_POST) {
            $receive_company['id'] = I('id');
            $data_company['name'] = I('name');
            $data_company['user_uid'] = I('user_uid');
            $duty->where($receive_company)->save($data_company);
//            header('Location: ' . $urlshang);
            $this->redirect('index');
        }
        $this->display();
    }
    //查查看单位旗下的相关用户
    public  function company_chakan(){
        $need=$data['duty_id']=I('id');

        //把单位编号的值放在session中
        session('duty_id',$data['duty_id']);
        $member=D('Member');
        $duty_member=D('Duty_member');
        $condition['duty_id']=session('duty_id');
       

        //通过duty_member表获取相应的旗下用户的user_uid
        $list=$duty_member->where($data)->field('user_uid')->select();
        $nu=count($list);
        //for循环根据已获得的user_uid来获得member表中的值
        for($i=0;$i<$nu;$i++){
            $search['uid']=$list[$i]['user_uid'];
            $list2[$i]=$member->where($search)->select();

        }
        $this->assign('need',$need);
        $this->assign('_list',$list2);
        $this->display();
    }
    //删除单位旗下的用户
    public function  company_chakan_delete(){
        $condition['user_uid']=I('uid');
        $condition['duty_id']=session('duty_id');
      
        $duty_member=D('Duty_member');

      $duty_member->where($condition)->delete();
      $this->redirect('Xiangmu/company');


    }
    public  function company_xinjian(){
        $duty=D('Duty');
        $member=D('Member');
        if(IS_POST) {

            $data_company['name'] = I('name');
            $res1['uid']=$data_company['user_uid'] = I('user_uid');

            //判断用户表中是否有指定的用户
            $res=$member->where($res1)->select();
            if(!empty($res)){
                $duty->add($data_company);
            }else{
                $this->error('您所输入的用户不存在');
            }

            $this->redirect('company');
        }
        $this->display();

    }
    public  function company_member_xinjian(){
        //获取新增下属的参数uid
        $con=I('uid');
        //赋值到前台  在隐藏文本显示
        $this->assign('con',$con);
        $member=D('Member');
        $duty_member=D('Duty_member');

        if(IS_POST) {

            $data_company['duty_id']=I('duty_id');
            $res1['uid']=$data_company['user_uid'] = I('user_uid');

            //判断用户表中是否有指定的用户
            $res=$member->where($res1)->select();
            if(!empty($res)){
            $duty_member->add($data_company);

            }else{
                $this->error('您所输入的用户不存在');
            }

           $this->redirect('company');
        }
        $this->display();
    }

    public  function ceshi()
    {
        $id=array_unique((array)I('id', 0));
        $xiangmu=M('Xiangmu');
        $id=is_array($id) ? implode(',', $id) : $id;
        if (empty($id)) {
            $this->error('请选择要操作的数据!');
        }


        $map['id']=array('in', $id);

        $data=$xiangmu->where($map)->select();
        $number=count($data);

        if (!empty($data)) {
            echo 'aa';

            // 导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
            import("Org.Util.PHPExcel");
            import("Org.Util.PHPExcel.Writer.Excel5");
            import("Org.Util.PHPExcel.IOFactory.php");

            $filename="test_excel";
            $headArr=array(
                "项目编号",
                "项目名称",
                "项目分类",
                '项目位置',
                '责任单位',
                '责任人',
                '联系电话',
                '目前工作进展情况',
                '下一步工作打算',
                '存在问题',
                '是否需要协调',
                '是否开工',
                '市重点项目',
                '市政务办现场会项目',
                '区重点项目',
                '区局联席会项目',

                '项目建设年度',
                '建设内容',
                '本月周进度计划安排',
                '立项手续完成时间及文号',
                '可研手续完成时间及文号',
                '初步设计手续完成时间及文号',
                '水土保持手续完成时间及文号',
                '土地手续完成时间及文号',
                '规划手续完成时间及文号',
                '环保手续完成时间及文号',
                '施工图预算审核完成时间',
                '完成设计招标时间',
                '完成施工监理招标时间',
                '建设周期',
                '2016年6月计划安排',
                '2016年7月计划安排',
                '2016年8月计划安排',
                '2016年9月计划安排',
                '2016年10月计划安排',
                '2016年11月计划安排',
                '2016年12月计划安排',
                '2016年年度资金需求',
                '2017年计划安排',
                '2017年资金需求',


            );
            $this->getExcel1($filename, $headArr, $data);
        } else {
            $this->error('没有要打印的报表');
        }




    }


    public function jianguan(){
        $xiangmu_fenlei = D('Xiangmu_fenlei');
        $list_fenlei = $xiangmu_fenlei->select();
        $this->assign('fenlei', $list_fenlei);
      $map['company']='建管局';

        $xiangmu=D('Xiangmu');
        $list = $this->lists('Xiangmu', $map, 'create_time');
        $this->assign('map',$map);
        $this->assign('_list', $list);
        $this->display();
    }

    public function jiaoti(){
        $xiangmu_fenlei = D('Xiangmu_fenlei');
        $list_fenlei = $xiangmu_fenlei->select();
        $this->assign('fenlei', $list_fenlei);
        $map['company']='教体局';

        $xiangmu=D('Xiangmu');
        $list = $this->lists('Xiangmu', $map, 'create_time');
        $this->assign('map',$map);
        $this->assign('_list', $list);
        $this->display();
    }

    public function jiaotong(){
        $xiangmu_fenlei = D('Xiangmu_fenlei');
        $list_fenlei = $xiangmu_fenlei->select();
        $this->assign('fenlei', $list_fenlei);
        $map['company']='交通商务办';
        $this->assign('map',$map);
        $xiangmu=D('Xiangmu');
        $list = $this->lists('Xiangmu', $map, 'create_time');

        $this->assign('_list', $list);
        $this->display();
    }
    public function shengtai(){
        $xiangmu_fenlei = D('Xiangmu_fenlei');
        $list_fenlei = $xiangmu_fenlei->select();
        $this->assign('fenlei', $list_fenlei);
        $map['company']='生态商住办';
        $this->assign('map',$map);
        $xiangmu=D('Xiangmu');
        $list = $this->lists('Xiangmu', $map, 'create_time');

        $this->assign('_list', $list);
        $this->display();
    }
    public function xiandai(){
        $xiangmu_fenlei = D('Xiangmu_fenlei');
        $list_fenlei = $xiangmu_fenlei->select();
        $this->assign('fenlei', $list_fenlei);
        $map['company']='现代商贸办';
        $this->assign('map',$map);
        $xiangmu=D('Xiangmu');
        $list = $this->lists('Xiangmu', $map, 'create_time');

        $this->assign('_list', $list);
        $this->display();
    }
    public function jinshui(){
        $xiangmu_fenlei = D('Xiangmu_fenlei');
        $list_fenlei = $xiangmu_fenlei->select();
        $this->assign('fenlei', $list_fenlei);
        $map['company']='金水公司';
        $this->assign('map',$map);
        $xiangmu=D('Xiangmu');
        $list = $this->lists('Xiangmu', $map, 'create_time');

        $this->assign('_list', $list);
        $this->display();
    }
    public function haichuang(){
        $xiangmu_fenlei = D('Xiangmu_fenlei');
        $list_fenlei = $xiangmu_fenlei->select();
        $this->assign('fenlei', $list_fenlei);
        $map['company']='海创公司';
        $this->assign('map',$map);
        $xiangmu=D('Xiangmu');
        $list = $this->lists('Xiangmu', $map, 'create_time');

        $this->assign('_list', $list);
        $this->display();
    }
    public function chengjian(){

        $xiangmu_fenlei = D('Xiangmu_fenlei');
        $list_fenlei = $xiangmu_fenlei->select();
        $this->assign('fenlei', $list_fenlei);

        $map['company']='城建公司';
        $this->assign('map',$map);
        $xiangmu=D('Xiangmu');
        $list = $this->lists('Xiangmu', $map, 'create_time');

        $this->assign('_list', $list);
        $this->display();
    }



    public function go($n){
        $data   =   session('site_url');
        switch($n){
            case -1:
                $url    =   $data['2'];
                break;
            case -2:
                $url    =   $data['1'];
                break;
            case -3:
                $url    =   $data['0'];
                break;
            default :
                $url    =   $data['3'];
        }
        return $url;
    }


}
