<?php
/**
vid_user_update
vlevel_update
vnama_user_update
vpassword_update
vfoto_update
**/
 if (isset($_POST['vid_user_update']) && isset($_POST['vlevel_update']) && isset($_POST['vnama_user_update']) && isset($_POST['vpassword_update'])) 
 {
	$enc_password = hash('md5', $_POST['vpassword_update']);

	$imgFile = $_FILES['vfoto_update']['name'];
	$tmp_dir = $_FILES['vfoto_update']['tmp_name'];
	$imgSize = $_FILES['vfoto_update']['size'];
 
    $vidUser = $_POST['vid_user_update'];
    $vnama = $_POST['vnama_user_update'];
    $vusername = $_POST['vlevel_update'];
    $vpassword = $enc_password;
/**
**/

if(empty($imgFile)){
			$errMSG = "Please Select Image File.";
		}
		else
		{
			$upload_dir = '../../assets/images/'; // upload directory

			$current_img = '../../assets/images/'.$_POST['vfoto_details'].'';
	
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
		
			// valid image extensions
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
		
			// rename uploading image
			$userpic = rand(1000,1000000).".".$imgExt;

			// allow valid image file formats
			if(in_array($imgExt, $valid_extensions)){			
				// Check file size '5MB'
				if($imgSize < 5000000)				{
					move_uploaded_file($tmp_dir,$upload_dir.$userpic);
					unlink($current_img);
				}
				else{
					$errMSG = "Sorry, your file is too large.";
				}
			}
			else{
				$errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";		
			}
		}

		// if no error occured, continue ....
		if(!isset($errMSG))
		{
		/**
		vid_user
		vuser_name
		vnama_user
		vpassword
		vfoto
		**/
		require '../../config/lib.php';	
   		$object = new AturUser();

   		$object->updateUser($vidUser, $vnama, $vusername, $vpassword, $userpic);
		}
 }

?>