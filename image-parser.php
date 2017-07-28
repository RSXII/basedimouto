<?php
//begin upload parser
if($_POST['did_upload']){
//the folder where uploads will be saved
$upload_directory = 'uploads';
//what sizes do we need to generate?
$sizes = array(
'thumbnail' => 150,
'medium' 	=> 300,
);
//get the uploaded file
$uploadedfile = $_FILES['uploadedfile']['tmp_name'];
if($uploadedfile){
//validate: make sure this is an image
list( $width, $height ) = getimagesize($uploadedfile);
}

if( $width > 0 AND $height > 0 ){
//what type of image is it?
$filetype = $_FILES['uploadedfile']['type'];
switch($filetype){
case 'image/gif':
$source = imagecreatefromgif($uploadedfile);
break;

case 'image/jpg':
case 'image/jpeg':
case 'image/pjpeg':
$source = imagecreatefromjpeg($uploadedfile);
break;
case 'image/png':
//temporarily increase the server memory
ini_set( 'memory_limit', '16M' );
//process the png
$source = imagecreatefrompng($uploadedfile);
ini_restore('memory_limit');
break;
default:
$feedback = 'The only valid filetypes are .gif, .jpg, and .png';
}//end of switch
//resize and save each image size
$uniquestring = sha1(microtime());
foreach ($sizes AS $size_name => $size) {
/*SQUARE CROP CALCULATIONS*/
if ($width > $height) {
$crop_y = 0;
$crop_x = ($width - $height) / 2;
$smallestSide = $height;
} else {
$crop_x = 0;
$crop_y = ($height - $width) / 2;
$smallestSide = $width;
}
//resize the image - make a new blank canvas of the desired size
$tmp_canvas = imagecreatetruecolor($size, $size);
//copy the original image onto this canvas and resize
imagecopyresampled($tmp_canvas, $source, 0, 0, $crop_x, $crop_y, $size, $size, $smallestSide, $smallestSide);
//path will be like: ../uploads/dfgjdfhngkhf_thumbnail.jpg
$filepath = $upload_directory . '/' . $uniquestring . '_' . $size_name . '.jpg';

//save the image into the directory!
$did_save = imagejpeg($tmp_canvas, $filepath, 75);
}//end foreach
//if it worked, save the file name in the DB for the logged in user
if($did_save){
//delete the old avatar
$query_old = "SELECT profile_pic FROM users
WHERE user_id = " . $session_user
. " LIMIT 1";
$result_old = $db->query($query_old);
if($result_old->num_rows == 1){
$row_old = $result_old->fetch_assoc();
foreach ($sizes as $size_name => $size) {
$old_filepath = ROOT_PATH . '/uploads/' . $row_old['profile_pic'] . '_'
. $size_name . '.jpg';
//DELETE
@unlink($old_filepath);
}
}
//END DELETE old file
$query = "UPDATE users
SET profile_pic = '$uniquestring'
WHERE user_id = " . $session_user ;
$result = $db->query($query);
if($db->affected_rows >= 1){
$feedback = 'success';
header("Refresh:0");
}else{
$feedback = 'db error';
}
}else{
$feedback = 'The file did not save';
}
}else{
$feedback = 'That file is not an image. try again';
}
} //end of upload parser
?>
