<?php
session_start();
// echo '<pre>';
//         print_r($_SESSION);
// echo '</pre>';
include('../Authen/conn.php');
$m_id = $_SESSION['m_id'];
$m_level = $_SESSION['m_level'];
$m_username = $_SESSION['m_username'];
$_SERVER['REMOTE_ADDR'];
$host = gethostbyaddr($_SERVER['REMOTE_ADDR']);
if($m_level!='admin'){
Header("Location: ../Authen/logout.php");
}

if(isset($_REQUEST['update_id']))
{
    try
    {

        $id = $_REQUEST['update_id']; //get "update_id" from index.php page through anchor tag operation and store in "$id" variable
        $select_stmt = $conn->prepare('SELECT * FROM tbl_emp WHERE m_id =:m_id'); //sql select query
        $select_stmt->bindParam(':m_id',$id);
        $select_stmt->execute(); 
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);
    }
    catch(PDOException $e)
    {
        $e->getMessage();
    }
    
}
if(isset($_REQUEST['btn_update']))
{
    include('../Authen/connlogin.php');
        $name=@$_POST['txt_name'];
        $pass=@$_POST['txt_password'];
        $ip_user=@$_POST['txt_ip'];
        $host_user=@$_POST['txt_host'];
        $addby = $_SESSION['m_username'];
        $id=@$_POST['txt_id'];
        //คำสั่งแก้ไขข้อมูล
        $sql = "UPDATE tbl_emp SET
        m_username='$name',
        m_password='$pass',
        host='$host_user',
        ip='$ip_user',
        create_by='$addby'
        where m_id = '$id' ";
        if(mysqli_query($condb,$sql)) {
                   $status ='update user';
                   $insert_stmt=$conn->prepare('INSERT INTO add_user_log(m_username,m_password,m_action,action_by,host,ip) VALUES(:m_usernameup,:m_passwordup,:m_actionup,:action_byup,:hostup,:ipup)'); //sql insert query					
                    //bind all parameter 
                   $insert_stmt->bindParam(':m_usernameup',$name);
                   $insert_stmt->bindParam(':m_passwordup',$pass);
                   $insert_stmt->bindParam(':m_actionup',$status);
                   $insert_stmt->bindParam(':action_byup',$addby);
                   $insert_stmt->bindParam(':hostup',$host_user);
                   $insert_stmt->bindParam(':ipup',$ip_user);
                   $insert_stmt->execute();
        echo "<script>alert('แก้ไขข้อมูลเรียบร้อยแล้ว'); </script>";
        echo "<script>window.location='adduser.php';</script>";
        } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($condb);
        $status ='Failed to update user';
        $insert_stmt=$conn->prepare('INSERT INTO add_user_log(m_username,m_password,m_action,action_by,host,ip) VALUES(:m_usernameup,:m_passwordup,:m_actionup,:action_byup,:hostup,:ipup)'); //sql insert query					
         //bind all parameter 
        $insert_stmt->bindParam(':m_usernameup',$name);
        $insert_stmt->bindParam(':m_passwordup',$pass);
        $insert_stmt->bindParam(':m_actionup',$status);
        $insert_stmt->bindParam(':action_byup',$addby);
        $insert_stmt->bindParam(':hostup',$host_user);
        $insert_stmt->bindParam(':ipup',$ip_user);
        $insert_stmt->execute();
        echo "<script>alert('ไม่สามารถแก้ไขข้อมูลได้');</script>";
        }
        mysqli_close($condb);
}
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

            <!--========== BOX ICONS ==========-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet"
        crossorigin="anonymous" />

    <!--========== CSS ==========-->
    <link rel="stylesheet" href="../assets/navbar/css/styles.css">
    <title>Hello, world!</title>
    <style>
    .navbar {
        background-color: #D470A2;
    }
    img {
        border-radius: 50%;
    }
    .container {
        align-items: center;
    }.nav__container {
  margin-left: 15%;
}
.nav__link:hover {
  color: var(--first-color);
  text-decoration: none;
}    .header__container a{
        text-decoration: none;
    }
    </style>
</head>
<body>
<?php include 'nav.php'; ?>
    <div class="wrapper">
        <div class="container mt-5 col-xs-12 col-md-12 col-lg-8 col-xl-4">
            <div class="card">
                <div class="col">
                    <form method="POST"  class="form-horizontal" enctype="multipart/form-data">
                        <div class="form-group">
                            <input type="hidden" name="txt_ip" value="<?php echo $_SERVER['REMOTE_ADDR'];?>" />
                            <input type="hidden" name="txt_host"
                                value="<?php echo gethostbyaddr($_SERVER['REMOTE_ADDR']); ?>" />
                            <input type="hidden" name="txt_id" class="form-control" value="<?=$row["m_id"]?> " />
                        </div>
                        <div class="form-group">
                            <label for="">Username</label>
                            <input type="text" name="txt_name" class="form-control" value="<?=$row["m_username"]?> " />
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="text" name="txt_password" class="form-control"
                                value="<?=$row["m_password"]?> " />
                        </div>
                        <div class="form-group">
                        <div class="col-md-12  text-center">
                                <input type="submit" name="btn_update" class="btn btn-primary" value="Update">
                                <a href="adduser.php" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous">
    </script>
</body>
<script src="../assets/js/main.js"></script>
</html>