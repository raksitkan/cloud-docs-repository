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
if ($m_level != 'admin') {  //check session

    Header("Location: ../index.php"); //ไม่พบผู้ใช้กระโดดกลับไปหน้า login form 

} else
    // if($m_level!='admin'){
    // Header("Location: ../Authen/logout.php");
    // }
    //query member login
    $queryemp = "SELECT * FROM tbl_emp WHERE m_id=$m_id";
$datam = mysqli_query($condb, $queryemp) or die("Error in query: $queryemp " . mysqli_error($condb));
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
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />

    <!--========== CSS ==========-->
    <link rel="stylesheet" href="../assets/navbar/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <!--========== Font ==========-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


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

        .header__container a {
            text-decoration: none;
        }


        .box {
            margin-top: 5%;
        }

        .box-part {
            background-color: #eee;
            border-radius: 0;
            padding: 60px 10px;
            margin: 30px 0px;
        }

        .text {
            margin: 20px 0px;
        }

        .fa {
            color: #4183D7;
        }

        #chart-container {
            width: 100%;
            height: auto;
        }
        @media screen and (min-width: 768px) {
            #chart-container {
            width: 200%;
            height: auto;
        }

  }
  @media screen and (min-width: 1024px) {
            #chart-container {
            width: 415%;
            height: auto;
        }

  }

    </style>
</head>

<body>
    <?php include 'nav.php'; ?>
    <main>
        <div class="box">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">

                        <div class="box-part text-center">

                            <i class="fa fa-plus-circle fa-3x" aria-hidden="true"></i>

                            <div class="title">
                                <h4>เอกสารใหม่</h4>
                            </div>

                            <div class="text">
                                <span><?php
                                        require_once("../Authen/connlogin.php");
                                        $sql = "select count(*) as total1 from file_tbl where date(timestemp)=date(date_sub(now(),interval 1 day))";
                                        $result = mysqli_query($condb, $sql);
                                        $total = mysqli_fetch_array($result, MYSQLI_ASSOC);
                                        // mysqli_free_result($result);
                                        echo $total['total1'];
                                        echo (" File");
                                        ?></span>
                            </div>



                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">

                        <div class="box-part text-center">

                            <i class="fa fa-files-o fa-3x" aria-hidden="true"></i>

                            <div class="title">
                                <h4>เอกสารทั้งหมด</h4>
                            </div>

                            <div class="text">
                                <span><?php
                                        require_once("../Authen/count.php");
                                        $sql = "SELECT * FROM file_tbl";
                                        $mysqliStatus = $mysqli->query($sql);
                                        $rows_count_value = mysqli_num_rows($mysqliStatus);
                                        echo $rows_count_value;
                                        echo (" File");
                                        $mysqli->close();
                                        ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">

                        <div class="box-part text-center">

                            <i class="fa fa-users fa-3x" aria-hidden="true"></i>

                            <div class="title">
                                <h4>จำนวนผู้ใช้</h4>
                            </div>

                            <div class="text">
                                <span><?php
                                        require("../Authen/count.php");
                                        $sql = "SELECT * FROM tbl_emp";
                                        $mysqliStatus = $mysqli->query($sql);
                                        $rows_count_value = mysqli_num_rows($mysqliStatus);
                                        echo $rows_count_value;
                                        echo (" user");
                                        $mysqli->close();
                                        ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">

                        <div class="box-part text-center">

                            <i class="fa fa-database fa-3x" aria-hidden="true"></i>

                            <div class="title">
                                <h4>สถานะหน่วยความจำ</h4>
                            </div>

                            <div class="text">
                                <span><?php
                                        $df = disk_free_space("C:");
                                        $df = ceil($df / 1073741824);
                                        echo $df;
                                        //////
                                        echo ("/");
                                        $dt = disk_total_space("C:");
                                        $dt = ceil($dt / 1073741824);
                                        echo $dt;
                                        echo ("GB");
                                        ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div id="chart-container">
        <canvas id="graphCanvas"></canvas>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script>
        $(document).ready(function() {
            showGraph();
        });

        function showGraph(){
            {
                $.post("data.php", function(data) {
                    console.log(data);
                    let name = [];
                    let score = [];

                    for (let i in data) {
                        name.push(data[i].file_type);
                        score.push(data[i].total);
                    }
                    let chartdata = {
                        labels: name,
                        datasets: [{
                                label: 'Total File',
                                backgroundColor: '#A792BD',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: score
                        }]
                        
                    };
                    let graphTarget = $('#graphCanvas');
                    let barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata
                    })
                })
            }
        }
    </script>


                </div>
            </div>
        </div>


    </main>
    <!--========== MAIN JS ==========-->




</body>


</html>