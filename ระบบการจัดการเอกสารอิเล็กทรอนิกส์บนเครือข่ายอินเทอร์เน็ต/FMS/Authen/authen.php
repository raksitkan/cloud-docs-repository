<?php 
date_default_timezone_set("Asia/Bangkok");
echo $date = date('Y-m-d h:i:s');
session_start();
 $host = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        if(isset($_POST['m_username'])){
                  include("connlogin.php");
                  $m_username = mysqli_real_escape_string($condb,$_POST['m_username']);
                  // $m_password = mysqli_real_escape_string($condb,$_POST['m_password']);
                   $m_password = mysqli_real_escape_string($condb, $_POST["password"]);

                echo  $sql="SELECT * FROM tbl_emp 
                  WHERE  m_username='".$m_username."'  AND  m_password=".$m_password." ";

                  $result = mysqli_query($condb,$sql);
				
                  if(mysqli_num_rows($result)==1){

                      $row = mysqli_fetch_array($result);

                     $_SESSION["m_id"] = $row["m_id"];
                     $_SESSION["m_username"] = $row["m_username"];
                      $_SESSION["m_level"] = $row["m_level"];
                      $_SERVER['REMOTE_ADDR'];
                      $host = gethostbyaddr($_SERVER['REMOTE_ADDR']);

                      if($_SESSION["m_level"]=="admin"){ 
                        $a = ("Has LoggedIn the system at");
                        $sql = "INSERT INTO history_log (m_level,ip,login_time,m_username,m_action,host)
                         VALUES ('{$_SESSION["m_level"]}','{$_SERVER["REMOTE_ADDR"]}','$date','$m_username','$a','$host')";
                         if (mysqli_query($condb, $sql)) {
                          //  echo "New record created successfully";
                         } else {
                           echo "Error: " . $sql . "<br>" . mysqli_error($condb);
                         }
                        Header("Location: ..\admin\index.php");
                      }
                      else if($_SESSION["m_level"]=="staff"){
                      $b = ("Has LoggedIn the system at");
                      $sql = "INSERT INTO history_log (m_level,ip,login_time,m_username,m_action,host)
                      VALUES ('{$_SESSION["m_level"]}','{$_SERVER["REMOTE_ADDR"]}','$date','$m_username','$b','$host')";
                        if (mysqli_query($condb, $sql)) {
                          // echo "New record created successfully";
                        } else {
                          echo "Error: " . $sql . "<br>" . mysqli_error($condb);
                        }
                        Header("Location: ..\User\user.php");                   
                      }
                  }else{
                    echo "<script>";
                        echo "alert(\" user หรือ  password ไม่ถูกต้อง\");"; 
                        echo "window.history.back()";
                    echo "</script>";

                  }

        }else{
  
             Header("Location: ../index.php"); //user & m_password incorrect back to login again
    
        }
?>