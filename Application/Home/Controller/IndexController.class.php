<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------
namespace Home\Controller;

use OT\DataDictionary;
use Think\Upload;
use User\Api\UserApi;
use Think\Controller;
use Think\Model;

/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class IndexController extends HomeController
{
    
    // 系统首页
    public function index()
    {
        $xiangmu_fenlei = D('Xiangmu_fenlei');
        $list_fenlei = $xiangmu_fenlei->select();


        $this->assign('fenlei', $list_fenlei);
//        $nowpage_number=session('next_self_');
//
//        $this->assign('next_now',$nowpage_number=session('_self_'));

        $uid['user_uid'] = session('user_auth.uid');
        
        if ($uid['user_uid'] !== null) {
            $uid['user_uid'] = session('user_auth.uid');
            // echo $uid;
            $duty = M('Duty');
            
            // 判断责任单位表里是否有该uid 如果存在 则说明该账号为责任单位账号
            $res = $duty->where($uid)->select();


            session('duty_id', $res['0']['id']);

            if (! empty($res)){
                $where1['company']=$res['0']['name'];


                $where['duty_id'] = $res['0']['id'];

//                $duty_member = M('Duty_member');
//                $result = $duty_member->where($where)
//                    ->field('user_uid')
//                    ->select();
//
//                for ($i = 0; $i < count($result); $i ++) {
//                    $tran[$i] = $result[$i]['user_uid'];
//                }
                
                $xiangmu = M('Xiangmu');
//                $q['user_uid'] = array(
//                    'in',
//                    $tran
//                );
                
                $lists = $this->lists($xiangmu, $where1, 'create_time desc');

                $nu = count($lists);
                for ($i = 0; $i < $nu; $i ++) {

                    $lists[$i]['time'] = substr($lists[$i]['time'], 0, 10);

                    $this->select_man();



                }
                $this->assign('_list', $lists);
            } else {

                $xiangmu = M('Xiangmu');
                
                $list = $this->lists('Xiangmu', $uid, 'create_time desc ');
                $nu = count($list);
                
                for ($i = 0; $i < $nu; $i ++) {
                    
                    $list[$i]['time'] = substr($list[$i]['time'], 0, 10);
                    

                }
                $this->select_man();
                $this->select_company();
                $this->assign('_list', $list);
            }
        } else {
            $this->redirect('User/login');
        }

        $this->display();
        
       
    }


    public  function second(){

        $q['id']=I('id');

        $uid['user_uid'] = session('user_auth.uid');
        $xiangmu=M('Xiangmu');
        $list=$xiangmu->where($q)->select();
       $this->assign('result_1',$list);
        if (IS_POST) {
            $urlshang = $_SERVER['HTTP_REFERER'];
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


           $this->redirect('bianji',array('id'=>$where['id']));

        }









        $this->display();




    }
    public function next_index()
    {
        $xiangmu_fenlei = D('Xiangmu_fenlei');
        $list_fenlei = $xiangmu_fenlei->select();
        $this->assign('fenlei', $list_fenlei);
        $title=D('Title');
        $head_title=$title->field('name')->select();

$this->assign('title',$head_title);
        $uid['user_uid'] = session('user_auth.uid');
         $nowpage_number=session('_self_');
        $this->assign('now',$nowpage_number);
        if ($uid['user_uid'] !== null) {
            $uid['user_uid'] = session('user_auth.uid');
            // echo $uid;
            $duty = M('Duty');

            // 判断责任单位表里是否有该uid 如果存在 则说明该账号为责任单位账号
            $res = $duty->where($uid)->select();
            session('duty_id', $res['0']['id']);
            if (! empty($res)){

                $where['duty_id'] = $res['0']['id'];
//                session('duty_id', $res['0']['id']);
                $duty_member = M('Duty_member');
                $result = $duty_member->where($where)
                    ->field('user_uid')
                    ->select();

                for ($i = 0; $i < count($result); $i ++) {
                    $tran[$i] = $result[$i]['user_uid'];
                }

                $xiangmu = M('Xiangmu');
                $q['user_uid'] = array(
                    'in',
                    $tran
                );

                $lists = $this->lists($xiangmu, $q, 'create_time desc');

                $nu = count($lists);

                for ($i = 0; $i < $nu; $i ++) {

                    $lists[$i]['time'] = substr($lists[$i]['time'], 0, 10);

                    $this->select_man();
                    $this->select_company();

                    $this->assign('_list', $lists);
                }
            } else {
                $xiangmu = D('Xiangmu');

                $list = $this->lists('Xiangmu', $uid, 'create_time desc ');
                $nu = count($list);

                for ($i = 0; $i < $nu; $i ++) {

                    $list[$i]['time'] = substr($list[$i]['time'], 0, 10);

                    $this->select_man();
                    $this->select_company();

                    $this->assign('_list', $list);
                }
            }
        } else {
            $this->redirect('User/login');
        }

        $next_nowpage_number=substr(__SELF__,-6,1);
        $ceshi=substr(__SELF__,-8,1);
        if($ceshi=="p") {
            if (is_numeric($next_nowpage_number)) {

            } else {
                $next_nowpage_number = 1;
            }
            session('next_self_', $next_nowpage_number);
//dump($next_nowpage_number);
            $this->assign('next_now', $next_nowpage_number);
        }
        $this->display();


    }
    public function company()
    {
        $uid['user_uid'] = session('user_auth.uid');
        
        if ($uid['user_uid'] !== null) {
            $uid['user_uid'] = session('user_auth.uid');
            // echo $uid;
            $duty = M('Duty');
            
            // 判断责任单位表里是否有该uid 如果存在 则说明该账号为责任单位账号
            $res = $duty->where($uid)->select();
            
            if (! empty($res)) {
                
                $where['duty_id'] = $res['0']['id'];
                
                $duty_member = M('Duty_member');
                $result = $duty_member->where($where)
                    ->field('user_uid')
                    ->select();
                
                for ($i = 0; $i < count($result); $i ++) {
                    $tran[$i] = $result[$i]['user_uid'];
                }
                
                $xiangmu = M('Xiangmu');
                $q['user_uid'] = array(
                    'in',
                    $tran
                );
                
                $lists = $this->lists($xiangmu, $q, 'create_time');
                
                $this->assign('lists', $lists);
            } else {
                $xiangmu = D('Xiangmu');
                
                $list = $this->lists('Xiangmu', $uid, 'time ');
                $nu = count($list);
                
                for ($i = 0; $i < $nu; $i ++) {
                    
                    $list[$i]['time'] = substr($list[$i]['time'], 0, 10);
                    
                    $this->select_man();
                    $this->select_company();
                    $this->assign('_list', $list);
                }
            }
        } else {
            $this->redirect('User/login');
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
            // var_dump($q);
            
            $r = count($q);
            
            $l = Array();
            foreach ($q as $key => $value) {
                $l[] = Array(
                    'aa' => $key,
                    'man' => $value
                );
            }
            // var_dump($l);
            $this->assign('q', $l);
        }
    }

    public function select_company()
    {
        $xiangmu = D('Duty');
        $a = $xiangmu->select();
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




        }
        $this->assign('company', $l);
    }

    public function dayin_all()
    
    {
        $first_stage=M('FirstStage');
        $xiangmu = D('Xiangmu');
        $fenlei_stage=M('FenleiStage');
        $stage=M('Stage');



        $d_id['id'] = session('duty_id');
        if ($d_id['id']!=null) {
            $duty= M('Duty');
            $result = $duty->where($d_id)
                ->field('name')
                ->find();
            

            $q['company']=$result['name'];


            $data = $xiangmu->field('user_uid,time,create_time,xiangmu_uid,finish_time1,finish_time2,finish_time3,finish_time4,finish_time5,finish_time6,finish_time7,finish_time8,finish_time9,finish_time10,finish_time11',true)->where($q)->select();


        } else {
            $uid['user_uid'] = session('user_auth.uid');

            $data = $xiangmu->field('user_uid,time,create_time,xiangmu_uid,finish_time1,finish_time2,finish_time3,finish_time4,finish_time5,finish_time6,finish_time7,finish_time8,finish_time9,finish_time10,finish_time11',true)->where($uid)->select();

//            $data = $xiangmu->where($uid)
//                ->field('user_uid,time,create_time,xiangmu_uid', true)
//                ->select();

        }
        $number = count($data);

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

                $result_1[$k][$keyName]['item']=$ccc;
                unset($cc);
            }


            unset($cc);

        }

        if (! empty($data)) {
            
            import("Org.Util.PHPExcel");
            import("Org.Util.PHPExcel.Writer.Excel5");
            import("Org.Util.PHPExcel.IOFactory.php");

            $this->getExcel($data,$result_1);
        } else {
            $this->error('没有要打印的报表');
        }
    }
//    private function getExcel1($data,$result_1)
//    {
//
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
////            '立项手续完成时间及文号',
////            '可研手续完成时间及文号',
////            '初步设计手续完成时间及文号',
////            '水土保持手续完成时间及文号',
////            '土地手续完成时间及文号',
////            '规划手续完成时间及文号',
////            '环保手续完成时间及文号',
////            '施工图预算审核完成时间',
////            '完成设计招标时间',
////            '完成施工监理招标时间',
////            '建设周期',
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
//        $arr            =   array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ');
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
//        $b=33;
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
//
//
//                if($a<(count($arr)-13)){
//                    $a++;
//                }else{
//                    $a=0;
//                }
//
//            }
//
//
//            foreach ($headArr as $k => $v) {
//                $colum = $arr[$k];
//                //从第几行开始写入信息
//                $objPHPExcel->setActiveSheetIndex($key)->setCellValue($colum . '4', $v);
//            }
//
//
//
//            $objPHPExcel->getActiveSheet()->mergeCells('A1:AK2');
//            $objPHPExcel->getActiveSheet()->setCellValue('A1','李沧区综合建设业务平台');
//            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER	);
//            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
//
//            $objPHPExcel->getActiveSheet()->mergeCells('A3:AE3');
//            $objPHPExcel->getActiveSheet()->setCellValue('A3','基本信息');
//            $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER	);
//            $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
//
//
//            $objPHPExcel->getActiveSheet()->mergeCells('AF3:AK3');
//            $objPHPExcel->getActiveSheet()->setCellValue('AF3',$rows['fenlei']);
//            $objPHPExcel->getActiveSheet()->getStyle('AF3')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER	);
//            $objPHPExcel->getActiveSheet()->getStyle('AF3')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
//
//            //$objPHPExcel->getActiveSheet()->mergeCells('AT4:AU4');
//            $objPHPExcel->getActiveSheet()->setCellValue('AI4','受理时间');
//            $objPHPExcel->getActiveSheet()->setCellValue('AJ4','结束时间');
//            $objPHPExcel->getActiveSheet()->getStyle('AI4')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER	);
//            $objPHPExcel->getActiveSheet()->getStyle('AM4')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
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
//            // $row ++;
//        }
//        $objPHPExcel->getActiveSheet()->mergeCells('AF3:AK3');
//        //表格右侧写入
//        $objPHPExcel->setActiveSheetIndex(0);
//        $objActSheet = $objPHPExcel->getActiveSheet(0);
//        $x=0;
//
//        foreach ($result_1 as $key1 =>$rows1){//筛选出来总共多少个项目
//            $n1='5';
//            $n2='0';
//            foreach ($rows1 as $key2 =>$v){//筛选出每个项目对应的阶段有几个
//
//                $number='0';
//                //$n1=$number+$n1;
//                $number=count($v['item']);
////                dump($number);
////                exit();
//                $n2=$n1+$number;
//                if($number >1){
//                    $n2--;
//                }
//
//
//
//                $objPHPExcel->getActiveSheet()->mergeCells('AF'.$n1.':AF'.$n2);
//;
//
//                $objPHPExcel->getActiveSheet()->setCellValue('AF'.$n1,$v['name']);
//                $n1=$n2+1;
//                foreach ($v['item'] as $key3 =>$value1){
//
//                    $x+=1;
//                    $objPHPExcel->getActiveSheet()->setCellValue('AG'.$row1,$x);
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
//                            $b=33;
//                        }
//                    }
//                    $row1++;
//
//                }
//
//
//            }
//
//            $objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setWidth(50);
//            $row1 = 5;
//            $objPHPExcel->setActiveSheetIndex($key1+1);
//            $objActSheet = $objPHPExcel->getActiveSheet($key1+1);
//            $x=0;
//
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
//        //  $objPHPExcel->getActiveSheet()->mergeCells('A1:E2');
//
//        $fileName = iconv("utf-8", "gb2312", $fileName);
//        // 重命名表
//        //  $objPHPExcel->getActiveSheet()->setTitle('test');
//        // 设置活动单指数到第一个表,所以Excel打开这是第一个表
//        $objPHPExcel->setActiveSheetIndex(0);
//        header('Content-Type: application/vnd.ms-excel');
//        header("Content-Disposition: attachment;filename=\"$fileName\"");
//        header('Cache-Control: max-age=0');
//
////        $objPHPExcel->createSheet();//创建一个新的sheet
////        $objPHPExcel->setActiveSheetIndex(1);   //设置第2个表为活动表，提供操作句柄   活动表就是打开表格式焦点所在的表格
////        $objPHPExcel->getSheet(1)->setTitle( '测试2');   //直接得到第二个表进行设置,将工作表重新命名为测试2
//        //  $objPHPExcel->getActiveSheet()->getTabColor()->setARGB( 'FF0094FF');     //设置标签颜色
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
//    private function getExcel($fileName, $headArr, $data)
//    {
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
//        // 创建PHPExcel对象，注意，不能少了\
//        $objPHPExcel = new \PHPExcel();
//        $objProps = $objPHPExcel->getProperties();
//        $arr            =   array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ');
//
////        // 设置表头
////        $key = ord("A");
////        foreach ($headArr as $v) {
////            $colum = chr($key);
////            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colum . '1', $v);
////            $key += 1;
////        }
////
////        $column = 2;
////        $objActSheet = $objPHPExcel->getActiveSheet();
////        foreach ($data as $key => $rows) { // 行写入
////            $span = ord("A");
////            foreach ($rows as $keyName => $value) { // 列写入
////                $j = chr($span);
////                $objActSheet->setCellValue($j . $column, $value);
////                $span ++;
////            }
////            $column ++;
////        }
////
//        foreach ($headArr as $k => $v) {
//            $colum = $arr[$k];
//
//
//            //dump($colum);
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colum . '1', $v);
//
//        }
//        $row = 2;
//        $a=0;
//        $objActSheet = $objPHPExcel->getActiveSheet();
//
//        foreach ($data as $key => $rows) { // 行写入
//
//            foreach ($rows as $keyName => $value) { // 列写入
//
//                $colum = $arr[$a];
//
//                $objActSheet->setCellValue($colum.$row, $value);
//                if($a<(count($arr)-2)){
//                    $a++;
//                }else{
//                    $a=0;
//                }
//
//
//            }
//
//            $row ++;
//        }
//
//        $fileName = iconv("utf-8", "gb2312", $fileName);
//        // 重命名表
//        // $objPHPExcel->getActiveSheet()->setTitle('test');
//        // 设置活动单指数到第一个表,所以Excel打开这是第一个表
//        $objPHPExcel->setActiveSheetIndex(0);
//        header('Content-Type: application/vnd.ms-excel');
//        header("Content-Disposition: attachment;filename=\"$fileName\"");
//        header('Cache-Control: max-age=0');
//
//        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//        $objWriter->save('php://output'); // 文件通过浏览器下载
//        exit();
//    }
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


    Public function xinjian()
    {
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
            $update['total_money'] = I('total_money');

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
                  $this->redirect('Index/index');
                } else {
                    
                    $this->error('请输入完整信息');
                }
            } else {
                $this->error('信息错误');
            }
        } else {  }
        
        $this->display();
    }

    public function xiangmu_copy_chakan()
    {
        $uid = session('user_auth.uid');
        $id['xiangmu_id'] = I('id');
        $xiangmu_copy = D('xiangmu_copy');
        // echo $id['xiangmu_id'];
        $result1 = $xiangmu_copy->where($id)
            ->field('user_uid')
            ->select();
        // var_dump($result1);
        
        $list = $this->lists('Xiangmu_copy', $id, 'create_time desc');
        
        // $list = $this->lists('Xiangmu_copy', $id,'');
        // $list = $xiangmu_copy->where($id)->select();
        // var_dump($xiangmu_copy->where($id)->select());
        $count1 = count($list);
        $count2 = 0;
        
        $a = $list[$count2];
        $b['0'] = $list[$count2];
        $nu = count($list);
        
        for ($i = 0; $i < $nu; $i ++) {
            // echo $nu;
            
            $list[$i]['time'] = substr($list[$i]['time'], 0, 10);
        }
        $this->assign('a', $a);
        $this->assign('b', $b);
        
        $this->assign('_list', $list);
        
        $this->display();
    }
    public function next_xiangmu_copy_chakan()
    {
        $uid = session('user_auth.uid');
        $id['xiangmu_id'] = I('id');
        $xiangmu_copy = D('xiangmu_copy');
        // echo $id['xiangmu_id'];
        $result1 = $xiangmu_copy->where($id)
            ->field('user_uid')
            ->select();
        // var_dump($result1);

        $list = $this->lists('Xiangmu_copy', $id, 'create_time desc');

        // $list = $this->lists('Xiangmu_copy', $id,'');
        // $list = $xiangmu_copy->where($id)->select();
        // var_dump($xiangmu_copy->where($id)->select());
        $count1 = count($list);
        $count2 = 0;

        $a = $list[$count2];
        $b['0'] = $list[$count2];
        $nu = count($list);

        for ($i = 0; $i < $nu; $i ++) {
            // echo $nu;

            $list[$i]['time'] = substr($list[$i]['time'], 0, 10);
        }
        $this->assign('a', $a);
        $this->assign('b', $b);

        $this->assign('_list', $list);

        $this->display();
    }

    public function delete()
    {
        $xiangmu = D('Xiangmu');
        $id['id'] = I('id');
      
        $xiangmu->where($id)->delete();

        
        $this->redirect('Index/index');
    }

    public function xiangmu_copy_delete()
    {
        $xiangmu_copy = D('Xiangmu_copy');
        $id['id'] = I('id');
        // var_dump($id);
        $xiangmu_copy->where($id)->delete();
        $this->redirect('Xiangmu/index');
        $this->display();
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
            // var_dump($data);
            import("Org.Util.PHPExcel");
            import("Org.Util.PHPExcel.Writer.Excel5");
            import("Org.Util.PHPExcel.IOFactory.php");
            

            $this->getExcel1($data,$result_1);
        } else {
            $this->error('没有打印的报表', U('Index/index'));
        }
    }

    public function bianji2()
    {
        $this->select_company();
        $id['id'] = I('id');
        $xiangmu = D('Xiangmu');
        $result_1 = $xiangmu->where($id)->

        select();

        $this->assign('result_1', $result_1);
        
        $uid['user_uid'] = session('user_auth.uid');

        // var_dump($uid);
        $update['user_uid'] = $result_1['0']['user_uid'];

        $xiangmu_fenlei = D('Xiangmu_fenlei');
        $list_fenlei = $xiangmu_fenlei->select();
        $this->assign('fenlei', $list_fenlei);
        
        $uid = session('user_auth.uid');
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
            $update['haimian'] = I('haimian');
            if (empty($update['haimian'])) {
                $update['haimian'] = "否";
            } else {
                $update['haimian'] = "是";
            }
            $update['shenpi'] = I('shenpi');
            if (empty($update['shenpi'])) {
                $update['shenpi'] = "否";
            } else {
                $update['shenpi'] = "是";
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
            $up1['company']=I('shuru');
            if(!empty($up1['company'])){
                $update['company']=$up1['company'];
            }
            $update['man'] = I('man');
            $update['phone'] = I('phone');
            $update['work_progress'] = I('work_progress');
            $update['next_plan"'] = I('next_plan"');
            $update['problem'] = I('problem');
            // var_dump($update);
            // echo $id['id'];
            // var_dump($id);
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
            $xiangmu = D('Xiangmu');

            $xiangmu->where($id)->save($update);
            
            $xiangmu_copy = D('xiangmu_copy');
            $update['xiangmu_id'] = I('id');
            // var_dump($xiangmu_copy->select());
            // echo 'aaa';
            $add2['name'] = I('company');


            $xiangmu_copy->create($update);
            $xiangmu_copy->add();

            
            $this->redirect('Xiangmu/index');
        } else {}
        
        $this->display();
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
            $time2= strtotime($time2);
            $time1= strtotime($time1);

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
            if (! empty($bb)) {
                
                session('xiangmu_id', $bb);
                
                $chaxun = "xiangmu_id=$bb " . $time;

                $list = $this->lists('Xiangmu_copy', $chaxun, 'create_time desc');
                session('chazhao_sql1',$chaxun);


                
                $b['0'] = $list['0'];
                $nu = count($list);
                
                for ($i = 0; $i < $nu; $i ++) {
                    // echo $nu;
                    
                    $list[$i]['time'] = substr($list[$i]['time'], 0, 10);
                }
              
                $this->assign('b', $b);
                $this->assign('bb', $bb);
                $this->assign('_list', $list);
                

            } else {
                
                $bb = session('xiangmu_id');
                $chaxun = "xiangmu_id=$bb " . $time; // echo $chaxun;
                

                $list = $this->lists('Xiangmu_copy', $chaxun, 'create_time desc');
                $b['0'] = $list['0'];
                session('chazhao_sql1',$chaxun);
                $this->assign('b', $b);
                $this->assign('bb', $bb);
                $this->assign('_list', $list);


            }
        } else {
            
            $this->error('请输入时间', U('Xiangmu/index'));
        }
        $this->display();
    }

    public function dayin_sousuo()
    {
        $result = session('result');

        if ( session('where.id')!=null) {
            
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
        if (session('where.user_uid')!=null) {
            
            $where['user_uid'] = session('where.user_uid');
        }


        if ($result == "是") {
            echo 'aa';
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
            $this->error('没有要打印的报表', U('Xiangmu/index'));
        }
    }

    public function dayin_sousuo_xiangmu_copy()
    {
        $sql = session('chazhao_sql1');

        $xiangmu_copy = D('Xiangmu_copy');
        
        $data = $xiangmu_copy->where($sql)
            ->field('id,user_uid,time,create_time', true)
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
            $this->error('没有打印的报表', U('Xiangmu/index'));
        }
    }

    public function bianji()
    {
        $this->select_company();

       $id['id'] = I('id');
        $xiangmu = D('Xiangmu');

        $result_1 = $xiangmu->where($id)->select();




        $a['fenlei_name']=$result_1['0']['fenlei'];
        $fenlei_stage=M('FenleiStage');
        //根据id从fenlei_stage里获得stage_id
        $b=$fenlei_stage->field('stage_id')->where($a)->select();
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

        $dutyM  =   M('Duty');
        $duty_result    =   $dutyM->select();
        $this->assign('duty_result',$duty_result);


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
            $up1['company']=I('shuru');
//            if(!empty($up1['company'])){
//                $update['company']=$up1['company'];
//            }
            $update['man'] = I('man');
            $update['phone'] = I('phone');
            $update['total_money'] = I('total_money');
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


//
            $this->redirect('Index/index');
        } else {}
        
        $this->display();
    }

    public  function dayin_haimian(){

        $first_stage=M('FirstStage');
        $xiangmu = D('Xiangmu');
        $fenlei_stage=M('FenleiStage');
        $stage=M('Stage');



        $d_id['duty_id'] = session('duty_id');
        if ($d_id['duty_id']!=null) {
//            $duty_member = M('Duty_member');
//            $result = $duty_member->where($d_id)
//                ->field('user_uid')
//                ->select();
//
//            for ($i = 0; $i < count($result); $i ++) {
//                $tran[$i] = $result[$i]['user_uid'];
//            }
//
//            $q['haimian']='是';
//            $q['user_uid'] = array(
//                'in',
//                $tran
//            );
            $duty = M('Duty');
            $result = $duty->where($d_id)
                ->field('name')
                ->find();

            for ($i = 0; $i < count($result); $i ++) {
                $tran[$i] = $result[$i]['user_uid'];
            }

            $q['haimian']='是';
//            $q['user_uid'] = array(
//                'in',
//                $tran
//            );
            $q['company']=$result['name'];
            $data = $xiangmu->field('user_uid,time,create_time,xiangmu_uid,finish_time1,finish_time2,finish_time3,finish_time4,finish_time5,finish_time6,finish_time7,finish_time8,finish_time9,finish_time10,finish_time11',true)->where($q)->select();
//            $data = $xiangmu->where($q)
//                ->field('user_uid,time,create_time,xiangmu_uid', true)
//                ->select();
        } else {
            $uid['user_uid'] = session('user_auth.uid');
            $uid['haimian']='是';
            $data = $xiangmu->field('user_uid,time,create_time,xiangmu_uid,finish_time1,finish_time2,finish_time3,finish_time4,finish_time5,finish_time6,finish_time7,finish_time8,finish_time9,finish_time10,finish_time11',true)->where($uid)->select();

//            $data = $xiangmu->where($uid)
//                ->field('user_uid,time,create_time,xiangmu_uid', true)
//                ->select();

        }
        $number = count($data);

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

                $result_1[$k][$keyName]['item']=$ccc;
                unset($cc);
            }


            unset($cc);

        }

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


            $this->getExcel($data,$result_1);
        } else {
            $this->error('没有要打印的报表');
        }
    }
    public function sousuo()
    {
        $xiangmu_fenlei = D('Xiangmu_fenlei');
        $list_fenlei = $xiangmu_fenlei->select();
        $this->assign('fenlei', $list_fenlei);

        // 从session中获取责任单位的账户id
        $d_id['id'] = session('duty_id');

        // 判断是否是责任单位账户
        if ($d_id['id']!=null) {

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
            $name=$sousuo['name']=I('name');
            if (! empty($name)) {
                $where['name'] = array(
                    'like',
                    '%' . $name . '%'
                );
            }
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
            $help = $sousuo['help'] = I('help');
            
            if (! empty($help)) {
                
                $where['help'] = $help;
            }
            $shenpi = $sousuo['shenpi'] = I('shenpi');

            if (! empty($shenpi)) {

                $where['shenpi'] = $shenpi;
            }
            
            $action = $sousuo['action'] = I('action');
            
            if (! empty($action)) {
                $where['action'] = $action;
            }
            $haimian = $sousuo['haimian'] = I('haimian');

            if (! empty($haimian)) {
                $where['haimian'] = $haimian;
            }

            $major = $sousuo['major'] = I('major');

            if (! empty($major)) {
                $where['major'] = $major;
            }

            $major2 = $sousuo['major2'] = I('major2');

            if (! empty($major2)) {
                $where['major2'] = $major2;
            }

            $major3 = $sousuo['major3'] = I('major3');

            if (! empty($major3)) {
                $where['major3'] = $major3;
            }

            $major4 = $sousuo['major4'] = I('major4');

            if (! empty($major4)) {
                $where['major4'] = $major4;
            }

            $result = I('new');
            
            $duty = M('Duty');
            // 从duty_member表中筛选出与duty_id相同的user_uid

            $res_duty = $duty->where($d_id)
                ->field('name')
                ->find();

            $where['company']=$res_duty['name'];

            $xiangmu = M('Xiangmu');

            session('where',$where);


                $Model = D('Xiangmu');
                $list = $this->lists($Model, $where, 'create_time desc');

              ;
                $nu = count($list);
                
                for ($i = 0; $i < $nu; $i ++) {
                    // echo $nu;
                    
                    $list[$i]['time'] = substr($list[$i]['time'], 0, 10);
                }
                $this->assign('_list', $list);
//            }
        }
        //个人用户操作
        else {

            $xiangmu_fenlei = D('Xiangmu_fenlei');
            $list_fenlei = $xiangmu_fenlei->select();
            $this->assign('fenlei', $list_fenlei);
            
            $this->select_man();
            $this->select_company();
            



            
            $uid = session('user_auth.uid');
            $xiangmu = D('Xiangmu');
            $xiangmu_first = D('Xiangmu_first');
            $aa = "user_uid=$uid ";
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
            $name=$sousuo['name']=I('name');
            if (! empty($name)) {
                $where['name'] = array(
                    'like',
                    '%' . $name . '%'
                );
            }
            $fenlei = $sousuo['fenlei'] = I('fenlei');
            if (! empty($fenlei)) {
                $where['fenlei'] = array(
                    'like',
                    '%' . $fenlei . '%'
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
            
            $action = $sousuo['action'] = I('action');
            
            if (! empty($action)) {
                $where['action'] = $action;
            }
            $shenpi = $sousuo['shenpi'] = I('shenpi');

            if (! empty($shenpi)) {

                $where['shenpi'] = $shenpi;
            }
            $haimian = $sousuo['haimian'] = I('haimian');

            if (! empty($haimian)) {

                $where['haimian'] = $haimian;
            }
            $major = $sousuo['major'] = I('major');

            if (! empty($major)) {

                $where['major'] = $major;
            }
            $major2 = $sousuo['major2'] = I('major2');

            if (! empty($major2)) {

                $where['major2'] = $major2;
            }

            $major3 = $sousuo['major3'] = I('major3');

            if (! empty($major3)) {

                $where['major3'] = $major3;
            }

            $major4 = $sousuo['major4'] = I('major4');

            if (! empty($major4)) {

                $where['major4'] = $major4;
            }


            $where['id'] = array(
                'egt',
                - 100
            );
            $where['user_uid'] = array(
                'eq',
                $uid
            );

            session('where', $where);
            session('result', $result);

                $Model = D('Xiangmu');
                $list = $this->lists($Model, $where, 'create_time desc');
                
                $nu = count($list);
                
                for ($i = 0; $i < $nu; $i ++) {

                    
                    $list[$i]['time'] = substr($list[$i]['time'], 0, 10);
                }
                $this->assign('_list', $list);
//            }
        }
        

        $this->display();
    }
    public  function  dayin_xuanze(){
        $id=I('id');
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
    public  function  next_sousuo(){
        $xiangmu_fenlei = D('Xiangmu_fenlei');
        $list_fenlei = $xiangmu_fenlei->select();
        $this->assign('fenlei', $list_fenlei);
        // 从session中获取责任单位的账户id
        $d_id['duty_id'] = session('duty_id');
//        var_dump($d_id);

        // 判断是否是责任单位账户
        if ($d_id['duty_id']!=null) {
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
            $name=$sousuo['name']=I('name');
            if (! empty($name)) {
                $where['name'] = array(
                    'like',
                    '%' . $name . '%'
                );
            }
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
            $help = $sousuo['help'] = I('help');

            if (! empty($help)) {

                $where['help'] = $help;
            }
            $shenpi = $sousuo['shenpi'] = I('shenpi');

            if (! empty($shenpi)) {

                $where['shenpi'] = $shenpi;
            }

            $action = $sousuo['action'] = I('action');

            if (! empty($action)) {
                $where['action'] = $action;
            }
            $haimian = $sousuo['haimain'] = I('haimian');

            if (! empty($haimain)) {
                $where['haimain'] = $haimain;
            }

            $major = $sousuo['major'] = I('major');

            if (! empty($major)) {
                $where['major'] = $major;
            }

            $major2 = $sousuo['major2'] = I('major2');

            if (! empty($major2)) {
                $where['major2'] = $major2;
            }

            $major3 = $sousuo['major3'] = I('major3');

            if (! empty($major3)) {
                $where['major3'] = $major3;
            }

            $major4 = $sousuo['major4'] = I('major4');

            if (! empty($major4)) {
                $where['major4'] = $major4;
            }

            $result = I('new');

            $duty_member = M('Duty_member');
            // 从duty_member表中筛选出与duty_id相同的user_uid

            $res_duty = $duty_member->where($d_id)
                ->field('user_uid')
                ->select();

            // 遍历获取到的二维数组，使其转化为一维数组
            for ($i = 0; $i < count($res_duty); $i ++) {
                $tran[$i] = $res_duty[$i]['user_uid'];
            }

            $xiangmu = M('Xiangmu');
            $where['user_uid'] = array(
                'in',
                $tran
            );
            session('where',$where);

            if ($result == "1") {
                $Model = D('Xiangmu_first');
                //var_dump($where);
                $list = $this->lists($Model, $where, 'create_time desc');
                $nu = count($list);

                for ($i = 0; $i < $nu; $i ++) {

                    $list[$i]['time'] = substr($list[$i]['time'], 0, 10);
                }

                $this->assign('_list', $list);
            } else {

                $Model = D('Xiangmu');
                $list = $this->lists($Model, $where, 'create_time desc');

                $nu = count($list);

                for ($i = 0; $i < $nu; $i ++) {
                    // echo $nu;

                    $list[$i]['time'] = substr($list[$i]['time'], 0, 10);
                }
                $this->assign('_list', $list);
            }
        }
        //个人用户操作
        else {

            $xiangmu_fenlei = D('Xiangmu_fenlei');
            $list_fenlei = $xiangmu_fenlei->select();
            $this->assign('fenlei', $list_fenlei);

            $this->select_man();
            $this->select_company();





            $uid = session('user_auth.uid');
            $xiangmu = D('Xiangmu');
            $xiangmu_first = D('Xiangmu_first');
            $aa = "user_uid=$uid ";
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
            $name=$sousuo['name']=I('name');
            if (! empty($name)) {
                $where['name'] = array(
                    'like',
                    '%' . $name . '%'
                );
            }
            $fenlei = $sousuo['fenlei'] = I('fenlei');
            if (! empty($fenlei)) {
                $where['fenlei'] = array(
                    'like',
                    '%' . $fenlei . '%'
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
                $time2= strtotime($time2);
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
                $time2= strtotime($time2);

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

            $action = $sousuo['action'] = I('action');

            if (! empty($action)) {
                $where['action'] = $action;
            }
            $shenpi = $sousuo['shenpi'] = I('shenpi');

            if (! empty($shenpi)) {

                $where['shenpi'] = $shenpi;
            }
            $haimian = $sousuo['haimian'] = I('haimian');

            if (! empty($haimian)) {

                $where['haimian'] = $haimian;
            }
            $major = $sousuo['major'] = I('major');

            if (! empty($major)) {

                $where['major'] = $major;
            }
            $major2 = $sousuo['major2'] = I('major2');

            if (! empty($major2)) {

                $where['major2'] = $major2;
            }

            $major3 = $sousuo['major3'] = I('major3');

            if (! empty($major3)) {

                $where['major3'] = $major3;
            }

            $major4 = $sousuo['major4'] = I('major4');

            if (! empty($major4)) {

                $where['major4'] = $major4;
            }


            $where['id'] = array(
                'egt',
                - 100
            );
            $where['user_uid'] = array(
                'eq',
                $uid
            );

            session('where', $where);
            session('result', $result);

            if ($result == "") {
                $Model = D('Xiangmu_first');

                $list = $this->lists($Model, $where, 'create_time desc');
                $nu = count($list);

                for ($i = 0; $i < $nu; $i ++) {


                    $list[$i]['time'] = substr($list[$i]['time'], 0, 10);
                }
                $this->assign('_list', $list);
            } else {

                $Model = D('Xiangmu');
                $list = $this->lists($Model, $where, 'create_time desc');

                $nu = count($list);

                for ($i = 0; $i < $nu; $i ++) {


                    $list[$i]['time'] = substr($list[$i]['time'], 0, 10);
                }
                $this->assign('_list', $list);
            }
        }


        $this->display();


    }
    public function bianji4()
    {
        $this->select_company();
        $id['xiangmu_id'] = I('xiangmu_id');
        $xiangmu_copy = D('Xiangmu_copy');
        $result_2 = $xiangmu_copy->where($id)->order('create_time desc')->

        select();
       $result_1=$result_2['0'];
        $this->assign('result_1', $result_1);
        
        $uid['user_uid'] = session('user_auth.uid');
        
        

        $xiangmu_fenlei = D('Xiangmu_fenlei');
        $list_fenlei = $xiangmu_fenlei->select();
        $this->assign('fenlei', $list_fenlei);
        
        
        if (IS_POST) {
            $id1['id'] = I('id');
            
            
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
            $update['haimian'] = I('haimian');

            if (empty($update['haimian'])) {
                $update['haimian'] = "否";
            } else {
                $update['haimian'] = "是";
            }
            $update['shenpi'] = I('shenpi');

            if (empty($update['shenpi'])) {
                $update['shenpi'] = "否";
            } else {
                $update['shenpi'] = "是";
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
            $up1['company']=I('shuru');
            if(!empty($up1['company'])){
                $update['company']=$up1['company'];
            }
            $update['man'] = I('man');
            $update['phone'] = I('phone');
            $update['work_progress'] = I('work_progress');
            $update['next_plan"'] = I('next_plan"');
            $update['problem'] = I('problem');

            
            $xiangmu = D('Xiangmu');
           
           
            $xiangmu->where($id1)->save($update);
            
            $xiangmu_copy = D('xiangmu_copy');
            $update['xiangmu_id'] = I('id');
            
            $add2['name'] = I('company');
            


            $xiangmu_copy->create($update);
            $xiangmu_copy->add();

           $this->redirect('Xiangmu/index');
        } else {}

        $this->display();
    }

    public function bianji3()
    {
$this->select_company();
        $xiangmu_fenlei = D('Xiangmu_fenlei');
        $list_fenlei = $xiangmu_fenlei->select();
        $this->assign('fenlei', $list_fenlei);



        $xiangmu_copy = D('xiangmu_copy');
        $id['id'] = I('id');
        $xiangmu = D('Xiangmu');
        $result_1 = $xiangmu_copy->where($id)->order('create_time desc')->

        select();



        $uid = session('user_auth.uid');


        $this->assign('result_1', $result_1);

        $ceshi['id'] = $result_1['0']['xiangmu_id'];
        $where['id']=$result_1['0']['id'];
        session('bianji3_where', $where['id']);


        if (IS_POST) {
            $id['id'] = I('xiangmu_id');



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

            $update['haimian'] = I('haimian');
            if (empty($update['haimian'])) {
                $update['haimian'] = "否";
            } else {
                $update['haimian'] = "是";
            }
            $update['shenpi'] = I('shenpi');
            if (empty($update['shenpi'])) {
                $update['shenpi'] = "否";
            } else {
                $update['shenpi'] = "是";
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
            $up1['company']=I('shuru');
            if(!empty($up1['company'])){
                $update['company']=$up1['company'];
            }
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
            // echo $id['id'];
            // var_dump($id);
            

            
            // echo $update['user_uid'];

        $xiangmu->where($id)->save($update);

            $xiangmu_copy = D('xiangmu_copy');
            $update['xiangmu_id'] = $result_1['0']['xiangmu_id'];

             $where['id']=session('bianji3_where');
            dump($where);
           $xiangmu_copy->where($where)->save($update);

            $this->redirect('Index/index');
        } else {}
        
        $this->display();
    }
    public  function city_project(){

        $d_id['id'] = session('duty_id');
        if ($d_id['id']!=null) {

            $duty = M('Duty');
            $result = $duty->where($d_id)
                ->field('name')
                ->find();


//            for ($i = 0; $i < count($result); $i ++) {
//                $tran[$i] = $result[$i]['user_uid'];
//            }
//            $where['user_uid'] = array(
//                'in',
//                $tran
//            );
                $where['company']=$result['name'];

        } else {
            $where['user_uid'] = session('user_auth.uid');

        }



        $xiangmu=D('Xiangmu');
        $where['major']='是';

        $list = $this->lists($xiangmu, $where, 'create_time desc');

        $this->assign('_list', $list);
        $this->display();
    }
    public  function major2(){


        $d_id['duty_id'] = session('duty_id');
        if ($d_id['duty_id']!=null) {
            $duty = M('Duty');
            $result = $duty->where($d_id)
                ->field('name')
                ->find();
            $where['company']=$result['name'];
//            $duty_member = M('Duty_member');
//            $result = $duty_member->where($d_id)
//                ->field('user_uid')
//                ->select();
//            for ($i = 0; $i < count($result); $i ++) {
//                $tran[$i] = $result[$i]['user_uid'];
//            }
//            $where['user_uid'] = array(
//                'in',
//                $tran
//            );

        } else {
            $where['user_uid'] = session('user_auth.uid');

        }
        $xiangmu=D('Xiangmu');
        $where['major2']='是';
        $list = $this->lists($xiangmu, $where, 'create_time desc');

        $this->assign('_list', $list);
        $this->display();
    }
    public  function major3(){

        $d_id['duty_id'] = session('duty_id');
        if ($d_id['duty_id']!=null) {
//            $duty_member = M('Duty_member');
//            $result = $duty_member->where($d_id)
//                ->field('user_uid')
//                ->select();
//            for ($i = 0; $i < count($result); $i ++) {
//                $tran[$i] = $result[$i]['user_uid'];
//            }
//            $where['user_uid'] = array(
//                'in',
//                $tran
//            );
            $duty = M('Duty');
            $result = $duty->where($d_id)
                ->field('name')
                ->find();
            $where['company']=$result['name'];
        } else {
            $where['user_uid'] = session('user_auth.uid');

        }
        $xiangmu=D('Xiangmu');
        $where['major3']='是';
        $list = $this->lists($xiangmu, $where, 'create_time desc');

        $this->assign('_list', $list);
        $this->display();
    }
    public  function major4(){

        $d_id['duty_id'] = session('duty_id');
        if ($d_id['duty_id']!=null) {
//            $duty_member = M('Duty_member');
//            $result = $duty_member->where($d_id)
//                ->field('user_uid')
//                ->select();
//            for ($i = 0; $i < count($result); $i ++) {
//                $tran[$i] = $result[$i]['user_uid'];
//            }
//            $where['user_uid'] = array(
//                'in',
//                $tran
//            );
            $duty = M('Duty');
            $result = $duty->where($d_id)
                ->field('name')
                ->find();
            $where['company']=$result['name'];
        } else {
            $where['user_uid'] = session('user_auth.uid');

        }
        $xiangmu=D('Xiangmu');
        $where['major4']='是';
        $list = $this->lists($xiangmu, $where, 'create_time desc');
        $this->assign('_list', $list);
        $this->display();
    }
    public  function haimian(){

        $d_id['duty_id'] = session('duty_id');
        if ($d_id['duty_id']!=null) {
//            $duty_member = M('Duty_member');
//            $result = $duty_member->where($d_id)
//                ->field('user_uid')
//                ->select();
//            for ($i = 0; $i < count($result); $i ++) {
//                $tran[$i] = $result[$i]['user_uid'];
//            }
//            $where['user_uid'] = array(
//                'in',
//                $tran
//            );
            $duty = M('Duty');
            $result = $duty->where($d_id)
                ->field('name')
                ->find();
            $where['company']=$result['name'];

        } else {
            $where['user_uid'] = session('user_auth.uid');

        }
        $xiangmu=D('Xiangmu');
        $where['haimian']='是';
        $list = $this->lists($xiangmu, $where, 'create_time desc');
        $this->assign('_list', $list);
        $this->display();
    }


    public function dayin_major()
    {
        $first_stage=M('FirstStage');
        $xiangmu = D('Xiangmu');
        $fenlei_stage=M('FenleiStage');
        $stage=M('Stage');



        $d_id['id'] = session('duty_id');
        if ($d_id['id']!=null) {
            $duty = M('Duty');
            $result = $duty->where($d_id)
                ->field('name')
                ->find();

//            for ($i = 0; $i < count($result); $i ++) {
//                $tran[$i] = $result[$i]['user_uid'];
//            }
        $q['company']=$result['name'];

            $q['major']='是';
//            $q['user_uid'] = array(
//                'in',
//                $tran
//            );
            $data = $xiangmu->field('user_uid,time,create_time,xiangmu_uid,finish_time1,finish_time2,finish_time3,finish_time4,finish_time5,finish_time6,finish_time7,finish_time8,finish_time9,finish_time10,finish_time11',true)->where($q)->select();
//            $data = $xiangmu->where($q)
//                ->field('user_uid,time,create_time,xiangmu_uid', true)
//                ->select();
        } else {
            $uid['user_uid'] = session('user_auth.uid');
            $uid['major']='是';
            $data = $xiangmu->field('user_uid,time,create_time,xiangmu_uid,finish_time1,finish_time2,finish_time3,finish_time4,finish_time5,finish_time6,finish_time7,finish_time8,finish_time9,finish_time10,finish_time11',true)->where($uid)->select();

//            $data = $xiangmu->where($uid)
//                ->field('user_uid,time,create_time,xiangmu_uid', true)
//                ->select();

        }

        $number = count($data);

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

                $result_1[$k][$keyName]['item']=$ccc;
                unset($cc);
            }


            unset($cc);

        }


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


            $this->getExcel($data,$result_1);
        } else {
            $this->error('没有要打印的报表');
        }
    }

    public function dayin_major2()
    {
        $first_stage=M('FirstStage');
        $xiangmu = D('Xiangmu');
        $fenlei_stage=M('FenleiStage');
        $stage=M('Stage');



        $d_id['id'] = session('duty_id');
        if ($d_id['id']!=null) {
            $duty = M('Duty');
            $result = $duty->where($d_id)
                ->field('name')
                ->find();

            for ($i = 0; $i < count($result); $i ++) {
                $tran[$i] = $result[$i]['user_uid'];
            }

            $q['major2']='是';
//            $q['user_uid'] = array(
//                'in',
//                $tran
//            );
            $q['company']=$result['name'];
            $data = $xiangmu->field('user_uid,time,create_time,xiangmu_uid,finish_time1,finish_time2,finish_time3,finish_time4,finish_time5,finish_time6,finish_time7,finish_time8,finish_time9,finish_time10,finish_time11',true)->where($q)->select();
//            $data = $xiangmu->where($q)
//                ->field('user_uid,time,create_time,xiangmu_uid', true)
//                ->select();
        } else {
            $uid['user_uid'] = session('user_auth.uid');
            $uid['major2']='是';
            $data = $xiangmu->field('user_uid,time,create_time,xiangmu_uid,finish_time1,finish_time2,finish_time3,finish_time4,finish_time5,finish_time6,finish_time7,finish_time8,finish_time9,finish_time10,finish_time11',true)->where($uid)->select();

//            $data = $xiangmu->where($uid)
//                ->field('user_uid,time,create_time,xiangmu_uid', true)
//                ->select();

        }
        $number = count($data);

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

                $result_1[$k][$keyName]['item']=$ccc;
                unset($cc);
            }


            unset($cc);

        }

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


            $this->getExcel($data,$result_1);
        } else {
            $this->error('没有要打印的报表');
        }
    }

    public function dayin_major3()
    {
        $first_stage=M('FirstStage');
        $xiangmu = D('Xiangmu');
        $fenlei_stage=M('FenleiStage');
        $stage=M('Stage');



        $d_id['duty_id'] = session('duty_id');
        if ($d_id['duty_id']!=null) {
//            $duty_member = M('Duty_member');
//            $result = $duty_member->where($d_id)
//                ->field('user_uid')
//                ->select();
//
//            for ($i = 0; $i < count($result); $i ++) {
//                $tran[$i] = $result[$i]['user_uid'];
//            }
//
//            $q['major3']='是';
//            $q['user_uid'] = array(
//                'in',
//                $tran
//            );
            $duty = M('Duty');
            $result = $duty->where($d_id)
                ->field('name')
                ->find();

            for ($i = 0; $i < count($result); $i ++) {
                $tran[$i] = $result[$i]['user_uid'];
            }

            $q['major3']='是';
//            $q['user_uid'] = array(
//                'in',
//                $tran
//            );
            $q['company']=$result['name'];
            $data = $xiangmu->field('user_uid,time,create_time,xiangmu_uid,finish_time1,finish_time2,finish_time3,finish_time4,finish_time5,finish_time6,finish_time7,finish_time8,finish_time9,finish_time10,finish_time11',true)->where($q)->select();
//            $data = $xiangmu->where($q)
//                ->field('user_uid,time,create_time,xiangmu_uid', true)
//                ->select();
        } else {
            $uid['user_uid'] = session('user_auth.uid');
            $uid['major3']='是';
            $data = $xiangmu->field('user_uid,time,create_time,xiangmu_uid,finish_time1,finish_time2,finish_time3,finish_time4,finish_time5,finish_time6,finish_time7,finish_time8,finish_time9,finish_time10,finish_time11',true)->where($uid)->select();

//            $data = $xiangmu->where($uid)
//                ->field('user_uid,time,create_time,xiangmu_uid', true)
//                ->select();

        }
        $number = count($data);

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

                $result_1[$k][$keyName]['item']=$ccc;
                unset($cc);
            }


            unset($cc);

        }

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


            $this->getExcel($data,$result_1);
        } else {
            $this->error('没有要打印的报表');
        }
    }

    public function dayin_major4()
    {
        $first_stage=M('FirstStage');
        $xiangmu = D('Xiangmu');
        $fenlei_stage=M('FenleiStage');
        $stage=M('Stage');



        $d_id['duty_id'] = session('duty_id');
        if ($d_id['duty_id']!=null) {
//            $duty_member = M('Duty_member');
//            $result = $duty_member->where($d_id)
//                ->field('user_uid')
//                ->select();
//
//            for ($i = 0; $i < count($result); $i ++) {
//                $tran[$i] = $result[$i]['user_uid'];
//            }
//
//            $q['major4']='是';
//            $q['user_uid'] = array(
//                'in',
//                $tran
//            );
            $duty = M('Duty');
            $result = $duty->where($d_id)
                ->field('name')
                ->find();

            for ($i = 0; $i < count($result); $i ++) {
                $tran[$i] = $result[$i]['user_uid'];
            }

            $q['major4']='是';
//            $q['user_uid'] = array(
//                'in',
//                $tran
//            );
            $q['company']=$result['name'];
            $data = $xiangmu->field('user_uid,time,create_time,xiangmu_uid,finish_time1,finish_time2,finish_time3,finish_time4,finish_time5,finish_time6,finish_time7,finish_time8,finish_time9,finish_time10,finish_time11',true)->where($q)->select();
//            $data = $xiangmu->where($q)
//                ->field('user_uid,time,create_time,xiangmu_uid', true)
//                ->select();
        } else {
            $uid['user_uid'] = session('user_auth.uid');
            $uid['major4']='是';
            $data = $xiangmu->field('user_uid,time,create_time,xiangmu_uid,finish_time1,finish_time2,finish_time3,finish_time4,finish_time5,finish_time6,finish_time7,finish_time8,finish_time9,finish_time10,finish_time11',true)->where($uid)->select();

//            $data = $xiangmu->where($uid)
//                ->field('user_uid,time,create_time,xiangmu_uid', true)
//                ->select();

        }
        $number = count($data);

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
    public  function xiugai($id='',$start_time='',$end_time=''){
        $first_stage=M('FirstStage');
        $where['id']=$id;

        if($start_time!=''){

            $updata['start_time']=$start_time;
//            $updata['start_time']=strtotime($updata['start_time']);
        }
        if($end_time!=''){
            $updata['end_time']=$end_time;
//            $updata['end_time']=strtotime( $updata['end_time']);

        }


        $first_stage->where($where)->save($updata);
        $data="ok";
        $this->ajaxReturn($data);

    }

}