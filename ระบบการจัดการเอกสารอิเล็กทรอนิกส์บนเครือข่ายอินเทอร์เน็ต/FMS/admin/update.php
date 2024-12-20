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

if($m_level!='admin'){
Header("Location: ../Authen/logout.php");
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
    <!--========== CSS Nav==========-->
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

        <div class="container mt-5 col-6">

            <div class="col">

                <?php
				
				if(isset($_REQUEST['update_id']))
				{
					try
					{

						$id = $_REQUEST['update_id']; //get "update_id" from index.php page through anchor tag operation and store in "$id" variable
						$select_stmt = $conn->prepare('SELECT * FROM file_tbl WHERE id =:id'); //sql select query
						$select_stmt->bindParam(':id',$id);
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
					try
					{
						$milliseconds = round(microtime(true) * 1000);
						$host = gethostbyaddr($_SERVER['REMOTE_ADDR']);
						$name	= $_REQUEST['txt_name'];	//textbox name "txt_name"
						$ip_user	=$_REQUEST['txt_ip'];	//textbox ip "txt_ip
						echo $image_file	= $_FILES["txt_file"]["name"];
						$raw_file	= $_FILES["txt_file"]["name"];
						$type		= $_FILES["txt_file"]["type"];	//file name "txt_file"
						$size		= $_FILES["txt_file"]["size"];
						$temp		= $_FILES["txt_file"]["tmp_name"];
						$exp = explode(".", $image_file);
						$ext = end($exp);
						$image_file = $m_username.$milliseconds.".".$ext;
						$fileNameCmps = explode(".", $image_file);
						$fileExtension = strtolower(end($fileNameCmps));
						$directory="../filedata/"; //set upload folder path for update time previous file remove and new file upload for next use
						
				
						if($name!='')
						{
							$update_stmt=$conn->prepare('UPDATE file_tbl SET fname=:name_up WHERE id=:id'); //sql update query
							$update_stmt->bindParam(':name_up',$name);
							$update_stmt->bindParam(':id',$id);
							$update_stmt->execute();
							if($update_stmt->execute())
							{   echo '
								<script type = "text/javascript">
							   alert("แก้ไขสำเร็จ");
							   window.location = "file.php";
						   </script>';
							}
						}
						
						if($image_file!='')
						{
							if($allowedfileExtensions = array('zip', 'txt', 'xls', 'doc','pdf','rar') ) //check file extension
							{	
								if(in_array($fileExtension, $allowedfileExtensions)) //check file not exist in your upload folder path
								{
									if($size < 1000000) //check file size 5MB
									{
										@unlink($directory.$row['file']); //unlink function remove previous file
										move_uploaded_file($temp, "../filedata/" .$image_file);	//move upload file temperory directory to your upload folder	
										$status = "แก้ไขไฟล์";
									}

									if($allowedfileExtensions != array('zip', 'txt', 'xls', 'doc','pdf','rar')) //check file size 5MB
									{
										echo '
										<script type = "text/javascript">
									   alert("อัพโหลดผิดนามสกุล1");
									   window.location = "file.php";
								   </script>';
									}
								elseif($size > 1000000) {
									{
										$errorMsg="Your File To large Please Upload 5MB Size"; //error message file size not large than 5MB
										$status = "File too Hight";
										$insert_stmt=$conn->prepare('INSERT INTO file_log(file_name,name_random,action,create_by,ip,host) VALUES(:fileup,:filerandom,:actionup,:m_username,:ipup,:hostup)'); //sql insert query					
										//bind all parameter 
								   $insert_stmt->bindParam(':fileup',$raw_file);
								   $insert_stmt->bindParam(':filerandom',$image_file);
								   $insert_stmt->bindParam(':actionup',$status);
								   $insert_stmt->bindParam(':ipup',$ip_user);
								   $insert_stmt->bindParam(':m_username',$m_username);
								   $insert_stmt->bindParam(':hostup',$host);
								   $insert_stmt->execute();
								   echo '
								   <script type = "text/javascript">
								  alert("ไฟล์มีขนาดใหญ่เกินไป");
								  window.location = "file.php";
							  </script>';
							  exit();
								}
							}
						}
								else
								{	
									$errorMsg="File Already Exists...Check Upload Folder"; //error message file not exists your upload folder path
									$status = "File Already Exists";
									$insert_stmt=$conn->prepare('INSERT INTO file_log(file_name,action,create_by,ip,host) VALUES(:fileup,:actionup,:m_username,:ipup,:hostup)'); //sql insert query					
									//bind all parameter 
							   $insert_stmt->bindParam(':fileup',$raw_file);
							   $insert_stmt->bindParam(':actionup',$status);
							   $insert_stmt->bindParam(':ipup',$ip_user);
							   $insert_stmt->bindParam(':m_username',$m_username);
							   $insert_stmt->bindParam(':hostup',$host);
					   $insert_stmt->execute();
								   echo '
								   <script type = "text/javascript">
								  alert("อัพโหลดผิดนามสกุล");
								  window.location = "file.php";
							  </script>';
							  exit();
								}
							
							}		
						}
		
						if(!isset($errorMsg))
						{
							$status ='update file';
							$insert_stmt=$conn->prepare('INSERT INTO file_log(file_name,name_random,action,create_by,ip,host) VALUES(:fileup,:filerandom,:actionup,:m_username,:ipup,:hostup)'); //sql insert query					
							//bind all parameter 
					   $insert_stmt->bindParam(':fileup',$raw_file);
					   $insert_stmt->bindParam(':filerandom',$image_file);
					   $insert_stmt->bindParam(':actionup',$status);
					   $insert_stmt->bindParam(':ipup',$ip_user);
					   $insert_stmt->bindParam(':m_username',$m_username);
					   $insert_stmt->bindParam(':hostup',$host);
							$insert_stmt->execute();

							$update_stmt=$conn->prepare('UPDATE file_tbl SET fname=:name_up,file_name=:raw_name,file=:file_up ,ip=:ip_up,status=:status,host=:hostup WHERE id=:id'); //sql update query
							$update_stmt->bindParam(':name_up',$name);
							$update_stmt->bindParam(':raw_name',$raw_file);
							$update_stmt->bindParam(':file_up',$image_file);	//bind all parameter
							$update_stmt->bindParam(':ip_up',$ip_user);
							$update_stmt->bindParam(':id',$id);
							$update_stmt->bindParam(':status',$status);
							$update_stmt->bindParam(':hostup',$host);
							if($update_stmt->execute())
							{
								$updateMsg="File Update Successfully.......";	//file update success message
								header("refresh:2;file.php");	//refresh 3 second and redirect to index.php page
							}
						}
					}
					catch(PDOException $e)
					{
						echo $e->getMessage();
					}
					
				}
		if(isset($errorMsg))
		{
			?>
                <div class="alert alert-danger">
                    <strong>WRONG ! <?php echo $errorMsg; ?></strong>
                </div>
                <?php
		}
		if(isset($updateMsg)){
		?>
                <div class="alert alert-success">
                    <strong>UPDATE ! <?php echo $updateMsg; ?></strong>
                </div>
                <?php
		}
		?>
                <form method="post" class="form-horizontal" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" name="txt_name" class="form-control" value="<?=$row["fname"]?> " />
                        <input type="hidden" name="txt_ip" value="<?php echo $_SERVER['REMOTE_ADDR'];?>" />
                    </div>

                    <div class="form-group">
                        <label for="">File</label>
                        <input type="file" name="txt_file" class="form-control" value="<?=$row["file"]?>" />
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9 m-t-15">
                            <input type="submit" name="btn_update" class="btn btn-primary" value="Update">
                            <a href="index.php" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>

                </form>

            </div>
        </div>


    </div>










    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous">
    </script>

<script src="../assets/js/main.js"></script>
</body>

</html>