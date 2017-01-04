<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Admin\Model;

use Think\Model\RelationModel;

/**
 * 用户模型
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */

class DutyModel extends RelationModel {

    protected $_link = array(
        'DutyMember'=>array(
            'mapping_type'      => self::HAS_MANY,
            'class_name'        => 'DutyMember',
            'foreign_key'=>'user_uid',
        ));
}
