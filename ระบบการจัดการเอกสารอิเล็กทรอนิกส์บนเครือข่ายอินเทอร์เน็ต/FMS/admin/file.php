<?php
session_start();
// echo '<pre>';
//         print_r($_SESSION);
// echo '</pre>';
include('../Authen/connlogin.php');
include('../Authen/conn.php');

$m_id = $_SESSION['m_id'];
$m_level = $_SESSION['m_level'];
$m_username = $_SESSION['m_username'];
if ($m_level != 'admin'){  //check session
 
    Header("Location: ../index.php"); //ไม่พบผู้ใช้กระโดดกลับไปหน้า login form 

}else
// if($m_level!='admin'){
// Header("Location: ../Authen/logout.php");
// }
//query member login
$queryemp = "SELECT * FROM tbl_emp WHERE m_id=$m_id";
$datam = mysqli_query($condb, $queryemp) or die ("Error in query: $queryemp " . mysqli_error($condb));
$rowm = mysqli_fetch_array($datam);
//เวลาปัจจุบัน
$timenow = date('H:i:s');
$datenow = date('Y-m-d');

//query delete_id



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
.box{
    margin-top: 5%;
}
.box-part{ 
    background-color: #eee;
    border-radius:0;
    padding:60px 10px;
    margin:30px 0px;
}
.text{
    margin:20px 0px;
}
.fa{
     color:#4183D7;
}
.date-selector {
  position: relative;
}

.date-selector>input[type=date] {
  text-indent: -500px;
}

    </style>
</head>

<body>
    <?php include 'nav.php'; ?>
    <main><br>
    
        <!--========== CONTENTS1 ==========-->
        <div class="container mt-5 col">
   
                        <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item " aria-current="page">ข้อมูลการอัพโหลด</li>
  </ol>
</nav>
            <?php
require_once("../Authen/dbcontroller.php");
$db_handle = new DBController();
$name = "";
$timestemp = "";
$queryCondition = "";
if(!empty($_POST["search"])) {
    foreach($_POST["search"] as $k=>$v){
        if(!empty($v)) {

            $queryCases = array("name","timestemp");
            if(in_array($k,$queryCases)) {
                if(!empty($queryCondition)) {
                    $queryCondition .= " AND ";
                } else {
                    // $queryCondition .= " WHERE ";
                }
            }
            switch($k) {
                case "name":
                    $name = $v;
                    $queryCondition .= "and name or `file_name` LIKE '" . $v . "%'";
                    break;
                case "timestemp":
                    $timestemp = $v;
                    $queryCondition .= "and timestemp LIKE '" . $v . "%'";
                    break;
            }
        }
    }
}
$orderby = " ORDER BY id desc"; 
$sql = "SELECT *, DATE_FORMAT(timestemp, '%d/%m/%Y/%T') as dt FROM file_tbl where id " . $queryCondition ;//ดึงขอมูลเฉพาะuserที่เป็นคนอัพโหลดไฟล์ 
require_once("perpage.php");
require_once("pagination_function.php");
$href = 'index.php';					
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
            <div class="container col">
                <div id="file_tbls-grid">
                    <form name="frmSearch" method="post" action="">
                        <div class="form-inline mb-2">
                            <div class="form-group">
    <input type="text" class="form-control" name="search[name]" placeholder="ชื่อเอกสาร/เรื่อง"  value="<?php echo $name; ?>">
  </div>
                            &nbsp;
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<div class="date-selector">
  <input id="datePicker" class="form-control" type="date"   name="search[timestemp]" value="<?php echo $timestemp; ?>" onkeydown="return false" />
  <span id="datePickerLbl" style="pointer-events: none;"></span>
</div>
&nbsp;
                            &nbsp;
                            <div class="form-group mr-2">
                                <input type="submit" name="go" class="btn btn-primary" value="Search">
                            </div>
                            <div class="form-group mr-2">
                                <input type="reset" class="btn btn-secondary" value="Reset"
                                    onclick="window.location=''">
                            </div>
                        </div>
                        <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <td class='text-center'>Titel</td>
                                    <td class='text-center'>file</td>
                                    <td class='text-center'>Real_filename</td>
                                    <td class='text-center'>Time</td>
                                    <td class='text-center'><a href="" class="btn btn-light" data-toggle="modal"
                                            data-target="#inputform">Add File</a></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
					if(!empty($result)) {
						foreach($result as $k=>$v) {
						  if(is_numeric($k)) {
					?>
                                <tr>
                                    <td><?php echo $result[$k]["fname"]; ?></td>
                                    <td><?php echo $result[$k]["file_name"]; ?></td>
                                    <td><?php echo $result[$k]["file_name_random"]; ?></td>
                                     <td> <?php echo $result[$k]["dt"]; ?></td>
                                    <td class='text-center'><a
                                            href="update.php?update_id=<?php echo $result[$k]["id"]; ?>"
                                            class="btn btn-warning">Edit</a>&nbsp;
                                        <a href="process.php?delete_id=<?php echo $result[$k]["file_name_random"];?>"
                                            onclick="Del(this.href);return false;"
                                            class="btn btn-danger">Delete</a>&nbsp;
                                        <a href="download.php?id=<?php echo $result[$k]["id"] ?>"
                                            class="btn btn-primary">Download</a>
                                    </td>
                                </tr>
                                <?php
						  }
					   }
                    }
					if(isset($result["perpage"])) {
					?>
                                <nav-colspan>
                                    <tr>
                                        <td colspan="5" align=center> <?php echo $result["perpage"]; ?></td>
                                    </tr>
                                    <?php } ?>
                                </nav-colspan>
                            <tbody>
                        </table>
                        </div>
                    </form>
                </div>
            </div>
            

            <!--========== CONTENTS2 ==========-->
                        <!-- this is input form -->
                        <div class="modal fade" id="inputform" tabuser="-1" role="dialog" aria-labelledby="myModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form method="post" action="process.php" class="form-horizontal" enctype="multipart/form-data">
                            <div class="form-group">
                                <div class="col">
                                    <input type="hidden" name="txt_ip" value="<?php echo $_SERVER['REMOTE_ADDR'];?>" />
                                    <input type="hidden" name="txt_id" value="<?php echo $m_id; ?>" />
                                </div>
                                <br><br>
                                <div class=" form-group">
                                    <div class="col">
                                        <input type="text" name="txt_name" class="form-control" placeholder="ชื่อไฟล์"
                                            required />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col">
                                        <input type="file" name="txt_file" class="form-control" required />

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
    <script src="../assets/js/time.js"></script>
    <script src="../assets/js/main.js"></script>


</body>


</html>