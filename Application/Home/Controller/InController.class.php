<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------
namespace Home\Controller;

use Home\Model\BookBeifenModel;
use Home\Model\TagBeifenModel;
use Home\Model\TagBookBeifenModel;
use OT\DataDictionary;
use Think\Log;
use Think\Upload;
use User\Api\UserApi;
use Think\Controller;
use Think\Model;

/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class InController extends HomeController
{

    // 系统首页

    public  function  index(){

        $this->display();
    }
    Public function xinjian()
    {


        $Upload=new Upload();

        $res=$Upload->uploadOne($_FILES['biaoge']);
        // 如果没上传文件，则上传路径为空 即$res为空

        if (!empty($res)) {
            $xinjian['biaoge_dizhi']='Uploads/' . $res['savepath'] . $res['savename'];
            Log::write();
            // echo $xinjian['biaoge_dizhi'];
            // 导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
            import("Org.Util.PHPExcel");
            // 要导入的xls文件，位于根目录下的Public文件夹

            // $filename="./Public/1.xls";
            $filename=$xinjian['biaoge_dizhi'];
            // 创建PHPExcel对象，注意，不能少了\
            $PHPExcel=new \PHPExcel();
            // 如果excel文件后缀名为.xls，导入这个类
            // import("Org.Util.PHPExcel.Reader.Excel5");
            // 如果excel文件后缀名为.xlsx，导入这下类
            import("Org.Util.PHPExcel.Reader.Excel2007");
            $PHPReader=new \PHPExcel_Reader_Excel2007();

            // $PHPReader = new \PHPExcel_Reader_Excel5();
            // 载入文件
            $PHPExcel=$PHPReader->load($filename);
            // 获取表中的第一个工作表，如果要获取第二个，把0改为1，依次类推
            $currentSheet=$PHPExcel->getSheet(0);
            // 获取总列数
            $allColumn=$currentSheet->getHighestColumn();
            // 获取总行数
            $allRow=$currentSheet->getHighestRow();
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


            $result=array();
            $tags=array();
            $TagBeifenM=new TagBeifenModel();
            $TagBookBeifenM=new TagBookBeifenModel();


            $BookBeifenM=new BookBeifenModel();
            for ($i=2; $i <= $allRow; $i++) {
              $update['isbn']= $data['isbn']=(String)$PHPExcel->getActiveSheet()->getCell("B" . $i)->getValue();
            $update['title']              =   (string)$PHPExcel->getActiveSheet()->getCell("C".$i)->getValue();
            $update['author']             =   (string)$PHPExcel->getActiveSheet()->getCell("D".$i)->getValue();
            $update['publisher']          =   (string)$PHPExcel->getActiveSheet()->getCell("G".$i)->getValue();
            $update['pages']              =   (int)$PHPExcel->getActiveSheet()->getCell("E".$i)->getValue();

            $update['pubdate']            =   (string)$PHPExcel->getActiveSheet()->getCell("E".$i)->getValue();

             $update['image']              =   (string)$PHPExcel->getActiveSheet()->getCell("F".$i)->getValue();
            // $update['image']              =   'image/'.$data['image'];
                $tag=(string)$PHPExcel->getActiveSheet()->getCell("I" . $i)->getValue();
                $tag=explode(' ', $tag);
                $count=count($tag);
                $tag=$tag[$count - 2];
                $data['tag_id']=$tag;

                $result[]=$data;
                $tags[]=$tag;
                unset($data);
                $update1[]=$update;


            }
//            $tags=array_unique($tags);
//            $tags=implode(',', $tags);
//            $tagIds=$TagBeifenM->getIds($tags);

            //dump($tagIds);
           // dump($tags);
            foreach ($result as $k=>$v) {
                foreach ($tagIds as $row) {
                    if ($v['tag_id'] == $row['tag']) {
                        $result[$k]['tag_id']=$row['id'];
                        $result[$k]['tag_id']=$row['id'];
                        $id=$TagBookBeifenM->where($result[$k])->getField('id');
                        if ($id) {
                            dump($id);
                            unset($result[$k]);

                        } else {

                        }
                        break;
                    }
                }
            }
            foreach ($update1 as $k=>$v) {
                foreach ($tagIds as $row) {
                    if ($v['isbn'] == $row['tag']) {
                        $update1[$k]['isbn']=$row['id'];
                        $update1[$k]['isbn']=$row['id'];
                        $id=$TagBookBeifenM->where($result[$k])->getField('id');
                        if ($id) {
                            dump($id);
                            unset($result[$k]);

                        } else {

                        }
                        break;
                    }
                }
            }
dump($update1);
            //$TagBookBeifenM->addAll($result);
            //$BookBeifenM->addAll($update);

        }


    }

    public function book(){
        import("Org.Util.PHPExcel");
        // 要导入的xls文件，位于根目录下的Public文件夹

        // $filename="./Public/1.xls";
        $filename=$xinjian['biaoge_dizhi'];
        // 创建PHPExcel对象，注意，不能少了\
        $PHPExcel=new \PHPExcel();
        // 如果excel文件后缀名为.xls，导入这个类
        // import("Org.Util.PHPExcel.Reader.Excel5");
        // 如果excel文件后缀名为.xlsx，导入这下类
        import("Org.Util.PHPExcel.Reader.Excel2007");
        $PHPReader=new \PHPExcel_Reader_Excel2007();

        // $PHPReader = new \PHPExcel_Reader_Excel5();
        // 载入文件
        $PHPExcel=$PHPReader->load($filename);
        // 获取表中的第一个工作表，如果要获取第二个，把0改为1，依次类推
        $currentSheet=$PHPExcel->getSheet(0);
        // 获取总列数
        $allColumn=$currentSheet->getHighestColumn();
        // 获取总行数
        $allRow=$currentSheet->getHighestRow();
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


        $result=array();
        $tags=array();
        $TagBeifenM=new TagBeifenModel();
        $TagBookBeifenM=new TagBookBeifenModel();


        $BookBeifenM=new BookBeifenModel();
        for ($i=2; $i <= $allRow; $i++) {
            $update['isbn']= $data['isbn']=(String)$PHPExcel->getActiveSheet()->getCell("B" . $i)->getValue();
            $update['title']              =   (string)$PHPExcel->getActiveSheet()->getCell("C".$i)->getValue();
            $update['author']             =   (string)$PHPExcel->getActiveSheet()->getCell("D".$i)->getValue();
            $update['publisher']          =   (string)$PHPExcel->getActiveSheet()->getCell("G".$i)->getValue();
            $update['pages']              =   (int)$PHPExcel->getActiveSheet()->getCell("E".$i)->getValue();

            $update['pubdate']            =   (string)$PHPExcel->getActiveSheet()->getCell("E".$i)->getValue();

            $update['image']              =   (string)$PHPExcel->getActiveSheet()->getCell("F".$i)->getValue();
            // $update['image']              =   'image/'.$data['image'];
            $tag=(string)$PHPExcel->getActiveSheet()->getCell("I" . $i)->getValue();
            $tag=explode(' ', $tag);
            $count=count($tag);
            $tag=$tag[$count - 2];
            $data['tag_id']=$tag;

            $result[]=$data;
            $tags[]=$tag;
            unset($data);
            $update1[]=$update;


        }
//            $tags=array_unique($tags);
//            $tags=implode(',', $tags);
//            $tagIds=$TagBeifenM->getIds($tags);

        //dump($tagIds);
        // dump($tags);
        foreach ($result as $k=>$v) {
            foreach ($tagIds as $row) {
                if ($v['tag_id'] == $row['tag']) {
                    $result[$k]['tag_id']=$row['id'];
                    $result[$k]['tag_id']=$row['id'];
                    $id=$TagBookBeifenM->where($result[$k])->getField('id');
                    if ($id) {
                        dump($id);
                        unset($result[$k]);

                    } else {

                    }
                    break;
                }
            }
        }
        foreach ($update1 as $k=>$v) {
            foreach ($tagIds as $row) {
                if ($v['isbn'] == $row['tag']) {
                    $update1[$k]['isbn']=$row['id'];
                    $update1[$k]['isbn']=$row['id'];
                    $id=$TagBookBeifenM->where($result[$k])->getField('id');
                    if ($id) {
                        dump($id);
                        unset($result[$k]);

                    } else {

                    }
                    break;
                }
            }
        }

        $TagBookBeifenM->addAll($result);
        //$BookBeifenM->addAll($update);

    }


}