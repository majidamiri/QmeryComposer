<?php


/**
 * This is the category class for contacting to
 * Qmery api platform
 *
 * @author Majid <info@majidoffline.com>
 *
 * The followings are the available columns in table 'tbl_videos':
 * 
 * @property integer $id
 * @property string $description
 * @property string $title
 * @property integer $video_count
 * @property integer $last_modified
 * @property integer $create_date
 * @property string $hash_id
 * @property string $name Description
 */


namespace Category;
use \Base\Base;
use GuzzleHttp;

class Category extends Base
{

    private $_attibutes = array(
        'public' => array(
            'title' => null,
            'description' => null
        ),
        'private' => array(
            'video_count' => null,
            'create_date' => null,
            'last_modified' => null,
            'hash_id' => null,
            'id' => null
        )
    );
    private $_isNew = true;
    private $_parent = null;

    function __get($name) {
        if ($ret = parent::__get($name)) {
            return $ret;
        }
        if (key_exists($name, $this->_attibutes['public'])) {
            return $this->_attibutes['public'][$name];
        }
        if (key_exists($name, $this->_attibutes['private'])) {
            return $this->_attibutes['private'][$name];
        }
//        throw new Exception('Property '. $name .' is not defined');
        return false;
    }

    function __set($name, $value) {
        if (key_exists($name, $this->_attibutes['public'])) {
            $this->_attibutes['public'][$name] = $value;
            return $value;
        } else if (key_exists($name, $this->_attibutes['private'])) {
            $this->_attibutes['private'][$name] = $value;
            return $value;
        } else {

            //throw new \Exception('You can\'t access to ' . $name . ' cause its private');
        }
        return false;
    }
    function __construct($array = array()) {

        $this->_parent = Base::Instance($array);
        if (!$this->_parent->api_link) {
            return;
        }
        if (is_array($array)) {
            foreach ($array as $key => $val) {
                $this->$key = $val;
            }
        } elseif (is_string($array)) {
            $this->hash_id = $array;
            $this->getCategory();
        }

        if (($this->id !== null)) {
            $this->_isNew = false;
        }
    }

    function delete() {
    	$client = new GuzzleHttp\Client();
        $uri = $uri = $this->_parent->api_link . parent::REQUEST_CATEGORY . $this->hash_id . '.json' . $this->_parent->_authStr();
        $request = $client->delete($uri, array(), array (
            //'api_token' => str_replace('@', '', $_POST['firstname'])
        ));
        $response = $request->getBody();

        echo $response;

    }

    function getCategory() {
        $uri = $uri = $this->_parent->api_link . parent::REQUEST_CATEGORY . $this->hash_id . '.json' . $this->_parent->_authStr();
    	$client = new GuzzleHttp\Client();
        $request = $client->get($uri, array(), array(
            //'api_token' => str_replace('@', '', $_POST['firstname'])
        ));
        $response = json_decode($request->getBody());
        if($request->getStatusCode() != 200)
        {
            return false;
        }
        foreach ($response as $k => $v) {
            $this->$k = $v;
        }
        return $this;

    }


    function insert() {
        $uri = $uri = $this->_parent->api_link . parent::REQUEST_LIST . $this->_parent->_authStr();
        $qmerySize['title'] = $this->title;
        $qmerySize['description'] = $this->description;      
    	$client = new GuzzleHttp\Client();
        $request = $client->post($uri, array(
        	"debug"=>false,
        	"json"=>$qmerySize
        ));
        $response = json_decode($request->getBody());
        if($request->getStatusCode() != 201)
        {
            return false;
        }	
        $headers = $request->getHeaders();
        $uri = $headers['Location'][0] . $this->_parent->_authStr();
        $request = $client->get($uri, array(), array(
            //'api_token' => str_replace('@', '', $_POST['firstname'])
        ));
        $response = json_decode($request->getBody());
        if($request->getStatusCode() != 200)
        {
            return false;
        }
        foreach ($response as $k => $v) {
            $this->$k = $v;
        }
        return $this;

    }





    public function update() {
        $uri = $uri = $this->_parent->api_link . parent::REQUEST_CATEGORY . $this->hash_id . '.json' . $this->_parent->_authStr();
        $qmerySize['title'] = $this->title;
        $qmerySize['description'] = $this->description;      
    	$client = new GuzzleHttp\Client();
        $request = $client->put($uri, array(
        	"debug"=>false,
        	"json"=>$qmerySize
        ));
        $response = json_decode($request->getBody());
        if($request->getStatusCode() != 200)
        {
            return false;
        }	
        $request = $client->get($uri, array(), array(
            //'api_token' => str_replace('@', '', $_POST['firstname'])
        ));
        $response = json_decode($request->getBody());
        if($request->getStatusCode() != 200)
        {
            return false;
        }
        foreach ($response as $k => $v) {
            $this->$k = $v;
        }
        return $this;
    }
















}


?>
