<?php 
class UploadFile{
    public function uploadIamge ($filename){
        $target_dir = "uploads/";
        $name_part= explode("." , $_FILES[$filename]['name']);
        
        $ext =end( $name_part);
        $new_file_name =time().".".$ext ;
        
        $target_file = $target_dir .  $new_file_name;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        $accecptOnly = ['jpg' , 'png' , 'jpeg' ];
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES[$filename]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
        }

        // Check if file already exists
        if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
        }

        // Check file size
        if ($_FILES[$filename]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
        }

        // Allow certain file formats
        foreach( $accecptOnly as $mime){
            if($imageFileType == $mime){
                break ;
            }
            else {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
        }
        // if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        // && $imageFileType != "gif" ) {
        
        // }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
        if (move_uploaded_file($_FILES[$filename]["tmp_name"], $target_file)) {
            // echo "The file ". htmlspecialchars( basename( $_FILES[$filename]["name"])). " has been uploaded.";
            return $new_file_name ;
        } else {
            // echo "Sorry, there was an error uploading your file.";
            return '' ;
        }
    }
 }
}
?>