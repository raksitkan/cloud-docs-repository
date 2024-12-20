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
$ip = $_SERVER['REMOTE_ADDR'];
$host = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$datenow = date('Y-m-d');
if(isset($_REQUEST['btn_insert']))
{
	try
	{
        $milliseconds = round(microtime(true) * 1000);
		$name	= $_REQUEST['txt_name'];
		$ip_user	= $_REQUEST['txt_ip'];	//textbox ip "txt_
		$id_user	= $_REQUEST['txt_id'];
        $raw_file	= $_FILES["txt_file"]["name"];
		$image_file	= $_FILES["txt_file"]["name"];
		$type		= $_FILES["txt_file"]["type"];	//file name "txt_file"	
		$size		= $_FILES["txt_file"]["size"];
		$temp		= $_FILES["txt_file"]["tmp_name"];
		$exp = explode(".", $image_file);
		$ext = end($exp);
		$image_file = $m_username.$milliseconds.".".$ext;
        $fileNameCmps = explode(".", $image_file);
	    $fileExtension = strtolower(end($fileNameCmps));
		$directory="../filedata/"; //set upload folder path for update time previous file remove and new file upload for next use
		if(empty($name)){
			$errorMsg="Please Enter Name";
		}
		if($image_file)
		{
			if($allowedfileExtensions = array('zip', 'txt', 'xls', 'doc','pdf','rar') ) //check file extension
			{	
				if(in_array($fileExtension, $allowedfileExtensions)) //check file not exist in your upload folder path
				{
					if($size <= 1000000) //check file size 5MB
					{
                        
						move_uploaded_file($temp, "../filedata/" .$image_file);	//move upload file temperory directory to your upload folder	

                //         echo '
                //         <script type = "text/javascript">
                //        alert("Upload file successfully!");
                //        window.location = "index.php";
                //    </script>';
						
					}
					elseif($size > 1000000) { // file shouldn't be larger than 1Megabyte
                        $status ='File too Hight';
                        $insert_stmt=$conn->prepare('INSERT INTO file_log(file_name,subjects,action,create_by,host,ip) VALUES(:fileup,:fname,:actionup,:m_username,:ipup,:hostup)'); //sql insert query					
                        //bind all parameter 
                   $insert_stmt->bindParam(':fileup',$raw_file);
                   $insert_stmt->bindParam(':fname',$name);
                   $insert_stmt->bindParam(':actionup',$status);
                   $insert_stmt->bindParam(':m_username',$m_username);
                   $insert_stmt->bindParam(':ipup',$ip_user);
                   $insert_stmt->bindParam(':hostup',$host);
                        $insert_stmt->execute();
                        echo '
                        <script type = "text/javascript">
                       alert("File too Hight!");
                       window.location = "index.php";
                   </script>';
                   exit();
                    }
				}else{
                $status ='Upload Wrong Extension';
                $insert_stmt=$conn->prepare('INSERT INTO file_log(file_name,subjects,action,create_by,host,ip) VALUES(:fileup,:fname,:actionup,:m_username,:ipup,:hostup)'); //sql insert query					
                //bind all parameter 
           $insert_stmt->bindParam(':fileup',$raw_file);
           $insert_stmt->bindParam(':fname',$name);
           $insert_stmt->bindParam(':actionup',$status);
           $insert_stmt->bindParam(':m_username',$m_username);
           $insert_stmt->bindParam(':ipup',$ip_user);
           $insert_stmt->bindParam(':hostup',$host);
			    $insert_stmt->execute();
                    echo '
                    <script type = "text/javascript">
                   alert("อัพโหลดผิดนามสกุล");
                   window.location = "index.php";
               </script>';
              exit();
            }

			
			}
			
		}
		if(!isset($errorMsg))
		{

            $status ='Upload file successfully';
            $insert_stmt=$conn->prepare('INSERT INTO file_log(file_name,name_random,action,create_by,ip,host,subjects) VALUES(:fileup,:filerandom,:actionup,:m_username,:ipup,:hostup,:subjects)'); //sql insert query					
            //bind all parameter 
       $insert_stmt->bindParam(':fileup',$raw_file);
       $insert_stmt->bindParam(':filerandom',$image_file);
       $insert_stmt->bindParam(':actionup',$status);
       $insert_stmt->bindParam(':ipup',$ip_user);
       $insert_stmt->bindParam(':m_username',$m_username);
       $insert_stmt->bindParam(':hostup',$host);
       $insert_stmt->bindParam(':subjects',$name);
            $insert_stmt->execute();

            
            $insert_stmt=$conn->prepare('INSERT INTO file_tbl(name,file_name,file,m_username,status,host,ip) VALUES(:fname,:ffile,:rfileup,:username,:status,:hostup,:ipup)'); //sql insert query					
			$insert_stmt->bindParam(':fname',$name);
            $insert_stmt->bindParam(':ffile',$raw_file);	  //bind all parameter 
            $insert_stmt->bindParam(':rfileup',$image_file);
            $insert_stmt->bindParam(':username',$m_username);
			$insert_stmt->bindParam(':status',$status);
            $insert_stmt->bindParam(':hostup',$host);
            $insert_stmt->bindParam(':ipup',$ip_user);
			if($insert_stmt->execute())
			{
                echo '
                <script type = "text/javascript">
               alert("File Upload Successfully........");
               window.location = "index.php";
           </script>';

			}
		}
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
}
//query delete_id
if(isset($_REQUEST['delete_id']))
{
    // select image from db to delete
    $file=$_REQUEST['delete_id'];	//get delete_id and store in $id variable		
    $select_stmt= $conn->prepare('SELECT * FROM file_tbl WHERE file_name_random =:file');	//sql select query
    $select_stmt->bindParam(':file',$file);
    $select_stmt->execute();
    $row=$select_stmt->fetch(PDO::FETCH_ASSOC);

    $status ='Deleted Successfully';
    $insert_stmt=$conn->prepare('INSERT INTO file_log(action,name_random,create_by,ip,host) VALUES(:actionup,:nameup,:create_byup,:ipup,:hostup)'); //sql insert query					
         //bind all parameter 
    $insert_stmt->bindParam(':actionup',$status);
    $insert_stmt->bindParam(':nameup',$file);
    $insert_stmt->bindParam(':create_byup',$m_username);
    $insert_stmt->bindParam(':ipup',$ip);
    $insert_stmt->bindParam(':hostup',$host);
    $insert_stmt->execute();

    @unlink("../filedata/".$row['file_name_random']); //unlink function permanently remove your file		
    //delete an orignal ecord from db
    $delete_stmt = $conn->prepare('DELETE FROM file_tbl WHERE file_name_random =:file');
    $delete_stmt->bindParam(':file',$file);
    $delete_stmt->execute();
    echo "<script type='text/javascript'>alert('Deleted Successfully');document.location='user.php'</script>";
}

?>