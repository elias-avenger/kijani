<?php
    include "db/queries.php";
    
    if(isset($_POST['add-creator'])){
        $type = 'A';
        validateAndSubmitUser($type);
        header("location: ../admin_signup.php");
    }
    if(isset($_POST['add-user'])){
        $type =  $_POST['role'];
        validateAndSubmitUser($type); 
        header("location: ../dashboard/dash_users.php");   
    }

    function validateAndSubmitUser($tp){
        $fn = $_POST['fname'];
        $ln = $_POST['lname'];
        $el = $_POST['email'];
        $pd = $_POST['password'];
        $pn = $_POST['phone'];
        $db = $_POST['dob'];
        $cp = $_POST['conf_password'];
        if(isset($_SESSION['email'])){
            $user_data = mysqli_fetch_array(getUser($_SESSION['email']));
            $uid = $user_data['id'];
        }
        if(mysqli_num_rows(getUser($el)) >= 1){
            $_SESSION['msg'] = "email-exists";
        }
        elseif(!preg_match('/^[0-9]{10}+$/', $pn)){
            $_SESSION['msg'] = "phone-fmt";
        }
        elseif($pd !== $cp){
            $_SESSION['msg'] = "conf-pass";
        }
        else{
            $pwd = password_hash($pd, PASSWORD_DEFAULT);
            $qry = "INSERT INTO users(fname, lname, email, password, phone, dob, type, created_by) VALUES('$fn','$ln','$el','$pwd','$pn','$db','$tp','$uid')";
            addData($qry);
            $_SESSION['msg'] = "success";
        }
    }
?>