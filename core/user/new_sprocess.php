<?php
require_once("../init.php");
if(empty($_POST)===false)
{
    $fname=strip_tags(trim($_POST['firstname']));
    $lname=strip_tags(trim($_POST['lastname']));
    $email=strip_tags(trim($_POST['email']));
    $gender=strip_tags(trim($_POST['gender']));
    $month=strip_tags(trim($_POST['month']));
    $day=strip_tags(trim($_POST['day']));
    $year=strip_tags(trim($_POST['year']));
    $user_name=strip_tags(trim($fname.time()));
    $password=sha1(strip_tags(trim($_POST['password1'])));
    $c_password=sha1(strip_tags(trim($_POST['confirm_password'])));
    $birthday=$year."-".$month."-".$day;
// echo $fname .'<br>'.$lname.'<br>'.$email.'<br>'.$gender.'<br>'.$user_name.'<br>'.$password.'<br>'.$c_password ;
    if(!empty($fname)and!empty($lname)and!empty($email)and!empty($gender)and!empty($month)and!empty($day)and!empty($year)){
        if($password === $c_password){
            $query1=    mysqli_query($con,"SELECT email from dir_user WHERE email='$email'");
            if($query1){
                $count=mysqli_num_rows($query1);
                if($count==0){
                    $query2=mysqli_query($con,"INSERT INTO dir_user(fname,lname,email,gender,dob,password,user_name)VALUES('$fname','$lname','$email','$gender','$birthday','$password','$user_name');");
                    $inserted_dir_id=mysqli_insert_id($con);
                    if($query2){
                        $verify_string='';
                        for($i=0;$i<10;$i++){
                            $verify_string.=chr(mt_rand(32,126));
                        }
                        $verify_string=urlencode($verify_string);
                        $query3=mysqli_query($con,"INSERT INTO user(dir_id,fname,lname,user_name,email,verify_string)VALUES ('$inserted_dir_id','$fname','$lname','$user_name','$email','$verify_string');");
                        $inserted_ssn=mysqli_insert_id($con);
                        if($query3){
                            $query4=mysqli_query($con,"UPDATE dir_user SET ssn=$inserted_ssn WHERE dir_id='$inserted_dir_id'");
                            if($query4){
                                echo "success";
                                $verify_string='';
                                            for($i=0;$i<10;$i++){
                                                $verify_string.=chr(mt_rand(32,126));
                                            }
                                                //echo "success!";
                                                
                                                $safe_email=urlencode($email);
                                                $verify_url="http://localhost/resume-master/resume-master/core/user/verify_user.php";
                                                $msg_body="click on this link to activate your account ".$verify_url."?email=".$safe_email."&verify_string=".$verify_string."></a>";
                                                require("PHPMailer-master/PHPMailerAutoload.php"); //or select the proper destination for this file if your page is in some   //other folder
                                                ini_set("SMTP","ssl://smtp.gmail.com"); 
                                                ini_set("smtp_port","465"); //No further need to edit your configuration files
                                                $mail = new PHPMailer(); // create a new object
                                                $mail->IsSMTP(); // enable SMTP
                                                $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
                                                $mail->SMTPAuth = true; // authentication enabled
                                                $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
                                                $mail->Host = "smtp.gmail.com";
                                                $mail->Port = 465; // or 587
                                                $mail->IsHTML(true);
                                                $mail->Username = "test1901994@gmail.com";
                                                $mail->Password = "sexysingham";
                                                $mail->SetFrom("test1901994@gmail.com");
                                                $mail->Subject = "VERIFY YOUR ACCOUNT";
                                                $mail->Body = $msg_body;
                                                $mail->AddAddress($email);
                                                if($mail->Send())
                                                {
                                                    echo "<h1><center>Verification mail has been sent to your email-id,kindly check your spam if you haven't got the mail.Follow the link to activate your account and enjoy profferys!!</center></h1>";
                                                    }
                                                    else
                                                    {
                                                    echo "<h1>Error sending the mail</h1>";
                                                }
                                                //header("Location: login.php");
                            }
                            else{
                                echo "failure1";
                            }
                        }
                        else{
                            echo "failure2";
                        }
                    }
                    else{
                        echo "failure3";
                    }
                }
                else{
                    echo "user already exists";
                }
            }
            else{
                echo "failure4";
            }
        }
        else{
            echo "failure5";
        }
    }
    else{
        echo "Failure6";
    }
}
?>
