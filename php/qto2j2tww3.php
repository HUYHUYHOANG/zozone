<?php

use function GuzzleHttp\Promise\each;

require_once('../includes/config.php');
require_once('../includes/lib/HTMLPurifier/HTMLPurifier.standalone.php');
require_once('../includes/sql_builder/idiorm.php');
require_once('../includes/db.php');
require_once('../includes/classes/class.template_engine.php');
require_once('../includes/classes/class.country.php');
require_once('../includes/functions/func.global.php');
require_once('../includes/functions/func.sqlquery.php');
require_once('../includes/functions/func.users.php');
require_once('../includes/functions/func.customers.php');
require_once('../includes/lang/lang_' . $config['lang'] . '.php');
require_once('../includes/seo-url.php');

sec_session_start();
define("ROOTPATH", dirname(__DIR__));

if (isset($_GET['action'])) {
    if ($_GET['action'] == "add_item") {
        add_item();
    }
    if ($_GET['action'] == "add_pdf_menu") {
        add_pdf_menu();
    }
    if ($_GET['action'] == "edit_item") {
        edit_item();
    }
    if ($_GET['action'] == "get_item") {
        get_item();
    }
    if ($_GET['action'] == "get_online_booking") {
        get_online_booking();
    }
    if ($_GET['action'] == "get_image_menu") {
        get_image_menu();
    }
    if ($_GET['action'] == "delete_item") {
        delete_item();
    }
    if ($_GET['action'] == "delete_image_menu") {
        delete_image_menu();
    }

    if ($_GET['action'] == "add_image_item") {
        add_image_item();
    }

    if ($_GET['action'] == "submitBlogComment") {
        submitBlogComment();
    }
    if ($_GET['action'] == "get_allegie") {
        get_allegie();
    }
    if ($_GET['action'] == "addSlideShowImage") {
        addSlideShowImage();
    }

    if ($_GET['action'] == "addSlideImage") {
        addSlideImage();
    }

    if ($_GET['action'] == "addImageInGroup") {
        addImageInGroup();
    }

    if($_GET['action'] == "EditSlideImage")
    {
        EditSlideImage();
    }

    if($_GET['action'] == "EditFooterImage")
    {
        EditFooterImage();
    }

    if ($_GET['action'] == "EditGroupImageById") {
        EditGroupImageById();
    }

    if ($_GET['action'] == "addFooterImage") {
        addFooterImage();
    }

    if($_GET['action'] == "CommonSaveImage")
    {
        CommonSaveImage();
    }

    if($_GET['action'] == "setFloattingImage"){
        setFloattingImage();
    }
    
    die(0);
}



if (isset($_POST['action'])) {

    if($_POST['action'] == "get_whatsapp_message")
    {
        get_whatsapp_message();
    }
    if ($_POST['action'] == "update_customer_password") {
        update_customer_password();
    }

    if ($_POST['action'] == "update_customer_address") {
        update_customer_address();
    }
    if ($_POST['action'] == "addNewOpenHour") {
        addNewOpenHour();
    }
    if ($_POST['action'] == "addNewCat") {
        addNewCat();
    }
    if ($_POST['action'] == "editOpenHour") {
        editOpenHour();
    }
    if ($_POST['action'] == "editCat") {
        editCat();
    }
    if ($_POST['action'] == "deleteCat") {
        deleteCat();
    }
    if ($_POST['action'] == "deleteOpenHour") {
        deleteOpenHour();
    }


    if ($_POST['action'] == "addNewSubCat") {
        addNewSubCat();
    }
    if ($_POST['action'] == "editSubCat") {
        editSubCat();
    }
    if ($_POST['action'] == "deleteSubCat") {
        deleteSubCat();
    }

    if ($_POST['action'] == "updateCatPosition") {
        updateCatPosition();
    }

    if ($_POST['action'] == "updateSubCatPosition") {
        updateSubCatPosition();
    }

    if ($_POST['action'] == "updateMenuPosition") {
        updateMenuPosition();
    }

    if ($_POST['action'] == "updateExtrasPosition") {
        updateExtrasPosition();
    }

    if ($_POST['action'] == "updateImageMenuPosition") {
        updateImageMenuPosition();
    }

    if ($_POST['action'] == "ajaxlogin") {
        ajaxlogin();
    }
    if ($_POST['action'] == "email_verify") {
        email_verify();
    }
    if ($_POST['action'] == "addAllegie") {
        addAllegie();
    }
    if ($_POST['action'] == "addAdditives") {
        addAdditives();
    }

    if ($_POST['action'] == "addProperties") {
        addProperties();
    }
    if ($_POST['action'] == "addMenuExtra") {
        addMenuExtra();
    }
    if ($_POST['action'] == "editAllegie") {
        editAllegie();
    }
    if ($_POST['action'] == "editProperties") {
        editProperties();
    }
    if ($_POST['action'] == "editAdditives") {
        editAdditives();
    }
    if ($_POST['action'] == "editMenuExtra") {
        editMenuExtra();
    }
    if ($_POST['action'] == "deleteAllegie") {
        deleteAllegie();
    }
    if ($_POST['action'] == "deleteProperties") {
        deleteProperties();
    }

    if ($_POST['action'] == "deleteAdditives") {
        deleteAdditives();
    }

    if ($_POST['action'] == "deleteMenuExtra") {
        deleteMenuExtra();
    }

    if ($_POST['action'] == "sendRestaurantOrder") {
        sendRestaurantOrder();
    }
    if ($_POST['action'] == "sendRestaurantReserve") {
        sendRestaurantReserve();
    }
    if ($_POST['action'] == "sendRestaurantOrderTemp") {
        sendRestaurantOrderTemp();
    }
    if ($_POST['action'] == "SendRestaurantBooking") {
        sendRestaurantBooking();
    }

    if ($_POST['action'] == "check_user_login") {
        check_user_login();
    }
    if ($_POST['action'] == "completeBooking") {
        completeBooking();
    }

    if ($_POST['action'] == "completeOrder") {
        completeOrder();
    }

    if ($_POST['action'] == "completeOrderReserve") {
        completeOrderReserve();
    }

    if ($_POST['action'] == "deleteOrder") {
        deleteOrder();
    }
    if ($_POST['action'] == "deleteOrderReserve") {
        deleteOrderReserve();
    }
    if ($_POST['action'] == "deleteBooking") {
        deleteBooking();
    }
    if ($_POST['action'] == "deleteImageSlideShow") {
        deleteImageSlideShow();
    }
    if($_POST['action'] == "deleteCoverImage")
    {
        deleteCoverImage();
    }
    if($_POST['action'] == "deleteFooterImage")
    {
        deleteFooterImage();
    }
    
    if ($_POST['action'] == "getBookings") {
        getBookings();
    }

    if($_POST['action'] == "getListBookings")
    {
        getListBookings();
    }

    if ($_POST['action'] == "getOrders") {
        getOrders();
    }
    if ($_POST['action'] == "getListOrders") {
        getListOrders();
    }
    
    if ($_POST['action'] == "getOrdersReserve") {
        getOrdersReserve();
    }
    if ($_POST['action'] == "getListOrdersReserve") {
        getListOrdersReserve();
    }
  

    if ($_POST['action'] == "checkStoreSlug") {
        checkStoreSlug();
    }
    if ($_POST['action'] == "save-open-time") {
        save_open_time();
    }
    if ($_POST['action'] == "customers_login") {
        customers_login();
    }
    // if ($_POST['action'] == "addShippingFee") {
    //     addShippingFee();
    // }
    // if ($_POST['action'] == "addShippingFeeGoogleMap") {
    //     addShippingFeeGoogleMap();
    // }
    // if ($_POST['action'] == "editShippingFee") {
    //     editShippingFee();
    // }
    // if ($_POST['action'] == "editShippingFeeGoogleMap") {
    //     editShippingFeeGoogleMap();
    // }
    if ($_POST['action'] == "EditShippingFeeGMap") {
        EditShippingFeeGMap();
    }
    if ($_POST['action'] == "getKmFromGMap") {
        // getKmFromGMap();
    }
    if ($_POST['action'] == "getShippingFee") {
        getShippingFee();
    }
    if ($_POST['action'] == "resetOrderDeliveryTakeaway") {
        resetOrderDeliveryTakeaway();
    }
    if ($_POST['action'] == "resetBooking") {
        resetBooking();
    }

    if ($_POST['action'] == "resetOrderOnTable") {
        resetOrderOnTable();
    }
    if ($_POST['action'] == "resetOrderReserve") {
        resetOrderReserve();
    }

    if ($_POST['action'] == "deleteShipping") {
        deleteShipping();
    }
    if ($_POST['action'] == "deleteShippingGoogleMap") {
        deleteShippingGoogleMap();
    }
    if ($_POST['action'] == "deleteTable") {
        deleteTable();
    }
    if ($_POST['action'] == "deleteCancellationReason") {
        deleteCancellationReason();
    }
    if ($_POST['action'] == "emptyTable") {
        emptyTable();
    }
    if ($_POST['action']  == "ResetStatusTable") {
        ResetStatusTable();
    }
    if ($_POST['action'] == "ResetStatusOnTable") {
        ResetStatusOnTable();
    }
    // if ($_POST['action'] == "addTable") {
    //     addTable();
    // }
    // if ($_POST['action'] == "addCancellationReason") {
    //     addCancellationReason();
    // }
    // if ($_POST['action'] == "addMultiTable") {
    //     addMultiTable();
    // }
    // if ($_POST['action'] == "editTable") {
    //     editTable();
    // }
    // if ($_POST['action'] == "editCancellationReason") {
    //     editCancellationReason();
    // }
    if ($_POST['action'] == "ForgotPassword") {
        CustomerForgotPassword();
    }
    if ($_POST['action'] == "check_and_update_table") {
        check_and_update_table();
    }
    if ($_POST['action'] == "checkConfirmOrders") {
        checkConfirmOrders();
    }
    if ($_POST['action'] == "checkRemoveTableFromMobile") {
        checkRemoveTableFromMobile();
    }
    if ($_POST['action'] == "checkTableUsing") {
        checkTableUsing();
    }
    if ($_POST['action'] == "pushDataToOrderTemp") {
        pushDataToOrderTemp();
    }
    if ($_POST['action'] == "RemoveDataToOrderTemp") {
        RemoveDataToOrderTemp();
    }
    if ($_POST['action'] == "RemoveDataOrderTempExtra") {
        RemoveDataOrderTempExtra();
    }
    // if ($_POST['action'] == "editStatusBooking") {
    //     editStatusBooking();
    // }
    if ($_POST['action'] == "getReserveData") {
        getReserveData();
    }
    if ($_POST['action'] == "getReserveItemData") {
        getReserveItemData();
    }
    if ($_POST['action'] == "RemoveDataReserve") {
        RemoveDataReserve();
    }
    if ($_POST['action'] == "EditIsDisableReserve") {
        EditIsDisableReserve();
    }
    if ($_POST['action'] == "saveAddressCustomer") {
        saveAddressCustomer();
    }
    if ($_POST['action'] == "cancelModule") {
        cancelModule();
    }

    // if ($_POST['action'] == "addOnlineCoupon") {
    //     addOnlineCoupon();
    // }
    // if ($_POST['action'] == "addOnTableCoupon") {
    //     addOnTableCoupon();
    // }

    // if ($_POST['action'] == "editOnlineCoupon") {
    //     editOnlineCoupon();
    // }
    // if ($_POST['action'] == "deleteOnlineCoupon") {
    //     deleteOnlineCoupon();
    // }
    // if ($_POST['action'] == "editOnTableCoupon") {
    //     editOnTableCoupon();
    // }
    if ($_POST['action'] == "deleteOnTableCoupon") {
        deleteOnTableCoupon();
    }
    if ($_POST['action'] == "checkDiscountCode") {
        checkDiscountCode();
    }
    if($_POST['action'] == "checkOpenHourRestaurant")
    {
        checkOpenHourRestaurant();
    }
    if($_POST['action'] == "checkOpenHourBooking")
    {
        checkOpenHourBooking();
    }
    if($_POST['action'] == "addGroupImageName")
    {
        addGroupImageName();
    }

    if($_POST['action'] == "editGroupImageName")
    {
        editGroupImageName();
    }


    if($_POST['action'] == "deleteGroupImage")
    {
        deleteGroupImage();
    }

    if($_POST['action'] == "getSliderBanner")
    {
        getSliderBanner();
    }

    if($_POST['action'] == "getSliderFooterImage")
    {
        getSliderFooterImage();
    }
    
    
    if($_POST['action'] == "getGroupImageById")
    {
        getGroupImageById();
    }

    if($_POST['action'] == "deleteGroupImageById")
    {
        deleteGroupImageById();
    }

    if($_POST['action'] == "changeGroupImageActive")
    {
        changeGroupImageActive();
    }
    if($_POST['action'] == "changeOnOffOpenBanner")
    {
        changeOnOffOpenBanner();
    }

    if($_POST['action'] == "changeOnOffFooterImage")
    {
        changeOnOffFooterImage();
    }

    

    if($_POST['action'] == "changeTimerImage")
    {
        changeTimerImage();
    }
    
    die(0);
}

function CustomerForgotPassword()
{
    global $config, $lang;
    $result['success'] = false;
    $result['message'] = $lang['ERROR_TRY_AGAIN'];
    // Lookup the email address
    $email_info1 = check_customer_account_exists($_POST['email']);

    // Check if the email address exists
    if ($email_info1 != 0) {

        $email_userid = get_customer_id_by_email($_POST['email']);
        $password = mt_rand(1000, 9999);
        $pass_hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 13]);
        // $now = date("Y-m-d H:i:s");
        $update_customer = ORM::for_table($config['db']['pre'] . 'customers')->find_one($email_userid);
        $update_customer->password_hash = $pass_hash;
        $update_customer->save();
        // Send the email
        send_customer_forgot_email($_POST['email'], $email_userid, $password);
        $result['success'] = true;
        $result['message'] = '';
    } else {
        $result['success'] = false;
        $result['message'] = $lang['EMAILNOTEXIST'];
    }
    die(json_encode($result));
}

function checkOpenHourBooking()
{
    global $config, $lang;
    $result['success'] = false;
    $result['message'] = $lang['ERROR_TRY_AGAIN'];
    $bCheck1 = false;
    $bCheck2 = false;
    if(isset($_POST['restaurant_id']))
    {
    $restaurant_id =  $_POST['restaurant_id'];
    $datetime_from = $_POST['datetime_from'];
    $datetime_to = $_POST['datetime_to'];
    $day = date('w', strtotime($datetime_from));
 
    $days = array('sunday', 'monday', 'tuesday', 'wednesday','thursday','friday', 'saturday');
    $dayofweek = $days[$day];
    $open_hour_of_week = ORM::for_table($config['db']['pre'] . 'open_close_hour')
    ->where(array('restaurant_id'=> $restaurant_id,'day_of_week' => $dayofweek))
    ->find_one();
    if(!empty($open_hour_of_week['id']))
    {
        $result['message'] = $lang['OUR_RESTAURANT_IS_NOT_OPEN'];
        $date = date('Y-m-d', strtotime($datetime_from));
        $open_hour = $open_hour_of_week['open_hour'];
        $close_hour =  $open_hour_of_week['close_hour'];
        $open_hour_2 =  $open_hour_of_week['open_hour_2'];
        $close_hour_2 =  $open_hour_of_week['close_hour_2'];
        $datetime_open_hour =  date("Y-m-d H:i",strtotime($date . ' ' . $open_hour));
        $datetime_close_hour = date("Y-m-d H:i",strtotime($date . ' ' . $close_hour));
        //check date from
        $datetime_from_check = date("Y-m-d H:i",strtotime($datetime_from));   
        if($datetime_from_check >= $datetime_open_hour && $datetime_from_check <= $datetime_close_hour)
        {
            $bCheck1 = true;
        }
        else
        {
            if(!empty($open_hour_2) && !empty($close_hour_2))
            {
                $datetime_open_hour_2 = date("Y-m-d H:i",strtotime($date . ' ' . $open_hour_2));
                $datetime_close_hour_2 = date("Y-m-d H:i",strtotime($date . ' ' . $close_hour_2));
                if($datetime_from_check >= $datetime_open_hour_2 && $datetime_from_check <= $datetime_close_hour_2)
                {
                    $bCheck1 = true;
                }
            }    
        }
        // check date to

        $datetime_to_check = date("Y-m-d H:i",strtotime($datetime_to));   
        if($datetime_to_check >= $datetime_open_hour && $datetime_to_check <= $datetime_close_hour)
        {
            $bCheck2 = true;
        }
        else
        {
            if(!empty($open_hour_2) && !empty($close_hour_2))
            {
                $datetime_open_hour_2 = date("Y-m-d H:i",strtotime($date . ' ' . $open_hour_2));
                $datetime_close_hour_2 = date("Y-m-d H:i",strtotime($date . ' ' . $close_hour_2));
                if($datetime_to_check >= $datetime_open_hour_2 && $datetime_to_check <= $datetime_close_hour_2)
                {
                    $bCheck2 = true;
                }
            }    
        }      
    }
    }
    if($bCheck1 == true && $bCheck2 == true)
    {
        $result['success'] = true;
        $result['message'] = '';
    }
    die(json_encode($result));
}

function checkOpenHourRestaurant()
{
    global $config, $lang;
    $result['success'] = false;
    $result['message'] = $lang['ERROR_TRY_AGAIN'];
    if(isset($_POST['restaurant_id']))
    {
    $restaurant_id =  $_POST['restaurant_id'];
    $datetime = $_POST['datetime'];
    $day = date('w', strtotime($datetime));
 
    $days = array('sunday', 'monday', 'tuesday', 'wednesday','thursday','friday', 'saturday');
    $dayofweek = $days[$day];
    $open_hour_of_week = ORM::for_table($config['db']['pre'] . 'open_close_hour')
    ->where(array('restaurant_id'=> $restaurant_id,'day_of_week' => $dayofweek))
    ->find_one();
    if(!empty($open_hour_of_week['id']))
    {
        $result['message'] = $lang['OUR_RESTAURANT_IS_NOT_OPEN'];
        $date = date('Y-m-d', strtotime($datetime));
        $open_hour = $open_hour_of_week['open_hour'];
        $close_hour =  $open_hour_of_week['close_hour'];
        $open_hour_2 =  $open_hour_of_week['open_hour_2'];
        $close_hour_2 =  $open_hour_of_week['close_hour_2'];
        
        $datetime_check = date("Y-m-d H:i",strtotime($datetime));
        $datetime_open_hour =  date("Y-m-d H:i",strtotime($date . ' ' . $open_hour));
        $datetime_close_hour = date("Y-m-d H:i",strtotime($date . ' ' . $close_hour));
        if($datetime_check >= $datetime_open_hour && $datetime_check <= $datetime_close_hour)
        {
            $result['success'] = true;
            $result['message'] = '';
        }
        else
        {
            if(!empty($open_hour_2) && !empty($close_hour_2))
            {
                $datetime_open_hour_2 = date("Y-m-d H:i",strtotime($date . ' ' . $open_hour_2));
                $datetime_close_hour_2 = date("Y-m-d H:i",strtotime($date . ' ' . $close_hour_2));
                if($datetime_check >= $datetime_open_hour_2 && $datetime_check <= $datetime_close_hour_2)
                {
                    $result['success'] = true;
                    $result['message'] = '';
                }
            }    
        }
           
    }
    }
    die(json_encode($result));
}
function emptyTable()
{
    global $lang, $config;
    $result['success'] = false;
    $result['message'] = $lang['ERROR_TRY_AGAIN'];
    if (!checkloggedin()) {
        die(json_encode($result));
    }
    $id = $_POST['id'];
    if (trim($id) != '') {
        $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
            ->where('user_id', $_SESSION['user']['id'])
            ->find_one();
        $update_table = ORM::for_table($config['db']['pre'] . 'table')
            ->use_id_column('id')
            ->where(array(
                'id' => $id
            ))
            ->find_one();
        $update_table->set('status', 'empty');
        $update_table->set('updated_at', date("Y-m-d H:i:s"));
        $update_table->set('is_processing', '0');
        $update_table->set('customer_id', NULL);
        $update_table->save();
        ORM::for_table($config['db']['pre'] . 'order_temp')
            ->where(array(
                'restaurant_id' => $restaurant['id'],
                'table' => $update_table['table_number']
            ))
            ->delete_many();
        ORM::for_table($config['db']['pre'] . 'order_temp_extras')
            ->where(array(
                'restaurant_id' => $restaurant['id'],
                'table_number' => $update_table['table_number']
            ))
            ->delete_many();



        if ($update_table) {
            $result['success'] = true;
            $result['message'] = $lang['SUCCESS_DELETE'];
        }
    }
    die(json_encode($result));
}
function ResetStatusOnTable()
{
    global $lang, $config;
    $result['success'] = false;
    $result['message'] = $lang['ERROR_TRY_AGAIN'];
    $restaurant_id = $_POST['restaurant'];
    if (trim($restaurant_id) != '') {
        if (empty($_POST['table'])) {
            die(json_encode($result));
        }
        ORM::for_table($config['db']['pre'] . 'order_temp')
            ->where(array(
                'restaurant_id' => $restaurant_id,
                'table' => $_POST['table']

            ))
            ->delete_many();
        ORM::for_table($config['db']['pre'] . 'order_temp_extras')
            ->where(array(
                'restaurant_id' => $restaurant_id,
                'table_number' => $_POST['table']
            ))
            ->delete_many();
        $update_table = ORM::for_table($config['db']['pre'] . 'table')
            ->use_id_column('id')
            ->where(array(
                'restaurant_id' => $restaurant_id,
                'table_number' => $_POST['table']
            ))
            ->find_many();
        $update_table->set('status', 'empty');
        $update_table->set('is_processing', '0');
        $update_table->set('updated_at', date("Y-m-d H:i:s"));
        $update_table->set('customer_id', NULL);
        $update_table->save();
        $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
            ->where('id', $restaurant_id)
            ->find_one();
        $userdata = get_user_data(null, $restaurant['user_id']);
        $msg = ['action' => 'table_remove', 'table_name' => $_POST['table']];
        FirebaseNotification($userdata['firebase_token'], $lang, 'table_remove', $msg);
        if ($update_table) {
            $result['success'] = true;
            $result['message'] = $lang['SUCCESS_DELETE'];
        }
    }
    die(json_encode($result));
}
function ResetStatusTable()
{
    global $lang, $config;
    $result['success'] = false;
    $result['message'] = $lang['ERROR_TRY_AGAIN'];
    if (!checkloggedin()) {
        die(json_encode($result));
    }
    $restaurant_id = $_POST['restaurant_id'];
    if (trim($restaurant_id) != '') {
        ORM::for_table($config['db']['pre'] . 'order_temp')
            ->where(array(
                'restaurant_id' => $restaurant_id
            ))
            ->delete_many();
        ORM::for_table($config['db']['pre'] . 'order_temp_extras')
            ->where(array(
                'restaurant_id' => $restaurant_id
            ))
            ->delete_many();
        $update_table = ORM::for_table($config['db']['pre'] . 'table')
            ->use_id_column('id')
            ->where(array(
                'restaurant_id' => $restaurant_id
            ))
            ->find_many();
        $update_table->set('status', 'empty');
        $update_table->set('is_processing', '0');
        $update_table->set('updated_at', date("Y-m-d H:i:s"));
        $update_table->set('customer_id', NULL);
        $update_table->save();
        $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
            ->where('user_id', $_SESSION['user']['id'])
            ->find_one();
        $userdata = get_user_data(null, $restaurant['user_id']);
        $msg = ['action' => 'table_remove', 'table_name' => $_POST['table']];
        FirebaseNotification($userdata['firebase_token'], $lang, 'table_remove', $msg);
        if ($update_table) {
            $result['success'] = true;
            $result['message'] = $lang['SUCCESS_DELETE'];
        }
    }
    die(json_encode($result));
}

function deleteCancellationReason()
{
    global $lang, $config;

    $result['success'] = false;
    $result['message'] = $lang['ERROR_TRY_AGAIN'];
    if (!checkloggedin()) {
        die(json_encode($result));
    }
    $id = $_POST['id'];
    if (trim($id) != '') {
        $reason = ORM::for_table($config['db']['pre'] . 'cancellation_reason')->find_one($id);

        if (!empty($reason['id'])) {

            $data = ORM::for_table($config['db']['pre'] . 'cancellation_reason')
                ->where(array(
                    'id' => $id
                ))
                ->delete_many();
            if ($data) {
                $result['success'] = true;
                $result['message'] = $lang['SUCCESS_DELETE'];
            }
        }
    }
    die(json_encode($result));
}
function deleteTable()
{
    global $lang, $config;

    $result['success'] = false;
    $result['message'] = $lang['ERROR_TRY_AGAIN'];
    if (!checkloggedin()) {
        die(json_encode($result));
    }
    $id = $_POST['id'];
    if (trim($id) != '') {
        $shipping = ORM::for_table($config['db']['pre'] . 'table')->find_one($id);

        if (!empty($shipping['id'])) {

            $data = ORM::for_table($config['db']['pre'] . 'table')
                ->where(array(
                    'id' => $id
                ))
                ->delete_many();

            if ($data) {
                $result['success'] = true;
                $result['message'] = $lang['SUCCESS_DELETE'];
            }
        }
    }
    die(json_encode($result));
}
function deleteShippingGoogleMap()
{
    global $lang, $config;

    $result['success'] = false;
    $result['message'] = $lang['ERROR_TRY_AGAIN'];
    if (!checkloggedin()) {
        die(json_encode($result));
    }
    $id = $_POST['id'];
    if (trim($id) != '') {
        $shipping = ORM::for_table($config['db']['pre'] . 'shipping_fee_google')->find_one($id);

        if (!empty($shipping['id'])) {

            $data = ORM::for_table($config['db']['pre'] . 'shipping_fee_google')
                ->where(array(
                    'id' => $id
                ))
                ->delete_many();

            if ($data) {
                $result['success'] = true;
                $result['message'] = $lang['SUCCESS_DELETE'];
            }
        }
    }
    die(json_encode($result));
}
function deleteShipping()
{
    global $lang, $config;

    $result['success'] = false;
    $result['message'] = $lang['ERROR_TRY_AGAIN'];
    if (!checkloggedin()) {
        die(json_encode($result));
    }
    $id = $_POST['id'];
    if (trim($id) != '') {
        $shipping = ORM::for_table($config['db']['pre'] . 'shipping_fee')->find_one($id);

        if (!empty($shipping['id'])) {

            $data = ORM::for_table($config['db']['pre'] . 'shipping_fee')
                ->where(array(
                    'id' => $id
                ))
                ->delete_many();

            if ($data) {
                $result['success'] = true;
                $result['message'] = $lang['SUCCESS_DELETE'];
            }
        }
    }
    die(json_encode($result));
}


function resetOrderReserve()
{
    global  $config, $lang;
    $result['success'] = false;
    $result['message'] = $lang['ERROR_TRY_AGAIN'];
    if (!checkloggedin()) {
        die(json_encode($result));
    }
    $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
        ->where('user_id', $_SESSION['user']['id'])
        ->find_one();
    $restaurant_id = $restaurant->id;
    $Orders = ORM::for_table($config['db']['pre'] . 'reserve')
        ->where('restaurant_id', $restaurant_id)
        ->find_many();
    foreach ($Orders as $Order) {
        //delete customer info
        ORM::for_table($config['db']['pre'] . 'reserve_customer_info')
            ->where('reserve_id', $Order->id)
            ->delete_many();
        //delete items extra
        $Items = ORM::for_table($config['db']['pre'] . 'reserve_items')
            ->where('reserve_id', $Order->id)
            ->find_many();
        foreach ($Items as $Item) {
            ORM::for_table($config['db']['pre'] . 'reserve_item_extras')
                ->where('reserve_item_id', $Item->id)
                ->delete_many();
        }
        //delete items
        ORM::for_table($config['db']['pre'] . 'reserve_items')
            ->where('reserve_id', $Order->id)
            ->delete_many();
    }
    //delete Order 
    ORM::for_table($config['db']['pre'] . 'reserve')
        ->where('restaurant_id', $restaurant_id)
        ->delete_many();
    $result['success'] = true;
    $result['message'] = $lang['DELETE_SUCCESS'];

    $userdata = get_user_data(null, $restaurant['user_id']);
    /* send notification to firebase */
    $msg = ['action' => 'reset_all_reserve'];
    FirebaseNotification($userdata['firebase_token'], $lang, 'reset_all_reserve', $msg);

    die(json_encode($result));
}

function resetOrderOnTable()
{
    global  $config, $lang;
    $result['success'] = false;
    $result['message'] = $lang['ERROR_TRY_AGAIN'];
    if (!checkloggedin()) {
        die(json_encode($result));
    }
    $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
        ->where('user_id', $_SESSION['user']['id'])
        ->find_one();
    $restaurant_id = $restaurant->id;
    if (!empty($restaurant_id)) {
        $Orders = ORM::for_table($config['db']['pre'] . 'orders')
            ->where(array('restaurant_id' => $restaurant_id, 'type' => 'on-table'))
            ->find_many();
        foreach ($Orders as $Order) {
            //delete customer info
            ORM::for_table($config['db']['pre'] . 'order_customer_info')
                ->where('order_id', $Order->id)
                ->delete_many();
            //delete items extra
            $Items = ORM::for_table($config['db']['pre'] . 'order_items')
                ->where('order_id', $Order->id)
                ->find_many();
            foreach ($Items as $Item) {
                ORM::for_table($config['db']['pre'] . 'order_item_extras')
                    ->where('order_item_id', $Item->id)
                    ->delete_many();
            }
            //delete items
            ORM::for_table($config['db']['pre'] . 'order_items')
                ->where('order_id', $Order->id)
                ->delete_many();
        }
        //delete Order temp
        ORM::for_table($config['db']['pre'] . 'order_temp')
            ->where(array('restaurant_id' => $restaurant_id))
            ->delete_many();
        ORM::for_table($config['db']['pre'] . 'order_temp_extras')
            ->where(array('restaurant_id' => $restaurant_id))
            ->delete_many();
        $update_table = ORM::for_table($config['db']['pre'] . 'table')
            ->use_id_column('id')
            ->where(array(
                'restaurant_id' => $restaurant_id
            ))
            ->find_many();
        $update_table->set('status', 'empty');
        $update_table->set('is_processing', '0');
        $update_table->set('updated_at', date("Y-m-d H:i:s"));
        $update_table->set('customer_id', NULL);
        $update_table->save();

        //delete Order 
        ORM::for_table($config['db']['pre'] . 'orders')
            ->where(array('restaurant_id' => $restaurant_id, 'type' => 'on-table'))
            ->delete_many();
        $userdata = get_user_data(null, $restaurant['user_id']);
        /* send notification to firebase */
        $msg = ['action' => 'on_order_table_remove'];
        FirebaseNotification($userdata['firebase_token'], $lang, 'on_order_table_remove', $msg);

        
        $msg = ['action' => 'table_remove'];
         FirebaseNotification($userdata['firebase_token'], $lang, 'table_remove', $msg);
        $result['success'] = true;
        $result['message'] = $lang['DELETE_SUCCESS'];
    }
    die(json_encode($result));
}

function resetBooking()
{
    global  $config, $lang;
    $result['success'] = false;
    $result['message'] = $lang['ERROR_TRY_AGAIN'];
    if (!checkloggedin()) {
        die(json_encode($result));
    }

    $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
        ->where('user_id', $_SESSION['user']['id'])
        ->find_one();
    $restaurant_id = $restaurant->id;
    if (!empty($restaurant_id)) {
        //delete Bookings
        ORM::for_table($config['db']['pre'] . 'booking_table')
            ->where('restaurant_id', $restaurant_id)
            ->delete_many();
        $userdata = get_user_data(null, $restaurant['user_id']);
        /* send notification to firebase */
        $msg = ['action' => 'booking_remove'];
        FirebaseNotification($userdata['firebase_token'], $lang, 'booking_remove', $msg);
        $result['success'] = true;
        $result['message'] = $lang['DELETE_SUCCESS'];
    }
    die(json_encode($result));
}
function resetOrderDeliveryTakeaway()
{
    global  $config, $lang;
    $result['success'] = false;
    $result['message'] = $lang['ERROR_TRY_AGAIN'];
    if (!checkloggedin()) {
        die(json_encode($result));
    }

    $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
        ->where('user_id', $_SESSION['user']['id'])
        ->find_one();
    $restaurant_id = $restaurant->id;
    if (!empty($restaurant_id)) {
        $Orders = ORM::for_table($config['db']['pre'] . 'orders')
            ->where('restaurant_id', $restaurant_id)
            ->where_in('type', array('takeaway', 'delivery'))
            ->find_many();
        foreach ($Orders as $Order) {
            //delete customer info
            ORM::for_table($config['db']['pre'] . 'order_customer_info')
                ->where('order_id', $Order->id)
                ->delete_many();
            //delete items extra
            $Items = ORM::for_table($config['db']['pre'] . 'order_items')
                ->where('order_id', $Order->id)
                ->find_many();
            foreach ($Items as $Item) {
                ORM::for_table($config['db']['pre'] . 'order_item_extras')
                    ->where('order_item_id', $Item->id)
                    ->delete_many();
            }
            //delete items
            ORM::for_table($config['db']['pre'] . 'order_items')
                ->where('order_id', $Order->id)
                ->delete_many();
        }
        //delete Order 
        ORM::for_table($config['db']['pre'] . 'orders')
            ->where('restaurant_id', $restaurant_id)
            ->where_in('type', array('takeaway', 'delivery'))
            ->delete_many();
        $userdata = get_user_data(null, $restaurant['user_id']);
        /* send notification to firebase */
        $msg = ['action' => 'delivery_takeaway_order_remove'];
        FirebaseNotification($userdata['firebase_token'], $lang, 'delivery_takeaway_order_remove', $msg);
        $result['success'] = true;
        $result['message'] = $lang['DELETE_SUCCESS'];
    }
    die(json_encode($result));
}

function getShippingFee()
{
    global $lang, $config;
    $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
        ->where('id', $_POST['restaurant'])
        ->find_one();
    $restaurant_id = $restaurant->id;
    // $settings = get_all_setting($restaurant->user_id);
    $restaurant_shipping_fee = get_restaurant_option($restaurant_id, 'restaurant_shipping_fee');  // $settings['restaurant_shipping_fee'];
    $currency =  get_option('currency_code');

    if ($restaurant_shipping_fee == "plz") {

        if (empty($_POST['zip_code'])) {
            $result['success'] = false;
            $result['message'] = $lang['ZIPCODE_REQ'];
            die(json_encode($result));
        }
        $shipping_fee = ORM::for_table($config['db']['pre'] . 'shipping_fee')
            ->where_like('route', '%' . $_POST['route'] . '%')
            ->where(array(
                'restaurant_id' => $restaurant->id,
                'zip_code' => $_POST['zip_code']
            ))
            ->find_one();
        if (!empty($shipping_fee)) {
            $result['success'] = true;
            $result['message'] = $shipping_fee->price;
            die(json_encode($result));
        } else {
            // không có tên đường trong hệ thống
            $shipping_fee = ORM::for_table($config['db']['pre'] . 'shipping_fee')
                ->where(array(
                    'restaurant_id' => $restaurant->id,
                    'zip_code' => $_POST['zip_code']
                ))
                ->find_one();
            if (!empty($shipping_fee)) {
                $result['success'] = true;
                $result['message'] = $shipping_fee->price;
                die(json_encode($result));
            } else {
                $result['success'] = false;
                $result['message'] = $lang['ZIPCODE_NOT_FOUND']; //not found
                die(json_encode($result));
            }
        }
    } else {
        if (empty($_POST['address'])) {
            $result['success'] = false;
            $result['message'] = $lang['ADDRESS_REQUIRED'];
            die(json_encode($result));
        }
        $km = getKmFromGMap($_POST['address'], $restaurant_id);
        $km = round($km);
        $shipping_fee = ORM::for_table($config['db']['pre'] . 'shipping_fee_google')
            ->where('restaurant_id', $restaurant_id)
            ->where_lte('km_from', $km)
            ->where_gte('km_to', $km)
            ->find_one();
        // không tìm thấy phí giao hàng
        if (empty($shipping_fee)) {
            $shipping_fee = ORM::for_table($config['db']['pre'] . 'shipping_fee_google')
                ->where('restaurant_id', $restaurant_id)
                ->where_gte('km_to', $km)
                ->find_one();

            if (!empty($shipping_fee)) {
                if ($shipping_fee->delivery == 1) {
                    $result['success'] = true;
                    $result['message'] = 0;
                    die(json_encode($result));
                } else {
                    $result['success'] = false;
                    $result['message'] = $lang['NOT_DELIVER']; //We do not deliver to this address
                    die(json_encode($result));
                }
            } else {
                $result['success'] = false;
                $result['message'] = $lang['NOT_DELIVER']; //We do not deliver to this address
                die(json_encode($result));
            }
        } else {
            if (!empty($shipping_fee)) {
                if ($shipping_fee->delivery == 1) {
                    $result['success'] = true;
                    $result['message'] = $shipping_fee->price;
                    die(json_encode($result));
                } else {
                    $result['success'] = false;
                    $result['message'] = $lang['NOT_DELIVER']; //We do not deliver to this address
                    die(json_encode($result));
                }
            } else {
                $result['success'] = false;
                $result['message'] = $lang['NOT_DELIVER']; //We do not deliver to this address
                die(json_encode($result));
            }
        }
    }
}
function getKmFromGMap($address, $restaurant_id)
{
    $APIKey = get_option("gmap_api_key");
    $restaurant_address = get_restaurant_option($restaurant_id, 'restaurant_address_delivery');
    $restaurant_address = preg_replace('/\s+/', '+', $restaurant_address);
    $queryAddressEnd = "&key=" . $APIKey;
    $address_customer = preg_replace('/\s+/', '+', $address);
    $queryAddress = "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=" . $address_customer;
    $queryAddressRestaurant = "&destinations=" . $restaurant_address;
    $url = $queryAddress . $queryAddressRestaurant . $queryAddressEnd;
    $data = get_content($url);
    $data = json_decode($data);
    $time = 0;
    $distance = 0;
    foreach ($data->rows[0]->elements as $road) {
        $time += $road->duration->value;
        $distance += $road->distance->value;
    }
    $km = $distance / 1000;
    return $km;
}
function EditShippingFeeGMap()
{
    global $lang, $config;

    // if (empty($_POST["price"])) {
    //     $price_error = $lang['PRICE_REQ'];
    //     $result['success'] = false;
    //     $result['message'] = $price_error;
    //     die(json_encode($result));
    // }
    $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
        ->where('user_id', $_SESSION['user']['id'])
        ->find_one();
    update_restaurant_option($restaurant->id, 'restaurant_price_per_km', $_POST["price"]);
    update_restaurant_option($restaurant->id, 'restaurant_address_delivery', $_POST["address"]);
    $result['success'] = true;
    $result['message'] = $lang['SAVED_SUCCESS'];
    die(json_encode($result));
}
function update_customer_password()
{
    global $lang, $config;
    $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
        ->where('slug', $_POST['slug'])
        ->find_one();
    $loggedin = customerslogin($_POST['email'], $_POST['old_password'],$restaurant['id']);
    if ($loggedin == false) {
        $password_error = $lang['PASSWORD_INCORRECT'];
        $result['success'] = false;
        $result['message'] = $password_error;
        die(json_encode($result));
    }
    if (empty($_POST["new_password"])) {
        $password_error = $lang['ENTERPASS'];
        $result['success'] = false;
        $result['message'] = $password_error;
        die(json_encode($result));
    } elseif ((strlen($_POST['new_password']) < 4) or (strlen($_POST['new_password']) > 21)) {
        $password_error = $lang['PASSLENG'];
        $result['success'] = false;
        $result['message'] = $password_error;
        die(json_encode($result));
    }
    $password = $_POST["new_password"];
    $pass_hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 13]);
    if (!empty($_POST['id'])) {
        $update_customer = ORM::for_table($config['db']['pre'] . 'customers')->find_one($_POST['id']);
    }
    $update_customer->password_hash = $pass_hash;
    $update_customer->save();
    $customer_id = $update_customer->id();
    if ($customer_id) {
        $loggedin = customerslogin($_POST['email'], $password, $restaurant['id']);
        create_customers_session($loggedin, $_POST['slug']);
        $result['success'] = true;
        $result['message'] = $lang['CHANGE_PASSWORD_SUCCESS'];
    } else {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
    }
    die(json_encode($result));
}
function customers_login()
{
    global  $lang,$config;
    $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
    ->where('slug', $_POST['slug'])
    ->find_one();
    $loggedin = customerslogin($_POST['username'], $_POST['password'],$restaurant['id']);
    if ($loggedin) {
        create_customers_session($loggedin, $_POST['slug']);
        $result['success'] = true;
        $result['message'] = $lang['LOGGEDIN_SUCCESS'];
        die(json_encode($result));
    } else {
        $result['success'] = false;
        $result['message'] = $lang['USERNOTFOUND'];
        die(json_encode($result));
    }
}
function update_customer_address()
{
    global $config, $lang;
    if (empty($_POST['id'])) {
        $result['success'] = false;
        $result['message'] = $lang['ID_REQ'];
        die(json_encode($result));
    }

    if (empty($_POST['zip_code'])) {
        $result['success'] = false;
        $result['message'] = $lang['ZIPCODE_REQ'];
        die(json_encode($result));
    }
    // if (empty($_POST['city'])) {
    //     $result['success'] = false;
    //     $result['message'] = $lang['CITY_REQ'];
    //     die(json_encode($result));
    // }
    if (empty($_POST['address'])) {
        $result['success'] = false;
        $result['message'] = $lang['ADDRESS_REQ'];
        die(json_encode($result));
    }

    if (empty($_POST['email'])) {
        $result['success'] = false;
        $result['message'] = $lang['EMAIL_REQ'];
        die(json_encode($result));
    }

    if (empty($_POST['phone_number'])) {
        $result['success'] = false;
        $result['message'] = $lang['EMAIL_REQ'];
        die(json_encode($result));
    }
    if (empty($_POST['name'])) {
        $result['success'] = false;
        $result['message'] = $lang['NAME_REQ'];
        die(json_encode($result));
    }

    if(!ctype_alnum($_POST['name']))
    {
        $result['success'] = false;
        $result['message'] = $lang['NAMEALPHA'] ." [A-Z,a-z,0-9]";
        die(json_encode($result));
    }

    $customer_name = validate_input($_POST['name']);;
    $customer_phone_number = validate_input($_POST['phone_number']);
    $customer_email = validate_input($_POST['email']);
    $customer_address = validate_input($_POST['address']);
    $customer_house_number = validate_input($_POST['house_number']);
    $customer_street_name = validate_input($_POST['street_name']);
    $customer_city = validate_input($_POST['city']);
    $customer_zip_code = validate_input($_POST['zip_code']);
    if (!empty($_POST['id'])) {
        $update_address = ORM::for_table($config['db']['pre'] . 'customers')->find_one($_POST['id']);
    }

    $update_address->name = $customer_name;
    $update_address->phone = $customer_phone_number;
    $update_address->email = $customer_email;
    $update_address->address = $customer_address;
    $update_address->house_number = $customer_house_number;
    $update_address->street_name = $customer_street_name;
    $update_address->city = $customer_city;
    $update_address->zip_code = $customer_zip_code;

    $update_address->save();
    $address_id = $update_address->id();
    if ($address_id) {
        $result['success'] = true;
        $result['message'] = $lang['SAVED_SUCCESS'];
        $_SESSION['customer']['name'] = $customer_name;
        $_SESSION['customer']['phone'] = $customer_phone_number;
        $_SESSION['customer']['email'] = $customer_email;
        $_SESSION['customer']['address'] = $customer_address;
        $_SESSION['customer']['house_number'] = $customer_house_number;
        $_SESSION['customer']['street_name'] = $customer_street_name;
        $_SESSION['customer']['city'] = $customer_city;
        $_SESSION['customer']['zip_code'] = $customer_zip_code;
    } else {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
    }
    die(json_encode($result));
}
function save_open_time()
{
    global $lang, $config;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }

    $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
        ->where('user_id', $_SESSION['user']['id'])
        ->find_one();

    $soption_name =  "OpenTime_" . $_POST['option_name'];
    $open_close = $_POST['restaurant_open_or_close'];
    $open_time = validate_input($_POST['open_time']);
    $close_time = validate_input($_POST['close_time']);
    if (strcmp($open_close, "close") == 0) {
        update_restaurant_option($restaurant['id'], $soption_name, 'close');
    } else {
        $sOption_value = $open_time . "-" . $close_time;
        update_restaurant_option($restaurant['id'], $soption_name, $sOption_value);


        $result['success'] = true;
        $result['message'] = $lang['SAVED_SUCCESS'];

        //die(json_encode($result));

    }
}

function add_pdf_menu()
{
    global $config, $lang;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }
    $MainFileName = null;
    // Valid formats
    $valid_formats = array("pdf");
    /*Start pdf Uploading*/
    $file = $_FILES['pdf_upload'];
    $filename = $file['name'];
    $ext = getExtension($filename);
    $ext = strtolower($ext);
    if (!empty($filename)) {
        //File extension check
        if (in_array($ext, $valid_formats)) {
            $main_path = ROOTPATH . "/storage/menu-pdf/";
            $filename = uniqid(time()) . '.' . $ext;
            if (move_uploaded_file($file['tmp_name'], $main_path . $filename)) {
                $MainFileName = $filename;
            } else {
                $result['success'] = false;
                $result['message'] = $lang['ERROR_PDF'];
                die(json_encode($result));
            }
        } else {
            $result['success'] = false;
            $result['message'] = $lang['ONLY_PDF_ALLOW'];
            die(json_encode($result));
        }
    }
    /*End pdf Uploading*/


    if (!empty($_POST['id'])) {
        $insert_menu = ORM::for_table($config['db']['pre'] . 'pdf_menu')->find_one($_POST['id']);
        $insert_menu->user_id = $_SESSION['user']['id'];
    } else {
        $insert_menu = ORM::for_table($config['db']['pre'] . 'pdf_menu')->create();
        $insert_menu->user_id = $_SESSION['user']['id'];
    }
    if ($MainFileName) {
        $insert_menu->name = $MainFileName;
    }
    $insert_menu->save();

    $menu_id = $insert_menu->id();
    if ($menu_id) {
        $result['success'] = true;
        $result['message'] = $lang['SAVED_SUCCESS'];
    } else {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
    }
    die(json_encode($result));
}


function EditGroupImageById()
{
    global $config, $lang;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }
    $shop_id = getShopId();
    // Valid formats
    $valid_formats = array("jpeg", "jpg", "png");

    /*Start Item Logo Image Uploading*/
    $file = $_FILES['image'];

    $filename = $file['name'];

    $ext = getExtension($filename);
    $ext = strtolower($ext);
    if (!empty($filename)) {
        //File extension check
        if (in_array($ext, $valid_formats)) {
            $main_path = ROOTPATH . "/storage/shop/group/";
            $filename = uniqid(time()) . '.' . $ext;
            if (move_uploaded_file($file['tmp_name'], $main_path . $filename)) {
                $MainFileName = $filename;
                resizeImage(150, $main_path . 'small_' . $filename, $main_path . $filename);
                resizeImage(800, $main_path . 'big_' . $filename, $main_path . $filename);

                $update_image = ORM::for_table($config['db']['pre'] . 'shop_image')
                ->where('id',$_GET['id'])
                ->find_one();
                $update_image->image = $MainFileName;
                $update_image->save();

                $data = '';
                $images = ORM::for_table($config['db']['pre'] . 'shop_image')
                          ->where(array('shop_id' => $shop_id, 'group_id' => $update_image['group_id']))
                          ->find_many(); 
                          foreach ($images as $image) {
                            $data .= '<li><div data-group-id="'. $update_image['group_id'] .'" data-id="'. $image['id'] .'" class="input-file-slide"><img src="'. $config['site_url'] .'/storage/shop/group/'. $image['image'] .'" id="group_image_'.$image['id'].'"><span class="delete_group_image delete_image">&times;</span> <div class="uploadButton uploadButton-slider"><input class="uploadButton-input" type="file" accept="image/*" onchange="EditGroupImage('. $update_image['group_id'] .',&apos;group_image_'. $image['id'] .'&apos;)" id="group_image_upload_'. $image['id'] .'" name="group_image"/> <label class="uploadButton-slider-button ripple-effect" for="group_image_upload_'. $image['id'] .'">Upload</label></div></div></li>';
                          }
                $result['success'] = true;
                $result['data'] = $data;
                $result['message'] = $lang['EDIT_IMAGE_SUCCESS'];
                die(json_encode($result));

            } else {
                $result['success'] = false;
                $result['message'] = $lang['ERROR_IMAGE'];
                die(json_encode($result));
            }
        } else {
            $result['success'] = false;
            $result['message'] = $lang['ONLY_JPG_ALLOW'];
            die(json_encode($result));
        }
    }
    /*End Item Logo Image Uploading*/
}


function EditFooterImage()
{
    global $config, $lang;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }
    $shop_id = getShopId();
    // Valid formats
    $valid_formats = array("jpeg", "jpg", "png");

    /*Start Item Logo Image Uploading*/
    $file = $_FILES['image'];
    $filename = $file['name'];
    $ext = getExtension($filename);
    $ext = strtolower($ext);
    if (!empty($filename)) {
        //File extension check
        if (in_array($ext, $valid_formats)) {
            $main_path = ROOTPATH . "/storage/shop/footer/";
            $filename = uniqid(time()) . '.' . $ext;
            if (move_uploaded_file($file['tmp_name'], $main_path . $filename)) {
                $MainFileName = $filename;
                resizeImage(1200, $main_path . 'big_' . $filename, $main_path . $filename);
                $insert_image = ORM::for_table($config['db']['pre'] . 'shop_image')->where('id',$_GET['id'])->find_one();
                $insert_image->image = $MainFileName;
                $insert_image->save();    
                $data = '';
                $images = ORM::for_table($config['db']['pre'] . 'shop_image')
                          ->where(array('shop_id' => $shop_id, 'image_type' => 'footer_image'))
                          ->find_many(); 
                          foreach ($images as $image) {
                            $data .= '<li><div data-id="'. $image['id'] .'" class="input-file-slide"><img src="'. $config['site_url'] .'/storage/shop/footer/'. $image['image'] .'" id="shop_footer_image_'.$image['id'].'"><span class="delete_footer_image delete_image">&times;</span> <div class="uploadButton uploadButton-slider"><input class="uploadButton-input" type="file" accept="image/*" onchange="EditFooterImage(this,&apos;shop_footer_image_'. $image['id'] .'&apos;,&apos;footer_image&apos;)" id="footer_image_upload_'. $image['id'] .'" name="shop_footer_image"/> <label class="uploadButton-slider-button ripple-effect" for="footer_image_upload_'. $image['id'] .'">Upload</label></div></div></li>';
                          }
                $result['success'] = true;
                $result['data'] = $data;
                $result['message'] = $lang['EDIT_IMAGE_SUCCESS'];
                die(json_encode($result));
            } else {
                $result['success'] = false;
                $result['message'] = $lang['ERROR_IMAGE'];
                die(json_encode($result));
            }
        } else {
            $result['success'] = false;
            $result['message'] = $lang['ONLY_JPG_ALLOW'];
            die(json_encode($result));
        }
    }
}


function EditSlideImage()
{
    global $config, $lang;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }
    $shop_id = getShopId();
    // Valid formats
    $valid_formats = array("jpeg", "jpg", "png");

    /*Start Item Logo Image Uploading*/
    $file = $_FILES['image'];

    $filename = $file['name'];



    $ext = getExtension($filename);
    $ext = strtolower($ext);

  

    if (!empty($filename)) {


        //File extension check
        if (in_array($ext, $valid_formats)) {
            $main_path = ROOTPATH . "/storage/shop/cover/";
            $filename = uniqid(time()) . '.' . $ext;
            if (move_uploaded_file($file['tmp_name'], $main_path . $filename)) {
                $MainFileName = $filename;
                resizeImage(1200, $main_path . 'big_' . $filename, $main_path . $filename);
                $insert_image = ORM::for_table($config['db']['pre'] . 'shop_image')->where('id',$_GET['id'])->find_one();
                $insert_image->image = $MainFileName;
                $insert_image->save();    
                $data = '';
                $images = ORM::for_table($config['db']['pre'] . 'shop_image')
                          ->where(array('shop_id' => $shop_id, 'image_type' => $_GET['image_type']))
                          ->find_many(); 
                          foreach ($images as $image) {
                            //$data .= '<li><div data-id="'. $image['id'] .'" class="input-file-slide"><img src="'. $config['site_url'] .'/storage/shop/cover/'. $image['image'] .'" id="shop_cover_image_'.$image['id'].'"><span class="delete_cover_image">&times;</span> <div class="uploadButton uploadButton-slider"><input class="uploadButton-input" type="file" accept="image/*" onchange="readImageURLAndEdit(this,&apos;shop_cover_image_'. $image['id'] .'&apos;,&apos;banner&apos;)" id="cover_upload_'. $image['id'] .'" name="shop_cover_image"/> <label class="uploadButton-slider-button ripple-effect" for="cover_upload_'. $image['id'] .'">Upload</label></div></div></li>';
                            $data .= getBannerSliderItemContent($image, $config['site_url']);
                        }
                $result['success'] = true;
                $result['data'] = $data;
                $result['message'] = $lang['EDIT_IMAGE_SUCCESS'];
                die(json_encode($result));
            } else {
                $result['success'] = false;
                $result['message'] = $lang['ERROR_IMAGE'];
                die(json_encode($result));
            }
        } else {
            $result['success'] = false;
            $result['message'] = $lang['ONLY_JPG_ALLOW'];
            die(json_encode($result));
        }
    }
    /*End Item Logo Image Uploading*/
}


function addImageInGroup()
{
    global $config, $lang;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }
    $shop_id = getShopId();
    // Valid formats
    $valid_formats = array("jpeg", "jpg", "png");

    /*Start Item Logo Image Uploading*/
    $file = $_FILES['image'];

    $filename = $file['name'];

    $ext = getExtension($filename);
    $ext = strtolower($ext);
    if (!empty($filename)) {
        //File extension check
        if (in_array($ext, $valid_formats)) {
            $main_path = ROOTPATH . "/storage/shop/group/";
            $filename = uniqid(time()) . '.' . $ext;
            if (move_uploaded_file($file['tmp_name'], $main_path . $filename)) {
                $MainFileName = $filename;
                resizeImage(1200, $main_path . 'big_' . $filename, $main_path . $filename);
                $insert_image = ORM::for_table($config['db']['pre'] . 'shop_image')->create();
                $insert_image->image = $MainFileName;
                $insert_image->shop_id = $shop_id;
                $insert_image->group_id = $_GET['group_id'];
                $insert_image->save();           
                $data = '';
                $images = ORM::for_table($config['db']['pre'] . 'shop_image')
                          ->where(array('shop_id' => $shop_id, 'group_id' => $_GET['group_id']))
                          ->find_many();
                          foreach ($images as $image) {
                            $data .= '<li><div data-group-id="'. $_GET['group_id'] .'" data-id="'. $image['id'] .'" class="input-file-slide"><img src="'. $config['site_url'] .'/storage/shop/group/'. $image['image'] .'" id="group_image_'.$image['id'].'"><span class="delete_group_image delete_image">&times;</span> <div class="uploadButton uploadButton-slider"><input class="uploadButton-input" type="file" accept="image/*" onchange="EditGroupImage('. $_GET['group_id'] .',&apos;group_image_'. $image['id'] .'&apos;)" id="group_image_upload_'. $image['id'] .'" name="group_image"/> <label class="uploadButton-slider-button ripple-effect" for="group_image_upload_'. $image['id'] .'">Upload</label></div></div></li>';
                          }
                $result['success'] = true;
                $result['data'] = $data;
                $result['message'] = $lang['ADD_IMAGE_SUCCESS'];
                die(json_encode($result));
            } else {
                $result['success'] = false;
                $result['message'] = $lang['ERROR_IMAGE'];
                die(json_encode($result));
            }
        } else {
            $result['success'] = false;
            $result['message'] = $lang['ONLY_JPG_ALLOW'];
            die(json_encode($result));
        }
    }
    /*End Item Logo Image Uploading*/
}

function getGroupImageById()
{
   global $config, $lang;
   $result['success'] = false;
   $result['data'] = '';
   $result['message'] = $lang['ERROR_TRY_AGAIN'];
   if (!checkloggedin()) {
       die(json_encode($result));
   }
   $shop_id = getShopId();
   $data = '';
   if(isset($_POST['id']))
   {
    $images = ORM::for_table($config['db']['pre'] . 'shop_image')
    ->where(array('shop_id' => $shop_id, 'group_id' => $_POST['id']))
    ->find_many();
    foreach ($images as $image) {
      $data .= '<li><div data-group-id="'. $_POST['id'] .'" data-id="'. $image['id'] .'" class="input-file-slide"><img src="'. $config['site_url'] .'/storage/shop/group/'. $image['image'] .'" id="group_image_'.$image['id'].'"><span class="delete_group_image delete_image">&times;</span> <div class="uploadButton uploadButton-slider"><input class="uploadButton-input" type="file" accept="image/*" onchange="EditGroupImage('. $_POST['id'] .',&apos;group_image_'. $image['id'] .'&apos;)" id="group_image_upload_'. $image['id'] .'" /> <label class="uploadButton-slider-button ripple-effect" for="group_image_upload_'. $image['id'] .'">Upload</label></div></div></li>';
    }
   $result['success'] = true;
   $result['data'] = $data;
   $result['message'] = '';
   }
   die(json_encode($result));
}

 function getSliderBanner()
 {
    global $config, $lang;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }
    $shop_id = getShopId();
    $data = '';
    $images = ORM::for_table($config['db']['pre'] . 'shop_image')
              ->where(array('shop_id' => $shop_id, 'image_type' => 'banner'))
              ->find_many();
              foreach ($images as $image) {
                //$data .= '<li><div data-id="'. $image['id'] .'" class="input-file-slide"><img src="'. $config['site_url'] .'/storage/shop/cover/'. $image['image'] .'" id="shop_cover_image_'.$image['id'].'"><span class="delete_cover_image">&times;</span> <div class="uploadButton uploadButton-slider"><input class="uploadButton-input" type="file" accept="image/*" onchange="readImageURLAndEdit(this,&apos;shop_cover_image_'. $image['id'] .'&apos;,&apos;banner&apos;)" id="cover_upload_'. $image['id'] .'" name="shop_cover_image"/> <label class="uploadButton-slider-button ripple-effect" for="cover_upload_'. $image['id'] .'">Upload</label></div></div></li>';
                $data .= getBannerSliderItemContent($image, $config['site_url']);
            }
    $result['success'] = true;
    $result['data'] = $data;
    $result['message'] = '';
    die(json_encode($result));
 }
 function getBannerSliderItemContent($image, $site_url){
    $floating = $image['is_floating'];    
    $text = $floating ? 'Unset floating' : 'Set as floating';
    $s = '<li>
        <div data-id="' . $image['id'] . '" class="input-file-slide">
            <img src="' . $site_url . '/storage/shop/cover/' . $image['image'] . '" id="shop_cover_image_' . $image['id'] . '">';
//  $s .=  '<div class="set-floating-btn-wrap ' . ($floating?'hidden':'') . '"><a data-id="'.$image['id'].'" class="btn-set-floating-banner">Set as floating banner</a></div>';
    $s .=  '<div class="set-floating-btn-wrap"><a data-id="'.$image['id'].'" data-state="' . $floating . '" class="btn-set-floating-banner">' . ($text) . '</a></div>';
    
    $s .= '<span class="delete_cover_image">&times;</span>
            <div class="uploadButton uploadButton-slider">
                <input class="uploadButton-input" type="file" accept="image/*" onchange="readImageURLAndEdit(this,&apos;shop_cover_image_' . $image['id'] . '&apos; , &apos;banner&apos;)" id="cover_upload_' . $image['id'] . '" name="shop_cover_image"/>
                <label class="uploadButton-slider-button ripple-effect" for="cover_upload_' . $image['id'] . '">Upload</label>
            </div>            
        </div>        
    </li>';    
    return preg_replace("/\r|\n|\t+|\s{3,}/", "", $s);
}

function setFloattingImage(){
    global $config, $lang;
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    $state = isset($_GET['state']) ? $_GET['state'] : -1;
    if($id <=0 || $state <0 ) return;
    
    $shop_id = getShopId();
    $table = $config['db']['pre'] . 'shop_image';    
    if($state){ //set all other to zero
        $sql = "UPDATE {$table} SET is_floating=0 WHERE shop_id={$shop_id}";
        ORM::get_db()->prepare($sql)->execute();
    }
    $sql = "UPDATE {$table} SET is_floating={$state} WHERE id={$id} AND shop_id={$shop_id}";
    $ret = ORM::get_db()->prepare($sql)->execute();
    $btnText = $state ? 'Unset floating' : 'Set as floating';
    echo json_encode(array('result' => $ret, 'id' => $id, 'btnText' => $btnText));
}

 function getSliderFooterImage()
 {
    global $config, $lang;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }
    $shop_id = getShopId();
    $data = '';
    $images = ORM::for_table($config['db']['pre'] . 'shop_image')
              ->where(array('shop_id' => $shop_id, 'image_type' => 'footer_image'))
              ->find_many();
              foreach ($images as $image) {
                $data .= '<li><div data-id="'. $image['id'] .'" class="input-file-slide"><img src="'. $config['site_url'] .'/storage/shop/footer/'. $image['image'] .'" id="shop_footer_image_'.$image['id'].'"><span class="delete_footer_image delete_image">&times;</span> <div class="uploadButton uploadButton-slider"><input class="uploadButton-input" type="file" accept="image/*" onchange="EditFooterImage(this,&apos;shop_footer_image_'. $image['id'] .'&apos;,&apos;footer_image&apos;)" id="footer_image_upload_'. $image['id'] .'" name="shop_footer_image"/> <label class="uploadButton-slider-button ripple-effect" for="footer_image_upload_'. $image['id'] .'">Upload</label></div></div></li>';
              }
    $result['success'] = true;
    $result['data'] = $data;
    $result['message'] = '';
    die(json_encode($result));
 }


 function CommonSaveImage()
{
    global $config, $lang;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }
    $shop_id = getShopId();
    // Valid formats
    $valid_formats = array("jpeg", "jpg", "png");

    /*Start Item Logo Image Uploading*/
    $file = $_FILES['image'];

    $filename = $file['name'];

    $id = $_GET['id'];

    $ext = getExtension($filename);
    $ext = strtolower($ext);
    if (!empty($filename)) {
        //File extension check
        if (in_array($ext, $valid_formats)) {
            if($id == "logo_image")
            {
                $main_path = ROOTPATH . "/storage/shop/logo/";
            }
            else if($id == "shop_background_image")
            {
                $main_path = ROOTPATH . "/storage/shop/background/";
            }
            else if($id == "shop_outstanding_service_image")
            {
                $main_path = ROOTPATH . "/storage/shop/outstanding_service/"; 
            }
            $filename = uniqid(time()) . '.' . $ext;
            if (move_uploaded_file($file['tmp_name'], $main_path . $filename)) {
                $MainFileName = $filename;
               
                if($id == "logo_image")
                {
         $shop_update = ORM::for_table($config['db']['pre'] . 'shop')
         ->where('id', $_SESSION['user']['shop_id'])
         ->find_one();
         $shop_update->set('main_image', $MainFileName);
         $shop_update->save();
                }
                else
                {
                    update_shop_option($shop_id,$id,$MainFileName);
                }     
                $result['success'] = true;
                $result['message'] = $lang['SAVED_SUCCESS'];
                die(json_encode($result));
            } else {
                $result['success'] = false;
                $result['message'] = $lang['ERROR_IMAGE'];
                die(json_encode($result));
            }
        } else {
            $result['success'] = false;
            $result['message'] = $lang['ONLY_JPG_ALLOW'];
            die(json_encode($result));
        }
    }
    /*End Item Logo Image Uploading*/
}


 function addFooterImage()
{
    global $config, $lang;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }
    $shop_id = getShopId();
    // Valid formats
    $valid_formats = array("jpeg", "jpg", "png");

    /*Start Item Logo Image Uploading*/
    $file = $_FILES['image'];

    $filename = $file['name'];

    $ext = getExtension($filename);
    $ext = strtolower($ext);
    if (!empty($filename)) {
        //File extension check
        if (in_array($ext, $valid_formats)) {
            $main_path = ROOTPATH . "/storage/shop/footer/";
            $filename = uniqid(time()) . '.' . $ext;
            if (move_uploaded_file($file['tmp_name'], $main_path . $filename)) {
                $MainFileName = $filename;
                resizeImage(800, $main_path . 'big_' . $filename, $main_path . $filename);
                $insert_image = ORM::for_table($config['db']['pre'] . 'shop_image')->create();
                $insert_image->image = $MainFileName;
                $insert_image->shop_id = $shop_id;
                $insert_image->image_type ='footer_image';
                $insert_image->save();
                $data = '';
                $images = ORM::for_table($config['db']['pre'] . 'shop_image')
                          ->where(array('shop_id' => $shop_id, 'image_type' => 'footer_image'))
                          ->find_many();
                          foreach ($images as $image) {
                            $data .= '<li><div data-id="'. $image['id'] .'" class="input-file-slide"><img src="'. $config['site_url'] .'/storage/shop/footer/'. $image['image'] .'" id="shop_footer_image_'.$image['id'].'"><span class="delete_footer_image delete_image">&times;</span> <div class="uploadButton uploadButton-slider"><input class="uploadButton-input" type="file" accept="image/*" onchange="EditFooterImage(this,&apos;shop_footer_image_'. $image['id'] .'&apos;,&apos;footer_image&apos;)" id="footer_image_upload_'. $image['id'] .'" name="shop_footer_image"/> <label class="uploadButton-slider-button ripple-effect" for="footer_image_upload_'. $image['id'] .'">Upload</label></div></div></li>';
                          }
                $result['success'] = true;
                $result['data'] = $data;
                $result['message'] = $lang['ADD_IMAGE_SUCCESS'];
                die(json_encode($result));
            } else {
                $result['success'] = false;
                $result['message'] = $lang['ERROR_IMAGE'];
                die(json_encode($result));
            }
        } else {
            $result['success'] = false;
            $result['message'] = $lang['ONLY_JPG_ALLOW'];
            die(json_encode($result));
        }
    }
    /*End Item Logo Image Uploading*/
}


function addSlideImage()
{
    global $config, $lang;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }
    $shop_id = getShopId();
    // Valid formats
    $valid_formats = array("jpeg", "jpg", "png");

    /*Start Item Logo Image Uploading*/
    $file = $_FILES['image'];

    $filename = $file['name'];

    $ext = getExtension($filename);
    $ext = strtolower($ext);
    if (!empty($filename)) {
        //File extension check
        if (in_array($ext, $valid_formats)) {
            $main_path = ROOTPATH . "/storage/shop/cover/";
            $filename = uniqid(time()) . '.' . $ext;
            if (move_uploaded_file($file['tmp_name'], $main_path . $filename)) {
                $MainFileName = $filename;
                resizeImage(1200, $main_path . 'big_' . $filename, $main_path . $filename);
                $insert_image = ORM::for_table($config['db']['pre'] . 'shop_image')->create();
                $insert_image->image = $MainFileName;
                $insert_image->shop_id = $shop_id;
                $insert_image->image_type = $_GET['image_type'];
                $insert_image->save();
                $image_id = $insert_image->id();

                 
                $data = '';
                $images = ORM::for_table($config['db']['pre'] . 'shop_image')
                          ->where(array('shop_id' => $shop_id, 'image_type' => $_GET['image_type']))
                          ->find_many();
                          foreach ($images as $image) {
                            //$data .= '<li><div data-id="'. $image['id'] .'" class="input-file-slide"><img src="'. $config['site_url'] .'/storage/shop/cover/'. $image['image'] .'" id="shop_cover_image_'.$image['id'].'"><span class="delete_cover_image">&times;</span> <div class="uploadButton uploadButton-slider"><input class="uploadButton-input" type="file" accept="image/*" onchange="readImageURLAndEdit(this,&apos;shop_cover_image_'. $image['id'] .'&apos;,&apos;banner&apos;)" id="cover_upload_'. $image['id'] .'" name="shop_cover_image"/> <label class="uploadButton-slider-button ripple-effect" for="cover_upload_'. $image['id'] .'">Upload</label></div></div></li>';
                            $data .= getBannerSliderItemContent($image, $config['site_url']);
                        }
                $result['success'] = true;
                $result['data'] = $data;
                $result['message'] = $lang['ADD_IMAGE_SUCCESS'];
                die(json_encode($result));
            } else {
                $result['success'] = false;
                $result['message'] = $lang['ERROR_IMAGE'];
                die(json_encode($result));
            }
        } else {
            $result['success'] = false;
            $result['message'] = $lang['ONLY_JPG_ALLOW'];
            die(json_encode($result));
        }
    }
    /*End Item Logo Image Uploading*/
}

function addSlideShowImage()
{
    global $config, $lang;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }
    $shop_id = getShopId();
    // Valid formats
    $valid_formats = array("jpeg", "jpg", "png");

    /*Start Item Logo Image Uploading*/
    $file = $_FILES['image'];

    $filename = $file['name'];

    $ext = getExtension($filename);
    $ext = strtolower($ext);
    if (!empty($filename)) {
        //File extension check
        if (in_array($ext, $valid_formats)) {
            $main_path = ROOTPATH . "/storage/shop/slideshow/";
            $filename = uniqid(time()) . '.' . $ext;
            if (move_uploaded_file($file['tmp_name'], $main_path . $filename)) {
                $MainFileName = $filename;
                resizeImage(150, $main_path . 'small_' . $filename, $main_path . $filename);
                resizeImage(800, $main_path . 'big_' . $filename, $main_path . $filename);

                $insert_image = ORM::for_table($config['db']['pre'] . 'shop_image')->create();
                $insert_image->image = $MainFileName;
                $insert_image->shop_id = $shop_id;
                $insert_image->save();
                $image_id = $insert_image->id();
            } else {
                $result['success'] = false;
                $result['message'] = $lang['ERROR_IMAGE'];
                die(json_encode($result));
            }
        } else {
            $result['success'] = false;
            $result['message'] = $lang['ONLY_JPG_ALLOW'];
            die(json_encode($result));
        }
    }
    /*End Item Logo Image Uploading*/
}

function add_item()
{
    global $config, $lang;
    $price = 0;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }

    if (empty($_POST['title'])) {
        $result['success'] = false;
        $result['message'] = $lang['TITLE_REQ'];
        $result['field'] = 'title';
        die(json_encode($result));
    }
    if (empty($_POST['price'])) {
        $result['success'] = false;
        $result['message'] = $lang['ITEM_PRICE_IS_RQ'];
        $result['field'] = 'price';
        die(json_encode($result));
    }
    
    $duration = intval($_POST['service_duration']);
    if ($duration<=0) {
        $result['success'] = false;
        $result['message'] = $lang['FIELD_REQ'];
        $result['field'] = 'service_duration';
        die(json_encode($result));
    }

    // if (empty($_POST['menu_item_id'])) {
    //     $result['success'] = false;
    //     $result['message'] = $lang['ITEM_ID_IS_RQ'];
    //     die(json_encode($result));
    // }


    if (!empty($_POST['is_discount'])) {
        if (empty($_POST['discount_price'])  || $_POST['discount_price'] == '0.00') {
            $result['success'] = false;
            $result['message'] = $lang['DISCOUNT_PRICE_REQ'];
            die(json_encode($result));
        }
        if ((float)$_POST['discount_price'] > (float) $_POST['price']) {
            $result['success'] = false;
            $result['message'] = $lang['INVALID_DISCOUNT_PRICE'];
            die(json_encode($result));
        }
    }
    //check id menu exits
    // if (!empty($_POST['id'])) {
    //     $check_menu_id = ORM::for_table($config['db']['pre'] . 'menu')
    //         ->where('user_id', $_SESSION['user']['id'])
    //         ->where('menu_res_id', $_POST['menu_item_id'])
    //         ->where_not_equal('id', $_POST['id'])
    //         ->find_one();
    // } else {
    //     $check_menu_id = ORM::for_table($config['db']['pre'] . 'menu')
    //         ->where('user_id', $_SESSION['user']['id'])
    //         ->where('menu_res_id', $_POST['menu_item_id'])
    //         ->find_one();
    // }
    // if (!empty($check_menu_id)) {
    //     $result['success'] = false;
    //     $result['message'] = $lang['ITEM_ID_ALREADY_EXISTS'];
    //     die(json_encode($result));
    // }

    $MainFileName = null;
    $cat_id = validate_input($_POST['cat_id']);
    $title = validate_input($_POST['title']);
    $menu_item_id = validate_input($_POST['menu_item_id']);
    $description = validate_input($_POST['description']);
    $category = $_POST['category'];
    if (empty($_POST['price'])) {
        $price = 0;
    } else {
        $price = validate_input($_POST['price']);
    }
    
    if (empty($_POST['service_duration'])) {
        $service_duration = 0;
    } else {
        $service_duration = validate_input($_POST['service_duration']);
    }

    // Valid formats
    $valid_formats = array("jpeg", "jpg", "png");

    /*Start Item Logo Image Uploading*/
    $file = $_FILES['main_image'];
    $filename = $file['name'];
    $ext = getExtension($filename);
    $ext = strtolower($ext);
    if (!empty($filename)) {
        //File extension check
        if (in_array($ext, $valid_formats)) {
            $main_path = ROOTPATH . "/storage/menu/";
            $filename = uniqid(time()) . '.' . $ext;
            if (move_uploaded_file($file['tmp_name'], $main_path . $filename)) {
                $MainFileName = $filename;
                resizeImage(300, $main_path . $filename, $main_path . $filename);
                resizeImage(150, $main_path . 'small_' . $filename, $main_path . $filename);
                resizeImage(800, $main_path . 'big_' . $filename, $main_path . $filename);
            } else {
                $result['success'] = false;
                $result['message'] = $lang['ERROR_IMAGE'];
                die(json_encode($result));
            }
        } else {
            $result['success'] = false;
            $result['message'] = $lang['ONLY_JPG_ALLOW'];
            die(json_encode($result));
        }
    }else{
        $MainFileName = $_POST['copy_image_file_name'];
    }
    /*End Item Logo Image Uploading*/

    $description = trim($description);
    if (trim($title) != '' && is_string($title)) {
        require('ctrls/bo/CFr3eGoogl3Translat3.class.php');    
        require('ctrls/lib/request.lib.php');
        $tr = new CFr3eGoogl3Translat3();
        $json = array();
        //$user_lang = !empty($_COOKIE['Quick_user_lang_code']) ? $_COOKIE['Quick_user_lang_code'] : $config['lang_code'];
        $user_lang = $config['lang_code'];
        if (!empty($_POST['id'])) {
            $insert_menu = ORM::for_table($config['db']['pre'] . 'menu')->find_one($_POST['id']);
            $json = json_decode($insert_menu['translation'], true);
            if($user_lang=='de'){   
                $langs = JsonHelper::getActiveLangCodes();
                foreach($langs as $langCode){
                    if($langCode=='de') continue;
                    $json[$langCode] = array('title' => $tr->translate('de', $langCode, $name), 'description' => !$description ? '' : $tr->translate('de', $langCode, $description) );
                }                
                $insert_menu->name = $title;
                $insert_menu->description = $description;    
            }else{
                $json[$user_lang] = array('title' => $name, 'description' => $description);
            }
        } else {
            $insert_menu = ORM::for_table($config['db']['pre'] . 'menu')->create();
            $langs = JsonHelper::getActiveLangCodes();
            $pos = array_search($user_lang, $langs);
            if($pos !== false) unset($langs[$pos]);
            foreach($langs as $desc_lang){
                $json[$desc_lang] = array('title' => $tr->translate($user_lang, $desc_lang, $title), 'description' => !$description ? '' : $tr->translate($user_lang, $desc_lang, $description));
            }
            $insert_menu->name = $user_lang=='de' ? $title : $json['de']['title'];
            $insert_menu->description = $user_lang=='de' ? $description : $json['de']['description'];
        }
        
        $json[$user_lang] = array('title' => $title, 'description' => $description);
        $insert_menu->active = isset($_POST['active']) ? '1' : '0';
        $insert_menu->shop_id = validate_input($_SESSION['user']['shop_id']);
        $insert_menu->cat_id = $cat_id;
        $insert_menu->price = $price;
        $insert_menu->service_duration = $service_duration;
        $insert_menu->type = validate_input($_POST['type']);
        $insert_menu->translation = json_encode($json, JSON_UNESCAPED_UNICODE);
        $insert_menu->discount_price = isset($_POST['discount_price']) ? validate_input($_POST['discount_price'])  : NULL;
        $insert_menu->is_new_food = isset($_POST['is_new_food']) ? '1' : '0';
        $insert_menu->is_discount = isset($_POST['is_discount']) ? '1' : '0';
        $insert_menu->cat_id = $category;
        if ($MainFileName) {
            $insert_menu->image = $MainFileName;
        }
        $insert_menu->save();
        $menu_id = $insert_menu->id();

         $extra_delete = $_POST['extra-delete'];           
		 $extra_id = $_POST['extra-id'];							
		 $extra_name = 	 $_POST['name-extra'];					
		 $extra_price = $_POST['price-extra'];

        foreach( $extra_delete as $key => $value ) {
            $delete = $value;
            $id = $extra_id[$key];
            $name = $extra_name[$key];
            $price  = $extra_price[$key];

            if(empty($id) &&  $delete == 0)
            {
                if(!empty($name) && !empty($price))
                {
                    $insert_extra = ORM::for_table($config['db']['pre'] . 'menu_extras')->create();
                    $insert_extra->title = $name;
                    $insert_extra->menu_id = $menu_id;
                    $insert_extra->price = $price;
                    $insert_extra->save();
                }
            }
            else if($delete == 1)
            {
                ORM::for_table($config['db']['pre'] . 'menu_extras')->where('id',$id)->delete_many();
            }
            else
            {
                if(!empty($name) && !empty($price))
                {
                $update_extra = ORM::for_table($config['db']['pre'] . 'menu_extras')->find_one($id);
                $update_extra->title = $name;
                $update_extra->price = $price;
                $update_extra->save();
                }
            }
        }

        if ($menu_id) {
            $result['success'] = true;
            $result['message'] = $lang['SAVED_SUCCESS'];
        } else {
            $result['success'] = false;
            $result['message'] = $lang['ERROR_TRY_AGAIN'];
        }
    } else {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
    }
    $result['id'] = $menu_id;
    die(json_encode($result));
}
function EditIsDisableReserve()
{
    global $config, $lang;
    $result = array('success' => false, 'message' => '');
    $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
    ->where('id', $_POST['restaurant'])
    ->find_one();
if (empty($restaurant->id)) {
    $result['success'] = false;
    $result['message'] = $lang['ERROR_TRY_AGAIN'];
    die(json_encode($result));
}
    $loggedin = checkcustomerloggedin($restaurant['id']);
    if ($loggedin == false) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }
    $id_customer = $_SESSION['customer']['id'];
 
    $restaurant_id = $restaurant->id;
    $Reserve = ORM::for_table($config['db']['pre'] . 'reserve')
        ->where(array('restaurant_id' => $restaurant_id, 'customer_id' => $id_customer, 'id' => $_POST['reserve_id']))
        ->find_one();
    if (!empty($Reserve->id)) {
        $Reserve->set('is_disabled', $_POST['is_disable']);
        $Reserve->save();

        $userdata = get_user_data(null, $restaurant['user_id']);
        /* send notification to firebase */
        $msg = ['action' => 'reserve_change_disabled', 'id' => $Reserve->id];
        FirebaseNotification($userdata['firebase_token'], $lang, 'reserve_change_disabled', $msg);
        $result['success'] = true;
        $result['message'] = '';
    }
    die(json_encode($result));
}
function RemoveDataReserve()
{
    global $config, $lang, $link;
    $result = array('success' => false, 'message' => '');
    $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
    ->where('id', $_POST['restaurant'])
    ->find_one();
if (empty($restaurant->id)) {
    $result['success'] = false;
    $result['message'] = $lang['ERROR_TRY_AGAIN'];
    die(json_encode($result));
}
    $loggedin = checkcustomerloggedin($restaurant->id);
    if ($loggedin == false) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }
    $id_customer = $_SESSION['customer']['id'];
   
    $restaurant_id = $restaurant->id;
    $reserve = ORM::for_table($config['db']['pre'] . 'reserve')
        ->where(array('restaurant_id' => $restaurant_id, 'id' => $_POST['reserve_id']))
        ->find_one();
    //check date 
    // $min_hour_edit = get_restaurant_option($restaurant_id, 'restaurant_min_hour_edit_pre_order', 1);
    // $now = date('Y-m-d H:i');
    // $timestamp = strtotime($now) + 60 * 60 * $min_hour_edit;
    // $time = date('Y-m-d H:i', $timestamp);
    // $reserve_date = date('Y-m-d H:i', strtotime($Reserve['date_reserve']));
    // if ($time > $reserve_date) {
    //     $result['success'] = false;
    //     $result['message'] = $lang['DATA_CANNOT_BE_DELETED'];
    //     die(json_encode($result));
    // }
    if (!empty($reserve->id)) {

        $reserve->set('status', 'cancelled');
        $reserve->set('cancellation_reason', $_POST['cancellation_reason']);
        $reserve->save();

     //update reserve customer info
      $reserve_customer_info =  ORM::for_table($config['db']['pre'] . 'reserve_customer_info')
      ->where('reserve_id', $_POST['reserve_id'])
      ->find_one();
    $reserve_customer_info->deleted = 1;
    $reserve_customer_info->save();
      
  $reserve_items = ORM::for_table($config['db']['pre'] . 'reserve_items')
      ->where('reserve_id',  $_POST['reserve_id'])
      ->find_many();
  foreach ($reserve_items as $item) {
  $reserve_item_extras =  ORM::for_table($config['db']['pre'] . 'reserve_item_extras')
          ->where('reserve_item_id', $item->id)
          ->find_many();
  $reserve_item_extras->set('is_cancelled_order', 1);
  $reserve_item_extras->save();
  }
  $reserve_items->set('is_cancelled_order', 1);
  $reserve_items->save();

    $userdata = get_user_data(null, $restaurant['user_id']);
    //send email and Whatsapps
    $icon_menu_item = "▪️";
    $icon_menu_extra = "▫️";
    $icon_phone = "☎️";
    $icon_address = "📌";
    $icon_email = "📧";
    $order_msg = $order_whatsapp_detail = '';

    $user_lang = !empty($_COOKIE['Quick_user_lang_code']) ? $_COOKIE['Quick_user_lang_code'] : $config['lang_code'];
    $items =  ORM::for_table($config['db']['pre'] . 'reserve_items')
    ->where(array('reserve_id' => $_POST['reserve_id'], 'deleted' => 0))
    ->find_many();
    $amount = $reserve['amount'];
    foreach ($items as $item) {
        $menu = ORM::for_table($config['db']['pre'] . 'menu')
            ->where('id', $item['item_id'])
            ->find_one();
        $item_id = $item['item_id'];
        $quantity = $item['quantity'];
        $amount_item =    $item['item_price'];
        $total_amount = $item['item_price'] * $quantity;
        $amount_reduced = !empty($menu['discount_price']) ? ($menu['price'] - $menu['discount_price']) * $quantity : 0;
      //  $amount += $total_amount;
            if (!$config['email_template']) {
                $order_msg .= $item['name'] . ($quantity > 1 ? ' &times; ' . $quantity : '') . '<br>';
            } else {
                $order_msg .= $item['name'] . ($quantity > 1 ? ' X ' . $quantity : '') . "\n";
            }

            $json = json_decode($menu['translation'], true);
            //   $title = !empty($json[$user_lang]['title']) ? $json[$user_lang]['title'] : $menu['name'];
            $title = $item['name'];
            $order_whatsapp_detail .= $icon_menu_item . $title . ' X ' . $quantity . "\n";

            $extras = ORM::for_table($config['db']['pre'] . 'reserve_item_extras')
            ->where('reserve_item_id', $item['id'])
            ->find_many();//
            foreach ($extras as $extra) {
                $menu_extra = ORM::for_table($config['db']['pre'] . 'menu_extras')
                    ->where('id', $extra['extra_id'])
                    ->find_one();

                if (isset($menu_extra['id'])) {            
                   // $amount += $menu_extra['price'] * $quantity;
                    if (!$config['email_template']) {
                        $order_msg .= $menu_extra['title'] . '<br>';
                    } else {
                        $order_msg .= $menu_extra['title'] . "\n";
                    }
                    $json = json_decode($menu_extra['translation'], true);
                    $title = !empty($json[$user_lang]['title']) ? $json[$user_lang]['title'] : $menu_extra['title'];

                    $order_whatsapp_detail .= $icon_menu_extra . $title . "\n";
                }
            }
            if (!$config['email_template']) {
                $order_msg .= '<br>';
            } else {
                $order_msg .= "\n";
            }      
    }

    $currency = !empty($userdata['currency']) ? $userdata['currency'] : get_option('currency_code');
    $name = validate_input($_POST['name']);
    $phone = '';
    $email ='';
    $address = '';
    $cancellation_reason =  $_POST['cancellation_reason'];
    $reserve_customer_info = ORM::for_table($config['db']['pre'] . 'reserve_customer_info')
    ->where('reserve_id', $_POST['reserve_id'])
    ->find_one();
    if ($reserve['type'] == 'takeaway') {
        $phone = validate_input($reserve_customer_info['phone_number']);
        $email = validate_input($reserve_customer_info['email']);
    } else if ($reserve['type'] == 'delivery') {
        $address = validate_input($reserve_customer_info['address']);
        $phone = validate_input($reserve_customer_info['phone_number']);
        $email = validate_input($reserve_customer_info['email']);
    }
    $name = validate_input($reserve_customer_info['customer_name']);
    $customer_details = validate_input($reserve_customer_info['customer_name']) . "\n";
    if ($reserve['type'] == 'takeaway') {
        $customer_details .= $icon_phone . ' ' . validate_input($reserve_customer_info['phone_number']) . "\n";
        $customer_details .= !empty($reserve_customer_info['email']) ? $icon_email . ' ' . validate_input($reserve_customer_info['email']) : '';
    } else if ($reserve['type'] == 'delivery') { 
        $customer_details .= $icon_phone . ' ' . validate_input($reserve_customer_info['phone_number']) . "\n";
        $customer_details .= !empty($reserve_customer_info['email']) ? $icon_email . ' ' . validate_input($reserve_customer_info['email']) . "\n" : '';
        $customer_details .= $icon_address . ' ' . validate_input($reserve_customer_info['address']) . "\n";
   
    }
    $order_type = $reserve['type'] == 'takeaway'? $lang['TAKEAWAY'] : $lang['DELIVERY'];
    $shipping_fee = $reserve['type'] == 'takeaway'? '' : validate_input($reserve['shipping_fee']);
    $discount_code = $reserve['coupons_code'];
    $discount_price = $reserve['include_total_discount_value'];
    $page = new HtmlTemplate();
    $page->html = $config['email_sub_canceled_pre_order'];
    $page->SetParameter('RESTAURANT_NAME', $restaurant['name']);
    $page->SetParameter('CUSTOMER_NAME', $name);
    $page->SetParameter('PHONE_NUMBER', $phone);
    $page->SetParameter('ADDRESS', $address);
    $page->SetParameter('EMAIL', $email);
    $page->SetParameter('CANCELLATION_REASON', $cancellation_reason);
    $page->SetParameter('SHIPPING_FEE', $shipping_fee);
    $page->SetParameter('ORDER_TYPE', $order_type);
    $email_subject = $page->CreatePageReturn($lang, $config, $link);

    $page = new HtmlTemplate();
    $page->html = $config['email_message_canceled_pre_order'];
    $page->SetParameter('RESTAURANT_NAME', $restaurant['name']);
    $page->SetParameter('CUSTOMER_NAME', $name);
    $page->SetParameter('PHONE_NUMBER', $phone);
    $page->SetParameter('ADDRESS', $address);
    $page->SetParameter('EMAIL', $email);
    $page->SetParameter('TAKEAWAY_DELIVERY_TIME', date('d-m-Y H:i:s', strtotime($reserve['date_reserve'])));
    $page->SetParameter('CANCELLATION_REASON', $cancellation_reason);
    $page->SetParameter('SHIPPING_FEE', $shipping_fee);
    $page->SetParameter('ORDER_TYPE', $order_type);
    $page->SetParameter('DISCOUNT_CODE', $discount_code);
    $page->SetParameter('DISCOUNT_PRICE', price_format(-$discount_price, $currency, false));
    $page->SetParameter('ORDER', $order_msg);
    $page->SetParameter('ORDER_TOTAL', price_format($amount, $currency, false));

    $email_body = $page->CreatePageReturn($lang, $config, $link);

    $userdata = get_user_data(null, $restaurant['user_id']);

    if (!empty($email)) {
        /* send email to user */
        email($email, $userdata['name'], $email_subject, $email_body);
    }
    /* send email to restaurant */
    email($userdata['email'], $userdata['name'], $email_subject, $email_body);
    $result['success'] = true;
    $result['message'] = '';
    $result['whatsapp_url'] = '';

    if ($config['quickorder_enable']) {
        //$settings = get_all_setting($restaurant['user_id']);
        $RESTAURANT_WHATSAPP_ORDERING = get_module_settting($restaurant['user_id'], 'whatsapp');
        if ($RESTAURANT_WHATSAPP_ORDERING == 1) {
            if (get_restaurant_option($restaurant['id'], 'quickorder_enable', 0)) { 
                    $whatsapp_number = get_restaurant_option($restaurant['id'], 'whatsapp_number');
                    $whatsapp_message = get_restaurant_option($restaurant['id'], 'whatsapp_canceled_pre_order_message');
                    $userdata = get_user_data(null, $restaurant['user_id']);
                    $currency = !empty($userdata['currency']) ? $userdata['currency'] : get_option('currency_code');
                    $page = new HtmlTemplate();
                    $page->html = $whatsapp_message;
                    $page->SetParameter('ORDER_ID',$_POST['reserve_id']);
                    $page->SetParameter('ORDER_DETAILS', $order_whatsapp_detail);
                    $page->SetParameter('CUSTOMER_DETAILS', $customer_details);
                    $page->SetParameter('ORDER_TYPE', $order_type);
                    $page->SetParameter('SHIPPING_FEE', $shipping_fee);
                    $page->SetParameter('TAKEAWAY_DELIVERY_TIME', date('d-m-Y H:i:s', strtotime($reserve['date_reserve'])));
                    $page->SetParameter('ORDER_TOTAL', price_format($amount, $currency, false));
                    $page->SetParameter('DISCOUNT_CODE', $discount_code);
                    $page->SetParameter('CANCELLATION_REASON', $cancellation_reason);
                    $page->SetParameter('DISCOUNT_PRICE', price_format(-$discount_price, $currency, false));
                    $whatsapp_message = $page->CreatePageReturn($lang, $config, $link);
                    $whatsapp_url = 'https://api.whatsapp.com/send?phone=' . $whatsapp_number . '&text=' . urlencode($whatsapp_message);
                    $result['whatsapp_url'] = $whatsapp_url;               
            }
        }
    }
        /* send notification to firebase */
        $msg = ['action' => 'reserve_delete', 'id' => $reserve->id];
        FirebaseNotification($userdata['firebase_token'], $lang, 'reserve_delete', $msg);
    }
    $result['success'] = true;
    $result['message'] = $lang['DELETE_SUCCESS'];
    die(json_encode($result));
}
function getReserveData()
{
    global $config, $lang;
    $result = array('success' => false, 'message' => '', 'data' => '');
    $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
    ->where('id', $_POST['restaurant'])
    ->find_one();
if (empty($restaurant->id)) {
    $result['success'] = false;
    $result['message'] = $lang['ERROR_TRY_AGAIN'];
    die(json_encode($result));
}
    $loggedin = checkcustomerloggedin($restaurant->id);
    if ($loggedin == false) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }
    $id_customer = $_SESSION['customer']['id'];
  
    //load lai danh sach nhung khong qua 14 ngay
    $date = date("Y-m-d H:i:s"); //, strtotime(date("Y-m-d H:i:s") . "-14 day")
    //get list Reserve 
    // $Reserve = ORM::for_table($config['db']['pre'] . 'reserve')
    //     ->where(array('restaurant_id' => $restaurant->id, 'customer_id' => $id_customer))
    //     ->where_gte('date_reserve', $date)
    //     ->find_many();

    $Reserve = ORM::for_table($config['db']['pre'] . 'reserve')
        ->table_alias('r')
        ->select_many('r.*', 'c.address')
        ->where_not_equal('r.status','cancelled')
        ->where_not_equal('r.status','completed')
        ->where(array( 'r.restaurant_id' => $restaurant->id, 'r.customer_id' => $id_customer))
        ->where_gte('r.date_reserve', $date)
        ->join($config['db']['pre'] . 'reserve_customer_info', array('r.id', '=', 'c.reserve_id'), 'c')
        ->find_many();
    $arr = [];
    // coupons_code
    // include_total_discount_value
    foreach ($Reserve as $info) {
        $arr_info = ['id' => $info['id'], 'date_reserve' =>  $info['date_reserve'], 'is_disabled' => $info['is_disabled'], 'coupons_code' => $info['coupons_code'], 'include_total_discount_value' => $info['include_total_discount_value'], 'type' => $info['type'], 'shipping_fee' => $info['shipping_fee'], 'address' => $info['address']];
        array_push($arr, $arr_info);
    }
    $result['success'] = true;
    $result['data'] = json_encode($arr);
    die(json_encode($result));
}

function getReserveItemData()
{
    global $config, $lang;
    $result = array('success' => false, 'message' => $lang['ERROR_TRY_AGAIN'], 'data' => '');
    $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
    ->where('id', $_POST['restaurant'])
    ->find_one();
if (empty($restaurant->id)) {
    die(json_encode($result));
}
    $loggedin = checkcustomerloggedin($restaurant->id);
    if ($loggedin == false) {
        die(json_encode($result));
    }
    if (empty($_POST['id'])) {
        die(json_encode($result));
    }
    $id_customer = $_SESSION['customer']['id'];
  
    //check reserve exist 
    $Reserve_result = ORM::for_table($config['db']['pre'] . 'reserve')
        ->where(array('restaurant_id' => $restaurant->id, 'customer_id' => $id_customer, 'id' => $_POST['id']))
        ->find_one();
    if (empty($Reserve_result->id)) {
        die(json_encode($result));
    }
    //get list Reserve 
    $Reserve = ORM::for_table($config['db']['pre'] . 'reserve_items')
        ->table_alias('r_i')
        ->select_many('r_i.*')
        ->where(array('r_i.reserve_id' => $Reserve_result->id))
        ->join($config['db']['pre'] . 'menu', array('i.id', '=', 'r_i.item_id'), 'i')
        ->find_many();
    $data = [];
    foreach ($Reserve as $info) {
        //get extra
        $reserve_item_extras = ORM::for_table($config['db']['pre'] . 'reserve_item_extras')
            ->table_alias('r_i_e')
            ->select_many('r_i_e.*', 'e.title', 'e.price')
            ->where(array(
                'r_i_e.reserve_item_id' => $info['id']
            ))
            ->join($config['db']['pre'] . 'menu_extras', array('e.id', '=', 'r_i_e.extra_id'), 'e')
            ->find_many();
        $arr_extras_info = [];
        foreach ($reserve_item_extras as $extra_info) {
            $arr_extra_info = [
                'id' => $extra_info['reserve_item_id'],
                'extra_id' => $extra_info['extra_id'],
                'name' => $extra_info['title'],
                'price' => $extra_info['price'],
                'deleted' => $extra_info['deleted']
            ];
            array_push($arr_extras_info, $arr_extra_info);
        }
        $arr_info = [
            'id' => $info['id'],
            'item_id' =>  $info['item_id'],
            'name' => $info['name'],
            'variation' => $info['variation'],
            'quantity' => $info['quantity'],
            'amount' => $info['amount'],
            'total_amount' => $info['total_amount'],
            'amount_reduced' => $info['amount_reduced'],
            'deleted' => $info['deleted'],
            'extras' => json_encode($arr_extras_info)
        ];
        array_push($data, $arr_info);
    }
    $result['success'] = true;
    $result['message'] = '';
    $result['data'] = json_encode($data);
    die(json_encode($result));
}
function get_allegie()
{
    global $config;
    $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
        ->where('user_id', $_SESSION['user']['id'])
        ->find_one();
    //get list Allegie
    $Allegies = ORM::for_table($config['db']['pre'] . 'allegie')
        ->where('restaurant_id',  $restaurant->id)->find_many(); //
    $Allegie_tlp = '';
    foreach ($Allegies as $info) {
        $Allegie_tlp .= '<div class="col-sm-3"><div class="checkbox"><label class="allegie_label"><input class="allegie" type="checkbox" name="allegie[]" value="' . $info['id'] . '">' . $info['alle_aliases'] . '</label></div></div>';
    }
    $response = array();
    $response['Allegie_tlp'] = $Allegie_tlp;
    die(json_encode($response));
}

function get_online_booking()
{
    global $config;
    $result = ORM::for_table($config['db']['pre'] . 'booking_table')
        ->find_one($_GET['id']);
    $response = array('success' => false);
    if (!empty($result)) {
        $response['success'] = true;
        $response['id'] = $result['id'];
        $response['customer_name'] = escape($result['customer_name']);
        $response['table_number'] = escape($result['table_number']);
        $response['phone_number'] = $result['phone_number'];
        $response['ticket'] = $result['ticket'];
        $response['status'] = $result['status'];
        $response['email'] = $result['email'];
        $response['date_from'] = date_format(date_create($result['date_from']), "d/m H:i");
        $response['date_to'] = date_format(date_create($result['date_to']), "d/m H:i");
        $response['note'] = $result['note'];
    }
    die(json_encode($response));
}
function get_item()
{
    global $config;
    $result = ORM::for_table($config['db']['pre'] . 'menu')
        ->where('user_id', $_SESSION['user']['id'])
        ->find_one($_GET['id']);
    $response = array('success' => false);
    if (!empty($result)) {

        $menu_allegie_result = ORM::for_table($config['db']['pre'] . 'allegie')
            ->table_alias('a')
            ->inner_join($config['db']['pre'] . "allegie_menu", "a.id = am.alle_id", 'am')
            ->where('am.menu_id', $_GET['id'])
            ->find_many();
        $Allegie_list = array();
        foreach ($menu_allegie_result as $Allegie) {
            array_push($Allegie_list, $Allegie['id']);
        }
        $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
            ->where('user_id', $_SESSION['user']['id'])
            ->find_one();
        //get list Allegie
        $Allegies = ORM::for_table($config['db']['pre'] . 'allegie')
            ->where('restaurant_id', $restaurant['id'])->find_many();
        $Allegie_tlp = '';
        foreach ($Allegies as $info) {
            $checked = in_array($info['id'], $Allegie_list) ? "checked" : "";
            $Allegie_tlp .= '<div class="col-sm-3"><div class="checkbox"><label class="allegie_label"><input class="allegie" type="checkbox" name="allegie[]" value="' . $info['id'] . '" ' . $checked . '>' . $info['alle_aliases'] .  '</label></div></div>';
        }

        $response['Allegie_tlp'] = $Allegie_tlp;
        $response['success'] = true;
        $user_lang = !empty($_COOKIE['Quick_user_lang_code']) ? $_COOKIE['Quick_user_lang_code'] : $config['lang_code'];
        $json = json_decode($result['translation'], true);

        $response['name'] = !empty($json[$user_lang]['title']) ? $json[$user_lang]['title'] : $result['name'];

        $description = !empty($json[$user_lang]['description']) ? $json[$user_lang]['description'] : $result['description'];
        $response['description'] = stripcslashes($description);

        $response['price'] = $result['price'];
        $response['type'] = $result['type'];
        $response['active'] = $result['active'];
        $response['discount_price'] = $result['discount_price'];
        $response['is_new_food'] = $result['is_new_food'];
        $response['is_discount'] = $result['is_discount'];
        $response['display_image'] = $result['display_image'];
        $response['service'] = $result['service_department'];
        $response['menu_res_id'] = $result['menu_res_id'];
        $response['image'] = !empty($result['image'])
            ? $config['site_url'] . 'storage/menu/' . $result['image']
            : $config['site_url'] . 'storage/menu/' . 'default.png';
    }
    die(json_encode($response));
}

function edit_item()
{
    global $config, $lang;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }

    if (empty($_POST['menu_id'])) {
        $result['success'] = false;
        $result['message'] = $lang['TITLE_REQ'];
        die(json_encode($result));
    }

    if (empty($_POST['title'])) {
        $result['success'] = false;
        $result['message'] = $lang['TITLE_REQ'];
        die(json_encode($result));
    }
    if (empty($_POST['description'])) {
        $result['success'] = false;
        $result['message'] = $lang['DESC_REQ'];
        die(json_encode($result));
    }
    if (empty($_POST['price'])) {
        $result['success'] = false;
        $result['message'] = $lang['PRICE_REQ'];
        die(json_encode($result));
    }
    $MainFileName = null;
    $main_imageName = '';
    $cat_id = validate_input($_POST['cat_id']);
    $title = validate_input($_POST['title']);
    $description = validate_input($_POST['description']);
    $price = validate_input($_POST['price']);

    // Valid formats
    $valid_formats = array("jpeg", "jpg", "png");

    /*Start Item Logo Image Uploading*/
    $file = $_FILES['main_image'];
    $filename = $file['name'];
    $ext = getExtension($filename);
    $ext = strtolower($ext);
    if (!empty($filename)) {
        //File extension check
        if (in_array($ext, $valid_formats)) {
            $main_path = ROOTPATH . "/storage/menu/";
            $filename = uniqid(time()) . '.' . $ext;
            if (move_uploaded_file($file['tmp_name'], $main_path . $filename)) {
                $MainFileName = $filename;
                resizeImage(350, $main_path . $filename, $main_path . $filename);
                // resizeImage(60, $main_path . 'small_' . $filename, $main_path . $filename);
                resizeImage(150, $main_path . 'small_' . $filename, $main_path . $filename);
                resizeImage(800, $main_path . 'big_' . $filename, $main_path . $filename);
            } else {
                $result['success'] = false;
                $result['message'] = $lang['ERROR_IMAGE'];
                die(json_encode($result));
            }
        } else {
            $result['success'] = false;
            $result['message'] = $lang['ONLY_JPG_ALLOW'];
            die(json_encode($result));
        }
    }
    /*End Item Logo Image Uploading*/

    if (trim($title) != '' && is_string($title)) {

        $insert_menu = ORM::for_table($config['db']['pre'] . 'menu')->create();
        $insert_menu->user_id = validate_input($_SESSION['user']['id']);
        $insert_menu->cat_id = $cat_id;
        $insert_menu->name = $title;
        $insert_menu->description = $description;
        $insert_menu->price = $price;
        if ($MainFileName) {
            $insert_menu->image = $MainFileName;
        }
        $insert_menu->save();

        $menu_id = $insert_menu->id();

        if ($menu_id) {
            $result['success'] = true;
            $result['message'] = $lang['SAVED_SUCCESS'];
        } else {
            $result['success'] = false;
            $result['message'] = $lang['ERROR_TRY_AGAIN'];
        }
    } else {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
    }
    die(json_encode($result));
}

function delete_item()
{
    global $lang, $config;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }
    $id = $_GET['id'];
    if (trim($id) != '') {
        $data = ORM::for_table($config['db']['pre'] . 'menu')
            ->where(array(
                'id' => $id,
                'shop_id' => $_SESSION['user']['shop_id'],
            ))
            ->delete_many();

        if ($data) {
            $result['success'] = true;
            $result['message'] = $lang['MENU_DELETED'];
        } else {
            $result['success'] = false;
            $result['message'] = $lang['ERROR_TRY_AGAIN'];
        }
    } else {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
    }
    die(json_encode($result));
}

function add_image_item()
{
    global $config, $lang;

    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }

    if (empty($_POST['title'])) {
        $result['success'] = false;
        $result['message'] = $lang['TITLE_REQ'];
        die(json_encode($result));
    }

    if (empty($_FILES['main_image']['name']) && empty($_POST['id'])) {
        $result['success'] = false;
        $result['message'] = $lang['IMAGE_REQ'];
        die(json_encode($result));
    }

    $MainFileName = null;
    $main_imageName = '';
    $title = validate_input($_POST['title']);

    // check if adding new item
    if (empty($_POST['id'])) {
        // Get usergroup details
        // $group_id = get_user_group();
        // // Get membership details
        // switch ($group_id) {
        //     case 'free':
        //         $plan = json_decode(get_option('free_membership_plan'), true);
        //         $settings = $plan['settings'];
        //         $limit = $settings['menu_limit'];
        //         break;
        //     case 'trial':
        //         $plan = json_decode(get_option('trial_membership_plan'), true);
        //         $settings = $plan['settings'];
        //         $limit = $settings['menu_limit'];
        //         break;
        //     default:
        //         $plan = ORM::for_table($config['db']['pre'] . 'plans')
        //             ->select('settings')
        //             ->where('id', $group_id)
        //             ->find_one();
        //         if (!isset($plan['settings'])) {
        //             $plan = json_decode(get_option('free_membership_plan'), true);
        //             $settings = $plan['settings'];
        //             $limit = $settings['menu_limit'];
        //         } else {
        //             $settings = json_decode($plan['settings'], true);
        //             $limit = $settings['menu_limit'];
        //         }
        //         break;
        // }


        // if ($limit != "999") {
        //     $total = ORM::for_table($config['db']['pre'] . 'image_menu')
        //         ->where('user_id', $_SESSION['user']['id'])
        //         ->count();

        //     if ($total >= $limit) {
        //         $result['success'] = false;
        //         $result['message'] = $lang['LIMIT_EXCEED_UPGRADE'];
        //         die(json_encode($result));
        //     }
        // }
    }

    // Valid formats
    $valid_formats = array("jpeg", "jpg", "png");

    /*Start Item Logo Image Uploading*/
    $file = $_FILES['main_image'];
    $filename = $file['name'];
    $ext = getExtension($filename);
    $ext = strtolower($ext);
    if (!empty($filename)) {
        //File extension check
        if (in_array($ext, $valid_formats)) {
            $main_path = ROOTPATH . "/storage/menu/";
            $filename = uniqid(time()) . '.' . $ext;
            if (move_uploaded_file($file['tmp_name'], $main_path . $filename)) {
                $MainFileName = $filename;
                // resizeImage(600, $main_path . $filename, $main_path . $filename);
            } else {
                $result['success'] = false;
                $result['message'] = $lang['ERROR_IMAGE'];
                die(json_encode($result));
            }
        } else {
            $result['success'] = false;
            $result['message'] = $lang['ONLY_JPG_ALLOW'];
            die(json_encode($result));
        }
    }
    /*End Item Logo Image Uploading*/

    if (trim($title) != '' && is_string($title)) {
        if (!empty($_POST['id'])) {
            $insert_menu = ORM::for_table($config['db']['pre'] . 'image_menu')->find_one($_POST['id']);
        } else {
            $insert_menu = ORM::for_table($config['db']['pre'] . 'image_menu')->create();
        }

        $insert_menu->active = isset($_POST['active']) ? '1' : '0';
        $insert_menu->user_id = validate_input($_SESSION['user']['id']);
        $insert_menu->name = $title;
        if ($MainFileName) {
            $insert_menu->image = $MainFileName;
        }
        $insert_menu->save();

        $menu_id = $insert_menu->id();

        if ($menu_id) {
            $result['success'] = true;
            $result['message'] = $lang['SAVED_SUCCESS'];
        } else {
            $result['success'] = false;
            $result['message'] = $lang['ERROR_TRY_AGAIN'];
        }
    } else {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
    }
    die(json_encode($result));
}

function get_image_menu()
{
    global $config;
    $result = ORM::for_table($config['db']['pre'] . 'image_menu')
        ->where('user_id', $_SESSION['user']['id'])
        ->find_one($_GET['id']);

    $response = array('success' => false);
    if (!empty($result)) {
        $response['success'] = true;
        $response['name'] = $result['name'];
        $response['active'] = $result['active'];
        $response['image'] = !empty($result['image'])
            ? $config['site_url'] . 'storage/menu/' . $result['image']
            : $config['site_url'] . 'storage/menu/' . 'default.png';
    }
    die(json_encode($response));
}

function delete_image_menu()
{
    global $lang, $config;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }
    $id = $_GET['id'];
    if (trim($id) != '') {
        $data = ORM::for_table($config['db']['pre'] . 'image_menu')
            ->where(array(
                'id' => $id,
                'user_id' => $_SESSION['user']['id'],
            ))
            ->delete_many();

        if ($data) {
            $result['success'] = true;
            $result['message'] = $lang['MENU_DELETED'];
        } else {
            $result['success'] = false;
            $result['message'] = $lang['ERROR_TRY_AGAIN'];
        }
    } else {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
    }
    die(json_encode($result));
}

function updateMenuPosition()
{
    global $config, $lang;
    $con = ORM::get_db();
    $position = $_POST['position'];
    if (is_array($position)) {
        foreach ($position as $key => $id) {
            $query = "UPDATE `" . $config['db']['pre'] . "menu` SET `position` = '" . $key . "' WHERE `id` = '" . $id . "'";
            $con->query($query);
        }

        $result['success'] = true;
        $result['message'] = $lang['POSITION_UPDATED'];
    } else {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
    }
    die(json_encode($result));
}

function updateExtrasPosition()
{
    global $config, $lang;
    $con = ORM::get_db();
    $position = $_POST['position'];
    if (is_array($position)) {
        foreach ($position as $key => $id) {
            $query = "UPDATE `" . $config['db']['pre'] . "menu_extras` SET `position` = '" . $key . "' WHERE `id` = '" . $id . "'";
            $con->query($query);
        }

        $result['success'] = true;
        $result['message'] = $lang['POSITION_UPDATED'];
    } else {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
    }
    die(json_encode($result));
}

function updateImageMenuPosition()
{
    global $config, $lang;
    $con = ORM::get_db();
    $position = $_POST['position'];
    if (is_array($position)) {
        foreach ($position as $key => $id) {
            $query = "UPDATE `" . $config['db']['pre'] . "image_menu` SET `position` = '" . $key . "' WHERE `id` = '" . $id . "'";
            $con->query($query);
        }

        $result['success'] = true;
        $result['message'] = $lang['POSITION_UPDATED'];
    } else {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
    }
    die(json_encode($result));
}
function getShopId()
{
    global $config;
    $shop = ORM::for_table($config['db']['pre'] . 'shop')
        ->where('id', $_SESSION['user']['shop_id'])
        ->find_one();
    return $shop['id'];
}


function addNewCat()
{
    global $config, $lang;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }

    $name = validate_input($_POST['name']);
    if (trim($name) != '' && is_string($name)) {
        //check menu exits
        $info = ORM::for_table($config['db']['pre'] . 'catagory_main')
            ->where(array('shop_id' => $_SESSION['user']['shop_id'], 'cat_name' => $name))
            ->count();
        if ($info == 0) {
            require('ctrls/bo/CFr3eGoogl3Translat3.class.php');
            require('ctrls/lib/request.lib.php');
            //$user_lang = !empty($_COOKIE['Quick_user_lang_code']) ? $_COOKIE['Quick_user_lang_code'] : $config['lang_code'];
            $user_lang = $config['lang_code'];
            $insert_category = ORM::for_table($config['db']['pre'] . 'catagory_main')->create();            
            $json = array();
            $tr = new CFr3eGoogl3Translat3();
            $langs = JsonHelper::getActiveLangCodes();
            $pos = array_search($user_lang, $langs);
            if($pos !== false) unset($langs[$pos]);
            foreach($langs as $desc_lang){
                $json[$desc_lang] = array('title' => $tr->translate($user_lang, $desc_lang, $name));
            }
            $json[$user_lang]['title'] = $name;
                  
            
            $insert_category->cat_name = $user_lang=='de' ? $name : $json['de']['title'];
            $insert_category->shop_id = $_SESSION['user']['shop_id'];
            $insert_category->translation = json_encode($json, JSON_UNESCAPED_UNICODE);
            $insert_category->save();

            $category_id = $insert_category->id();

            if ($category_id) {
                $result['success'] = true;
                $result['message'] = $lang['SAVED_SUCCESS'];
            } else {
                $result['success'] = false;
                $result['message'] = $lang['ERROR_TRY_AGAIN'];
            }
        } else {
            $result['success'] = false;
            $result['message'] = $lang['SERVICE_GROUP_NAME_ALREADY_EXIST'];
        }
    } else {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
    }
    die(json_encode($result));
}










function checkDiscountCode()
{
    global $config, $lang;
    $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
    ->where('slug', $_POST['slug'])->find_one();
    if (!checkcustomerloggedin($restaurant['id'])) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }
    if (!empty($_POST['discount_code'])) {
       
        $discount_code = trim($_POST['discount_code']);
        $quickqr_action = $_POST['quickqr_action'];
        $order_type_coupon = 'online';
        $order_type_order_table = array('takeaway', 'delivery');
        if ($quickqr_action == "on-table-action") {
            $order_type_coupon = 'on-table';
            $order_type_order_table = array('on-table');
        }
        // check discount code exists
        $coupon = ORM::for_table($config['db']['pre'] . 'coupons')
            ->where(array(
                'code' => $discount_code,
                'order_type' => $order_type_coupon,
                'restaurant_id' => $restaurant['id']
            ))
            ->find_one();
        if (!empty($coupon['id'])) {
            if(!empty($_POST['date']))
            {
                $date = date('Y-m-d',strtotime($_POST['date']));
            }
            else
            {
                $date = date('Y-m-d');
            }
         
            $id_customer = $_SESSION['customer']['id'];
            $date_expired = $coupon['date_expired'];
            $discount_price  = $coupon['discount'];
            if ($coupon['status'] == "0") {
                $result['success'] = false;
                $result['message'] = $lang['DISCOUNT_CODE_DOES_NOT_EXIST'];
                die(json_encode($result));
            }
            if ($date > $date_expired) {
                $result['success'] = false;
                $result['message'] = $lang['COUPON_CODE_WILL_EXPIRE_ON'] . ' ' . date('d-m-Y', strtotime($date_expired));
                die(json_encode($result));
            }
            // kiem tra khach hang da su dung ma nay chua
            $count = ORM::for_table($config['db']['pre'] . 'orders')
                ->where(array(
                    'coupons_code' => $discount_code,
                    'customer_id' => $id_customer,
                    'restaurant_id' => $restaurant['id']
                ))
                ->where_in('type', $order_type_order_table)
                ->count();
            if ($count == 1) {
                $result['success'] = false;
                $result['message'] = $lang['DISCOUNT_CODE_ALREADY_USED'];
                die(json_encode($result));
            } else {
                $reserve_id = $_POST['reserve_id'];
                $reserve_count = 0;

                //reserve table
                if (!empty($reserve_id) || substr($reserve_id, -4) == "-new") {
                    $reserve_count = ORM::for_table($config['db']['pre'] . 'reserve')
                        ->where(array(
                            'coupons_code' => $discount_code,
                            'customer_id' => $id_customer,
                            'restaurant_id' => $restaurant['id']
                        ))
                        ->count();
                } else {
                    $reserve_count = ORM::for_table($config['db']['pre'] . 'reserve')
                        ->where(array(
                            'coupons_code' => $discount_code,
                            'customer_id' => $id_customer,
                            'restaurant_id' => $restaurant['id']
                        ))
                        ->where_not_equal('id', $reserve_id)
                        ->count();
                }

                if ($reserve_count == 1) {
                    $result['success'] = false;
                    $result['message'] = $lang['DISCOUNT_CODE_ALREADY_USED'];
                    die(json_encode($result));
                }

                $result['success'] = true;
                $result['discount_price'] = $discount_price;
            }
        } else {
            $result['success'] = false;
            $result['message'] = $lang['DISCOUNT_CODE_DOES_NOT_EXIST'];
        }
    } else {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
    }
    die(json_encode($result));
}


function deleteGroupImage()
{
    global $config, $lang;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }

    $id = $_POST['id'];
    if (!empty($id)) {
        ORM::for_table($config['db']['pre'] . 'shop_image')
        ->where('group_id', $id)
        ->delete_many();
        ORM::for_table($config['db']['pre'] . 'shop_image_group')
            ->where('id', $id)
            ->delete_many();
        $result['success'] = true;
        $result['message'] = '';
    } else {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
    }
    die(json_encode($result));
}

function deleteOnTableCoupon()
{
    global $config, $lang;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }

    $id = $_POST['id'];
    if (!empty($id)) {
        ORM::for_table($config['db']['pre'] . 'coupons')
            ->where('id', $id)
            ->delete_many();
        $result['success'] = true;
        $result['message'] = '';
    } else {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
    }
    die(json_encode($result));
}

function deleteOnlineCoupon()
{
    global $config, $lang;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }

    $id = $_POST['id'];
    if (!empty($id)) {
        ORM::for_table($config['db']['pre'] . 'coupons')
            ->where('id', $id)
            ->delete_many();
        $result['success'] = true;
        $result['message'] = '';
    } else {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
    }
    die(json_encode($result));
}



function changeOnOffFooterImage()
{
    global $config, $lang;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }
    $shop_id = getShopId();
    $active = $_POST['active'];
    update_shop_option($shop_id, 'shop_open_footer_image', $active);
    $result['success'] = true;
    $result['message'] = $lang['SAVED_SUCCESS'];    
    die(json_encode($result));
}

function changeOnOffOpenBanner()
{
    global $config, $lang;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }
    $shop_id = getShopId();
    $active = $_POST['active'];
    update_shop_option($shop_id, 'shop_open_banner', $active);
    $result['success'] = true;
    $result['message'] = $lang['SAVED_SUCCESS'];    
    die(json_encode($result));
}


function changeTimerImage()
{
    global $config, $lang;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }
    $shop_id = getShopId();

    if($_POST['timer_for'] == "timer_cover_image")
    {
      update_shop_option($shop_id, 'timer_cover_image', $_POST['timer']);
    } 
    else if($_POST['timer_for'] == "timer_footer_image")
    {
        update_shop_option($shop_id, 'timer_footer_image', $_POST['timer']);
    }

    $result['success'] = true;
    $result['message'] = $lang['SAVED_SUCCESS'];    
    die(json_encode($result));
}



function changeGroupImageActive()
{
    global $config, $lang;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }
    $active = $_POST['active'];
    $id = $_POST['id'];
        $update_shop_image_group = ORM::for_table($config['db']['pre'] . 'shop_image_group')->where('id',$id)->find_one();
        $update_shop_image_group->active = $active;
        $update_shop_image_group->save();
        $result['success'] = true;
        $result['message'] = $lang['SAVED_SUCCESS'];    
    die(json_encode($result));
}


function editGroupImageName()
{
    global $config, $lang;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }
    $shop_id = getShopId();
    $group_name = $_POST['group_name'];
    if (empty($group_name)) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }
    //check exist
    $count = ORM::for_table($config['db']['pre'] . 'shop_image_group')
        ->where(array(
            'name' => $group_name,
            'shop_id' => $shop_id
        ))
        ->where_not_equal('id', $_POST['id'])
        ->count();
    if ($count == 0) {
        require('ctrls/bo/CFr3eGoogl3Translat3.class.php');
        $ggtl = new CFr3eGoogl3Translat3();
        $user_lang = $config['lang_code'];

        $update_shop_image_group = ORM::for_table($config['db']['pre'] . 'shop_image_group')->where('id',$_POST['id'])->find_one();

        $json = json_decode($update_shop_image_group['translation'], true);            
        if($user_lang=='de'){
            $json['en'] = array('title' => $ggtl->translate('en', 'de', $group_name));
            $json['vi'] = array('title' => $ggtl->translate('en', 'vi', $group_name));
            $json['de'] = array('title' => $group_name);
            $update_shop_image_group->name = $group_name;
        }else{
            $json[$user_lang] = array('title' => $group_name);
        }

        //$update_shop_image_group->name = $group_name;
        $update_shop_image_group->translation = json_encode($json, JSON_UNESCAPED_UNICODE);
        $update_shop_image_group->save();

            $result['success'] = true;
            $result['message'] = $lang['SAVED_SUCCESS'];
        
    } else {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_COUPON_CODE_EXISTS'];
    }
    die(json_encode($result));
}


function addGroupImageName()
{
    global $config, $lang;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }
    $shop_id = getShopId();
    $group_name = $_POST['group_name'];
    if (empty($group_name)) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }
    //check exist
    $count = ORM::for_table($config['db']['pre'] . 'shop_image_group')
        ->where(array(
            'name' => $group_name,
            'shop_id' => $shop_id
        ))->count();
    if ($count == 0) {
        $insert_shop_image_group = ORM::for_table($config['db']['pre'] . 'shop_image_group')->create();

        require('ctrls/bo/CFr3eGoogl3Translat3.class.php');
        require('ctrls/lib/request.lib.php');
        $ggtl = new CFr3eGoogl3Translat3();
        $user_lang = $config['lang_code'];

        $json = array();
        $langs = JsonHelper::getActiveLangCodes();
        $pos = array_search($user_lang, $langs);
        if($pos !== false) unset($langs[$pos]);
        foreach($langs as $desc_lang){
            $json[$desc_lang] = array('title' => $ggtl->translate($user_lang, $desc_lang, $group_name));
        }
        if($user_lang=='de'){            
            $insert_shop_image_group->name = $group_name;
        }else{
            $json[$user_lang]['title'] = $group_name;
            $insert_shop_image_group->name = $json['de']['title'];
        }
        
        $insert_shop_image_group->shop_id = $shop_id;
        $insert_shop_image_group->active = 1;
        $insert_shop_image_group->translation = json_encode($json, JSON_UNESCAPED_UNICODE);
        $insert_shop_image_group->save();
        $insert_shop_image_group_id = $insert_shop_image_group->id();

        if ($insert_shop_image_group_id) {
            $result['success'] = true;
            $result['message'] = $lang['SAVED_SUCCESS'];
        } else {
            $result['success'] = false;
            $result['message'] = $lang['ERROR_TRY_AGAIN'];
        }
    } else {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_COUPON_CODE_EXISTS'];
    }
    die(json_encode($result));
}




function addNewOpenHour()
{
    global $config, $lang;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }
    $shop_id = getShopId();
    $day_of_week = $_POST['day_of_week'];
    $open_time = $_POST['open_time'];
    $close_time = $_POST['close_time'];
    $open_time_2 = $_POST['open_time_2'];
    $close_time_2 = $_POST['close_time_2'];
  
    //check exist open_hour
    $count = ORM::for_table($config['db']['pre'] . 'open_close_hour')
        ->where(array(
            'day_of_week' => $day_of_week,
            'shop_id' => $shop_id
        ))->count();
    if ($count == 0) {
        $insert_open_hour = ORM::for_table($config['db']['pre'] . 'open_close_hour')->create();
        $insert_open_hour->day_of_week = $day_of_week;
        $insert_open_hour->open_hour = $open_time;
        $insert_open_hour->close_hour = $close_time;
        $insert_open_hour->shop_id = $shop_id;
        $insert_open_hour->open_hour_2 = $open_time_2;
        $insert_open_hour->close_hour_2 = $close_time_2;
        $insert_open_hour->save();

        $open_hour_id = $insert_open_hour->id();

        if ($open_hour_id) {
            $result['success'] = true;
            $result['message'] = $lang['SAVED_SUCCESS'];
        } else {
            $result['success'] = false;
            $result['message'] = $lang['ERROR_TRY_AGAIN'];
        }
    } else {
        $result['success'] = false;
        $result['message'] = $lang['DAY_OF_WEEK_ALREADY_EXISTS'];
    }


    die(json_encode($result));
}

function editOpenHour()
{
    global $lang, $config;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }
    $shop_id = getShopId();
    $day_of_week = $_POST['day_of_week'];
    $open_time = $_POST['open_time'];
    $close_time = $_POST['close_time'];
    $open_time_2 = $_POST['open_time_2'];
    $close_time_2 = $_POST['close_time_2'];
    $id = validate_input($_POST['id']);
    if (trim($id) != '') {
          //check exist open_hour
    $count = ORM::for_table($config['db']['pre'] . 'open_close_hour')
    ->where(array(
        'day_of_week' => $day_of_week,
        'shop_id' => $shop_id
    ))
    ->where_not_equal('id',$id)
    ->count();
if ($count == 0) {
    $open_hour_update = ORM::for_table($config['db']['pre'] . 'open_close_hour')
    ->use_id_column('id')
    ->where(array(
        'shop_id' => $shop_id,
        'id' => $id
    ))
    ->find_one();
$open_hour_update->set('day_of_week', $day_of_week);
$open_hour_update->set('open_hour', $open_time);
$open_hour_update->set('close_hour', $close_time);
$open_hour_update->set('shop_id', $shop_id);
$open_hour_update->set('open_hour_2', $open_time_2);
$open_hour_update->set('close_hour_2', $close_time_2);
$open_hour_update->save();

$result['success'] = true;
$result['message'] = $lang['SAVED_SUCCESS'];
}
else
{
    $result['success'] = false;
    $result['message'] = $lang['DAY_OF_WEEK_ALREADY_EXISTS'];
}
 
    } else {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
    }
    die(json_encode($result));
}




function editCat()
{
    global $lang, $config;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }
    $name = validate_input($_POST['name']);
    $id = validate_input($_POST['id']);
    if (trim($name) != '' && is_string($name) && trim($id) != '') {
        $info = ORM::for_table($config['db']['pre'] . 'catagory_main')
            ->where(array('shop_id' => $_SESSION['user']['shop_id'], 'cat_name' => $name))
            ->where_not_equal('cat_id', $id)
            ->find_one();
        if (empty($info)) {
            $catagory_update = ORM::for_table($config['db']['pre'] . 'catagory_main')
                ->use_id_column('cat_id')
                ->where(array(
                    'shop_id' => $_SESSION['user']['shop_id'],
                    'cat_id' => $id
                ))
                ->find_one();

            //$user_lang = !empty($_COOKIE['Quick_user_lang_code']) ? $_COOKIE['Quick_user_lang_code'] : $config['lang_code'];
            $user_lang = $config['lang_code'];
            $json = json_decode($catagory_update['translation'], true);            
            if($user_lang=='de'){
                require('ctrls/bo/CFr3eGoogl3Translat3.class.php');    
                require('ctrls/lib/request.lib.php');
                $tr = new CFr3eGoogl3Translat3();
                $langs = JsonHelper::getActiveLangCodes();
                foreach($langs as $langCode){
                    if($langCode=='de') continue;
                    $json[$langCode] = array('title' => $tr->translate('de', $langCode, $name));    
                }                
                $json['de'] = $name;
                $catagory_update->set('cat_name', $name);
            }else{
                $json[$user_lang] = array('title' => $name);
            }

            $catagory_update->set('translation', json_encode($json, JSON_UNESCAPED_UNICODE));
            $catagory_update->save();

            $result['success'] = true;
            $result['message'] = $lang['SAVED_SUCCESS'];
        } else {
            $result['success'] = false;
            $result['message'] = $lang['SERVICE_GROUP_NAME_ALREADY_EXIST'];
        }
    } else {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
    }
    die(json_encode($result));
}
function deleteOpenHour()
{
    global $lang, $config;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }
    $id = validate_input($_POST['id']);
    if (trim($id) != '') {

        $data = ORM::for_table($config['db']['pre'] . 'open_close_hour')
            ->where(array(
                'id' => $id
            ))
            ->delete_many();

        if ($data) {
            $result['success'] = true;
            $result['message'] = $lang['OPEN_HOUR_DELETED'];
        } else {
            $result['success'] = false;
            $result['message'] = $lang['ERROR_TRY_AGAIN'];
        }
    } else {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
    }
    die(json_encode($result));
}

function deleteCat()
{
    global $lang, $config;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }
    $id = validate_input($_POST['id']);
    if (trim($id) != '') {
        // kiểm tra còn món trong nhóm
        $total_menu = ORM::for_table($config['db']['pre'] . 'menu')
            ->where(array(
                'shop_id' => $_SESSION['user']['shop_id'],
                'cat_id' => $id
            ))
            ->count();
        if ($total_menu > 0) {
            $result['success'] = false;
            $result['message'] = $lang['THERE_ARE_STILL_SERVICE_IN_THE_SERVICE_GROUP'];
            die(json_encode($result));
        }
        $data = ORM::for_table($config['db']['pre'] . 'catagory_main')
            ->where(array(
                'shop_id' => $_SESSION['user']['shop_id'],
                'cat_id' => $id
            ))
            ->delete_many();

        if ($data) {
            $result['success'] = true;
            $result['message'] = $lang['SERVICE_GROUP_DELETED'];
        } else {
            $result['success'] = false;
            $result['message'] = $lang['ERROR_TRY_AGAIN'];
        }
    } else {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
    }
    die(json_encode($result));
}

function addNewSubCat()
{
    global $config, $lang;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }

    $name = validate_input($_POST['name']);
    $cat_id = validate_input($_POST['cat_id']);
    if (!empty($cat_id) && (trim($name) != '' && is_string($name))) {
        $info = ORM::for_table($config['db']['pre'] . 'catagory_main')
            ->where(array('shop_id' => $_SESSION['user']['shop_id'], 'cat_name' => $name))
            ->find_one();
        if (empty($info)) {
            $user_lang = !empty($_COOKIE['Quick_user_lang_code']) ? $_COOKIE['Quick_user_lang_code'] : $config['lang_code'];
            $json = array();
            $json[$user_lang] = array('title' => $name);

            $insert_category = ORM::for_table($config['db']['pre'] . 'catagory_main')->create();
            $insert_category->cat_name = $name;
            $insert_category->parent = $cat_id;
            $insert_category->shop_id = $_SESSION['user']['shop_id'];
            $insert_category->translation = json_encode($json, JSON_UNESCAPED_UNICODE);
            $insert_category->save();

            $category_id = $insert_category->id();

            if ($category_id) {
                $result['success'] = true;
                $result['message'] = $lang['SAVED_SUCCESS'];
            } else {
                $result['success'] = false;
                $result['message'] = $lang['ERROR_TRY_AGAIN'];
            }
        } else {
            $result['success'] = false;
            $result['message'] = $lang['SERVICE_GROUP_NAME_ALREADY_EXIST'];
        }
    } else {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
    }
    die(json_encode($result));
}

function editSubCat()
{
    global $lang, $config;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }

    $name = validate_input($_POST['name']);
    $cat_id = validate_input($_POST['cat_id']);
    $id = validate_input($_POST['id']);

    if (trim($name) != '' && is_string($name) && trim($id) != '') {
        $info = ORM::for_table($config['db']['pre'] . 'catagory_main')
            ->where(array('shop_id' => $_SESSION['user']['shop_id'], 'cat_name' => $name))
            ->where_not_equal('cat_id', $id)
            ->find_one();
        if (empty($info)) {
            $catagory_update = ORM::for_table($config['db']['pre'] . 'catagory_main')
                ->use_id_column('cat_id')
                ->where(array(
                    'shop_id' => $_SESSION['user']['shop_id'],
                    'cat_id' => $id
                ))
                ->find_one();
            $user_lang = !empty($_COOKIE['Quick_user_lang_code']) ? $_COOKIE['Quick_user_lang_code'] : $config['lang_code'];
            $json = json_decode($catagory_update['translation'], true);
            $json[$user_lang] = array('title' => $name);

            $catagory_update->set('translation', json_encode($json, JSON_UNESCAPED_UNICODE));
            $catagory_update->set('parent', validate_input($cat_id));
            $catagory_update->save();
            $result['success'] = true;
            $result['message'] = $lang['SAVED_SUCCESS'];
        } else {
            $result['success'] = false;
            $result['message'] = $lang['SERVICE_GROUP_NAME_ALREADY_EXIST'];
        }
    } else {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
    }
    die(json_encode($result));
}

function deleteSubCat()
{
    global $lang, $config;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }
    $id = validate_input($_POST['id']);
    if (trim($id) != '') {
        $data = ORM::for_table($config['db']['pre'] . 'catagory_main')
            ->where(array(
                'shop_id' => getShopId(),
                'cat_id' => $id
            ))->delete_many();

        if ($data) {
            $result['success'] = true;
            $result['message'] = $lang['SUBCATEGORY_DELETED'];
        } else {
            $result['success'] = false;
            $result['message'] = $lang['ERROR_TRY_AGAIN'];
        }
    } else {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
    }
    die(json_encode($result));
}

function updateCatPosition()
{
    global $config, $lang;
    $con = ORM::get_db();
    $position = $_POST['position'];
    if (is_array($position)) {
        foreach ($position as $key => $catid) {
            $query = "UPDATE `" . $config['db']['pre'] . "catagory_main` SET `cat_order` = '" . $key . "' WHERE `cat_id` = '" . $catid . "'";
            $con->query($query);
        }

        $result['success'] = true;
        $result['message'] = $lang['POSITION_UPDATED'];
    } else {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
    }
    die(json_encode($result));
}

function updateSubCatPosition()
{
    global $config, $lang;
    $con = ORM::get_db();
    $position = $_POST['position'];
    if (is_array($position)) {
        foreach ($position as $key => $catid) {
            $query = "UPDATE `" . $config['db']['pre'] . "catagory_main` SET `cat_order` = '" . $key . "' WHERE `cat_id` = '" . $catid . "'";
            $con->query($query);
        }

        $result['success'] = true;
        $result['message'] = $lang['POSITION_UPDATED'];
    } else {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
    }
    die(json_encode($result));
}

function addProperties()
{
    global $config, $lang;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }

    $aliases = validate_input($_POST['properties-aliases']);
    $name = validate_input($_POST['properties-name']);

    if (trim($aliases) == '' || empty($aliases)) {
        $result['success'] = false;
        $result['message'] = $lang['ALL_FIELDS_REQ'];
        die(json_encode($result));
    }

    if (trim($name) == '' || empty($name)) {
        $result['success'] = false;
        $result['message'] = $lang['ALL_FIELDS_REQ'];
        die(json_encode($result));
    }
    $image = '';
    if (isset($_POST['icon-name'])) {
        $image = validate_input($_POST['icon-name']);
    }
    $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
        ->where('user_id', $_SESSION['user']['id'])
        ->find_one();

    $info = ORM::for_table($config['db']['pre'] . 'properties')
        ->where(array('restaurant_id' => $restaurant['id']))
        ->where_any_is(array(array('properties_aliases' => $aliases), array('properties_name' => $name)))
        ->find_one();
    $info2 = ORM::for_table($config['db']['pre'] . 'properties')
        ->where(array('is_default' => "1"))
        ->where_any_is(array(array('properties_aliases' => $aliases), array('properties_name' => $name)))
        ->find_one();

    if (empty($info) && empty($info2)) {

        $insert = ORM::for_table($config['db']['pre'] . 'properties')->create();
        $insert->properties_aliases = $aliases;
        $insert->properties_name = $name;
        $insert->restaurant_id = $restaurant['id'];
        $insert->image = $image;
        $insert->is_default = '0';
        $insert->save();

        $id = $insert->id();

        if ($id) {
            $result['success'] = true;
            $result['message'] = $lang['SAVED_SUCCESS'];
        } else {
            $result['success'] = false;
            $result['message'] = $lang['ERROR_TRY_AGAIN'];
        }
    } else {
        $result['success'] = false;
        $result['message'] = $lang['EXIST_PROPERTIES'];
    }



    die(json_encode($result));
}

function addAdditives()
{
    global $config, $lang;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }

    $aliases = validate_input($_POST['additives-aliases']);
    $name = validate_input($_POST['additives-name']);

    if (trim($aliases) == '' || empty($aliases)) {
        $result['success'] = false;
        $result['message'] = $lang['ALL_FIELDS_REQ'];
        die(json_encode($result));
    }

    if (trim($name) == '' || empty($name)) {
        $result['success'] = false;
        $result['message'] = $lang['ALL_FIELDS_REQ'];
        die(json_encode($result));
    }
    $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
        ->where('user_id', $_SESSION['user']['id'])
        ->find_one();
    //Check exist 
    $info = ORM::for_table($config['db']['pre'] . 'additives')
        ->where(array('restaurant_id' => $restaurant['id']))
        ->where_any_is(array(array('additives_aliases' => $aliases), array('additives_name' => $name)))
        ->find_one();
    $info2 = ORM::for_table($config['db']['pre'] . 'additives')
        ->where(array('is_default' => "1"))
        ->where_any_is(array(array('additives_aliases' => $aliases), array('additives_name' => $name)))
        ->find_one();

    if (empty($info) && empty($info2)) {

        $insert = ORM::for_table($config['db']['pre'] . 'additives')->create();
        $insert->additives_aliases = $aliases;
        $insert->additives_name = $name;
        $insert->restaurant_id = $restaurant['id'];
        $insert->is_default = '0';
        $insert->save();
        $id = $insert->id();
        if ($id) {
            $result['success'] = true;
            $result['message'] = $lang['SAVED_SUCCESS'];
        } else {
            $result['success'] = false;
            $result['message'] = $lang['ERROR_TRY_AGAIN'];
        }
    } else {
        $result['success'] = false;
        $result['message'] = $lang['EXIST_ADDITIVES'];
    }
    die(json_encode($result));
}

function addAllegie()
{
    global $config, $lang;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }

    $aliases = validate_input($_POST['allegie-aliases']);
    $name = validate_input($_POST['allegie-name']);

    if (trim($aliases) == '' || empty($aliases)) {
        $result['success'] = false;
        $result['message'] = $lang['ALL_FIELDS_REQ'];
        die(json_encode($result));
    }

    if (trim($name) == '' || empty($name)) {
        $result['success'] = false;
        $result['message'] = $lang['ALL_FIELDS_REQ'];
        die(json_encode($result));
    }
    $image = '';
    if (isset($_POST['icon-name'])) {
        $image = validate_input($_POST['icon-name']);
    }
    $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
        ->where('user_id', $_SESSION['user']['id'])
        ->find_one();
    //Check exist allegie
    $info = ORM::for_table($config['db']['pre'] . 'allegie')
        ->where(array('restaurant_id' => $restaurant['id']))
        ->where_any_is(array(array('alle_aliases' => $aliases), array('alle_name' => $name)))
        ->find_one();

    $info2 = ORM::for_table($config['db']['pre'] . 'allegie')
        ->where(array('is_default' => "1"))
        ->where_any_is(array(array('alle_aliases' => $aliases), array('alle_name' => $name)))
        ->find_one();

    if (empty($info) && empty($info2)) {

        $insert = ORM::for_table($config['db']['pre'] . 'allegie')->create();
        $insert->alle_aliases = $aliases;
        $insert->alle_name = $name;
        $insert->restaurant_id = $restaurant['id'];
        $insert->image = $image;
        $insert->is_default = '0';
        $insert->save();
        $id = $insert->id();

        if ($id) {
            $result['success'] = true;
            $result['message'] = $lang['SAVED_SUCCESS'];
        } else {
            $result['success'] = false;
            $result['message'] = $lang['ERROR_TRY_AGAIN'];
        }
    } else {
        $result['success'] = false;
        $result['message'] = $lang['EXIST_ALLEGIE'];
    }



    die(json_encode($result));
}

function addMenuExtra()
{
    global $config, $lang;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }

    $title = validate_input($_POST['title']);
    $price = validate_input($_POST['price']);
    $menu_id = validate_input($_POST['menu_id']);
    $extra_option = validate_input($_POST['extra_option']);

    if (trim($menu_id) == '' || empty($menu_id)) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }

    if (trim($title) == '' || empty($title)) {
        $result['success'] = false;
        $result['message'] = $lang['ALL_FIELDS_REQ'];
        die(json_encode($result));
    }

    if (trim($price) == '' || empty($price)) {
        $result['success'] = false;
        $result['message'] = $lang['ALL_FIELDS_REQ'];
        die(json_encode($result));
    }

    $user_lang = !empty($_COOKIE['Quick_user_lang_code']) ? $_COOKIE['Quick_user_lang_code'] : $config['lang_code'];
    $json = array();
    $json[$user_lang] = array('title' => $title);

    $insert = ORM::for_table($config['db']['pre'] . 'menu_extras')->create();
    $insert->title = validate_input($title);
    $insert->price = validate_input($price);
    $insert->extra_option = $extra_option;
    $insert->translation = json_encode($json, JSON_UNESCAPED_UNICODE);
    $insert->menu_id = $menu_id;
    $insert->save();

    $id = $insert->id();

    if ($id) {
        $result['success'] = true;
        $result['message'] = $lang['SAVED_SUCCESS'];
    } else {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
    }

    die(json_encode($result));
}

function editAdditives()
{
    global $config, $lang;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }

    $aliases = validate_input($_POST['additives_aliases']);
    $name = validate_input($_POST['additives_name']);
    $id = validate_input($_POST['id']);
    if (trim($id) == '' || empty($id)) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }

    if (trim($aliases) == '' || empty($aliases)) {
        $result['success'] = false;
        $result['message'] = $lang['ALL_FIELDS_REQ'];
        die(json_encode($result));
    }

    if (trim($name) == '' || empty($name)) {
        $result['success'] = false;
        $result['message'] = $lang['ALL_FIELDS_REQ'];
        die(json_encode($result));
    }
    $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
        ->where('user_id', $_SESSION['user']['id'])
        ->find_one();


    $check_info2 = ORM::for_table($config['db']['pre'] . 'additives')
        ->where(array('is_default' => "1"))
        ->where_any_is(array(array('additives_aliases' => $aliases), array('additives_name' => $name)))
        ->find_one();


    $info = ORM::for_table($config['db']['pre'] . 'additives')
        ->where(array('restaurant_id' => $restaurant['id']))
        ->where_not_equal('id', $id)
        ->where_any_is(array(array('additives_aliases' => $aliases), array('additives_name' => $name)))
        ->find_one();
    $info2 = ORM::for_table($config['db']['pre'] . 'additives')
        ->where(array('is_default' => "1"))
        ->where_any_is(array(array('additives_aliases' => $aliases), array('additives_name' => $name)))
        ->find_one();

    if (empty($info) && empty($info2)) {

        $insert = ORM::for_table($config['db']['pre'] . 'additives')->find_one($id);
        $insert->additives_aliases = $aliases;
        $insert->additives_name = $name;
        $insert->restaurant_id = $restaurant['id'];
        $insert->is_default = '0';
        $insert->save();
        $result['success'] = true;
        $result['message'] = $lang['SAVED_SUCCESS'];
    } else {
        $result['success'] = false;
        $result['message'] = $lang['EXIST_ADDITIVES'];
    }
    die(json_encode($result));
}

function editProperties()
{
    global $config, $lang;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }

    $aliases = validate_input($_POST['properties_aliases']);
    $name = validate_input($_POST['properties_name']);
    $id = validate_input($_POST['id']);
    $image = '';
    if (isset($_POST['icon-name'])) {
        $image = validate_input($_POST['icon-name']);
    }

    if (trim($id) == '' || empty($id)) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }

    if (trim($aliases) == '' || empty($aliases)) {
        $result['success'] = false;
        $result['message'] = $lang['ALL_FIELDS_REQ'];
        die(json_encode($result));
    }

    if (trim($name) == '' || empty($name)) {
        $result['success'] = false;
        $result['message'] = $lang['ALL_FIELDS_REQ'];
        die(json_encode($result));
    }
    $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
        ->where('user_id', $_SESSION['user']['id'])
        ->find_one();
    $info = ORM::for_table($config['db']['pre'] . 'properties')
        ->where(array('restaurant_id' => $restaurant['id']))
        ->where_not_equal('id', $id)
        ->where_any_is(array(array('properties_aliases' => $aliases), array('properties_name' => $name)))
        ->find_one();
    $info2 = ORM::for_table($config['db']['pre'] . 'properties')
        ->where(array('is_default' => "1"))
        ->where_any_is(array(array('properties_aliases' => $aliases), array('properties_name' => $name)))
        ->find_one();

    if (empty($info) && empty($info2)) {

        $insert = ORM::for_table($config['db']['pre'] . 'properties')->find_one($id);
        $insert->properties_aliases = $aliases;
        $insert->properties_name = $name;
        $insert->restaurant_id = $restaurant['id'];
        $insert->is_default = '0';
        $insert->image = $image;
        $insert->save();
        $result['success'] = true;
        $result['message'] = $lang['SAVED_SUCCESS'];
    } else {
        $result['success'] = false;
        $result['message'] = $lang['EXIST_PROPERTIES'];
    }
    die(json_encode($result));
}
function editAllegie()
{
    global $config, $lang;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }

    $aliases = validate_input($_POST['alle_aliases']);
    $name = validate_input($_POST['alle_name']);
    $id = validate_input($_POST['id']);
    $image = '';
    if (isset($_POST['icon-name'])) {
        $image = validate_input($_POST['icon-name']);
    }

    if (trim($id) == '' || empty($id)) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }

    if (trim($aliases) == '' || empty($aliases)) {
        $result['success'] = false;
        $result['message'] = $lang['ALL_FIELDS_REQ'];
        die(json_encode($result));
    }

    if (trim($name) == '' || empty($name)) {
        $result['success'] = false;
        $result['message'] = $lang['ALL_FIELDS_REQ'];
        die(json_encode($result));
    }
    $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
        ->where('user_id', $_SESSION['user']['id'])
        ->find_one();
    $info = ORM::for_table($config['db']['pre'] . 'allegie')
        ->where(array('restaurant_id' => $restaurant['id']))
        ->where_not_equal('id', $id)
        ->where_any_is(array(array('alle_aliases' => $aliases), array('alle_name' => $name)))
        ->find_one();
    $info2 = ORM::for_table($config['db']['pre'] . 'allegie')
        ->where(array('is_default' => "1"))
        ->where_any_is(array(array('alle_aliases' => $aliases), array('alle_name' => $name)))
        ->find_one();

    if (empty($info) && empty($info2)) {

        $insert = ORM::for_table($config['db']['pre'] . 'allegie')->find_one($id);
        $insert->alle_aliases = $aliases;
        $insert->alle_name = $name;
        $insert->restaurant_id = $restaurant['id'];
        $insert->is_default = '0';
        $insert->image = $image;
        $insert->save();
        $result['success'] = true;
        $result['message'] = $lang['SAVED_SUCCESS'];
    } else {
        $result['success'] = false;
        $result['message'] = $lang['EXIST_ALLEGIE'];
    }
    die(json_encode($result));
}

function editMenuExtra()
{
    global $config, $lang;
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }

    $title = validate_input($_POST['title']);
    $price = validate_input($_POST['price']);
    $id = validate_input($_POST['id']);

    if (trim($id) == '' || empty($id)) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }

    if (trim($title) == '' || empty($title)) {
        $result['success'] = false;
        $result['message'] = $lang['ALL_FIELDS_REQ'];
        die(json_encode($result));
    }

    if (trim($price) == '' || empty($price)) {
        $result['success'] = false;
        $result['message'] = $lang['ALL_FIELDS_REQ'];
        die(json_encode($result));
    }

    $insert = ORM::for_table($config['db']['pre'] . 'menu_extras')->find_one($id);

    $user_lang = !empty($_COOKIE['Quick_user_lang_code']) ? $_COOKIE['Quick_user_lang_code'] : $config['lang_code'];
    $json = json_decode($insert['translation'], true);
    $json[$user_lang] = array('title' => validate_input($title));
    $insert->title = validate_input($title);
    $insert->translation = json_encode($json, JSON_UNESCAPED_UNICODE);
    $insert->price = $price;
    $insert->active = isset($_POST['active']) ? 1 : 0;
    $insert->save();

    $result['success'] = true;
    $result['message'] = $lang['SAVED_SUCCESS'];


    die(json_encode($result));
}

function deleteAdditives()
{
    global $lang, $config;

    $result['success'] = false;
    $result['message'] = $lang['ERROR_TRY_AGAIN'];
    if (!checkloggedin()) {
        die(json_encode($result));
    }
    $id = $_POST['id'];
    if (trim($id) != '') {
        $additives = ORM::for_table($config['db']['pre'] . 'additives')->find_one($id);

        if (!empty($additives['id'])) {
            ORM::for_table($config['db']['pre'] . 'additives_menu')
                ->where("additive_id", $additives['id'])
                ->delete_many();

            $data = ORM::for_table($config['db']['pre'] . 'additives')
                ->where(array(
                    'id' => $id
                ))
                ->delete_many();

            if ($data) {
                $result['success'] = true;
                $result['message'] = $lang['SUCCESS_DELETE'];
            }
        }
    }
    die(json_encode($result));
}

function deleteProperties()
{
    global $lang, $config;

    $result['success'] = false;
    $result['message'] = $lang['ERROR_TRY_AGAIN'];
    if (!checkloggedin()) {
        die(json_encode($result));
    }
    $id = $_POST['id'];
    if (trim($id) != '') {
        $properties = ORM::for_table($config['db']['pre'] . 'properties')->find_one($id);

        if (!empty($properties['id'])) {
            ORM::for_table($config['db']['pre'] . 'properties_menu')
                ->where("properties_id", $properties['id'])
                ->delete_many();

            $data = ORM::for_table($config['db']['pre'] . 'properties')
                ->where(array(
                    'id' => $id
                ))
                ->delete_many();

            if ($data) {
                $result['success'] = true;
                $result['message'] = $lang['SUCCESS_DELETE'];
            }
        }
    }
    die(json_encode($result));
}
function deleteAllegie()
{
    global $lang, $config;

    $result['success'] = false;
    $result['message'] = $lang['ERROR_TRY_AGAIN'];
    if (!checkloggedin()) {
        die(json_encode($result));
    }
    $id = $_POST['id'];
    if (trim($id) != '') {
        // check Allegies menu is with same user
        $allegies = ORM::for_table($config['db']['pre'] . 'allegie')->find_one($id);

        if (!empty($allegies['id'])) {
            ORM::for_table($config['db']['pre'] . 'allegie_menu')
                ->where("alle_id", $allegies['id'])
                ->delete_many();

            $data = ORM::for_table($config['db']['pre'] . 'allegie')
                ->where(array(
                    'id' => $id
                ))
                ->delete_many();

            if ($data) {
                $result['success'] = true;
                $result['message'] = $lang['SUCCESS_DELETE'];
            }
        }
    }
    die(json_encode($result));
}

function deleteMenuExtra()
{
    global $lang, $config;

    $result['success'] = false;
    $result['message'] = $lang['ERROR_TRY_AGAIN'];
    if (!checkloggedin()) {
        die(json_encode($result));
    }
    $id = $_POST['id'];
    if (trim($id) != '') {
        // check menu is with same user
        $menu_extra = ORM::for_table($config['db']['pre'] . 'menu_extras')->find_one($id);

        if (!empty($menu_extra['menu_id'])) {
            $menu = ORM::for_table($config['db']['pre'] . 'menu')
                ->where(array(
                    'id' => $menu_extra['menu_id'],
                    'user_id' => $_SESSION['user']['id'],
                ))
                ->find_one();

            if (!empty($menu['id'])) {
                $data = ORM::for_table($config['db']['pre'] . 'menu_extras')
                    ->where(array(
                        'id' => $id
                    ))
                    ->delete_many();

                if ($data) {
                    $result['success'] = true;
                    $result['message'] = $lang['SUCCESS_DELETE'];
                }
            }
        }
    }
    die(json_encode($result));
}

function ajaxlogin()
{
    global $config, $lang, $link;
    $loggedin = userlogin($_POST['username'], $_POST['password']);
    $result['success'] = false;
    $result['message'] = $lang['ERROR_TRY_AGAIN'];
    if (!is_array($loggedin)) {
        $result['message'] = $lang['USERNOTFOUND'];
    } elseif ($loggedin['status'] == 2) {
        $result['message'] = $lang['ACCOUNTBAN'];
    } else {
        $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
        $user_id = preg_replace("/[^0-9]+/", "", $loggedin['id']); // XSS protection as we might print this value
        $_SESSION['user']['id'] = $user_id;
        $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $loggedin['username']); // XSS protection as we might print this value
        $_SESSION['user']['username'] = $username;
        $_SESSION['user']['login_string'] = hash('sha512', $loggedin['password'] . $user_browser);
        $_SESSION['user']['user_type'] = $loggedin['user_type'];
        update_lastactive();

        $result['success'] = true;
        $result['message'] = $link['DASHBOARD'];
    }
    die(json_encode($result));
}

function email_verify()
{
    global $config, $lang;

    if (checkloggedin()) {
        /*SEND CONFIRMATION EMAIL*/
        email_template("signup_confirm", $_SESSION['user']['id']);

        $respond = $lang['SENT'];
        echo '<a class="button gray" href="javascript:void(0);">' . $respond . '</a>';
        die();
    } else {
        header("Location: " . $config['site_url'] . "login");
        exit;
    }
}

function submitBlogComment()
{
    global $config, $lang;
    $comment_error = $name = $email = $user_id = $comment = null;
    $result = array();
    $is_admin = '0';
    $is_login = false;
    if (checkloggedin()) {
        $is_login = true;
    }
    $avatar = $config['site_url'] . 'storage/profile/default_user.png';
    if (!($is_login || isset($_SESSION['admin']['id']))) {
        if (empty($_POST['user_name']) || empty($_POST['user_email'])) {
            $comment_error = $lang['ALL_FIELDS_REQ'];
        } else {
            $name = removeEmailAndPhoneFromString($_POST['user_name']);
            $email = $_POST['user_email'];

            $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
            if (!preg_match($regex, $email)) {
                $comment_error = $lang['EMAILINV'];
            }
        }
    } else if ($is_login && isset($_SESSION['admin']['id'])) {
        $commenting_as = 'admin';
        if (!empty($_POST['commenting-as'])) {
            if (in_array($_POST['commenting-as'], array('admin', 'user'))) {
                $commenting_as = $_POST['commenting-as'];
            }
        }
        if ($commenting_as == 'admin') {
            $is_admin = '1';
            $info = ORM::for_table($config['db']['pre'] . 'admins')->find_one($_SESSION['admin']['id']);
            $user_id = $_SESSION['admin']['id'];
            $name = $info['name'];
            $email = $info['email'];
            if (!empty($info['image'])) {
                $avatar = $config['site_url'] . 'storage/profile/' . $info['image'];
            }
        } else {
            $user_id = $_SESSION['user']['id'];
            $user_data = get_user_data(null, $user_id);
            $name = $user_data['name'];
            $email = $user_data['email'];
            if (!empty($user_data['image'])) {
                $avatar = $config['site_url'] . 'storage/profile/' . $user_data['image'];
            }
        }
    } else if ($is_login) {
        $user_id = $_SESSION['user']['id'];
        $user_data = get_user_data(null, $user_id);
        $name = $user_data['name'];
        $email = $user_data['email'];
        if (!empty($user_data['image'])) {
            $avatar = $config['site_url'] . 'storage/profile/' . $user_data['image'];
        }
    } else if (isset($_SESSION['admin']['id'])) {
        $is_admin = '1';
        $info = ORM::for_table($config['db']['pre'] . 'admins')->find_one($_SESSION['admin']['id']);
        $user_id = $_SESSION['admin']['id'];
        $name = $info['name'];
        $email = $info['email'];
        if (!empty($info['image'])) {
            $avatar = $config['site_url'] . 'storage/profile/' . $info['image'];
        }
    } else {
        $comment_error = $lang['LOGIN_POST_COMMENT'];
    }

    if (empty($_POST['comment'])) {
        $comment_error = $lang['ALL_FIELDS_REQ'];
    } else {
        $comment = validate_input($_POST['comment']);
    }

    $duplicates = ORM::for_table($config['db']['pre'] . 'blog_comment')
        ->where('blog_id', $_POST['comment_post_ID'])
        ->where('name', $name)
        ->where('email', $email)
        ->where('comment', $comment)
        ->count();

    if ($duplicates > 0) {
        $comment_error = $lang['DUPLICATE_COMMENT'];
    }

    if (!$comment_error) {
        if ($is_admin) {
            $approve = '1';
        } else {
            if ($config['blog_comment_approval'] == 1) {
                $approve = '0';
            } else if ($config['blog_comment_approval'] == 2) {
                if ($is_login) {
                    $approve = '1';
                } else {
                    $approve = '0';
                }
            } else {
                $approve = '1';
            }
        }

        $blog_cmnt = ORM::for_table($config['db']['pre'] . 'blog_comment')->create();
        $blog_cmnt->blog_id = $_POST['comment_post_ID'];
        $blog_cmnt->user_id = $user_id;
        $blog_cmnt->is_admin = $is_admin;
        $blog_cmnt->name = $name;
        $blog_cmnt->email = $email;
        $blog_cmnt->comment = $comment;
        $blog_cmnt->created_at = date('Y-m-d H:i:s');
        $blog_cmnt->active = $approve;
        $blog_cmnt->parent = $_POST['comment_parent'];
        $blog_cmnt->save();

        $id = $blog_cmnt->id();
        $date = date('d, M Y');
        $approve_txt = '';
        if ($approve == '0') {
            $approve_txt = '<em><small>' . $lang['COMMENT_REVIEW'] . '</small></em>';
        }

        $html = '<li id="li-comment-' . $id . '"';
        if ($_POST['comment_parent'] != 0) {
            $html .= 'class="children-2"';
        }
        $html .= '>
                   <div class="comments-box" id="comment-' . $id . '">
                        <div class="comments-avatar">
                            <img src="' . $avatar . '" alt="' . $name . '">
                        </div>
                        <div class="comments-text">
                            <div class="avatar-name">
                                <h5>' . $name . '</h5>
                                <span>' . $date . '</span>
                            </div>
                            ' . $approve_txt . '
                            <p>' . nl2br(stripcslashes($comment)) . '</p>
                        </div>
                    </div>
                </li>';

        $result['success'] = true;
        $result['html'] = $html;
        $result['id'] = $id;
    } else {
        $result['success'] = false;
        $result['error'] = $comment_error;
    }
    die(json_encode($result));
}

function sendRestaurantBooking()
{
    global $config, $lang, $link;
    $result = array('success' => false, 'message' => $lang['ERROR_TRY_AGAIN']);
    if (!empty($_POST['slug'])) {

        if (!isset($_POST['name']) || trim($_POST['name']) == '') {
            $result['message'] = $lang['YOUR_NAME_REQUIRED'];
        } else if ((!isset($_POST['table']) || trim($_POST['table']) == '' && !is_numeric($_POST['table']))) {
            $result['message'] = $lang['TABLE_NUMBER_REQUIRED'];
        } else if ((!isset($_POST['phone']) || trim($_POST['phone']) == '' && !is_numeric($_POST['phone']))) {
            $result['message'] = $lang['PHONE_NUMBER_REQUIRED'];
        } else {
            if ($_POST['slug'] == "admin") {
                if (!checkloggedin()) {
                    die(json_encode($result));
                }
                $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
                    ->where('user_id', $_SESSION['user']['id'])
                    ->find_one();
            } else {
                $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
                    ->where('slug', $_POST['slug'])
                    ->find_one();
            }

            if (isset($restaurant['id'])) {
                //chek table is using
                $table = ORM::for_table($config['db']['pre'] . 'booking_table')
                    ->raw_query("SELECT * FROM " . $config['db']['pre']  . "booking_table  WHERE ((date_from < :datefrom and date_to > :datefrom) OR (date_from < :dateto and date_to > :dateto))  AND restaurant_id = :res_id AND status NOT IN ('completed', 'cancelled', 'missed')", array('datefrom' => $_POST['from'], 'dateto' => $_POST['to'], 'res_id' => $restaurant->id))->find_many();
                $arTable = array();
                array_push($arTable, '9999999');
                foreach ($table as $info) {
                    array_push($arTable, $info->table_number);
                }
                $table = ORM::for_table($config['db']['pre'] . 'booking_table')
                    ->raw_query("SELECT * FROM " . $config['db']['pre']  . "booking_table  WHERE (date_from >= :datefrom and date_to <= :dateto)  AND restaurant_id = :res_id AND status NOT IN ('completed', 'cancelled', 'missed')", array('datefrom' => $_POST['from'], 'dateto' => $_POST['to'], 'res_id' => $restaurant->id))->find_many();
                foreach ($table as $info) {
                    if (in_array($info->table_number, $arTable) == false)
                        array_push($arTable, $info->table_number);
                }
                if (in_array($_POST['table'], $arTable)) {
                    $result['success'] = false;
                    $result['message'] = $lang['THIS_TABLE_IS_ALREADY_BOOKED'];
                    die(json_encode($result));
                }
                $booking = ORM::for_table($config['db']['pre'] . 'booking_table')->create();
                $booking->restaurant_id = $restaurant['id'];
                $booking->customer_name = validate_input($_POST['name']);
                $booking->table_number = validate_input($_POST['table']);
                $booking->phone_number = validate_input($_POST['phone']);
                $booking->email = validate_input($_POST['email']);
                $booking->date = validate_input($_POST['date']);
                $booking->date_from = validate_input($_POST['from']);
                $booking->date_to = validate_input($_POST['to']);
                $booking->ticket = validate_input($_POST['ticket']);
                $booking->note = validate_input($_POST['note']);
                $booking->print_coppy = 0;
                $booking->status = 'pending';

                $customer_details = validate_input($_POST['name']) . "\n";
                $icon_phone = "☎️";
                $icon_email = "📧";
                $customer_details .= $icon_phone . ' ' . validate_input($_POST['phone']) . "\n";
                $customer_details .= !empty($_POST['email']) ? $icon_email . ' ' . validate_input($_POST['email']) : '';
                $loggedin = checkcustomerloggedin($restaurant['id']);
                if ($loggedin) {
                    $booking->customer_id = $_SESSION['customer']['id'];
                }
                $booking->save();
                $phone = validate_input($_POST['phone']);
                $email = validate_input($_POST['email']);
                $name = validate_input($_POST['name']);
                $table =  validate_input($_POST['table']);
                $date = validate_input($_POST['date']);
                $date_from = validate_input($_POST['from']);
                $date_to = validate_input($_POST['to']);
                $ticket = validate_input($_POST['ticket']);

                $page = new HtmlTemplate();
                $page->html = $config['email_sub_booking'];
                $page->SetParameter('RESTAURANT_NAME', $restaurant['name']);
                $page->SetParameter('CUSTOMER_NAME', $name);
                $page->SetParameter('TABLE_NUMBER', $table);
                $page->SetParameter('PHONE_NUMBER', $phone);
                $page->SetParameter('EMAIL', $email);
                $page->SetParameter('DATE', $date);
                $page->SetParameter('DATE_FROM', $date_from);
                $page->SetParameter('DATE_TO', $date_to);
                $page->SetParameter('TICKET', $ticket);
                $email_subject = $page->CreatePageReturn($lang, $config, $link);

                $page = new HtmlTemplate();
                $page->html = $config['email_message_booking'];
                $page->SetParameter('RESTAURANT_NAME', $restaurant['name']);
                $page->SetParameter('CUSTOMER_NAME', $name);
                $page->SetParameter('TABLE_NUMBER', $table);
                $page->SetParameter('PHONE_NUMBER', $phone);
                $page->SetParameter('EMAIL', $email);
                $page->SetParameter('DATE', $date);
                $page->SetParameter('DATE_FROM', $date_from);
                $page->SetParameter('DATE_TO', $date_to);
                $page->SetParameter('TICKET', $ticket);
                $email_body = $page->CreatePageReturn($lang, $config, $link);

                $userdata = get_user_data(null, $restaurant['user_id']);

                if (!empty($email)) {
                    /* send email to user */
                    email($email, $userdata['name'], $email_subject, $email_body);
                }
                /* send email to restaurant */
                email($userdata['email'], $userdata['name'], $email_subject, $email_body);

                $msg = ['action' => 'booking_pending', 'id' =>  $booking->id];
                FirebaseNotification($userdata['firebase_token'], $lang, 'booking_pending', $msg);
                if ($loggedin) {
                    $customer_name = validate_input($_POST['name']);
                    $customer_phone_number = validate_input($_POST['phone']);
                    $customer_email = validate_input($_POST['email']);

                    $update_address = ORM::for_table($config['db']['pre'] . 'customers')->find_one($_SESSION['customer']['id']);
                    $update_address->name = $customer_name;
                    $update_address->phone = $customer_phone_number;
                    $update_address->email = $customer_email;
                    $update_address->save();
                    //save session
                    $_SESSION['customer']['name'] =  validate_input($_POST['name']);
                    $_SESSION['customer']['phone'] = validate_input($_POST['phone']);
                    $_SESSION['customer']['email'] = validate_input($_POST['email']);
                }

                $result['success'] = true;
                $result['message'] = '';
                $result['whatsapp_url'] = '';

                if ($config['quickorder_enable']) {
                    // $settings = get_all_setting($restaurant['user_id']);
                    $RESTAURANT_WHATSAPP_ORDERING = get_module_settting($restaurant['user_id'], 'whatsapp');
                    if ($RESTAURANT_WHATSAPP_ORDERING == 1) {
                        if (get_restaurant_option($restaurant['id'], 'quickorder_enable', 0)) {
                            $whatsapp_number = get_restaurant_option($restaurant['id'], 'whatsapp_number');

                            $whatsapp_message = get_restaurant_option($restaurant['id'], 'whatsapp_booking_message');
                            if (empty($whatsapp_message))
                                $whatsapp_message = $config['quickorder_whatsapp_booking_message'];
                            $page = new HtmlTemplate();
                            $page->html = $whatsapp_message;
                            $page->SetParameter('RESTAURANT_NAME', $restaurant['name']);
                            $page->SetParameter('CUSTOMER_DETAILS', $customer_details);
                            $page->SetParameter('TIME_FROM', validate_input($_POST['from']));
                            $page->SetParameter('TIME_TO', validate_input($_POST['to']));
                            $page->SetParameter('TICKET', validate_input($_POST['ticket']));
                            $page->SetParameter('TABLE', validate_input($_POST['table']));
                            $page->SetParameter('DATE', validate_input($_POST['date']));
                            $whatsapp_message = $page->CreatePageReturn($lang, $config, $link);

                            $result['whatsapp_url'] = 'https://api.whatsapp.com/send?phone=' . $whatsapp_number . '&text=' . urlencode($whatsapp_message);
                        }
                    }
                }
            }
        }
    }
    die(json_encode($result));
}
function checkTableUsing()
{
    global $config, $lang;
    $result = array('success' => false, 'status' => '', 'message' => $lang['ERROR_TRY_AGAIN']);
    $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
        ->where('id', $_POST['restaurant'])
        ->find_one();
    if (isset($restaurant['id'])) {
        if (isset($_POST['table'])) {
            //check table  exist
            $table = ORM::for_table($config['db']['pre'] . 'table')
                ->where(array(
                    'restaurant_id' => $restaurant['id'],
                    'table_number' => $_POST['table']
                ))
                ->find_one();
            if (empty($table)) {
                $result['success'] = false;
                $result['message'] = $lang['TABLE_DOSE_NOT_EXIST'];
                die(json_encode($result));
            } else {
                if (!empty($_POST['id_customer'])) {
                    $table = ORM::for_table($config['db']['pre'] . 'table')
                        ->where(array(
                            'restaurant_id' => $restaurant['id'],
                            'table_number' => $_POST['table'],
                            'customer_id' => $_POST['id_customer']
                        ))
                        ->find_one();

                    if (empty($table)) {
                        $result['success'] = false;
                        $result['message'] = '';
                    } else {
                        if ($table['status'] == 'waiting') {
                            $table->set('status', 'empty');
                            $table->set('is_processing', '0');
                            $table->set('updated_at', date("Y-m-d H:i:s"));
                            $table->set('customer_id', NULL);
                            $table->save();
                            $userdata = get_user_data(null, $restaurant['user_id']);
                            $msg = ['action' => 'table_remove', 'table_name' => $_POST['table']];
                            FirebaseNotification($userdata['firebase_token'], $lang, 'table_remove', $msg);
                        }
                        $result['success'] = true;
                        $result['message'] = '';
                    }
                    $result['status'] = $table['status'];
                } else {
                    $result['success'] = false;
                    $result['message'] = '';
                }
            }
        }
    }
    die(json_encode($result));
}
function checkRemoveTableFromMobile()
{
    global $config, $lang;
    $result = array('success' => false, 'message' => $lang['ERROR_TRY_AGAIN']);
    $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
        ->where('id', $_POST['restaurant'])
        ->find_one();
    if (isset($restaurant['id'])) {
        if (!empty($_POST['table'])) {
            $table = ORM::for_table($config['db']['pre'] . 'table')
                ->where(array(
                    'restaurant_id' => $restaurant['id'],
                    'table_number' => $_POST['table'],
                    'status' => 'empty'
                ))
                ->find_one();
            if (!empty($table)) {
                $result['success'] = true;
                $result['message'] = '';
            }
        }
    }
    die(json_encode($result));
}

function checkConfirmOrders()
{
    global $config, $lang;
    $result = array('success' => false, 'status' => 'empty', 'message' => $lang['ERROR_TRY_AGAIN']);
    $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
        ->where('id', $_POST['restaurant'])
        ->find_one();
    if (isset($restaurant['id'])) {
        if (!empty($_POST['table'])) {
            //check table  exist
            $table = ORM::for_table($config['db']['pre'] . 'table')
                ->where(array(
                    'restaurant_id' => $restaurant['id'],
                    'table_number' => $_POST['table']
                ))
                ->find_one();
            if (empty($table)) {
                die(json_encode($result));
            }

            if (!empty($_POST['id_customer'])) {
                $table = ORM::for_table($config['db']['pre'] . 'table')
                    ->where(array(
                        'restaurant_id' => $restaurant['id'],
                        'table_number' => $_POST['table'],
                        'customer_id' => $_POST['id_customer']
                    ))
                    ->find_one();
                if (!empty($table)) {
                    if ($table['status'] == 'using') {
                        $result['success'] = true;
                        $result['status'] = 'using';
                        $result['message'] = '';
                    } else {
                        $result['status'] = $table['status'];
                    }
                }
            }
        }
    }
    die(json_encode($result));
}

function check_and_update_table()
{
    global $config, $lang;
    $result = array('success' => false, 'id_customer' => '', 'message' => $lang['ERROR_TRY_AGAIN']);
    if (isset($_POST['restaurant'])) {
        $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
            ->where('id', $_POST['restaurant'])
            ->find_one();
    } else {
        die(json_encode($result));
    }
    if (empty($_POST['table'])) {
        $result['message'] = $lang['PLEASE_ENTER'];
        die(json_encode($result));
    }
    if (isset($restaurant['id'])) {
        //check table  exist
        $table = ORM::for_table($config['db']['pre'] . 'table')
            ->where(array(
                'restaurant_id' => $restaurant['id'],
                'table_number' => $_POST['table']
            ))
            ->find_one();
        if (empty($table)) {
            $result['message'] = $lang['TABLE_DOSE_NOT_EXIST'];
            die(json_encode($result));
        } else {
            //kiểm tra xem bàn có đang trống      
            $table = ORM::for_table($config['db']['pre'] . 'table')
                ->where(array(
                    'restaurant_id' => $restaurant['id'],
                    'table_number' => $_POST['table'],
                    'status' => 'empty'
                ))
                ->find_one();
            if (empty($table)) {
                //kiểm tra xem bàn đó khách đã ngồi trước đó chưa?
                $table = ORM::for_table($config['db']['pre'] . 'table')
                    ->where(array(
                        'restaurant_id' => $restaurant['id'],
                        'table_number' => $_POST['table'],
                        'customer_id' => $_POST['id_customer']
                    ))
                    ->find_one();
                if (empty($table)) {
                    $result['success'] = false;
                    $result['message'] = $lang['TABLE_IS_USING'];
                } else {
                    $result['success'] = true;
                    $result['message'] = $table['status'];
                    $result['id_customer'] =  $restaurant['id'] . "-" . $_POST['table'];
                }
            } else {
                $table->customer_id = $restaurant['id'] . "-" . $_POST['table'];
                if ($_POST['table_confirm'] == 0) {
                    $table->status = 'using';
                } else {
                    $table->status = 'waiting';
                }
                $table->set('updated_at', date("Y-m-d H:i:s"));
                $table->set('checkin_at', date("Y-m-d H:i:s"));
                $table->save();
                $result['success'] = true;
                $result['id_customer'] =  $restaurant['id'] . "-" . $_POST['table'];
                $result['message'] = '';

                // Kiểm tra và xóa bàn trước đó ra
                if ($_POST['table_before'] != $_POST['table']) {
                    if (!empty($_POST['table_before'])) {
                        $update_table = ORM::for_table($config['db']['pre'] . 'table')
                            ->where(array(
                                'restaurant_id' => $restaurant['id'],
                                'table_number' => $_POST['table_before'],
                                'customer_id' => $_POST['id_customer']
                            ))
                            ->find_one();
                        $update_table->set('status', 'empty');
                        $update_table->set('is_processing', '0');
                        $update_table->set('updated_at', date("Y-m-d H:i:s"));
                        $update_table->set('customer_id', NULL);
                        $update_table->save();
                        $userdata = get_user_data(null, $restaurant['user_id']);
                        $msg = ['action' => 'table_remove', 'table_name' => $_POST['table_before']];
                        FirebaseNotification($userdata['firebase_token'], $lang, 'table_remove', $msg);
                    }
                }
            }
        }
    }
    if ($result['success'] == true) {
        $userdata = get_user_data(null, $restaurant['user_id']);
        if ($result['message'] == '') {
            if ($_POST['table_confirm'] == 0) {
                $msg = ['action' => 'table_using', 'table_name' => $_POST['table']];
                FirebaseNotification($userdata['firebase_token'], $lang, 'table_using', $msg);
            } else {
                $msg = ['action' => 'table_confirm', 'table_name' => $_POST['table']];
                FirebaseNotification($userdata['firebase_token'], $lang, 'table_confirm', $msg);
            }
        }
    }
    die(json_encode($result));
}
/**
 * save restaurant order temp
 */
function sendRestaurantOrderTemp()
{
    global $config, $lang;
    $result = array('success' => false, 'customer_id' => '', 'date_order' => '', 'message' => $lang['ERROR_TRY_AGAIN']);
    if (!empty($_POST['items']) && !empty($_POST['restaurant'])) {
        $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
            ->where('id', $_POST['restaurant'])
            ->find_one();
        $table = ORM::for_table($config['db']['pre'] . 'table')
            ->where(array(
                'restaurant_id' => $restaurant['id'],
                'table_number' => $_POST['table'],
            ))
            ->find_one();
        if (isset($restaurant['id'])) {
            $items = json_decode($_POST['items'], true);
            $next_order = 1;
            foreach ($items as $item) {
                if ($item['next_order'] > $next_order) {
                    $next_order = $item['next_order'];
                }
            }
            // update date order_temp
            $now = date("Y-m-d H:i:s");
            $order_temp = ORM::for_table($config['db']['pre'] . 'order_temp')
                ->where(array(
                    'restaurant_id' => $restaurant['id'],
                    'table' => $_POST['table'],
                    'next_order' => $next_order
                ))
                ->find_many();
            $order_temp->set('create_at', $now);
            $order_temp->set('is_order', 1);
            $order_temp->save();

            $userdata = get_user_data(null, $restaurant['user_id']);
            /* send notification to firebase */
            $msg = ['action' => 'table_new_item', 'next_order' => $next_order, 'table_name' => $table['table_number']];
            FirebaseNotification($userdata['firebase_token'], $lang, 'table_new_item', $msg);
            //save customers if exist
            $next_order++;
            $result['success'] = true;
            $result['next_order'] = $next_order;
            $result['date_order'] =  date('d-m-Y H:i:s', strtotime($now));
            $result['message'] = '';
        }
    }
    die(json_encode($result));
}

function RemoveDataOrderTempExtra()
{
    global $config, $lang;
    $result = array('success' => false, 'customer_id' => '', 'message' => $lang['ERROR_TRY_AGAIN']);
    if (isset($_POST['extra_cart_key'])) {
        //delete extra
        ORM::for_table($config['db']['pre'] . 'order_temp_extras')
            ->where('id', $_POST['extra_cart_key'])
            ->delete_many();
        $result['success'] = true;
        $result['message'] = '';
    }
    die(json_encode($result));
}

function RemoveDataToOrderTemp()
{
    global $config, $lang;
    $result = array('success' => false, 'customer_id' => '', 'message' => $lang['ERROR_TRY_AGAIN']);
    if (!empty($_POST['items']) && !empty($_POST['restaurant'])) {
        $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
            ->where('id', $_POST['restaurant'])
            ->find_one();
        if (isset($restaurant['id'])) {
            $item = json_decode($_POST['items'], true);
            $order_temp_item_id = $item['id'];
            ORM::for_table($config['db']['pre'] . 'order_temp')
                ->where('id', $order_temp_item_id)
                ->delete_many();
            //delete extra
            ORM::for_table($config['db']['pre'] . 'order_temp_extras')
                ->where('order_temp_id', $order_temp_item_id)
                ->delete_many();
            $result['success'] = true;
            $result['message'] = '';
        }
    }
    die(json_encode($result));
}

function pushDataToOrderTemp()
{
    global $config, $lang;
    $result = array('success' => false, 'customer_id' => '', 'message' => $lang['ERROR_TRY_AGAIN']);
    if (!empty($_POST['items']) && !empty($_POST['restaurant'])) {
        $amount = 0;
        $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
            ->where('id', $_POST['restaurant'])
            ->find_one();
        $table = ORM::for_table($config['db']['pre'] . 'table')
            ->where(array(
                'restaurant_id' => $restaurant['id'],
                'table_number' => $_POST['table'],
            ))
            ->find_one();
        if (isset($restaurant['id'])) {
            $item = json_decode($_POST['items'], true);
            $item_id = $item['item_id'];
            $id = $item['id'];
            $extra_option_id = $item['extra_option_id'];
            $name = $item['item_name'];
            $quantity = $item['quantity'];
            $amount_item =    $item['item_price'];
            $total_amount = $item['item_price'] * $quantity;
            $amount_reduced =  $item['amount_reduced'] * $quantity;
            $amount += $total_amount;
            $menu = ORM::for_table($config['db']['pre'] . 'menu')
                ->where('id', $item_id)
                ->find_one();

            if (isset($menu['id'])) {
                // save order items
                $order_temp_item = ORM::for_table($config['db']['pre'] . 'order_temp')
                    ->where('id', $id)->find_one();
                if (empty($order_temp_item)) {
                    $order_temp_item = ORM::for_table($config['db']['pre'] . 'order_temp')->create();
                }
                $order_temp_item->id = $id;
                $order_temp_item->item_id = validate_input($item_id);
                $order_temp_item->quantity = validate_input($quantity);
                $order_temp_item->amount = validate_input($amount_item);
                $order_temp_item->total_amount = validate_input($total_amount);
                $order_temp_item->amount_reduced = validate_input($amount_reduced);
                $order_temp_item->create_at = date("Y-m-d H:i:s");
                $order_temp_item->restaurant_id = $restaurant['id'];
                $order_temp_item->table = $_POST['table'];
                $order_temp_item->extra_option_id = $extra_option_id;
                $order_temp_item->name = $name;
                $order_temp_item->next_order = $item['next_order'];
                $order_temp_item->is_order = 0;
                $order_temp_item->table_id = $table['id'];
                $order_temp_item->save();
                $extras = $item['extras'];
                //delete extra
                ORM::for_table($config['db']['pre'] . 'order_temp_extras')
                    ->where('order_temp_id', $id)
                    ->delete_many();
                foreach ($extras as $extra) {
                    $menu_extra = ORM::for_table($config['db']['pre'] . 'menu_extras')
                        ->where('id', $extra['extra_id'])
                        ->find_one();
                    if (isset($menu_extra['id'])) {
                        // save order items extras
                        $order_temp_item_extras = ORM::for_table($config['db']['pre'] . 'order_temp_extras')->create();
                        $order_temp_item_extras->id = $extra['id'];
                        $order_temp_item_extras->order_temp_id = $order_temp_item->id();
                        $order_temp_item_extras->quantity = $quantity;
                        $order_temp_item_extras->restaurant_id = $restaurant['id'];
                        $order_temp_item_extras->table_number = $_POST['table'];
                        $order_temp_item_extras->extra_id = validate_input($extra['extra_id']);
                        $order_temp_item_extras->save();
                        $amount += $menu_extra['price'] * $quantity;

                    }
                }
            }
            $result['success'] = true;
            $result['message'] = '';
        }
    }
    die(json_encode($result));
}
/**
 * save restaurant order
 */
function sendRestaurantOrder()
{

    global $config, $lang, $link;
    $result = array('success' => false, 'message' => $lang['ERROR_TRY_AGAIN']);

    if (!empty($_POST['items']) && !empty($_POST['restaurant'])) {


        if (!isset($_POST['ordering-type']) || trim($_POST['ordering-type']) == '') {
            /* Check order type is sent */
            $result['message'] = $lang['ORDERING_TYPE_REQUIRED'];
        } else if (!in_array($_POST['ordering-type'], array('on-table', 'takeaway', 'delivery'))) {
            /* Check order type is not changed */
            $result['message'] = $lang['ORDERING_TYPE_REQUIRED'];
        } else if (!isset($_POST['name']) || trim($_POST['name']) == '' && $_POST['ordering-type'] != 'on-table') {
            $result['message'] = $lang['YOUR_NAME_REQUIRED'];
        } else if ($_POST['ordering-type'] == 'on-table' && (!isset($_POST['table']) || trim($_POST['table']) == '' && !is_numeric($_POST['table']))) {
            $result['message'] = $lang['TABLE_NUMBER_REQUIRED'];
        } else if ($_POST['ordering-type'] != 'on-table' && (!isset($_POST['phone_number']) || trim($_POST['phone_number']) == '')) {
            $result['message'] = $lang['PHONE_NUMBER_REQUIRED'];
        } else if ($_POST['ordering-type'] == 'delivery' && (!isset($_POST['zip_code']) || trim($_POST['zip_code']) == '')) {
            $result['message'] = $lang['ZIPCODE_REQ'];
        } else if ($_POST['ordering-type'] == 'delivery' && (!isset($_POST['address']) || trim($_POST['address']) == '')) {
            $result['message'] = $lang['ADDRESS_REQUIRED'];
        } else if ($_POST['ordering-type'] != 'on-table' && (!isset($_POST['takeaway_delivery_time']) || trim($_POST['takeaway_delivery_time']) == '')) {
            $result['message'] = $lang['TAKEAWAY_DELIVERY_TIME_REQUIRED'];
        } else {
            $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
                ->where('id', $_POST['restaurant'])
                ->find_one();
            if ($_POST['pay_via'] == 'pay_online' && $_POST['ordering-type'] != 'on-table') {
                $payment_type = "order";
                $access_token = uniqid();
                $_SESSION['access_token'] = $access_token;
                $_SESSION['quickad'][$access_token]['pay_via'] = validate_input($_POST['pay_via']);
                $_SESSION['quickad'][$access_token]['customer_name'] = validate_input($_POST['name']);
                $_SESSION['quickad'][$access_token]['restaurant'] = validate_input($_POST['restaurant']);
                $_SESSION['quickad'][$access_token]['ordering-type'] = validate_input($_POST['ordering-type']);
                $_SESSION['quickad'][$access_token]['table'] = validate_input($_POST['table']);
                $_SESSION['quickad'][$access_token]['email'] = validate_input($_POST['email']);
                $_SESSION['quickad'][$access_token]['phone_number'] = validate_input($_POST['phone_number']);
                $_SESSION['quickad'][$access_token]['address'] = validate_input($_POST['address']);
                $_SESSION['quickad'][$access_token]['house_number'] = validate_input($_POST['house_number']);
                $_SESSION['quickad'][$access_token]['street_name'] = validate_input($_POST['street_name']);
                $_SESSION['quickad'][$access_token]['city'] = validate_input($_POST['city']);
                $_SESSION['quickad'][$access_token]['zip_code'] = validate_input($_POST['zip_code']);
                $_SESSION['quickad'][$access_token]['message'] = validate_input($_POST['message']);
                $_SESSION['quickad'][$access_token]['items'] = validate_input($_POST['items']);
                $_SESSION['quickad'][$access_token]['shipping_fee'] = validate_input($_POST['shipping_fee']);
                $_SESSION['quickad'][$access_token]['takeaway_delivery_time'] = validate_input($_POST['takeaway_delivery_time']);
                $_SESSION['quickad'][$access_token]['customer_id'] = validate_input($_SESSION['customer']['id']);
                $_SESSION['quickad'][$access_token]['name'] = validate_input($restaurant['name']);
                $_SESSION['quickad'][$access_token]['restaurant_id'] = $restaurant['id'];
                $_SESSION['quickad'][$access_token]['slug'] = $restaurant['slug'];
                $_SESSION['quickad'][$access_token]['discount_price'] = validate_input($_POST['discount_price']);
                $_SESSION['quickad'][$access_token]['discount_code'] = validate_input($_POST['discount_code']);
                $_SESSION['quickad'][$access_token]['amount'] = $_POST['total_sum'];
                $_SESSION['quickad'][$access_token]['payment_type'] = $payment_type;
                $_SESSION['restaurant_id'] = $restaurant['id'];

                $url = $link['PAYMENT'] . "/" . $access_token;
                $result['success'] = true;
                $result['message'] = $url;
            } else {
                $amount = 0;
                if (isset($restaurant['id'])) {
                    if ($_POST['ordering-type'] == 'on-table') {
                        $table = ORM::for_table($config['db']['pre'] . 'table')
                            ->where(array('restaurant_id' => $_POST['restaurant'], 'table_number' => $_POST['table']))
                            ->find_one();
                        if ($table['is_processing'] == '1') {
                            $newtimestamp = strtotime(date('Y-m-d H:i:s'));
                            $updatetimestamp = strtotime($table['updated_at'] . '+ 1 minute');
                            if ($newtimestamp < $updatetimestamp) {
                                $result['success'] = false;
                                $result['message'] =  $lang['ERROR_TRY_AGAIN'];
                                die(json_encode($result));
                            }
                        }
                    }
                    $takeaway_delivery_time = '';
                    $loggedin = checkcustomerloggedin($restaurant['id']);
                    $sNewId = getNextIDOrders($restaurant['id']);


                    $discount_price = validate_input($_POST['discount_price']);
                    $discount_code = trim($_POST['discount_code']);
                    // check discount code 
                    $order_type_coupon = 'online';
                    $order_type_order_table = array('takeaway', 'delivery');
                    if ($_POST['ordering-type'] == "on-table") {
                        $order_type_coupon = 'on-table';
                        $order_type_order_table = array('on-table');
                    }
                    // check discount code exists
                    $coupon = ORM::for_table($config['db']['pre'] . 'coupons')
                        ->where(array(
                            'code' => $discount_code,
                            'order_type' => $order_type_coupon,
                            'restaurant_id' => $restaurant['id']
                        ))
                        ->find_one();
                    if (!empty($coupon['id'])) {
                        $now = date('Y-m-d');
                        $id_customer = $_SESSION['customer']['id'];
                        $date_expired = $coupon['date_expired'];
                        $discount_price  = $coupon['discount'];
                        if ($coupon['status'] == "0") {
                            $discount_price = 0;
                            $discount_code = null;
                        }
                        if ($now > $date_expired) {
                            $discount_price = 0;
                            $discount_code = null;
                        }
                        // kiem tra khach hang da su dung ma nay chua
                        $count = ORM::for_table($config['db']['pre'] . 'orders')
                            ->where(array(
                                'coupons_code' => $discount_code,
                                'customer_id' => $id_customer,
                                'restaurant_id' => $restaurant['id']
                            ))
                            ->where_in('type', $order_type_order_table)
                            ->count();
                        if ($count == 1) {
                            $discount_price = 0;
                            $discount_code = null;
                        }
                    } else {
                        $discount_price = 0;
                        $discount_code = null;
                    }

                    // save order
                    $order = ORM::for_table($config['db']['pre'] . 'orders')->create();
                    $order->id = $sNewId;
                    $order->restaurant_id = validate_input($_POST['restaurant']);
                    $order->type = validate_input($_POST['ordering-type']);
                    $order->payment_gateway = $_POST['pay_via'] == 'pay_online' ? 'online' : 'cash';
                    $order->coupons_code = $discount_code;
                    $order->include_total_discount_value = $discount_price;
                    $customer_details = validate_input($_POST['name']) . "\n";

                    $icon_menu_item = "▪️";
                    $icon_menu_extra = "▫️";
                    $icon_phone = "☎️";
                    $icon_hash = "#️⃣";
                    $icon_address = "📌";
                    $icon_message = "📝";
                    $icon_email = "📧";

                    $order_type = '';
                    if ($_POST['ordering-type'] == 'on-table') {
                        $table = ORM::for_table($config['db']['pre'] . 'table')
                        ->where(array('table_number' => $_POST['table'],'restaurant_id' => $restaurant['id']))->find_one();
                        $checkin_at = $table['checkin_at'];
                        $order->checkin_at = $checkin_at;
                        $order->table_number = validate_input($_POST['table']);
                        $customer_details .= $icon_hash . ' ' . validate_input($_POST['table']);
                        $order_type = $lang['ON_TABLE'];
                    } else if ($_POST['ordering-type'] == 'takeaway') {
                        $customer_details .= $icon_phone . ' ' . validate_input($_POST['phone_number']) . "\n";
                        $customer_details .= !empty($_POST['email']) ? $icon_email . ' ' . validate_input($_POST['email']) : '';
                        $order_type = $lang['TAKEAWAY'];
                    } else if ($_POST['ordering-type'] == 'delivery') {
                        $order->shipping_fee = validate_input($_POST['shipping_fee']);
                        $customer_details .= $icon_phone . ' ' . validate_input($_POST['phone_number']) . "\n";
                        $customer_details .= !empty($_POST['email']) ? $icon_email . ' ' . validate_input($_POST['email']) . "\n" : '';
                        $customer_details .= $icon_address . ' ' . validate_input($_POST['address']) . "\n";
                        $customer_details .=  validate_input($_POST['street_name'])  . ' ' . validate_input($_POST['house_number']) . ', ' . validate_input($_POST['zip_code']) . ' ' . validate_input($_POST['city']);
                        $order_type = $lang['DELIVERY'];
                    }
                    if ($_POST['ordering-type'] != 'on-table') {
                        $arrTakeaway_delivery_time = explode(':', validate_input($_POST['takeaway_delivery_time']));
                        $hours = $arrTakeaway_delivery_time[0];
                        $minutes = $arrTakeaway_delivery_time[1];
                        $stime = "+ " . $hours . " hours + " . $minutes . " minute";
                        $takeaway_delivery_time =  date("Y-m-d H:i:s", strtotime($stime));
                        $order->takeaway_delivery_time = $takeaway_delivery_time;
                    }

                    if (!empty($_POST['message'])) {
                        $customer_details .= "\n" . $icon_message . ' ' . validate_input($_POST['message']) . "\n";
                    }

                    if ($loggedin) {
                        $order->customer_id = $_SESSION['customer']['id'];
                    }
                    $items = json_decode($_POST['items'], true);
                    $total_amount_order = 0;
                    $total_amount_reduced = 0;
                    foreach ($items as $item) {
                        $menu = ORM::for_table($config['db']['pre'] . 'menu')
                            ->where('id', $item['item_id'])
                            ->find_one();
                        $quantity = $item['quantity'];
                        $total_amount_order += $item['item_price'] * $quantity;
                        if (!empty($menu['discount_price'])) {
                            $total_amount_reduced += ($menu['price'] - $menu['discount_price']) * $quantity;
                        }
                        $extras = $item['extras'];
                        foreach ($extras as $extra) {
                            $price_extra = $extra['price'];
                            $total_amount_order += $price_extra * $quantity;
                        }
                    }
                    if ($_POST['ordering-type'] == 'delivery') {
                        $total_amount_order +=  $_POST['shipping_fee'];
                    }
                    $total_amount_order -= $discount_price;
                    $total_amount_order = $total_amount_order < 0 ? 0 : $total_amount_order;
                    $order->amount_reduced = $total_amount_reduced;
                    $order->amount = $total_amount_order;
                    $order->message = validate_input($_POST['message']);
                    $order->created_at = date('Y-m-d H:i:s');
                    $order->updated_at = date("Y-m-d H:i:s");
                    $order->print_coppy = 0;
                    $order->save();
                    //save customers
                    if ($_POST['ordering-type'] != 'on-table') {
                        $customers = ORM::for_table($config['db']['pre'] . 'order_customer_info')->create();
                        $customers->customer_name = validate_input($_POST['name']);
                        if ($_POST['ordering-type'] == 'takeaway') {
                            $customers->email = validate_input($_POST['email']);
                            $customers->phone_number = validate_input($_POST['phone_number']);
                        } else if ($_POST['ordering-type'] == 'delivery') {
                            $customers->phone_number = validate_input($_POST['phone_number']);
                            $customers->address = validate_input($_POST['address']);
                            $customers->email = validate_input($_POST['email']);
                            $customers->house_number = validate_input($_POST['house_number']);
                            $customers->street_name = validate_input($_POST['street_name']);
                            $customers->city = validate_input($_POST['city']);
                            $customers->zip_code = validate_input($_POST['zip_code']);
                        }
                        if ($loggedin) {
                            $customers->customer_id = $_SESSION['customer']['id'];
                        }
                        $customers->order_id = $sNewId;
                        $customers->save();
                    }
                    $order_msg = $order_whatsapp_detail = '';
                    $user_lang = !empty($_COOKIE['Quick_user_lang_code']) ? $_COOKIE['Quick_user_lang_code'] : $config['lang_code'];
                    //save order food
                    if ($_POST['ordering-type'] == 'on-table') {
                        $items = ORM::for_table($config['db']['pre'] . 'order_temp')
                            ->where(array(
                                'restaurant_id' => $restaurant['id'],
                                'table' => $_POST['table']
                            ))
                            ->find_many();
                        foreach ($items as $item) {
                            $menu = ORM::for_table($config['db']['pre'] . 'menu')
                                ->where('id', $item['item_id'])
                                ->find_one();
                            if (isset($menu['id'])) {
                                $ordertemp_id = $item['id'];
                                $item_id = $item['item_id'];
                                $quantity = $item['quantity'];
                                $amount_item =    $item['amount'];
                                $total_amount = $item['total_amount'];
                                $extra_option_id = $item['extra_option_id'];
                                $name = $item['name'];
                                $next_order = $item['next_order'];
                                //   $amount_reduced = $item['amount_reduced'];
                                $amount_reduced = !empty($menu['discount_price']) ? ($menu['price'] - $menu['discount_price']) * $quantity : 0;
                                $create_at = $item['create_at'];
                                $amount += $total_amount;
                                $is_print = $item['is_print'];
                                // save order items
                                $order_item = ORM::for_table($config['db']['pre'] . 'order_items')->create();
                                $order_item->id = $ordertemp_id;
                                $order_item->order_id = $sNewId;
                                $order_item->item_id = $item_id;
                                if(!empty($extra_option_id))
                                {
                                $order_item->extra_option_id = validate_input($extra_option_id);
                                }
                                $order_item->name = validate_input($name);
                                $order_item->quantity = $quantity;
                                $order_item->amount = $amount_item;
                                $order_item->total_amount = $total_amount;
                                $order_item->amount_reduced = $amount_reduced;
                                $order_item->create_at = $create_at;
                                $order_item->is_print = $is_print;
                                $order_item->next_order = $next_order;
                                $order_item->save();
                                if (!$config['email_template']) {
                                    $order_msg .= $name . ($quantity > 1 ? ' &times; ' . $quantity : '') . '<br>';
                                } else {
                                    $order_msg .= $name . ($quantity > 1 ? ' X ' . $quantity : '') . "\n";
                                }

                                $json = json_decode($menu['translation'], true);
                              //  $title = !empty($json[$user_lang]['title']) ? $json[$user_lang]['title'] : $name;
                                  $title = $name;
                                $order_whatsapp_detail .= $icon_menu_item . $title . ' X ' . $quantity . "\n";

                                $extras = ORM::for_table($config['db']['pre'] . 'order_temp_extras')
                                    ->where('order_temp_id', $item['id'])
                                    ->find_many();
                                foreach ($extras as $extra) {
                                    $menu_extra = ORM::for_table($config['db']['pre'] . 'menu_extras')
                                        ->where('id', $extra['extra_id'])
                                        ->find_one();
                                    if (isset($menu_extra['id'])) {
                                        // save order items extras
                                        $order_item_extras = ORM::for_table($config['db']['pre'] . 'order_item_extras')->create();
                                        $order_item_extras->order_item_id = $order_item->id();
                                        $order_item_extras->quantity = $quantity;
                                        $order_item_extras->extra_id = validate_input($extra['extra_id']);
                                        $order_item_extras->save();
                                        $amount += $menu_extra['price'] * $quantity;
                                        if (!$config['email_template']) {
                                            $order_msg .= $menu_extra['title'] . '<br>';
                                        } else {
                                            $order_msg .= $menu_extra['title'] . "\n";
                                        }
                                        $json = json_decode($menu_extra['translation'], true);
                                        $title = !empty($json[$user_lang]['title']) ? $json[$user_lang]['title'] : $menu_extra['title'];

                                        $order_whatsapp_detail .= $icon_menu_extra . $title . "\n";
                                    }
                                }
                                if (!$config['email_template']) {
                                    $order_msg .= '<br>';
                                } else {
                                    $order_msg .= "\n";
                                }
                            }
                        }
                    } else {
                        $index = 1;
                        foreach ($items as $item) {
                            $menu = ORM::for_table($config['db']['pre'] . 'menu')
                                ->where('id', $item['item_id'])
                                ->find_one();
                            $id = $sNewId . '-' . $index;
                            $item_id = $item['item_id'];
                            $quantity = $item['quantity'];
                            $amount_item =    $item['item_price'];
                            $total_amount = $item['item_price'] * $quantity;
                            $extra_option_id = $item['extra_option_id'];
                            $name = $item['item_name'];
                            // $amount_reduced =  $item['amount_reduced'] * $quantity;
                            $amount_reduced = !empty($menu['discount_price']) ? ($menu['price'] - $menu['discount_price']) * $quantity : 0;
                            $amount += $total_amount;

                            if (isset($menu['id'])) {
                                // save order items
                                $order_item = ORM::for_table($config['db']['pre'] . 'order_items')->create();
                                $order_item->id = $id;
                                $order_item->order_id = $sNewId;
                                $order_item->item_id = validate_input($item_id);
                                $order_item->quantity = validate_input($quantity);
                                $order_item->amount = validate_input($amount_item);
                                if(!empty($extra_option_id))
                                {
                                $order_item->extra_option_id = validate_input($extra_option_id);
                                }
                                $order_item->name = validate_input($name);
                                $order_item->total_amount = validate_input($total_amount);
                                $order_item->amount_reduced = validate_input($amount_reduced);
                                $order_item->create_at = date("Y-m-d H:i:s");
                                $order_item->save();
                                $index++;
                                if (!$config['email_template']) {
                                    $order_msg .= $name . ($quantity > 1 ? ' &times; ' . $quantity : '') . '<br>';
                                } else {
                                    $order_msg .= $name . ($quantity > 1 ? ' X ' . $quantity : '') . "\n";
                                }
                                $json = json_decode($menu['translation'], true);
                               // $title = !empty($json[$user_lang]['title']) ? $json[$user_lang]['title'] : $name;
                                 $title = $name;
                                $order_whatsapp_detail .= $icon_menu_item . $title . ' X ' . $quantity . "\n";

                                $extras = $item['extras'];
                                foreach ($extras as $extra) {
                                    $menu_extra = ORM::for_table($config['db']['pre'] . 'menu_extras')
                                        ->where('id', $extra['extra_id'])
                                        ->find_one();

                                    if (isset($menu_extra['id'])) {
                                        // save order items extras
                                        $order_item_extras = ORM::for_table($config['db']['pre'] . 'order_item_extras')->create();
                                        $order_item_extras->order_item_id = $order_item->id();
                                        $order_item_extras->quantity = $quantity;
                                        $order_item_extras->extra_id = validate_input($extra['extra_id']);
                                        $order_item_extras->save();
                                        $amount += $menu_extra['price'] * $quantity;
                                        if (!$config['email_template']) {
                                            $order_msg .= $menu_extra['title'] . '<br>';
                                        } else {
                                            $order_msg .= $menu_extra['title'] . "\n";
                                        }
                                        $json = json_decode($menu_extra['translation'], true);
                                        $title = !empty($json[$user_lang]['title']) ? $json[$user_lang]['title'] : $menu_extra['title'];

                                        $order_whatsapp_detail .= $icon_menu_extra . $title . "\n";
                                    }
                                }
                                if (!$config['email_template']) {
                                    $order_msg .= '<br>';
                                } else {
                                    $order_msg .= "\n";
                                }
                            }
                        }
                    }

                    if ($_POST['ordering-type'] == 'on-table') {

                        // delete order temp
                        ORM::for_table($config['db']['pre'] . 'order_temp')
                            ->where(array(
                                'restaurant_id' => $restaurant['id'],
                                'table' => $_POST['table']
                            ))
                            ->delete_many();
                        ORM::for_table($config['db']['pre'] . 'order_temp_extras')
                            ->where(array(
                                'restaurant_id' => $restaurant['id'],
                                'table_number' => $_POST['table']
                            ))
                            ->delete_many();
                        $table = ORM::for_table($config['db']['pre'] . 'table')
                            ->use_id_column('id')
                            ->where(array(
                                'restaurant_id' => $restaurant['id'],
                                'table_number' => $_POST['table']
                            ))
                            ->find_one();
                        $table->set('status', 'empty');
                        $table->set('is_processing', '0');
                        $table->set('updated_at', date("Y-m-d H:i:s"));
                        $table->set('customer_id', NULL);
                        $table->save();
                    }
                    $currency = !empty($userdata['currency']) ? $userdata['currency'] : get_option('currency_code');

                    if ($_POST['ordering-type'] == 'delivery') {
                        $shipping_fee = $_POST['shipping_fee'];
                        $sShipping_fee = price_format($_POST['shipping_fee'], $currency, false);
                    } else {
                        $shipping_fee = 0;
                        $sShipping_fee = '';
                    }

                    $amount += $shipping_fee;
                    $name = validate_input($_POST['name']);
                    $table = '';
                    $phone = '';
                    $email = '';
                    $address = '';
                    if ($_POST['ordering-type'] == 'on-table') {
                        $table =  validate_input($_POST['table']);
                    } else if ($_POST['ordering-type'] == 'takeaway') {
                        $phone = validate_input($_POST['phone_number']);
                        $email = validate_input($_POST['email']);
                    } else if ($_POST['ordering-type'] == 'delivery') {
                        $address = validate_input($_POST['address']);
                        $phone = validate_input($_POST['phone_number']);
                        $email = validate_input($_POST['email']);
                    }
                    $page = new HtmlTemplate();
                    $page->html = $config['email_sub_new_order'];
                    $page->SetParameter('RESTAURANT_NAME', $restaurant['name']);
                    $page->SetParameter('CUSTOMER_NAME', $name);
                    $page->SetParameter('TABLE_NUMBER', $table);
                    $page->SetParameter('PHONE_NUMBER', $phone);
                    $page->SetParameter('ADDRESS', $address);
                    $page->SetParameter('EMAIL', $email);
                    $page->SetParameter('SHIPPING_FEE', $sShipping_fee);
                    $page->SetParameter('ORDER_TYPE', $order_type);
                    $page->SetParameter('DISCOUNT_CODE', $discount_code);
                    $page->SetParameter('DISCOUNT_PRICE', price_format(-$discount_price, $currency, false));
                    $page->SetParameter('ORDER', $order_msg);
                    $page->SetParameter('ORDER_TOTAL', price_format($total_amount_order, $currency, false));
                    $page->SetParameter('MESSAGE', validate_input($_POST['message']));
                    $page->SetParameter('TAKEAWAY_DELIVERY_TIME', date('d-m-Y H:i:s', strtotime($takeaway_delivery_time)));
                    $email_subject = $page->CreatePageReturn($lang, $config, $link);

                    $page = new HtmlTemplate();
                    $page->html = $config['email_message_new_order'];
                    $page->SetParameter('RESTAURANT_NAME', $restaurant['name']);
                    $page->SetParameter('CUSTOMER_NAME', $name);
                    $page->SetParameter('TABLE_NUMBER', $table);
                    $page->SetParameter('PHONE_NUMBER', $phone);
                    $page->SetParameter('ADDRESS', $address);
                    $page->SetParameter('EMAIL', $email);
                    $page->SetParameter('SHIPPING_FEE', $sShipping_fee);
                    $page->SetParameter('ORDER_TYPE', $order_type);
                    $page->SetParameter('DISCOUNT_CODE', $discount_code);
                    $page->SetParameter('DISCOUNT_PRICE', price_format(-$discount_price, $currency, false));
                    $page->SetParameter('ORDER', $order_msg);
                    $page->SetParameter('TAKEAWAY_DELIVERY_TIME', date('d-m-Y H:i:s', strtotime($takeaway_delivery_time)));
                    $page->SetParameter('ORDER_TOTAL', price_format($total_amount_order, $currency, false));
                    $page->SetParameter('MESSAGE', validate_input($_POST['message']));
                    $email_body = $page->CreatePageReturn($lang, $config, $link);

                    $userdata = get_user_data(null, $restaurant['user_id']);
                    if ($_POST['ordering-type'] != 'on-table') {
                        if (!empty($_POST['email'])) {
                            /* send email to user */
                           email($_POST['email'], $userdata['name'], $email_subject, $email_body);
                        }
                        /* send email to restaurant */
                        email($userdata['email'], $userdata['name'], $email_subject, $email_body);
                    }
                    /* send notification to firebase */
                    if ($_POST['ordering-type'] == 'on-table') {
                        $msg = ['action' => 'table_check_out', 'table_name' => $_POST['table']];
                        FirebaseNotification($userdata['firebase_token'], $lang, 'table_check_out', $msg);
                    }
                    $msg = ['action' => 'order_pending', 'id' => $sNewId];
                    FirebaseNotification($userdata['firebase_token'], $lang, 'order_pending', $msg);
                    //save customers if exist              
                    if ($loggedin) {
                        $customer_name = validate_input($_POST['name']);
                        $customer_phone_number = validate_input($_POST['phone_number']);
                        $customer_email = validate_input($_POST['email']);
                        $customer_address = validate_input($_POST['address']);
                        $customer_house_number = validate_input($_POST['house_number']);
                        $customer_street_name = validate_input($_POST['street_name']);
                        $customer_city = validate_input($_POST['city']);
                        $customer_zip_code = validate_input($_POST['zip_code']);
                        $update_address = ORM::for_table($config['db']['pre'] . 'customers')->find_one($_SESSION['customer']['id']);
                        $update_address->name = $customer_name;
                        $update_address->phone = $customer_phone_number;
                        $update_address->email = $customer_email;
                        $update_address->address = $customer_address;
                        $update_address->house_number = $customer_house_number;
                        $update_address->street_name = $customer_street_name;
                        $update_address->city = $customer_city;
                        $update_address->zip_code = $customer_zip_code;
                        $update_address->save();
                        //save session
                        $_SESSION['customer']['name'] =  validate_input($_POST['name']);
                        $_SESSION['customer']['phone'] = validate_input($_POST['phone_number']);
                        $_SESSION['customer']['email'] = validate_input($_POST['email']);
                        $_SESSION['customer']['address'] = validate_input($_POST['address']);
                        $_SESSION['customer']['house_number'] = validate_input($_POST['house_number']);
                        $_SESSION['customer']['street_name'] = validate_input($_POST['street_name']);
                        $_SESSION['customer']['city'] = validate_input($_POST['city']);
                        $_SESSION['customer']['zip_code'] = validate_input($_POST['zip_code']);
                    }

                    $result['success'] = true;
                    $result['message'] = '';
                    $result['whatsapp_url'] = '';

                    if ($config['quickorder_enable']) {
                        //$settings = get_all_setting($restaurant['user_id']);
                        $RESTAURANT_WHATSAPP_ORDERING = get_module_settting($restaurant['user_id'], 'whatsapp');
                        if ($RESTAURANT_WHATSAPP_ORDERING == 1) {
                            if (get_restaurant_option($restaurant['id'], 'quickorder_enable', 0)) {
                                if ($_POST['ordering-type'] != 'on-table') {
                                    $whatsapp_number = get_restaurant_option($restaurant['id'], 'whatsapp_number');
                                    $whatsapp_message = get_restaurant_option($restaurant['id'], 'whatsapp_message');
                                    if (empty($whatsapp_message))
                                    $whatsapp_message = $config['quickorder_whatsapp_message'];
                                    $userdata = get_user_data(null, $restaurant['user_id']);
                                    $currency = !empty($userdata['currency']) ? $userdata['currency'] : get_option('currency_code');
                                    $page = new HtmlTemplate();
                                    $page->html = $whatsapp_message;
                                    $page->SetParameter('ORDER_ID', $sNewId);
                                    $page->SetParameter('ORDER_DETAILS', $order_whatsapp_detail);
                                    $page->SetParameter('CUSTOMER_DETAILS', $customer_details);
                                    $page->SetParameter('ORDER_TYPE', $order_type);
                                    $page->SetParameter('SHIPPING_FEE', $sShipping_fee);
                                    $page->SetParameter('TAKEAWAY_DELIVERY_TIME', date('d-m-Y H:i:s', strtotime($takeaway_delivery_time)));
                                    $page->SetParameter('ORDER_TOTAL', price_format($total_amount_order, $currency, false));
                                    $page->SetParameter('DISCOUNT_CODE', $discount_code);
                                    $page->SetParameter('DISCOUNT_PRICE', price_format(-$discount_price, $currency, false));
                                    $whatsapp_message = $page->CreatePageReturn($lang, $config, $link);
                                    $whatsapp_url = 'https://api.whatsapp.com/send?phone=' . $whatsapp_number . '&text=' . urlencode($whatsapp_message);
                                    $result['whatsapp_url'] = $whatsapp_url;
                                    $update_order = ORM::for_table($config['db']['pre'] . 'orders')
                                        ->where('id', $sNewId)
                                        ->find_one();
                                    $update_order->whatsapp_url = $whatsapp_url;
                                    $update_order->save();
                                }
                            }
                        }
                    }
                    if ($_POST['pay_via'] == 'pay_online') {
                        /* Save in session for payment page */
                        // $payment_type = "order";
                        // $access_token = uniqid();

                        // $_SESSION['quickad'][$access_token]['name'] = validate_input($restaurant['name']);
                        // $_SESSION['quickad'][$access_token]['restaurant_id'] = $restaurant['id'];
                        // $_SESSION['quickad'][$access_token]['amount'] = $amount;
                        // $_SESSION['quickad'][$access_token]['payment_type'] = $payment_type;
                        // $_SESSION['quickad'][$access_token]['order_id'] = $sNewId;
                        // $_SESSION['quickad'][$access_token]['whatsapp_url'] = $result['whatsapp_url'];
                        // $_SESSION['quickad'][$access_token]['phone'] = isset($_POST['phone_number']) ? validate_input($_POST['phone_number']) : '';

                        // $url = $link['PAYMENT'] . "/" . $access_token;
                        // $result['message'] = $url;
                    }
                }
            }
        }
    }
    die(json_encode($result));
}

function saveAddressCustomer()
{

    global $config, $lang;
    $result = array('success' => false, 'message' => $lang['ERROR_TRY_AGAIN']);
    $loggedin = checkcustomerloggedin($_POST['restaurant']);
    if (!$loggedin) {
        die(json_encode($result));
    }
    $customer_name = validate_input($_POST['name']);
    $customer_phone_number = validate_input($_POST['phone_number']);
    $customer_email = validate_input($_POST['email']);
    $customer_address = validate_input($_POST['address']);
    $customer_house_number = validate_input($_POST['house_number']);
    $customer_street_name = validate_input($_POST['street_name']);
    $customer_city = validate_input($_POST['city']);
    $customer_zip_code = validate_input($_POST['zip_code']);
    $update_address = ORM::for_table($config['db']['pre'] . 'customers')->find_one($_SESSION['customer']['id']);
    $update_address->name = $customer_name;
    $update_address->phone = $customer_phone_number;
    $update_address->email = $customer_email;
    $update_address->address = $customer_address;
    $update_address->house_number = $customer_house_number;
    $update_address->street_name = $customer_street_name;
    $update_address->city = $customer_city;
    $update_address->zip_code = $customer_zip_code;
    $update_address->save();
    //save session
    $_SESSION['customer']['name'] =  validate_input($_POST['name']);
    $_SESSION['customer']['phone'] = validate_input($_POST['phone_number']);
    $_SESSION['customer']['email'] = validate_input($_POST['email']);
    $_SESSION['customer']['address'] = validate_input($_POST['address']);
    $_SESSION['customer']['house_number'] = validate_input($_POST['house_number']);
    $_SESSION['customer']['street_name'] = validate_input($_POST['street_name']);
    $_SESSION['customer']['city'] = validate_input($_POST['city']);
    $_SESSION['customer']['zip_code'] = validate_input($_POST['zip_code']);
    $result['success'] = true;
    $result['message'] = '';
    die(json_encode($result));
}



function check_user_login()
{
    $loggedin = checkcustomerloggedin($_POST['restaurant_id']);
    $result = array('success' => false, 'message' => '');
    if ($loggedin) {
        $result['success'] = true;
    }
    die(json_encode($result));
}



function deleteImageSlideShow()
{
    global $config, $lang;
    $result = array('success' => false, 'message' => $lang['ERROR_TRY_AGAIN']);
    if (isset($_POST['id'])) {
       $shop_id = getShopId();
        ORM::for_table($config['db']['pre'] . 'shop_image')
            ->where(array(
                'shop_id' => $shop_id,
                'id' => $_POST['id']
            ))
            ->delete_many();

        $result['success'] = true;
        $result['message'] = '';
    }
    die(json_encode($result));
}


function deleteGroupImageById()
{
    global $config, $lang;
    $result = array('success' => false, 'message' => $lang['ERROR_TRY_AGAIN']);
    if (isset($_POST['id'])) {
        $shop_id = getShopId();
        ORM::for_table($config['db']['pre'] . 'shop_image')
            ->where(array(
                'shop_id' => $shop_id,
                'id' => $_POST['id']
            ))
            ->delete_many();
            $data = '';
            $images = ORM::for_table($config['db']['pre'] . 'shop_image')
                      ->where(array('shop_id' => $shop_id, 'group_id' => $_POST['group_id']))
                      ->find_many();
                      foreach ($images as $image) {
                        $data .= '<li><div data-group-id="'. $_POST['group_id'] .'" data-id="'. $image['id'] .'" class="input-file-slide"><img src="'. $config['site_url'] .'/storage/shop/group/'. $image['image'] .'" id="group_image_'.$image['id'].'"><span class="delete_group_image delete_image">&times;</span> <div class="uploadButton uploadButton-slider"><input class="uploadButton-input" type="file" accept="image/*" onchange="EditGroupImage('. $_POST['group_id'] .',&apos;group_image_'. $image['id'] .'&apos;)" id="group_image_upload_'. $image['id'] .'" name="group_image"/> <label class="uploadButton-slider-button ripple-effect" for="group_image_upload_'. $image['id'] .'">Upload</label></div></div></li>';
                      }
        $result['data'] = $data;
        $result['success'] = true;
        $result['message'] = $lang['DELETE_IMAGE_SUCCESS'];
    }
    die(json_encode($result));
}

function deleteCoverImage()
{
    global $config, $lang;
    $result = array('success' => false, 'message' => $lang['ERROR_TRY_AGAIN']);
    if (isset($_POST['id'])) {
        $shop_id = getShopId();
        ORM::for_table($config['db']['pre'] . 'shop_image')
            ->where(array(
                'shop_id' => $shop_id['id'],
                'id' => $_POST['id']
            ))
            ->delete_many();
            $data = '';
            $images = ORM::for_table($config['db']['pre'] . 'shop_image')
                      ->where(array('shop_id' => $shop_id['id'], 'image_type' => $_POST['image_type']))
                      ->find_many();
                      foreach ($images as $image) {
                            //$data .= '<li><div data-id="'. $image['id'] .'" class="input-file-slide"><img src="'. $config['site_url'] .'/storage/shop/cover/'. $image['image'] .'" id="shop_cover_image_'.$image['id'].'"><span class="delete_cover_image">&times;</span> <div class="uploadButton uploadButton-slider"><input class="uploadButton-input" type="file" accept="image/*" onchange="readImageURLAndEdit(this,&apos;shop_cover_image_'. $image['id'] .'&apos;,&apos;banner&apos;)" id="cover_upload_'. $image['id'] .'" name="shop_cover_image"/> <label class="uploadButton-slider-button ripple-effect" for="cover_upload_'. $image['id'] .'">Uploadss</label></div></div></li>';
                            $data .= getBannerSliderItemContent($image, $config['site_url']);
                      }
        $result['data'] = $data;
        $result['success'] = true;
        $result['message'] = $lang['DELETE_IMAGE_SUCCESS'];
    }
    die(json_encode($result));
}

function deleteFooterImage()
{
    global $config, $lang;
    $result = array('success' => false, 'message' => $lang['ERROR_TRY_AGAIN']);
    if (isset($_POST['id'])) {
        $shop_id = getShopId();
        ORM::for_table($config['db']['pre'] . 'shop_image')
            ->where(array(
                'shop_id' => $shop_id['id'],
                'id' => $_POST['id']
            ))
            ->delete_many();
            $data = '';
            $images = ORM::for_table($config['db']['pre'] . 'shop_image')
                      ->where(array('shop_id' => $shop_id['id'], 'image_type' => 'footer_image'))
                      ->find_many();
                      foreach ($images as $image) {
                        $data .= '<li><div data-id="'. $image['id'] .'" class="input-file-slide"><img src="'. $config['site_url'] .'/storage/shop/footer/'. $image['image'] .'" id="shop_footer_image_'.$image['id'].'"><span class="delete_footer_image delete_image">&times;</span> <div class="uploadButton uploadButton-slider"><input class="uploadButton-input" type="file" accept="image/*" onchange="EditFooterImage(this,&apos;shop_footer_image_'. $image['id'] .'&apos;,&apos;footer_image&apos;)" id="footer_image_upload_'. $image['id'] .'" name="shop_footer_image"/> <label class="uploadButton-slider-button ripple-effect" for="footer_image_upload_'. $image['id'] .'">Upload</label></div></div></li>';
                      }
        $result['data'] = $data;
        $result['success'] = true;
        $result['message'] = $lang['DELETE_IMAGE_SUCCESS'];
    }
    die(json_encode($result));
}
function deleteBooking()
{
    global $config, $lang;
    $result = array('success' => false, 'message' => $lang['ERROR_TRY_AGAIN']);
    if (isset($_POST['id'])) {
        // get restaurant
        $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
            ->where('user_id', $_SESSION['user']['id'])
            ->find_one();
        // get order
        $bookings = ORM::for_table($config['db']['pre'] . 'booking_table')
            ->where(array(
                'restaurant_id' => $restaurant['id'],
                'id' => $_POST['id']
            ))
            ->find_one();
        // $bookings->status = 'delete';
        // $bookings->save();
        if (isset($bookings['id'])) {
            ORM::for_table($config['db']['pre'] . 'booking_table')
                ->where(array(
                    'restaurant_id' => $restaurant['id'],
                    'id' => $bookings['id']
                ))
                ->delete_many();
        }
        $userdata = get_user_data(null, $_SESSION['user']['id']);
        $msg = ['action' => 'booking_delete', 'id' =>  $_POST['id']];
        FirebaseNotification($userdata['firebase_token'], $lang, 'booking_delete', $msg);
        $result['success'] = true;
        $result['message'] = '';
    }
    die(json_encode($result));
}

/**
 * Delete order Reserve
 */
function deleteOrderReserve()
{
    global $config, $lang, $link;
    $result = array('success' => false, 'message' => $lang['ERROR_TRY_AGAIN']);
    if (isset($_POST['id'])) {
        // get restaurant
        $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
            ->where('user_id', $_SESSION['user']['id'])
            ->find_one();

        $reserve = ORM::for_table($config['db']['pre'] . 'reserve')
            ->where(array(
                'restaurant_id' => $restaurant['id'],
                'id' => $_POST['id']
            ))
            ->find_one();
        $reserve->status = 'cancelled';
        $reserve->cancellation_reason = $_POST['cancellation_reason'];
        $reserve->updated_at = date("Y-m-d H:i:s");
        $reserve->save();
        //update reserve customer info
      $reserve_customer_info =  ORM::for_table($config['db']['pre'] . 'reserve_customer_info')
        ->where('reserve_id', $_POST['id'])
        ->find_one();
      $reserve_customer_info->deleted = 1;
      $reserve_customer_info->save();
        
    $reserve_items = ORM::for_table($config['db']['pre'] . 'reserve_items')
        ->where('reserve_id',  $_POST['id'])
        ->find_many();
    foreach ($reserve_items as $item) {
    $reserve_item_extras =  ORM::for_table($config['db']['pre'] . 'reserve_item_extras')
            ->where('reserve_item_id', $item->id)
            ->find_many();
    $reserve_item_extras->set('is_cancelled_order', 1);
    $reserve_item_extras->save();
    }
    $reserve_items->set('is_cancelled_order', 1);
    $reserve_items->save();
    $result['success'] = true;
    $result['message'] = '';
    }
    $userdata = get_user_data(null, $restaurant['user_id']);

    //send email and Whatsapps
    $icon_menu_item = "▪️";
    $icon_menu_extra = "▫️";
    $icon_phone = "☎️";
    $icon_hash = "#️⃣";
    $icon_address = "📌";
    $icon_message = "📝";
    $icon_email = "📧";
    $order_msg = $order_whatsapp_detail = '';

    $user_lang = !empty($_COOKIE['Quick_user_lang_code']) ? $_COOKIE['Quick_user_lang_code'] : $config['lang_code'];
    $items =  ORM::for_table($config['db']['pre'] . 'reserve_items')
    ->where(array('reserve_id'=> $_POST['id'],'deleted' => 0))
    ->find_many();
    $amount = 0;
    $amount = $reserve['amount'];
    foreach ($items as $item) {
        $menu = ORM::for_table($config['db']['pre'] . 'menu')
            ->where('id', $item['item_id'])
            ->find_one();
        $item_id = $item['item_id'];
        $quantity = $item['quantity'];
        $amount_item =    $item['item_price'];
        $total_amount = $item['item_price'] * $quantity;
        $amount_reduced = !empty($menu['discount_price']) ? ($menu['price'] - $menu['discount_price']) * $quantity : 0;
       // $amount += $total_amount;
            if (!$config['email_template']) {
                $order_msg .= $item['name'] . ($quantity > 1 ? ' &times; ' . $quantity : '') . '<br>';
            } else {
                $order_msg .= $item['name'] . ($quantity > 1 ? ' X ' . $quantity : '') . "\n";
            }
            $json = json_decode($menu['translation'], true);
            //  $title = !empty($json[$user_lang]['title']) ? $json[$user_lang]['title'] : $menu['name'];
            $title = $item['name'];
            $order_whatsapp_detail .= $icon_menu_item . $title . ' X ' . $quantity . "\n";

            $extras = ORM::for_table($config['db']['pre'] . 'reserve_item_extras')
            ->where('reserve_item_id', $item['id'])
            ->find_many();//
            foreach ($extras as $extra) {
                $menu_extra = ORM::for_table($config['db']['pre'] . 'menu_extras')
                    ->where('id', $extra['extra_id'])
                    ->find_one();

                if (isset($menu_extra['id'])) {            
                   // $amount += $menu_extra['price'] * $quantity;
                    if (!$config['email_template']) {
                        $order_msg .= $menu_extra['title'] . '<br>';
                    } else {
                        $order_msg .= $menu_extra['title'] . "\n";
                    }
                    $json = json_decode($menu_extra['translation'], true);
                    $title = !empty($json[$user_lang]['title']) ? $json[$user_lang]['title'] : $menu_extra['title'];

                    $order_whatsapp_detail .= $icon_menu_extra . $title . "\n";
                }
            }
            if (!$config['email_template']) {
                $order_msg .= '<br>';
            } else {
                $order_msg .= "\n";
            }
        
    }

    $currency = !empty($userdata['currency']) ? $userdata['currency'] : get_option('currency_code');
    
    $table = '';
    $phone = '';
    $email ='';
    $address = '';
    $cancellation_reason = $_POST['cancellation_reason'];
    $reserve_customer_info = ORM::for_table($config['db']['pre'] . 'reserve_customer_info')
    ->where('reserve_id', $_POST['id'])
    ->find_one();
    $name = $reserve_customer_info['customer_name'];
    if ($reserve['type'] == 'takeaway') {
        $phone = validate_input($reserve_customer_info['phone_number']);
        $email = validate_input($reserve_customer_info['email']);
    } else if ($reserve['type'] == 'delivery') {
        $address = validate_input($reserve_customer_info['address']);
        $phone = validate_input($reserve_customer_info['phone_number']);
        $email = validate_input($reserve_customer_info['email']);
    }

    $customer_details = validate_input($reserve_customer_info['customer_name']) . "\n";
    if ($reserve['type'] == 'takeaway') {
        $customer_details .= $icon_phone . ' ' . validate_input($reserve_customer_info['phone_number']) . "\n";
        $customer_details .= !empty($reserve_customer_info['email']) ? $icon_email . ' ' . validate_input($reserve_customer_info['email']) : '';
    } else if ($reserve['type'] == 'delivery') { 
        $customer_details .= $icon_phone . ' ' . validate_input($reserve_customer_info['phone_number']) . "\n";
        $customer_details .= !empty($reserve_customer_info['email']) ? $icon_email . ' ' . validate_input($reserve_customer_info['email']) . "\n" : '';
        $customer_details .= $icon_address . ' ' . validate_input($reserve_customer_info['address']) . "\n";
   
    }
    $order_type = $reserve['type'] == 'takeaway'? $lang['TAKEAWAY'] : $lang['DELIVERY'];
    $discount_code = $reserve['coupons_code'];
    $discount_price = $reserve['include_total_discount_value'];
    $shipping_fee = $reserve['type'] == 'takeaway'? '' : validate_input($reserve['shipping_fee']);
    $page = new HtmlTemplate();
    $page->html = $config['email_sub_canceled_pre_order'];
    $page->SetParameter('RESTAURANT_NAME', $restaurant['name']);
    $page->SetParameter('CUSTOMER_NAME', $name);
    $page->SetParameter('TABLE_NUMBER', $table);
    $page->SetParameter('PHONE_NUMBER', $phone);
    $page->SetParameter('ADDRESS', $address);
    $page->SetParameter('EMAIL', $email);
    $page->SetParameter('CANCELLATION_REASON', $cancellation_reason);
    $page->SetParameter('SHIPPING_FEE', $shipping_fee);
    $page->SetParameter('ORDER_TYPE', $order_type);
    $email_subject = $page->CreatePageReturn($lang, $config, $link);

    $page = new HtmlTemplate();
    $page->html = $config['email_message_canceled_pre_order'];
    $page->SetParameter('RESTAURANT_NAME', $restaurant['name']);
    $page->SetParameter('CUSTOMER_NAME', $name);
    $page->SetParameter('TABLE_NUMBER', $table);
    $page->SetParameter('PHONE_NUMBER', $phone);
    $page->SetParameter('ADDRESS', $address);
    $page->SetParameter('EMAIL', $email);
    $page->SetParameter('TAKEAWAY_DELIVERY_TIME', date('d-m-Y H:i:s', strtotime($reserve['date_reserve'])));
    $page->SetParameter('CANCELLATION_REASON', $cancellation_reason);
    $page->SetParameter('SHIPPING_FEE', $shipping_fee);
    $page->SetParameter('ORDER_TYPE', $order_type);
    $page->SetParameter('DISCOUNT_CODE', $discount_code);
    $page->SetParameter('DISCOUNT_PRICE', price_format(-$discount_price, $currency, false));
    $page->SetParameter('ORDER', $order_msg);
    $page->SetParameter('ORDER_TOTAL', price_format($amount, $currency, false));

    $email_body = $page->CreatePageReturn($lang, $config, $link);

    $userdata = get_user_data(null, $restaurant['user_id']);

    if (!empty($email)) {
        /* send email to user */
        email($email, $userdata['name'], $email_subject, $email_body);
    }
    /* send email to restaurant */
    email($userdata['email'], $userdata['name'], $email_subject, $email_body);
    $result['success'] = true;
    $result['message'] = '';
    $result['whatsapp_url'] = '';

    // if ($config['quickorder_enable']) {
    //     //$settings = get_all_setting($restaurant['user_id']);
    //     $RESTAURANT_WHATSAPP_ORDERING = get_module_settting($restaurant['user_id'], 'whatsapp');
    //     if ($RESTAURANT_WHATSAPP_ORDERING == 1) {
    //         if (get_restaurant_option($restaurant['id'], 'quickorder_enable', 0)) { 
    //                 $whatsapp_number = $phone;
    //                 $whatsapp_message = get_restaurant_option($restaurant['id'], 'whatsapp_canceled_pre_order_message');
    //                 $userdata = get_user_data(null, $restaurant['user_id']);
    //                 $currency = !empty($userdata['currency']) ? $userdata['currency'] : get_option('currency_code');
    //                 $page = new HtmlTemplate();
    //                 $page->html = $whatsapp_message;
    //                 $page->SetParameter('ORDER_ID', $_POST['id']);
    //                 $page->SetParameter('ORDER_DETAILS', $order_whatsapp_detail);
    //                 $page->SetParameter('CUSTOMER_DETAILS', $customer_details);
    //                 $page->SetParameter('ORDER_TYPE', $order_type);
    //                 $page->SetParameter('SHIPPING_FEE', validate_input($reserve['shipping_fee']));
    //                 $page->SetParameter('TAKEAWAY_DELIVERY_TIME', date('d-m-Y H:i:s', strtotime($reserve['date_reserve'])));
    //                 $page->SetParameter('ORDER_TOTAL', price_format($amount, $currency, false));
    //                 $page->SetParameter('DISCOUNT_CODE', $discount_code);
    //                 $page->SetParameter('CANCELLATION_REASON', $cancellation_reason);
    //                 $page->SetParameter('DISCOUNT_PRICE', price_format(-$discount_price, $currency, false));
    //                 $whatsapp_message = $page->CreatePageReturn($lang, $config, $link);
    //                 $whatsapp_url = 'https://api.whatsapp.com/send?phone=' . $whatsapp_number . '&text=' . urlencode($whatsapp_message);
    //                 $result['whatsapp_url'] = $whatsapp_url;
                
    //         }
    //     }
    // }
    /* send notification to firebase */
    $msg = ['action' => 'reserve_delete', 'id' => $_POST['id']];
    FirebaseNotification($userdata['firebase_token'], $lang, 'reserve_delete', $msg);
    die(json_encode($result));
}
function cancelModule()
{
    global $config, $lang;
    $result = array('success' => false, 'message' => $lang['ERROR_TRY_AGAIN']);
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }
    if (isset($_POST['id'])) {
        // get restaurant
        $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
            ->where('user_id', $_SESSION['user']['id'])
            ->find_one();
        // ORM::for_table($config['db']['pre'] . 'module_upgrades')
        // ->where(array(
        //     'user_id' => $_SESSION['user']['id'],
        //     'id' => $_POST['id']
        // ))->delete_many();

        $module = ORM::for_table($config['db']['pre'] . 'module_upgrades')
            ->where(array(
                'user_id' => $_SESSION['user']['id'],
                'id' => $_POST['id']
            ))
            ->order_by_desc('date_created')
            ->find_one();
        if ($module['active'] == "0") {

            ORM::for_table($config['db']['pre'] . 'module_upgrades')
                ->where(array(
                    'user_id' => $_SESSION['user']['id'],
                    'id' => $_POST['id']
                ))->delete_many();
        } else {
            $module->status = 'canceled';
            $module->date_canceled = date("Y-m-d H:i:s");
            $module->save();
        }
        $result['success'] = true;
        $result['message'] = '';
    }
    die(json_encode($result));
}
/**
 * Delete order
 */
function deleteOrder()
{
    global $config, $lang;

    $result = array('success' => false, 'message' => $lang['ERROR_TRY_AGAIN']);
    if (!checkloggedin()) {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }
    if (isset($_POST['id'])) {
        // get restaurant
        $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
            ->where('user_id', $_SESSION['user']['id'])
            ->find_one();

        $orders = ORM::for_table($config['db']['pre'] . 'orders')
            ->where(array(
                'restaurant_id' => $restaurant['id'],
                'id' => $_POST['id']
            ))
            ->find_one();
        $orders->status = 'cancelled';
        $orders->is_send_email_canceled = '1';
        $orders->updated_at = date("Y-m-d H:i:s");
        $orders->save();

          //update order customer info
      $order_customer_info =  ORM::for_table($config['db']['pre'] . 'order_customer_info')
      ->where('order_id', $_POST['id'])
      ->find_one();
      if(!empty($order_customer_info['id']))
      {
        $order_customer_info->deleted = 1;
        $order_customer_info->save();
      }    
  $order_items = ORM::for_table($config['db']['pre'] . 'order_items')
      ->where('order_id',  $_POST['id'])
      ->find_many();
  foreach ($order_items as $item) {
  $order_item_extras =  ORM::for_table($config['db']['pre'] . 'order_item_extras')
          ->where('order_item_id', $item->id)
          ->find_many();
  $order_item_extras->set('deleted', 1);
  $order_item_extras->save();
  }
  $order_items->set('deleted', 1);
  $order_items->save();
  $result['success'] = true;
  $result['message'] = '';
    }
    $userdata = get_user_data(null, $restaurant['user_id']);
    /* send notification to firebase */
    $msg = ['action' => 'order_delete', 'id' => $_POST['id']];
    FirebaseNotification($userdata['firebase_token'], $lang, 'order_delete', $msg);
    die(json_encode($result));
}
function getListOrdersReserve()
{
    global $config, $lang;
    $orders_data = array();

    if (checkloggedin()) {
        $ses_userdata = get_user_data($_SESSION['user']['username']);
        $currency = !empty($ses_userdata['currency']) ? $ses_userdata['currency'] : get_option('currency_code');

        $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
            ->where('user_id', $_SESSION['user']['id'])
            ->find_one();
        $order_id_array = json_decode($_POST['order_id_array'], true);
        if (isset($restaurant['user_id'])) {
            $orders = ORM::for_table($config['db']['pre'] . 'reserve')
                ->table_alias('o')
                ->select_many('o.*', 'c.customer_name', 'c.phone_number', 'c.address', 'c.email')
                ->where_in('o.id',$order_id_array)
                ->left_outer_join($config['db']['pre'] . 'reserve_customer_info', array('o.id', '=', 'c.reserve_id'), 'c')
                ->order_by_desc('date_reserve')->find_many();

            foreach ($orders as $order) {
                $orders_data[$order['id']]['id'] = $order['id'];
                $orders_data[$order['id']]['type'] = $order['type'];
                $orders_data[$order['id']]['customer_name'] = escape($order['customer_name']);
                $orders_data[$order['id']]['table_number'] = escape($order['table_number']);
                $orders_data[$order['id']]['phone_number'] = escape($order['phone_number']);
                $orders_data[$order['id']]['address'] = escape($order['address']);
                $orders_data[$order['id']]['is_paid'] = $order['is_paid'];
                $orders_data[$order['id']]['status'] = $order['status'];
                $orders_data[$order['id']]['is_disabled'] = $order['is_disabled'];
                $orders_data[$order['id']]['email'] = escape($order['email']);
                $orders_data[$order['id']]['message'] = escape($order['message']);
                $orders_data[$order['id']]['created_at'] = date('d.m H:i', strtotime($order['created_at']));
                $orders_data[$order['id']]['date_reserve'] = date('d.m H:i', strtotime($order['date_reserve']));

                $order_shipping_fee = $order['type'] == "takeaway" ? 0 : $order['shipping_fee'];
                $include_total_discount_value = empty($order['include_total_discount_value']) ? 0 : $order['include_total_discount_value'];
                $coupons_code = empty($order['coupons_code']) ? '' : $order['coupons_code'];
                // get order items
                $order_items = ORM::for_table($config['db']['pre'] . 'reserve_items')
                    ->table_alias('oi')
                    ->select_many('oi.*')
                    ->where(array(
                        'reserve_id' => $order['id'],'deleted' => 0
                    ))
                    ->join($config['db']['pre'] . 'menu', array('oi.item_id', '=', 'm.id'), 'm')
                    ->order_by_desc('id')
                    ->find_many();

                $orders_data[$order['id']]['items_tpl'] = $print_tpl = '';
                $price = 0;
                foreach ($order_items as $order_item) {
                    $tpl = '<div class="order-table-item">';
                    $tpl .= '<strong><i class="icon-material-outline-restaurant"></i> ' . $order_item['name'] . '</strong>';
                    if ($order_item['quantity'] > 1) {
                        $tpl .= ' &times; ' . $order_item['quantity'];
                    }
                    $price += $order_item['total_amount'];

                    // get order extras
                    $order_item_extras = ORM::for_table($config['db']['pre'] . 'reserve_item_extras')
                        ->table_alias('oie')
                        ->select_many('oie.*', 'me.title', 'me.price')
                        ->where(array(
                            'reserve_item_id' => $order_item['id'],'deleted' => 0
                        ))
                        ->join($config['db']['pre'] . 'menu_extras', array('oie.extra_id', '=', 'me.id'), 'me')
                        ->order_by_desc('id')
                        ->find_many();

                    $print_tpl_extra = $print_tpl_menu = '';
                    $print_tpl_menu .= '<tr><td>' . $order_item['name'] . ' &times; ' . $order_item['quantity'] . '</td><td>' . price_format($order_item['total_amount'], $currency) . '</td></tr>';

                    if ($order_item_extras->count()) {
                        $tpl .= '<div  class="padding-left-10">';
                        foreach ($order_item_extras as $order_item_extra) {
                            $price += $order_item_extra['price'] * $order_item['quantity'];
                            $tpl .= '<div><i class="icon-feather-plus"></i> ' . $order_item_extra['title'] . '</div>';
                            $print_tpl_extra .= '<tr class="order-menu-extra"><td><span class="margin-left-5">' . $order_item_extra['title'] . '</span></td><td>' . price_format($order_item_extra['price'] * $order_item['quantity'], $currency) . '</td></tr>';
                        }
                        $tpl .= '</div>';
                    }
                    $tpl .= '</div>';
                    $orders_data[$order['id']]['items_tpl'] .= $tpl;
                    $print_tpl .= $print_tpl_menu . $print_tpl_extra;
                }

                $price += $order_shipping_fee - $include_total_discount_value;
                $price = $price < 0 ? 0 : $price;
                $dorder_shipping_fee = $order_shipping_fee;
                $include_total_discount_value_format = price_format(-$include_total_discount_value, $currency);
                $order_shipping_fee = price_format($order_shipping_fee, $currency);

                $orders_data[$order['id']]['price'] = price_format($price, $currency);
                $orders_data[$order['id']]['price_number'] = $price;

                if ($orders_data[$order['id']]['type'] == 'takeaway')
                    $type = $lang['TAKEAWAY'];
                elseif ($orders_data[$order['id']]['type'] == 'delivery')
                    $type = $lang['DELIVERY'];

                $order_print_tpl = "<table>
                            <tr>
                                <td>{$lang['TIME']}</td>
                                <td>{$orders_data[$order['id']]['created_at']}</td>
                            </tr>
                            <tr>
                                <td>{$lang['NAME']}</td>
                                <td>{$orders_data[$order['id']]['customer_name']}</td>
                            </tr>
                            <tr>
                                <td>{$lang['TABLE_NO_ORDER_TYPE']}</td>
                                <td>$type</td>
                            </tr>" .
                    (!empty($orders_data[$order['id']]['phone_number']) ? "<tr>
                                <td>{$lang['PHONE']}</td>
                                <td>{$orders_data[$order['id']]['phone_number']}</td>
                            </tr>" : '')
                    .
                    (!empty($orders_data[$order['id']]['email']) ? "<tr>
                    <td>{$lang['EMAIL']}</td>
                    <td>{$orders_data[$order['id']]['email']}</td>
                </tr>" : '') .
                (!empty($orders_data[$order['id']]['date_reserve'])?"<tr>
                <td>{$lang['DELIVERY_TAKEAWAY_TIME']}</td>
                <td>{$orders_data[$order['id']]['date_reserve']}</td>
            </tr>":'') .
                    (!empty($orders_data[$order['id']]['address']) ? "<tr>
                                <td>{$lang['ADDRESS']}</td>
                                <td>{$orders_data[$order['id']]['address']}</td>
                            </tr>" : '') .
                    (!empty($orders_data[$order['id']]['message']) ? "<tr>
                                <td>{$lang['MESSAGE']}</td>
                                <td>{$orders_data[$order['id']]['message']}</td>
                            </tr>" : '') .
                    (!empty($orders_data[$order['id']]['is_paid']) ? "<tr>
                                <td>{$lang['PAYMENT']}</td>
                                <td>{$lang['PAID']}</td>
                            </tr>" : '') . "
                        </table>
                        <div class='order-print-divider'></div>
                        <table class='order-print-menu'>
                            <thead>
                            <tr>
                                <th>{$lang['MENU']}</th>
                                <th>{$lang['PRICE']}</th>
                            </tr>
                            </thead>
                            <tbody id='order-print-menu'>$print_tpl</tbody>
                            <tfoot>
                            " . (!empty($dorder_shipping_fee) ? "
                            <tr>
                            <th style='text-align:left'>{$lang['SHIPPING_FEE']}</th>
                            <td>{$order_shipping_fee}</td>
                        </tr>" : "")  . (!empty($coupons_code) ? "
                        <tr>
                        <th style='text-align:left'>{$lang['COUPON']}: {$coupons_code}</th>
                        <td>{$include_total_discount_value_format}</td>
                    </tr>" : "") . "<tr>
                                <th>{$lang['TOTAL']}</th>
                                <th>{$orders_data[$order['id']]['price']}</th>
                            </tr>
                            </tfoot>
                        </table>";

                $orders_data[$order['id']]['order_print_tpl'] = $order_print_tpl;

                $orders = ORM::for_table($config['db']['pre'] . 'reserve')->find_one($order['id']);
                $orders->seen = 1;
                $orders->save();
            }
        }
    }
    die(json_encode($orders_data));
}
function getOrdersReserve()
{
    global $config, $lang;
    $orders_data = array();

    if (checkloggedin()) {
        $ses_userdata = get_user_data($_SESSION['user']['username']);
        $currency = !empty($ses_userdata['currency']) ? $ses_userdata['currency'] : get_option('currency_code');

        $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
            ->where('user_id', $_SESSION['user']['id'])
            ->find_one();

        if (isset($restaurant['user_id'])) {
            $orders = ORM::for_table($config['db']['pre'] . 'reserve')
                ->table_alias('o')
                ->select_many('o.*', 'c.customer_name', 'c.phone_number', 'c.address', 'c.email')
                ->where(array(
                    'o.restaurant_id' => $restaurant['id'],
                    'o.seen' => 0
                ))
                ->left_outer_join($config['db']['pre'] . 'reserve_customer_info', array('o.id', '=', 'c.reserve_id'), 'c')
                ->order_by_desc('id')->find_many();

            foreach ($orders as $order) {
                $orders_data[$order['id']]['id'] = $order['id'];
                $orders_data[$order['id']]['type'] = $order['type'];
                $orders_data[$order['id']]['customer_name'] = escape($order['customer_name']);
                $orders_data[$order['id']]['table_number'] = escape($order['table_number']);
                $orders_data[$order['id']]['phone_number'] = escape($order['phone_number']);
                $orders_data[$order['id']]['address'] = escape($order['address']);
                $orders_data[$order['id']]['is_paid'] = $order['is_paid'];
                $orders_data[$order['id']]['status'] = $order['status'];
                $orders_data[$order['id']]['is_disabled'] = $order['is_disabled'];
                $orders_data[$order['id']]['email'] = escape($order['email']);
                $orders_data[$order['id']]['message'] = escape($order['message']);
                $orders_data[$order['id']]['created_at'] = date('d.m H:i', strtotime($order['created_at']));
                $orders_data[$order['id']]['date_reserve'] = date('d.m H:i', strtotime($order['date_reserve']));

                $order_shipping_fee = $order['type'] == "takeaway" ? 0 : $order['shipping_fee'];
                $include_total_discount_value = empty($order['include_total_discount_value']) ? 0 : $order['include_total_discount_value'];
                $coupons_code = empty($order['coupons_code']) ? '' : $order['coupons_code'];
                // get order items
                $order_items = ORM::for_table($config['db']['pre'] . 'reserve_items')
                    ->table_alias('oi')
                    ->select_many('oi.*', 'm.name')
                    ->where(array(
                        'reserve_id' => $order['id'],'deleted' => 0
                    ))
                    ->join($config['db']['pre'] . 'menu', array('oi.item_id', '=', 'm.id'), 'm')
                    ->order_by_desc('id')
                    ->find_many();

                $orders_data[$order['id']]['items_tpl'] = $print_tpl = '';
                $price = 0;
                foreach ($order_items as $order_item) {
                    $tpl = '<div class="order-table-item">';
                    $tpl .= '<strong><i class="icon-material-outline-restaurant"></i> ' . $order_item['name'] . '</strong>';
                    if ($order_item['quantity'] > 1) {
                        $tpl .= ' &times; ' . $order_item['quantity'];
                    }
                    $price += $order_item['total_amount'];

                    // get order extras
                    $order_item_extras = ORM::for_table($config['db']['pre'] . 'reserve_item_extras')
                        ->table_alias('oie')
                        ->select_many('oie.*', 'me.title', 'me.price')
                        ->where(array(
                            'reserve_item_id' => $order_item['id'],'deleted' => 0
                        ))
                        ->join($config['db']['pre'] . 'menu_extras', array('oie.extra_id', '=', 'me.id'), 'me')
                        ->order_by_desc('id')
                        ->find_many();

                    $print_tpl_extra = $print_tpl_menu = '';
                    $print_tpl_menu .= '<tr><td>' . $order_item['name'] . ' &times; ' . $order_item['quantity'] . '</td><td>' . price_format($order_item['total_amount'], $currency) . '</td></tr>';

                    if ($order_item_extras->count()) {
                        $tpl .= '<div  class="padding-left-10">';
                        foreach ($order_item_extras as $order_item_extra) {
                            $price += $order_item_extra['price'] * $order_item['quantity'];
                            $tpl .= '<div><i class="icon-feather-plus"></i> ' . $order_item_extra['title'] . '</div>';
                            $print_tpl_extra .= '<tr class="order-menu-extra"><td><span class="margin-left-5">' . $order_item_extra['title'] . '</span></td><td>' . price_format($order_item_extra['price'] * $order_item['quantity'], $currency) . '</td></tr>';
                        }
                        $tpl .= '</div>';
                    }
                    $tpl .= '</div>';
                    $orders_data[$order['id']]['items_tpl'] .= $tpl;
                    $print_tpl .= $print_tpl_menu . $print_tpl_extra;
                }

                $price += $order_shipping_fee - $include_total_discount_value;
                $price = $price < 0 ? 0 : $price;
                $dorder_shipping_fee = $order_shipping_fee;
                $include_total_discount_value_format = price_format(-$include_total_discount_value, $currency);
                $order_shipping_fee = price_format($order_shipping_fee, $currency);

                $orders_data[$order['id']]['price'] = price_format($price, $currency);
                $orders_data[$order['id']]['price_number'] = $price;

                if ($orders_data[$order['id']]['type'] == 'takeaway')
                    $type = $lang['TAKEAWAY'];
                elseif ($orders_data[$order['id']]['type'] == 'delivery')
                    $type = $lang['DELIVERY'];

                $order_print_tpl = "<table>
                            <tr>
                                <td>{$lang['TIME']}</td>
                                <td>{$orders_data[$order['id']]['created_at']}</td>
                            </tr>
                            <tr>
                                <td>{$lang['NAME']}</td>
                                <td>{$orders_data[$order['id']]['customer_name']}</td>
                            </tr>
                            <tr>
                                <td>{$lang['TABLE_NO_ORDER_TYPE']}</td>
                                <td>$type</td>
                            </tr>" .
                    (!empty($orders_data[$order['id']]['phone_number']) ? "<tr>
                                <td>{$lang['PHONE']}</td>
                                <td>{$orders_data[$order['id']]['phone_number']}</td>
                            </tr>" : '')
                    .
                    (!empty($orders_data[$order['id']]['email']) ? "<tr>
                    <td>{$lang['EMAIL']}</td>
                    <td>{$orders_data[$order['id']]['email']}</td>
                </tr>" : '') .
                (!empty($orders_data[$order['id']]['date_reserve'])?"<tr>
                <td>{$lang['DELIVERY_TAKEAWAY_TIME']}</td>
                <td>{$orders_data[$order['id']]['date_reserve']}</td>
            </tr>":'') .
                    (!empty($orders_data[$order['id']]['address']) ? "<tr>
                                <td>{$lang['ADDRESS']}</td>
                                <td>{$orders_data[$order['id']]['address']}</td>
                            </tr>" : '') .
                    (!empty($orders_data[$order['id']]['message']) ? "<tr>
                                <td>{$lang['MESSAGE']}</td>
                                <td>{$orders_data[$order['id']]['message']}</td>
                            </tr>" : '') .
                    (!empty($orders_data[$order['id']]['is_paid']) ? "<tr>
                                <td>{$lang['PAYMENT']}</td>
                                <td>{$lang['PAID']}</td>
                            </tr>" : '') . "
                        </table>
                        <div class='order-print-divider'></div>
                        <table class='order-print-menu'>
                            <thead>
                            <tr>
                                <th>{$lang['MENU']}</th>
                                <th>{$lang['PRICE']}</th>
                            </tr>
                            </thead>
                            <tbody id='order-print-menu'>$print_tpl</tbody>
                            <tfoot>
                            " . (!empty($dorder_shipping_fee) ? "
                            <tr>
                            <th style='text-align:left'>{$lang['SHIPPING_FEE']}</th>
                            <td>{$order_shipping_fee}</td>
                        </tr>" : "")  . (!empty($coupons_code) ? "
                        <tr>
                        <th style='text-align:left'>{$lang['COUPON']}: {$coupons_code}</th>
                        <td>{$include_total_discount_value_format}</td>
                    </tr>" : "") . "<tr>
                                <th>{$lang['TOTAL']}</th>
                                <th>{$orders_data[$order['id']]['price']}</th>
                            </tr>
                            </tfoot>
                        </table>";

                $orders_data[$order['id']]['order_print_tpl'] = $order_print_tpl;

                $orders = ORM::for_table($config['db']['pre'] . 'reserve')->find_one($order['id']);
                $orders->seen = 1;
                $orders->save();
            }
        }
    }
    die(json_encode($orders_data));
}


function getListBookings()
{
    global $config;
    $booking_data = array();
    if (checkloggedin()) {
        $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
            ->where('user_id', $_SESSION['user']['id'])
            ->find_one();
            $booking_id_array = json_decode($_POST['booking_id_array'], true);
        if (isset($restaurant['user_id'])) {
            $bookings = ORM::for_table($config['db']['pre'] . 'booking_table')
                ->where(array(
                    'restaurant_id' => $restaurant['id']
                ))
                ->where_in('id',$booking_id_array)
                ->order_by_asc('id')->find_many();
            foreach ($bookings as $booking) {
                $booking_data[$booking['id']]['id'] = $booking['id'];
                $booking_data[$booking['id']]['customer_name'] = escape($booking['customer_name']);
                $booking_data[$booking['id']]['table_number'] = escape($booking['table_number']);
                $booking_data[$booking['id']]['phone_number'] = $booking['phone_number'];
                $booking_data[$booking['id']]['ticket'] = $booking['ticket'];
                $booking_data[$booking['id']]['status'] = $booking['status'];
                $booking_data[$booking['id']]['email'] = $booking['email'];
                $booking_data[$booking['id']]['note'] = $booking['note'];

                $booking_data[$booking['id']]['date'] = date_format(date_create($booking['date_from']), "d.m.Y");
                $booking_data[$booking['id']]['date_from'] = date_format(date_create($booking['date_from']), "H:i");
                $booking_data[$booking['id']]['date_to'] = date_format(date_create($booking['date_to']), "H:i");

                $bookings_update = ORM::for_table($config['db']['pre'] . 'booking_table')->find_one($booking['id']);
                $bookings_update->seen = 1;
                $bookings_update->save();
            }
        }
    }
    die(json_encode($booking_data));
}

function get_whatsapp_message()
{
    global $config, $lang;
    $result = array('success' => false, 'message' => $lang['ERROR_TRY_AGAIN']);
    if (checkloggedin()) {
        $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
            ->where('user_id', $_SESSION['user']['id'])
            ->find_one();
        if (isset($restaurant['user_id'])) {
            $whatsapp_message = get_restaurant_option($restaurant['id'],'whatsapp_message');
        $whatsapp_booking_message = get_restaurant_option($restaurant['id'],'whatsapp_booking_message');
        $whatsapp_pre_order_message = get_restaurant_option($restaurant['id'],'whatsapp_pre_order_message');
        $whatsapp_canceled_pre_order_message = get_restaurant_option($restaurant['id'],'whatsapp_canceled_pre_order_message');   
        if(empty($whatsapp_booking_message))
        {
        $whatsapp_booking_message = $config['quickorder_whatsapp_booking_message'];
        }
        if(empty($whatsapp_message))
            $whatsapp_message = $config['quickorder_whatsapp_message'];

        }
        $result['success'] = true;
        $result['whatsapp_message'] = $whatsapp_message;
        $result['whatsapp_booking_message'] = $whatsapp_booking_message;
        $result['whatsapp_pre_order_message'] = $whatsapp_pre_order_message;
        $result['whatsapp_canceled_pre_order_message'] = $whatsapp_canceled_pre_order_message;      
    }
    die(json_encode($result));
}
function getBookings()
{
    global $config, $lang;
    $booking_data = array();
    if (checkloggedin()) {
        $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
            ->where('user_id', $_SESSION['user']['id'])
            ->find_one();
        if (isset($restaurant['user_id'])) {
            $bookings = ORM::for_table($config['db']['pre'] . 'booking_table')
                ->where(array(
                    'restaurant_id' => $restaurant['id'],
                    'seen' => 0
                ))
                ->order_by_desc('id')->find_many();
            foreach ($bookings as $booking) {
                $booking_data[$booking['id']]['id'] = $booking['id'];
                $booking_data[$booking['id']]['customer_name'] = escape($booking['customer_name']);
                $booking_data[$booking['id']]['table_number'] = escape($booking['table_number']);
                $booking_data[$booking['id']]['phone_number'] = $booking['phone_number'];
                $booking_data[$booking['id']]['ticket'] = $booking['ticket'];
                $booking_data[$booking['id']]['status'] = $booking['status'];
                $booking_data[$booking['id']]['email'] = $booking['email'];
                $booking_data[$booking['id']]['note'] = $booking['note'];

                $booking_data[$booking['id']]['date'] = date_format(date_create($booking['date_from']), "d.m.Y");
                $booking_data[$booking['id']]['date_from'] = date_format(date_create($booking['date_from']), "H:i");
                $booking_data[$booking['id']]['date_to'] = date_format(date_create($booking['date_to']), "H:i");

                $bookings_update = ORM::for_table($config['db']['pre'] . 'booking_table')->find_one($booking['id']);
                $bookings_update->seen = 1;
                $bookings_update->save();
            }
        }
    }
    die(json_encode($booking_data));
}


function getListOrders()
{
    global $config, $lang;
    $orders_data = array();

    if (checkloggedin()) {
        $ses_userdata = get_user_data($_SESSION['user']['username']);
        $currency = !empty($ses_userdata['currency']) ? $ses_userdata['currency'] : get_option('currency_code');

        $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
            ->where('user_id', $_SESSION['user']['id'])
            ->find_one();
        $order_id_array = json_decode($_POST['order_id_array'], true);

        if (isset($restaurant['user_id'])) {
            $orders = ORM::for_table($config['db']['pre'] . 'orders')
                ->table_alias('o')
                ->select_many('o.*', 'c.customer_name', 'c.phone_number', 'c.address', 'c.email')
                ->where(array(
                    'o.restaurant_id' => $restaurant['id']
                ))
                ->where_in('o.id',$order_id_array)
                ->left_outer_join($config['db']['pre'] . 'order_customer_info', array('o.id', '=', 'c.order_id'), 'c')
                ->order_by_asc('id')->find_many();

            foreach ($orders as $order) {
                $id = explode("-", $order['id']);
                $orders_data[$order['id']]['sid'] = (int) $id[2];
                $orders_data[$order['id']]['id'] = $order['id'];
                $orders_data[$order['id']]['type'] = $order['type'];
                $orders_data[$order['id']]['customer_name'] = escape($order['customer_name']);
                $orders_data[$order['id']]['table_number'] = escape($order['table_number']);
                $orders_data[$order['id']]['phone_number'] = escape($order['phone_number']);
                $orders_data[$order['id']]['address'] = escape($order['address']);
                $orders_data[$order['id']]['is_paid'] = $order['is_paid'];
                $orders_data[$order['id']]['status'] = $order['status'];
                $orders_data[$order['id']]['email'] = escape($order['email']);
                $orders_data[$order['id']]['message'] = escape($order['message']);
                $orders_data[$order['id']]['created_at'] = date('d.m.Y H:i', strtotime($order['created_at']));
                $orders_data[$order['id']]['takeaway_delivery_time'] = date('d.m.Y H:i', strtotime($order['takeaway_delivery_time']));

                $order_shipping_fee = empty($order['shipping_fee']) ? 0 : $order['shipping_fee'];
                $include_total_discount_value = empty($order['include_total_discount_value']) ? 0 : $order['include_total_discount_value'];
                $coupons_code = empty($order['coupons_code']) ? '' : $order['coupons_code'];
                // get order items
                $order_items = ORM::for_table($config['db']['pre'] . 'order_items')
                    ->table_alias('oi')
                    ->select_many('oi.*')
                    ->where(array(
                        'order_id' => $order['id']
                    ))
                    ->join($config['db']['pre'] . 'menu', array('oi.item_id', '=', 'm.id'), 'm')
                    ->order_by_desc('id')
                    ->find_many();

                $orders_data[$order['id']]['items_tpl'] = $print_tpl = '';
                $price = 0;
                foreach ($order_items as $order_item) {
                    $tpl = '<div class="order-table-item">';
                    $tpl .= '<strong><i class="icon-material-outline-restaurant"></i> ' . $order_item['name'] . '</strong>';
                    if ($order_item['quantity'] > 1) {
                        $tpl .= ' &times; ' . $order_item['quantity'];
                    }
                    $price += $order_item['total_amount'];

                    // get order extras
                    $order_item_extras = ORM::for_table($config['db']['pre'] . 'order_item_extras')
                        ->table_alias('oie')
                        ->select_many('oie.*', 'me.title', 'me.price')
                        ->where(array(
                            'order_item_id' => $order_item['id']
                        ))
                        ->join($config['db']['pre'] . 'menu_extras', array('oie.extra_id', '=', 'me.id'), 'me')
                        ->order_by_desc('id')
                        ->find_many();

                    $print_tpl_extra = $print_tpl_menu = '';
                    $print_tpl_menu .= '<tr><td>' . $order_item['name'] . ' &times; ' . $order_item['quantity'] . '</td><td>' . price_format($order_item['total_amount'], $currency) . '</td></tr>';

                    if ($order_item_extras->count()) {
                        $tpl .= '<div  class="padding-left-10">';
                        foreach ($order_item_extras as $order_item_extra) {
                            $price += $order_item_extra['price'] * $order_item['quantity'];
                            $tpl .= '<div><i class="icon-feather-plus"></i> ' . $order_item_extra['title'] . '</div>';
                            $print_tpl_extra .= '<tr class="order-menu-extra"><td><span class="margin-left-5">' . $order_item_extra['title'] . '</span></td><td>' . price_format($order_item_extra['price'] * $order_item['quantity'], $currency) . '</td></tr>';
                        }
                        $tpl .= '</div>';
                    }
                    $tpl .= '</div>';
                    $orders_data[$order['id']]['items_tpl'] .= $tpl;
                    $print_tpl .= $print_tpl_menu . $print_tpl_extra;
                }
                $price += $order_shipping_fee - $include_total_discount_value;
                $price = $price < 0 ? 0 : $price;
                $dorder_shipping_fee = $order_shipping_fee;
                $include_total_discount_value_format = price_format(-$include_total_discount_value, $currency);

                $order_shipping_fee = price_format($order_shipping_fee, $currency);
                $orders_data[$order['id']]['price'] = price_format($price, $currency);
                $orders_data[$order['id']]['price_number'] = $price;

                if ($orders_data[$order['id']]['type'] == 'on-table')
                    $type = $orders_data[$order['id']]['table_number'];
                elseif ($orders_data[$order['id']]['type'] == 'takeaway')
                    $type = $lang['TAKEAWAY'];
                elseif ($orders_data[$order['id']]['type'] == 'delivery')
                    $type = $lang['DELIVERY'];

                $order_print_tpl = "<table>
                            <tr>
                                <td>{$lang['TIME']}</td>
                                <td>{$orders_data[$order['id']]['created_at']}</td>
                            </tr>
                            <tr>
                                <td>{$lang['NAME']}</td>
                                <td>{$orders_data[$order['id']]['customer_name']}</td>
                            </tr>
                            <tr>
                                <td>{$lang['TABLE_NO_ORDER_TYPE']}</td>
                                <td>$type</td>
                            </tr>" .
                    ($orders_data[$order['id']]['type'] == 'takeaway' ? "<tr>
                            <td>{$lang['TAKEAWAY_DELIVERY']}</td>
                            <td>{$orders_data[$order['id']]['takeaway_delivery_time']}</td>
                        </tr>" : '') .
                    (!empty($orders_data[$order['id']]['phone_number']) ? "<tr>
                                <td>{$lang['PHONE']}</td>
                                <td>{$orders_data[$order['id']]['phone_number']}</td>
                            </tr>" : '')
                    .
                    (!empty($orders_data[$order['id']]['email']) ? "<tr>
                    <td>{$lang['EMAIL']}</td>
                    <td>{$orders_data[$order['id']]['email']}</td>
                </tr>" : '')
                    .
                    (!empty($orders_data[$order['id']]['address']) ? "<tr>
                                <td>{$lang['ADDRESS']}</td>
                                <td>{$orders_data[$order['id']]['address']}</td>
                            </tr>" : '') .
                    (!empty($orders_data[$order['id']]['message']) ? "<tr>
                                <td>{$lang['MESSAGE']}</td>
                                <td>{$orders_data[$order['id']]['message']}</td>
                            </tr>" : '') .
                    (!empty($orders_data[$order['id']]['is_paid']) ? "<tr>
                                <td>{$lang['PAYMENT']}</td>
                                <td>{$lang['PAID']}</td>
                            </tr>" : '') . "
                        </table>
                        <div class='order-print-divider'></div>
                        <table class='order-print-menu'>
                            <thead>
                            <tr>
                                <th>{$lang['MENU']}</th>
                                <th>{$lang['PRICE']}</th>
                            </tr>
                            </thead>
                            <tbody id='order-print-menu'>$print_tpl</tbody>
                            <tfoot>
                            " . (!empty($dorder_shipping_fee) ? "
                            <tr>
                            <th>{$lang['SHIPPING_FEE']}</th>
                            <td>{$order_shipping_fee}</td>
                        </tr>" : "") . (!empty($coupons_code) ? "
                        <tr>
                        <th>{$lang['COUPON']}: {$coupons_code}</th>
                        <td>{$include_total_discount_value_format}</td>
                    </tr>" : "") . "<tr>
                                <th>{$lang['TOTAL']}</th>
                                <th>{$orders_data[$order['id']]['price']}</th>
                            </tr>
                            </tfoot>
                        </table>";

                $orders_data[$order['id']]['order_print_tpl'] = $order_print_tpl;

                $orders = ORM::for_table($config['db']['pre'] . 'orders')->find_one($order['id']);
                $orders->seen = 1;
                $orders->save();
            }
        }
    }
    die(json_encode($orders_data));
}
function getOrders()
{
    global $config, $lang;
    $orders_data = array();

    if (checkloggedin()) {
        $ses_userdata = get_user_data($_SESSION['user']['username']);
        $currency = !empty($ses_userdata['currency']) ? $ses_userdata['currency'] : get_option('currency_code');

        $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
            ->where('user_id', $_SESSION['user']['id'])
            ->find_one();

        if (isset($restaurant['user_id'])) {
            $orders = ORM::for_table($config['db']['pre'] . 'orders')
                ->table_alias('o')
                ->select_many('o.*', 'c.customer_name', 'c.phone_number', 'c.address', 'c.email')
                ->where(array(
                    'o.restaurant_id' => $restaurant['id'],
                    'o.seen' => 0
                ))
                ->left_outer_join($config['db']['pre'] . 'order_customer_info', array('o.id', '=', 'c.order_id'), 'c')
                ->order_by_desc('id')->find_many();

            foreach ($orders as $order) {
                $id = explode("-", $order['id']);
                $orders_data[$order['id']]['sid'] = (int) $id[2];
                $orders_data[$order['id']]['id'] = $order['id'];
                $orders_data[$order['id']]['type'] = $order['type'];
                $orders_data[$order['id']]['customer_name'] = escape($order['customer_name']);
                $orders_data[$order['id']]['table_number'] = escape($order['table_number']);
                $orders_data[$order['id']]['phone_number'] = escape($order['phone_number']);
                $orders_data[$order['id']]['address'] = escape($order['address']);
                $orders_data[$order['id']]['is_paid'] = $order['is_paid'];
                $orders_data[$order['id']]['status'] = $order['status'];
                $orders_data[$order['id']]['email'] = escape($order['email']);
                $orders_data[$order['id']]['message'] = escape($order['message']);
                $orders_data[$order['id']]['created_at'] = date('d.m.Y H:i', strtotime($order['created_at']));
                $orders_data[$order['id']]['takeaway_delivery_time'] = date('d.m.Y H:i', strtotime($order['takeaway_delivery_time']));

                $order_shipping_fee = empty($order['shipping_fee']) ? 0 : $order['shipping_fee'];
                $include_total_discount_value = empty($order['include_total_discount_value']) ? 0 : $order['include_total_discount_value'];
                $coupons_code = empty($order['coupons_code']) ? '' : $order['coupons_code'];
                // get order items
                $order_items = ORM::for_table($config['db']['pre'] . 'order_items')
                    ->table_alias('oi')
                    ->select_many('oi.*')
                    ->where(array(
                        'order_id' => $order['id']
                    ))
                    ->join($config['db']['pre'] . 'menu', array('oi.item_id', '=', 'm.id'), 'm')
                    ->order_by_desc('id')
                    ->find_many();

                $orders_data[$order['id']]['items_tpl'] = $print_tpl = '';
                $price = 0;
                foreach ($order_items as $order_item) {
                    $tpl = '<div class="order-table-item">';
                    $tpl .= '<strong><i class="icon-material-outline-restaurant"></i> ' . $order_item['name'] . '</strong>';
                    if ($order_item['quantity'] > 1) {
                        $tpl .= ' &times; ' . $order_item['quantity'];
                    }
                    $price += $order_item['total_amount'];

                    // get order extras
                    $order_item_extras = ORM::for_table($config['db']['pre'] . 'order_item_extras')
                        ->table_alias('oie')
                        ->select_many('oie.*', 'me.title', 'me.price')
                        ->where(array(
                            'order_item_id' => $order_item['id']
                        ))
                        ->join($config['db']['pre'] . 'menu_extras', array('oie.extra_id', '=', 'me.id'), 'me')
                        ->order_by_desc('id')
                        ->find_many();

                    $print_tpl_extra = $print_tpl_menu = '';
                    $print_tpl_menu .= '<tr><td>' . $order_item['name'] . ' &times; ' . $order_item['quantity'] . '</td><td>' . price_format($order_item['total_amount'], $currency) . '</td></tr>';

                    if ($order_item_extras->count()) {
                        $tpl .= '<div  class="padding-left-10">';
                        foreach ($order_item_extras as $order_item_extra) {
                            $price += $order_item_extra['price'] * $order_item['quantity'];
                            $tpl .= '<div><i class="icon-feather-plus"></i> ' . $order_item_extra['title'] . '</div>';
                            $print_tpl_extra .= '<tr class="order-menu-extra"><td><span class="margin-left-5">' . $order_item_extra['title'] . '</span></td><td>' . price_format($order_item_extra['price'] * $order_item['quantity'], $currency) . '</td></tr>';
                        }
                        $tpl .= '</div>';
                    }
                    $tpl .= '</div>';
                    $orders_data[$order['id']]['items_tpl'] .= $tpl;
                    $print_tpl .= $print_tpl_menu . $print_tpl_extra;
                }
                $price += $order_shipping_fee - $include_total_discount_value;
                $price = $price < 0 ? 0 : $price;
                $dorder_shipping_fee = $order_shipping_fee;
                $include_total_discount_value_format = price_format(-$include_total_discount_value, $currency);

                $order_shipping_fee = price_format($order_shipping_fee, $currency);
                $orders_data[$order['id']]['price'] = price_format($price, $currency);
                $orders_data[$order['id']]['price_number'] = $price;

                if ($orders_data[$order['id']]['type'] == 'on-table')
                    $type = $orders_data[$order['id']]['table_number'];
                elseif ($orders_data[$order['id']]['type'] == 'takeaway')
                    $type = $lang['TAKEAWAY'];
                elseif ($orders_data[$order['id']]['type'] == 'delivery')
                    $type = $lang['DELIVERY'];

                $order_print_tpl = "<table>
                            <tr>
                                <td>{$lang['TIME']}</td>
                                <td>{$orders_data[$order['id']]['created_at']}</td>
                            </tr>
                            <tr>
                                <td>{$lang['NAME']}</td>
                                <td>{$orders_data[$order['id']]['customer_name']}</td>
                            </tr>
                            <tr>
                                <td>{$lang['TABLE_NO_ORDER_TYPE']}</td>
                                <td>$type</td>
                            </tr>" .
                    ($orders_data[$order['id']]['type'] == 'takeaway' ? "<tr>
                            <td>{$lang['TAKEAWAY_DELIVERY']}</td>
                            <td>{$orders_data[$order['id']]['takeaway_delivery_time']}</td>
                        </tr>" : '') .
                    (!empty($orders_data[$order['id']]['phone_number']) ? "<tr>
                                <td>{$lang['PHONE']}</td>
                                <td>{$orders_data[$order['id']]['phone_number']}</td>
                            </tr>" : '')
                    .
                    (!empty($orders_data[$order['id']]['email']) ? "<tr>
                    <td>{$lang['EMAIL']}</td>
                    <td>{$orders_data[$order['id']]['email']}</td>
                </tr>" : '')
                    .
                    (!empty($orders_data[$order['id']]['address']) ? "<tr>
                                <td>{$lang['ADDRESS']}</td>
                                <td>{$orders_data[$order['id']]['address']}</td>
                            </tr>" : '') .
                    (!empty($orders_data[$order['id']]['message']) ? "<tr>
                                <td>{$lang['MESSAGE']}</td>
                                <td>{$orders_data[$order['id']]['message']}</td>
                            </tr>" : '') .
                    (!empty($orders_data[$order['id']]['is_paid']) ? "<tr>
                                <td>{$lang['PAYMENT']}</td>
                                <td>{$lang['PAID']}</td>
                            </tr>" : '') . "
                        </table>
                        <div class='order-print-divider'></div>
                        <table class='order-print-menu'>
                            <thead>
                            <tr>
                                <th>{$lang['MENU']}</th>
                                <th>{$lang['PRICE']}</th>
                            </tr>
                            </thead>
                            <tbody id='order-print-menu'>$print_tpl</tbody>
                            <tfoot>
                            " . (!empty($dorder_shipping_fee) ? "
                            <tr>
                            <th>{$lang['SHIPPING_FEE']}</th>
                            <td>{$order_shipping_fee}</td>
                        </tr>" : "") . (!empty($coupons_code) ? "
                        <tr>
                        <th>{$lang['COUPON']}: {$coupons_code}</th>
                        <td>{$include_total_discount_value_format}</td>
                    </tr>" : "") . "<tr>
                                <th>{$lang['TOTAL']}</th>
                                <th>{$orders_data[$order['id']]['price']}</th>
                            </tr>
                            </tfoot>
                        </table>";

                $orders_data[$order['id']]['order_print_tpl'] = $order_print_tpl;

                $orders = ORM::for_table($config['db']['pre'] . 'orders')->find_one($order['id']);
                $orders->seen = 1;
                $orders->save();
            }
        }
    }
    die(json_encode($orders_data));
}

/* Check store slug validation */
function checkStoreSlug()
{
    global $config, $lang, $link;

    if (empty($_POST['slug'])) {
        $slug_error = $lang['RESTRO_SLUG_REQ'];
        echo "<span class='status-not-available'> " . $slug_error . "</span>";
    } else if (!preg_match('/^[a-z0-9]+(-?[a-z0-9]+)*$/i', $_POST['slug'])) {
        $slug_error = $lang['RESTRO_SLUG_INVALID'];
        echo "<span class='status-not-available'> " . $slug_error . "</span>";
    } else if (in_array($config['site_url'] . $_POST['slug'], $link)) {
        $slug_error = $lang['RESTRO_SLUG_INVALID'];
        echo "<span class='status-not-available'> " . $slug_error . "</span>";
    } else {
        $count = ORM::for_table($config['db']['pre'] . 'restaurant')
            ->where('slug', $_POST['slug'])
            ->where_not_equal('user_id', $_SESSION['user']['id'])
            ->count();

        // check row exist
        if ($count) {
            $slug_error = $lang['RESTRO_SLUG_NOT_EXIST'];
            echo "<span class='status-not-available'> " . $slug_error . "</span>";
        } else {
            $slug_success = $lang['SUCCESS'];
            echo "";
        }
    }
    die();
}
