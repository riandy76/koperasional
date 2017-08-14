<?php
 if (isset($_POST['vid_user']) && isset($_POST['vuser_name']) && isset($_POST['vnama_user']) && isset($_POST['vpassword']))
 {
	$enc_password = hash('md5', $_POST['vpassword']);

	$imgFile = $_FILES['vfoto']['name'];
	$tmp_dir = $_FILES['vfoto']['tmp_name'];
	$imgSize = $_FILES['vfoto']['size'];

    $vidUser = $_POST['vid_user'];
    $vnama = $_POST['vnama_user'];
    $vusername = $_POST['vuser_name'];
    $vpassword = $enc_password;

if(empty($imgFile)){
			$errMSG = "Please Select Image File.";
		}
		else
		{
			$upload_dir = '../../assets/images/'; // upload directory
	
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

   		$object->createUser($vidUser, $vnama, $vusername, $vpassword, $userpic);
		}
 }

?>