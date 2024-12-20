<?php
session_start();
include('../Authen/connlogin.php');
include('../Authen/conn.php');
$m_id = $_SESSION['m_id'];
$m_level = $_SESSION['m_level'];
$m_username = $_SESSION['m_username'];
$_SERVER['REMOTE_ADDR'];
$host = gethostbyaddr($_SERVER['REMOTE_ADDR']);
if ($m_level != 'admin'){  //check session
 
    Header("Location: ../index.php"); //ไม่พบผู้ใช้กระโดดกลับไปหน้า login form 
}else
//query member login
$queryemp = "SELECT * FROM tbl_emp WHERE m_id=$m_id";
$datam = mysqli_query($condb, $queryemp) or die ("Error in query: $queryemp " . mysqli_error($condb));
$rowm = mysqli_fetch_array($datam);
//เวลาปัจจุบัน
$timenow = date('H:i:s');
$datenow = date('Y-m-d');

//query insert
if(isset($_POST['btn_insert']))
{
	try
	{
		$username	= $_POST['txt_name'];
		$ip_user	= $_REQUEST['txt_ip'];	//textbox ip "txt_
		$host	= $_POST['txt_host'];
        $Pass	= $_POST['txt_password'];
        $level	= $_POST['level'];
        $addby	= $_POST['txt_by'];
		
//check username
$q_checkadmin = $condb->query("SELECT * FROM tbl_emp WHERE m_username = $username");
$v_checkadmin = $q_checkadmin->num_rows;
if($v_checkadmin == 1){
    $status ='Username Address already taken';
    $insert_stmt=$conn->prepare('INSERT INTO add_user_log(m_username,m_password,m_action,action_by,host,ip) VALUES(:m_usernameup,:m_passwordup,:m_actionup,:action_byup,:hostup,:ipup)'); //sql insert query					
         //bind all parameter 
    $insert_stmt->bindParam(':m_usernameup',$username);
    $insert_stmt->bindParam(':m_passwordup',$Pass);
    $insert_stmt->bindParam(':m_actionup',$status);
    $insert_stmt->bindParam(':action_byup',$m_username);
    $insert_stmt->bindParam(':hostup',$host);
    $insert_stmt->bindParam(':ipup',$ip_user);
    $insert_stmt->execute();
    echo '
        <script type = "text/javascript">
            alert("Username Address already taken");
            window.location = "adduser.php";
        </script>

    ';
}else
		{

            $status ='Add User';
            $insert_stmt=$conn->prepare('INSERT INTO add_user_log(m_username,m_password,m_action,action_by,host,ip) VALUES(:m_usernameup,:m_passwordup,:m_actionup,:action_byup,:hostup,:ipup)'); //sql insert query					
            //bind all parameter 
       $insert_stmt->bindParam(':m_usernameup',$username);
       $insert_stmt->bindParam(':m_passwordup',$Pass);
       $insert_stmt->bindParam(':m_actionup',$status);
       $insert_stmt->bindParam(':action_byup',$m_username);
       $insert_stmt->bindParam(':hostup',$host);
       $insert_stmt->bindParam(':ipup',$ip_user);
       $insert_stmt->execute();

			$insert_stmt=$conn->prepare('INSERT INTO tbl_emp(m_username,m_password,m_level,host,ip,create_by) VALUES(:passup,:mname,:levelup,:hostup,:ipup,:addby)'); //sql insert query					
			$insert_stmt->bindParam(':passup',$Pass);
            $insert_stmt->bindParam(':mname',$username);
            $insert_stmt->bindParam(':levelup',$level);
            $insert_stmt->bindParam(':hostup',$host);
            $insert_stmt->bindParam(':ipup',$ip_user);
            $insert_stmt->bindParam(':addby',$addby);
			if($insert_stmt->execute())
			{
                echo '
            <script type = "text/javascript">
            alert("Add User Successfully........");
            window.location = "adduser.php";
           </script>';
			}
         
		}
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--========== BOX ICONS ==========-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet"
        crossorigin="anonymous" />

    <!--========== CSS ==========-->
    <link rel="stylesheet" href="../assets/navbar/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <!--========== Font ==========-->
    <link rel="stylesheet" type="text/css"
        href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
 <!--========== model ==========-->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>


    <title>ข้อมูลผู้ใช้</title>
    <style>
        
    td,
    th {
        vertical-align: middle !important;
    }

    td p {
        margin: unset
    }

    .table thead tr {
        background-color: #d470a2 !important;
        color: #ffffff;
        text-align: left;
    }

    .modal {
        position: absolute;
        top: 25%;
        width: 100%;
        text-align: center;
        font-size: 18px;
    }
    .nav__container {
  margin-left: 15%;
}
.nav__link:hover {
  color: var(--first-color);
  text-decoration: none;
}
.header__container a{
        text-decoration: none;
    }
    </style>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php include 'nav.php'; ?>
    <?php
    if(isset($_REQUEST['delete_id']))
    {
        // select image from db to delete
        $id=$_REQUEST['delete_id'];	//get delete_id and store in $id variable		
        $select_stmt= $conn->prepare('SELECT * FROM tbl_emp WHERE m_username =:m_username');	//sql select query
        $select_stmt->bindParam(':m_username',$id);
        $select_stmt->execute();

        $status ='Delete User';
        $insert_stmt=$conn->prepare('INSERT INTO add_user_log(m_username,m_action,ip,host) VALUES(:m_usernameup,:m_actionup,:hostup,:ipup)'); //sql insert query					
        //bind all parameter 
   $insert_stmt->bindParam(':m_usernameup',$id);
   $insert_stmt->bindParam(':m_actionup',$status);
   $insert_stmt->bindParam(':actionby_up',$status);
   $insert_stmt->bindParam(':ipup',$status);
   $insert_stmt->bindParam(':hostup',$status);
//    $insert_stmt->execute();
        $row=$select_stmt->fetch(PDO::FETCH_ASSOC);
        $delete_stmt = $conn->prepare('DELETE FROM tbl_emp WHERE m_username =:m_username');
        $delete_stmt->bindParam(':m_username',$id);
        if($delete_stmt->execute())
        {
            echo '
            <script type = "text/javascript">
           alert("Deleate Successfully........");
           window.location = "adduser.php";
       </script>';
        }
    }
    

    ?>



 <br><br>
    

        <!--========== CONTENTS1 ==========-->
        <div class="container mt-5 col-xs-12 col-md-12 col-lg-12 col-xl-12">
        <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item " aria-current="page">ข้อมูลผู้ใช้งาน</li>
  </ol>
</nav>
            <?php
require_once("../Authen/dbcontroller.php");
$db_handle = new DBController();
$username = "";
$level = "";
$queryCondition = "";
if(!empty($_POST["search"])) {
    foreach($_POST["search"] as $k=>$v){
        if(!empty($v)) {

            $queryCases = array("m_username","m_level");
            if(in_array($k,$queryCases)) {
                if(!empty($queryCondition)) {
                    $queryCondition .= " AND ";
                } else {
                    $queryCondition .= " WHERE ";
                }
            }
            switch($k) {
                case "name":
                    $username = $v;
                    $queryCondition .= "and m_username LIKE '" . $v . "%'";
                    break;
                case "level":
                    $level = $v;
                    $queryCondition .= "and m_level LIKE '" . $v . "%'";
                    break;
            }
        }
    }
}
$orderby = " ORDER BY m_id desc"; 
$sql = "SELECT *, DATE_FORMAT(m_datesave, '%d/%m/%Y/%T') as dt FROM tbl_emp where m_id " . $queryCondition ;//ดึงขอมูลเฉพาะuserที่เป็นคนอัพโหลดไฟล์ 
require_once("perpage.php");
require_once("pagination_function.php");
$href = 'adduser.php';					
$perPage = 5; 
$page = 1;
if(isset($_POST['page'])){
    $page = $_POST['page'];
}
$start = ($page-1)*$perPage;
if($start < 0) $start = 0;
    
$query =  $sql . $orderby .  " limit " . $start . "," . $perPage; 

// echo $query;
$result = $db_handle->runQuery($query);

if(!empty($result)) {
    $result["perpage"] = showperpage($sql, $perPage, $href);
}
?>
            <form name="frmSearch" method="post" action="adduser.php">
                <div class="form-inline mb-2">
                    <div class="form-group">
                        <input type="text" placeholder="username" name="search[name]" class="form-control"
                            value="<?php echo $username; ?>" />
                    </div>
                    &nbsp;
                    <div class="form-group">
                        <input type="text" placeholder="Admin/Staff" name="search[level]" class="form-control"
                            value="<?php echo $level; ?>" />
                    </div>
                    &nbsp;
                    <div class="form-group mr-2">
                        <input type="submit" name="go" class="btn btn-primary" value="Search">
                    </div>
                    <div class="form-group mr-2">
                        <input type="reset" class="btn btn-secondary" value="Reset"
                            onclick="window.location='adduser.php'">
                    </div>
                </div>
                <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <td class='text-center'>m_id</td>
                            <td class='text-center'>Username</td>
                            <td class='text-center'>Password</td>
                            <td class='text-center'>Level</td>
                            <td class='text-center'>Create By</td>
                            <td class='text-center'>Device</td>
                            <td class='text-center'>IP Address</td>
                            <td class='text-center'>Time Create</td>
                            <td class='text-center'><a href="" class="btn btn-light" data-toggle="modal"
                                    data-target="#add_user">Add User</a></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
					if(!empty($result)) {
						foreach($result as $k=>$v) {
						  if(is_numeric($k)) {
					?>
                        <tr>
                            <td class='text-center'><?php echo $result[$k]["m_id"]; ?></td>
                            <td class='text-center'><?php echo $result[$k]["m_username"]; ?></td>
                            <td class='text-center'><?php echo $result[$k]["m_password"]; ?></td>
                            <td class='text-center'><?php echo $result[$k]["m_level"]; ?></td>
                            <td class='text-center'><?php echo $result[$k]["create_by"]; ?></td>
                            <td class='text-center'><?php echo $result[$k]["host"]; ?></td>
                            <td class='text-center'><?php echo $result[$k]["ip"]; ?></td>
                            <td class='text-center'><?php echo $result[$k]["dt"]; ?></td>

                            
                                    <td class='text-center'><a href="update_user.php?update_id=<?php echo $result[$k]["m_id"]; ?>"
                                    class="btn btn-warning">Edit</a>
                                <a href="?delete_id=<?php  echo $result[$k]["m_username"]; ?>"
                                onclick="Del(this.href);return false;" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>



                        <?php
						  }
					   }
                    }
                   
					if(isset($result["perpage"])) {
					?>
                        <nav>
                            <tr>
                            <td colspan="9" align=center> <?php echo $result["perpage"]; ?></td>

                            </tr>
                            <?php } ?>
                        </nav>
                    <tbody>
                </table>
                </div>
            </form>

        </div>

        <!--========== CONTENTS2 ==========-->
        <!-- this is input form -->
        <div class="modal fade" id="add_user" tabuser="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="post" class="form-horizontal" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="col">
                                <input type="hidden" name="txt_ip" value="<?php echo $_SERVER['REMOTE_ADDR'];?>" />
                                <input type="hidden" name="txt_host"
                                    value="<?php echo gethostbyaddr($_SERVER['REMOTE_ADDR']); ?>" />
                                <input type="hidden" name="txt_by" value="<?php echo $m_username; ?>" />
                            </div>
                            <br><br>
                            <div class=" form-group">
                                <div class="col">
                                    <input type="text" name="txt_name" class="form-control" placeholder="Username"
                                        required />
                                </div>
                            </div>

                            <div class=" form-group">
                                <div class="col">
                                    <input type="text" name="txt_password" class="form-control" placeholder="Password"
                                        required />
                                </div>
                            </div>

                            <div class=" form-group">
                                <div class="col">
                                    <select name="level" class="form-control">
                                        <option value="admin">Admin</option>
                                        <option selected value="staff">Staff</option>
                                    </select>
                                </div>
                            </div>
                            
                    </form>
                    <div class="modal-footer d-flex justify-content-center">
                        <button id="btn_insert" name="btn_insert" class="btn btn-info">Submit <i
                                class="fa fa-file ml-1"></i></button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- this is input form -->
    </main>
    <!--========== MAIN JS ==========-->
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/time.js"></script>
</body>
</html>
<SCRIPT LANGUAGE="JavaScript">
function Del(mypage) {
    //alert('url : '+mypage);
    var agree = confirm("คุณต้องการลบข้อมูลหรือไม่ ?");
    if (agree) {
        //alert('url : '+mypage);
        window.location = mypage;
    }
}
</SCRIPT>