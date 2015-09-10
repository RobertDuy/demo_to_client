<?php
require_once('wp-blog-header.php');
global $wpdb;

header('Content-Type: text/html; charset=utf-8');

$result = array();
if(isset($_POST['before_spin']) && $_POST['before_spin'] == 'true'){
    header('Content-Type: application/json');
    $user_name = $_POST['username'];
    $user_email = $_POST['email'];
    $user_phone = $_POST['phone'];
    $type_prize = $_POST['type_prize'];

    $sql = "SELECT * FROM $wpdb->user_win_prize WHERE user_email = '". $user_email . "' and type_prize = '". $type_prize ."' and user_phone= '". $user_phone ."' and user_name ='". $user_name . "'";
    $userWPrize = $wpdb->get_row($sql);

    if(isset($userWPrize) && isset($userWPrize->user_win_prize_id)){
        $result['status'] = 'Failed';
        $result['err_message'] = 'Duplicated user!';
    }
    echo json_encode($result);
}
else if(isset($_POST['before_spin']) && $_POST['before_spin'] == 'false'){
    header('Content-Type: application/json');
    $user_name = $_POST['username'];
    $user_email = $_POST['email'];
    $user_phone = $_POST['phone'];
    $type_prize = $_POST['type_prize'];
    $prize = $_POST['prize'];

    try{
        $wpdb->insert('wp_user_win_prize',
            array(
                'user_name' => $user_name,
                'user_email' => $user_email,
                'user_phone' => $user_phone,
                'user_w_prize' => $prize,
                'type_prize' => $type_prize,
                'date' => date('Y-m-d')
            )
        );
        $result['status'] = 'OK';
    }catch (Exception $e){
        $result['status'] = 'Failed';
    }
    echo json_encode($result);

}else if(isset($_POST['user_prize_edit'])){

}else if(isset($_POST['user_prize_delete'])){

}