<?php
use \Category\Category;
use \Video\Video;
use \Base\Base;
error_reporting(E_ALL);
ini_set("display_errors", true);
require __DIR__ . '/vendor/autoload.php';
$token_id = '33d82d78b556';

$category_array = array('token'=>$token_id);
$video_array = array('token'=>$token_id);

//for delete one category && get one category
$category_array['hash_id'] = "Qn3wVpaaP4p1vgN5"; 
//


//for delete one category && get one category
$video_array['hash_id'] = "2WXb5NQZAV"; 
//

//for add subtitle
// $video_array['file'] = "/var/www/html/a/sub.srt";
// $video_array['name'] = "sub majid";
//


//for add thumbnail
	$video_array['file'] = "/var/www/html/a/test.png";
	$video_array['default'] = 1;
//

//for delete thumbnail
	$video_array['index'] = 0;
//

//for insert category or update
// $category_array['title'] = "haj majid update shode "; 	
// $category_array['description'] = "update a b c asd"; 	
//

//for update or insert video 
//$video_array['title'] = "new upload lol"; 	
//$video_array['description'] = "update a b c asdsw a"; 	
	// insert 
		//$video_array['group_id'] = 1490;
	    //$video_array['logo_url'] = 'http://cdn.akamai.steamstatic.com/steam/apps/570/header.jpg?t=1485534561';
        //$video_array['logo_size'] = '10:10';
        //$video_array['logo_position'] = '10:10';
        //$video_array['callback_url'] = 'callback_url';
        //if u have Url
        //$video_array['url'] = "http://techslides.com/demos/sample-videos/small.3gp";
        //
        //if u have Upload File
        //$video_array['video'] = "/var/www/html/a/test.mp4";
        //

	//

//

$base = new Base($category_array);
$category = new Category($category_array);
$video = new Video($video_array);



//get all categories ......................................
// $All_Categories = $base->getCategories();
// var_dump($All_Categories);
//---------------------------------------------------------

//get all Videos-------------------------------------------
// $All_Videos = $base->getVideos();
// var_dump($All_Videos);
//---------------------------------------------------------

//delete one category -------------------------------------
//$DeleteCategory = $category->delete();
//---------------------------------------------------------

//get one category -------------------------------------
// $GetCategory = $category->getCategory();
// var_dump($GetCategory);
//---------------------------------------------------------

//insert one category -------------------------------------
//$InsertCategory = $category->insert();
//var_dump($InsertCategory);
//---------------------------------------------------------

//update one category -------------------------------------
// $UpdateCategory = $category->update();
// var_dump($UpdateCategory);
//---------------------------------------------------------

//get one video -------------------------------------
// $GetVideo = $video->getVideo();
// var_dump($GetVideo);
//---------------------------------------------------------

//update one video -------------------------------------
// $UpdateVideo = $video->update();
// var_dump($UpdateVideo);
//---------------------------------------------------------

//delete one video -------------------------------------
//$Deletevideo = $video->delete();
//---------------------------------------------------------


//add one video -------------------------------------
// $Insertvideo = $video->insert();
// var_dump($Insertvideo);
//---------------------------------------------------------

//add subtitle on video -------------------------------------
// $addsubtitle = $video->addsubtitle();
// var_dump($addsubtitle);
//---------------------------------------------------------


//delete subtitle  -------------------------------------
// $deletesubtitle = $video->deletesubtitle();
// var_dump($deletesubtitle);
//---------------------------------------------------------


//add thumbnail on video -------------------------------------
// $addthumbnail = $video->addthumbnail();
// var_dump($addthumbnail);
//---------------------------------------------------------


//delete thumbnail  -------------------------------------
// $deletethumbnail = $video->deletethumbnail();
// var_dump($deletethumbnail);
//---------------------------------------------------------


//set thumbnail  -------------------------------------
// $setthumbnail = $video->setthumbnail();
// var_dump($setthumbnail);
//---------------------------------------------------------



?>
