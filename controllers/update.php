<?php
    include "db/queries.php";
    $user = mysqli_fetch_array(getUser($_SESSION['email']));
    $user_id = $user['id'];
    $date = date("Y-m-d");
    if(isset($_POST['update-user'])){
        $id = $_POST['uid'];
        $fn = $_POST['fname'];
        $ln = $_POST['lname'];
        // $full_name = explode(" ", $_POST['full-name']);
        // $fn = $full_name[0];
        // if($full_name[2] > "") 
        //     $ln = $full_name[1]." ".$full_name[2];
        // else
        //     $ln = $full_name[1];
        $el = $_POST['email'];
        $pn = $_POST['phone'];
        $tp = $_POST['type'];
        $dt = $_POST['entity'];
        $uqry = "UPDATE users SET fname = '$fn', lname='$ln', email='$el', phone='$pn', type='$tp', last_updated='$date', last_updated_by='$user_id' WHERE id='$id'";
        update($uqry);
        if($dt != ''){
        $eqry = "UPDATE budgeting_entities SET incharge='$id' WHERE id='$dt'";
        update($eqry);
        }
        $_SESSION['msg'] = "updated";
        header("location: ../dashboard/dash_users.php");
    }
?>