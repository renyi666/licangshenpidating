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
class NextController extends AdminController
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
            $list = $this->lists('Xiangmu', '', 'create_time');
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
        $xiangmu = D('Xiangmu');
        $a = $xiangmu->select();
        
        $b = count($a);
        
        for ($i == 0; $i < $b + 1; $i ++) {
            
            $c[$i] = $a[$i - 1]['company'];
            
            $c['0'] = $a['0']['company'];
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
            $this->assign('company', $l);
        }
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


                    dump($add);

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

    public function bianji()
    {
       $res_id= $id['id'] = I('id');
        //var_dump($res_id);
        $this->assign('res_id',$res_id);
        $xiangmu = D('Xiangmu');
        $result_1 = $xiangmu->where($id)->find();
        
        $this->assign('result_1', $result_1);
        

        
        $xiangmu_fenlei = D('Xiangmu_fenlei');
        $list_fenlei = $xiangmu_fenlei->select();
        $this->assign('fenlei', $list_fenlei);
        
        $update['user_uid'] = session('user_auth.uid');
        $uid = session('user_auth.uid');
        $xiangmu = D('Xiangmu');
        
        if (IS_POST) {
            $id['id'] = I('res_id');
            
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
            $update['name'] = I('name');
            $update['next_plan'] = I('next_plan');
            $update['location'] = I('location');
            $update['company'] = I('company');
            $update['man'] = I('man');
            $update['phone'] = I('phone');
            $update['work_progress'] = I('work_progress');
            $update['next_plan"'] = I('next_plan"');
            $update['problem'] = I('problem');



            $update['construction_year'] = I('construction_year');
            $update['construction_content'] = I('construction_content');
            $update['current_week'] = I('current_week');
            $update['finish_time1'] = I('finish_time1');
            $update['finish_time2'] = I('finish_time2');
            $update['finish_time3'] = I('finish_time3');
            $update['finish_time4'] = I('finish_time4');
            $update['finish_time5'] = I('finish_time5');
            $update['finsih_time6'] = I('finsih_time6');
            $update['finish_time7'] = I('finish_time7');
            $update['finsih_time8'] = I('finsih_time8');
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
            


            $xiangmu->where($id)->save($update);
            
            $xiangmu_copy = D('xiangmu_copy');
            $update['xiangmu_id'] = I('res_id');
          
            $xiangmu_copy->create($update);
            $xiangmu_copy->add();
            
           $this->redirect('Next/index');
        } else {}
        
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
        $major['major'] = "是";
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
            
            $this->redirect('Next/index');
        } else {}
        
        $this->display();
    }

    public function delete()
    {
        $xiangmu = D('Xiangmu');
        $xiangmu_first = D('Xiangmu_first');
        
        $id['id'] = I('id');
       
        $xiangmu->where($id)->delete();
        $xiangmu_copy = D('Xiangmu_copy');
        $id1['xiangmu_id'] = I('id');
        
        $xiangmu_copy->where($id1)->delete();
        $xiangmu_first->where($id)->delete();
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
        
        $company = $sousuo['company'] = I('company');
        if (! empty($sousuo['company'])) {
            
            $company = trim($company);
            
            $where['company'] = array(
                'like',
                '%' . $company . '%'
            );
        }
        $result = I('new');
        
        if (! empty($result)) {
            $result = '是';
        } else {
            $result = '否';
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
        $haimian = $sousuo['haimian'] = I('haimian');

        if (! empty($haimian)) {

            $where['haimian'] = $haimian;
        }
        $major = $sousuo['major'] = I('major');

        if (! empty($major)) {
            $where['major'] = $major;
        } $major2 = $sousuo['major2'] = I('major2');

        if (! empty($major2)) {
            $where['major2'] = $major2;
        } $major3 = $sousuo['major3'] = I('major3');

        if (! empty($major3)) {
            $where['major3'] = $major3;
        } $major4 = $sousuo['major4'] = I('major4');

        if (! empty($major4)) {
            $where['major4'] = $major4;
        }
        
        $shenpi = $sousuo['shenpi'] = I('shenpi');
        
        if (! empty($shenpi)) {
            $where['shenpi'] = $shenpi;
        }
        
        $where['id'] = array(
            'egt',
            - 100
        );
        
        session('where', $where);
        session('result', $result);
        if ($result == "否") {
            $Model = D('Xiangmu_first');
            
            $list = $this->lists($Model, $where, 'create_time');
            $nu = count($list);
            
            for ($i = 0; $i < $nu; $i ++) {
                // echo $nu;
                
                $list[$i]['time'] = substr($list[$i]['time'], 0, 10);
            }
            $this->assign('_list', $list);
            
            /*
             * 把result值传到前台来判断是否显示最新进展
             */
        } else {
            
            $Model = D('Xiangmu');
            $list = $this->lists($Model, $where, 'create_time');
            $nu = count($list);
            
            for ($i = 0; $i < $nu; $i ++) {
                // echo $nu;
                
                $list[$i]['time'] = substr($list[$i]['time'], 0, 10);
            }
            
            $this->assign('_list', $list);
        }
        
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
            $this->redirect('Next/index');
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

    private function getExcel($fileName, $headArr, $data)
    {
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
                if($a<(count($arr)-2)){
                    $a++;
                }else{
                    $a=0;
                }

//                dump($colum.$row);
//                dump($value);
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

    public function dayin_all()
    {
        $xiangmu = D('Xiangmu');
        
        $data = $xiangmu->field('user_uid,time,create_time,xiangmu_uid', true)->select();
        //dump($data);
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
            $this->success('没有要打印的报表', 'Xaingmu/index');
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
            $this->success('没有要打印的报表', 'Xaingmu/index');
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
            $this->success('没有要打印的报表', 'Xaingmu/index');
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
            $this->success('没有要打印的报表', 'Xaingmu/index');
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
            $this->success('没有要打印的报表', 'Xaingmu/index');
        }
    }

    public function dayin_current()
    {
        $xiangmu_copy = D('Xiangmu_copy');
        
        $result['xiangmu_id'] = I('xiangmu_id');
       // dump($result);
        if(empty($result['xiangmu_id'] )){
         $this->error('没有要打印的表');
        }
        // echo $result['xiangmu_id'];
        
        $data = $xiangmu_copy->where($result)
            ->field('id,user_uid,time,create_time', true)
            ->select();
       // dump($data);
        // $this->display();
        $number = count($data);
        if (! empty($data)) {
            
            import("Org.Util.PHPExcel");
            import("Org.Util.PHPExcel.Writer.Excel5");
            import("Org.Util.PHPExcel.IOFactory.php");
            
            $filename = $data['0']['name'] . 项目记录;
            $headArr = array(
                '项目编号',
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

            )
            ;
            $this->getExcel($filename, $headArr, $data);
          
        } else {
            $this->error('没有打印的报表', U('Xiangmu/index'));
        }
    }

    public function dayin_sousuo()
    {
        /*
         * 从session中获取where对象的各个值，使用where来查询
         */
        $result = session('result');
        
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
        if (session('where.haimian')!=null) {

            $where['haimian'] = session('where.haimian');
        }
        if (session('where.shenpi')!=null) {

            $where['shenpi'] = session('where.shenpi');
        }

        if (session('where.major')!=null) {

            $where['major'] = session('where.major');
        }
        if (session('where.major2')!=null) {

            $where['major2'] = session('where.major2');
        }
        if (session('where.major3')!=null) {

            $where['major3'] = session('where.major3');
        }
        if (session('where.major4')!=null) {

            $where['major4'] = session('where.major4');
        }
        if (session('where.help')!=null) {
            
            $where['help'] = session('where.help');
        }
        
        if (session('where.action')!=null) {
            
            $where['action'] = session('where.action');
        }
        
        if ($result == "是") {
            
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
	
	
	
	
	public function bianji3(){
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
			
dump($update);
            $xiangmu_copy->create($update);
            $xiangmu_copy->add();

			$this->redirect('Next/index');


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
        $this->assign('result',$result);
        $this->display();
    }
    
    //删除单位表中的相关单位
    public function company_delete(){
        $duty=D('Duty');
        $data['id']=I('id');
        $duty->where($data)->delete();
        $this->redirect('Xiangmu/company_chakan');

    }
    
    //对单位进行相应的编辑
    public  function company_bianji(){
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
}
