<?php
    if (isset($_POST["coupon"])) {
        include("controllers/database/connection.php");
        $con=openCon();
        $coupon = mysqli_query($con, "select * from coupons where coupon='$_POST[coupon]'");
        if (mysqli_num_rows($coupon)==false){
            $form_data['success'] = false;
            $form_data["message"] = "Coupon not found";
        }
        else {
            $rcoupon = mysqli_fetch_array($coupon);
            if (!$rcoupon["isDisabled"]){
                $form_data['success'] = true;
                $form_data["message"] = $rcoupon["percentage"];
                mysqli_query($con, "update coupons set usedCount = usedCount + 1 where coupon = '$_POST[coupon]'");
            }
            else {
                $form_data['success'] = false;
                $form_data["message"] = "Coupon is disabled";
            }
        }
        echo json_encode($form_data);
    }
    else {
        header("Location: checkout.php");
    }


?>