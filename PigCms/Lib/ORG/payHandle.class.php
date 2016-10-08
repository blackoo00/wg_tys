<?php
final class payHandle
{
    public $from;
    public $db;
    public $payType;
    public $token;
    public function __construct($token, $from, $paytype = 'tenpay')
    {
        $this->from = $from;
        $this->from = $from ? $from : 'Groupon';
        $this->from = $this->from != 'groupon' ? $this->from : 'Groupon';
        switch (strtolower($this->from)) {
            default:
            case 'groupon':
            case 'store':
                $this->db = M('Product_cart');
                break;
            case 'repast':
                $this->db = M('Dish_order');
                break;
            case 'hotels':
                $this->db = M('Hotels_order');
                break;
            case 'business':
                $this->db = M('Reservebook');
                break;
            case 'card':
                $this->db = M('Member_card_pay_record');
                break;
        }
        $this->token = $token;
        $this->payType = $paytype;
    }
    public function getFrom()
    {
        return $this->from;
    }
    public function beforePay($id)
    {
        $thisOrder = $this->db->where(array('token' => $this->token, 'orderid' => $id))->find();
        switch (strtolower($this->from)) {
            default:
                $price = $thisOrder['price'];
                break;
            case 'business':
                $price = $thisOrder['payprice'];
                break;
        }
        return array('orderid' => $thisOrder['orderid'], 'price' => $price, 'wecha_id' => $thisOrder['wecha_id'], 'token' => $thisOrder['token']);
    }
    public function afterPay($id, $transaction_id = '')
    {
        $thisOrder = $this->beforePay($id);
        $wecha_id = $thisOrder['wecha_id'];
        $order_model = $this->db;
        $order_model->where(array('orderid' => $id))->setField('paid', 1);
        if (strtolower($this->getFrom()) == 'groupon') {
            $order_model->where(array('orderid' => $thisOrder['orderid']))->save(array('transactionid' => $transaction_id, 'paytype' => $this->payType));
        }
        // if (strtolower($this->getFrom()) == 'store') {
        //     $out_trade_no = $thisOrder['orderid'];
        //     $_GET['token'] = $thisOrder['token'];
        //     //订单处理
        //     $order = M('product_cart')->where(array('orderid'=>$out_trade_no))->find();
        //     if($order['setInc']==0){
        //         $custom = M('custom_list')->where(array('openid' => $order['wecha_id']))->find();//孕妈
        //         if($custom&&$custom['did']!=0){
        //             M('doctor_list')->where('id='.$custom['did'])->setInc('orderNums',1);//孕妈订单加1
        //             $doctor = M('doctor_list')->where('id='.$custom['did'])->find();//孕育师
        //             if($doctor&&$doctor['hid']!=0){
        //                 M('doctor_list')->where('id='.$custom['did'])->setInc('orderNums',1);//孕育师订单加1
        //                 M('hospital_list')->where('id='.$doctor['hid'])->setInc('orderNums',1);//医院订单加1
        //             }
        //         }
        //         // M('product_cart')->where(array('orderid'=>$out_trade_no))->setField('setInc',1);
        //     }
        //     //三级分销
        //     $order = M('product_cart')->where(array('orderid'=>$out_trade_no))->find();
        //     if($order['setInc']==0){
        //         $userInfo = M('Distribution_member')->where(array('token' => $_GET['token'], 'wecha_id' => $order['wecha_id']))->find();
        //         dump($userInfo);
        //         $this->distriOrderStatus($_GET['token'],$order['id'],1);
        //         if($userInfo['fid']!=0){
        //             M('Distribution_member')->where(array('token' => $_GET['token'], 'id' => $userInfo['fid']))->setInc('orderNums');//一级订单累加
        //         }
        //         if($userInfo['sid']!=0){
        //             M('Distribution_member')->where(array('token' => $_GET['token'], 'id' => $userInfo['sid']))->setInc('orderNums');//二级订单累加
        //         }
        //         if($userInfo['tid']!=0){
        //             M('Distribution_member')->where(array('token' => $_GET['token'], 'id' => $userInfo['tid']))->setInc('orderNums');//三级订单累加
        //         }
        //         $orderNums = M('product_cart')->where(array('wecha_id'=>$order['wecha_id'],'token'=>$_GET['token'],'paid'=>1))->count();
        //         if($orderNums==1){
        //             $dataDistri['beDistri'] = 1;
        //             M('product_cart')->where(array('orderid'=>$out_trade_no,'token'=>$_GET['token']))->save($dataDistri);
        //         }
        //         if($userInfo['distritime']==0){
        //             $datas['distritime'] = time();
        //             M('Distribution_member')->where(array('wecha_id' => $order['wecha_id'], 'token' => $_GET['token']))->save($datas);
        //         }
        //         // M('product_cart')->where(array('orderid'=>$out_trade_no))->setField('setInc',1);
        //     }
        // }
        return $thisOrder;
    }
    function distriOrderStatus($token,$order_id,$status) {
        $condition['order_id'] = $order_id;
        $condition['token'] = $token;
        $data['status'] = $status;
        $db = M('Distribution_ordermoney');
        $db->where($condition)->save($data);
    }
}