<?php
use \Category\Category;
use \Base\Base;
require __DIR__ . '/vendor/autoload.php';
$token_id = '33d82d78b556';
$category_array = array('token'=>$token_id);
//for delete one category && get one category
//$category_array['hash_id'] = "Qn3wVpaaP4p1vgN5"; 
//


//for insert category or update
// $category_array['title'] = "haj majid update shode "; 	
// $category_array['description'] = "update a b c asd"; 	
//


$base = new Base($category_array);
$category = new Category($category_array);

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






?>
