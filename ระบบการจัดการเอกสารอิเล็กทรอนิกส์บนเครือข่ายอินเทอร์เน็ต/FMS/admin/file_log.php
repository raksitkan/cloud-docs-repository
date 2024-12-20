<?php
session_start();
include('../Authen/connlogin.php');
include('../Authen/conn.php');
$m_id = $_SESSION['m_id'];
$m_level = $_SESSION['m_level'];
$m_username = $_SESSION['m_username'];
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
    }.date-selector {
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


        <div class="container mt-5 col-xs-12 col-md-12 col-lg-12 col-xl-12">
        <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item " aria-current="page">ข้อมูลการจัดการไฟล์</li>
  </ol>
</nav>
<?php
require_once("../Authen/dbcontroller.php");
$db_handle = new DBController();
$create_by = "";
$create_time = "";
$queryCondition = "";
if(!empty($_POST["search"])) {
    foreach($_POST["search"] as $k=>$v){
        if(!empty($v)) {

            $queryCases = array("create_by","create_time");
            if(in_array($k,$queryCases)) {
                if(!empty($queryCondition)) {
                    $queryCondition .= " AND ";
                } else {
                    $queryCondition .= " WHERE ";
                }
            }
            switch($k) {
                case "name":
                    $create_by = $v;
                    $queryCondition .= "and create_by LIKE '" . $v . "%'";
                    break;
                case "timestemp":
                    $create_time = $v;
                    $queryCondition .= "and create_time LIKE '" . $v . "%'";
                    break;
            }
        }
    }
}
$orderby = " order by log_id desc"; 
 $sql = " SELECT * FROM file_log where log_id  " . $queryCondition ;//ดึงขอมูลเฉพาะuserที่เป็นคนอัพโหลดไฟล์ 
require_once("perpage.php");
require_once("pagination_function.php");
$href = 'file_log.php';					
$perPage = 10; 
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
                <form name="frmSearch" method="post" action="file_log.php">


                    <div class="form-inline mb-2">
                        <div class="form-group">
                            <input type="text" placeholder="username" name="search[name]" class="form-control"
                                value="<?php echo $create_by; ?>" />

                        </div>
                        &nbsp;
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<div class="date-selector">
  <input id="datePicker" class="form-control" type="date"   name="search[timestemp]" value="<?php echo $create_time; ?>" onkeydown="return false" />
  <span id="datePickerLbl" style="pointer-events: none;"></span>
</div>
                        &nbsp;

                        <div class="form-group mr-2">
                        <input type="submit" name="go" class="btn btn-primary" value="Search">
                        </div>
                        <div class="form-group mr-2">
                        <input type="reset" class="btn btn-secondary" value="Reset" onclick="window.location='file_log.php'">
                        </div>
                    </div>



                    <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <td class='text-center'>log_id</td>
                                <td class='text-center'>Filename</td>
                                <td class='text-center'>Subject</td>
                                <td class='text-center'>Action</td>
                                <td class='text-center'>Create_By</td>
                                <td class='text-center'>IP</td>
                                <td class='text-center'>Time_Add</td>
                                <td class='text-center'><a href="" class="btn btn-light" data-toggle="modal"
                                        data-target="#dateform">Print</a></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
					if(!empty($result)) {
						foreach($result as $k=>$v) {
						  if(is_numeric($k)) {
					?>
                            <tr>
                                <td><?php echo $result[$k]["log_id"]; ?></td>
                                <td><?php echo $result[$k]["file_name"]; ?></td>
                                <td><?php echo $result[$k]["subjects"]; ?></td>
                                <td><?php echo $result[$k]["action"]; ?></td>
                                <td><?php echo $result[$k]["create_by"]; ?></td>
                                
                                <td><?php echo $result[$k]["ip"]; ?></td>
                                <td><?php echo $result[$k]["create_time"]; ?></td>
                                <td><?php echo $result[$k]["host"]; ?></td>

                            </tr>



                            <?php
						  }
					   }
                    }
                   
					if(isset($result["perpage"])) {
					?>
                            <nav>
                                <tr>
                                <td colspan="8" align=center> <?php echo $result["perpage"]; ?></td>

                                </tr>
                                <?php } ?>
                            </nav>
                        <tbody>
                    </table>
                    </div>
                </form>
          
        </div>

        <!--========== CONTENTS2 ==========-->
        <!-- Modal -->
        <div class="modal fade" id="dateform" tabuser="-1" role="dialog" aria-labelledby="myModalLabel"
        
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="post" action="exportData.php" class="form-horizontal" enctype="multipart/form-data">
                            <br><br>
    <h3>เลือกวันที่พิพม์รายงาน</h3>
    <br>
                            <div class=" form-group">
                                <div class="col">     
                                    <input type="date" id="startdate" name="startdate"> To <input type="date" id="enddate" name="enddate">
                                </div>
                            </div>                
                   
                    <div class="modal-footer d-flex justify-content-center">
                        <button id="btn_insert" name="btn_file_log" class="btn btn-info">Submit <i
                                class="fa fa-file ml-1"></i></button>
                                </form>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!--========== MAIN JS ==========-->

    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/time.js"></script>


</body>


</html>