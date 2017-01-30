<?php

/**
 * This is the category class for contacting to
 * Qmery api platform
 *
 * @author Majid <info@majidoffline.com>
 * You Cant Buy Happiness But U Can Buy Weed And Thats Pretty Close .
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

namespace Video;
use \Base\Base;
use GuzzleHttp;
class Video extends Base {

    private $_attibutes = array(
        'public' => array(
            'title' => null,
            'description' => null,
            'video' => null,
            'file' => null,
            'name' => null,
            'default' => null,
            'index' => null,
            'url' => null
        ),
        'private' => array(
            'length' => null,
            'viewed' => null,
            'status' => null,
            'group_id' => null,
            'video_quality' => null,
            'link' => null,
            'thumbnail' => null,
            'create_date' => null,
            'modified_date' => null,
            'hash_id' => null,
            'id' => null,
            'engagement' => null,
            'percent' => null,
            'uniquePlay' => null,
            'played' => null,
            'hls' => null
        )
    );
    
    public $logoUrl = null;
    public $logoSize = null;
    public $logoPosition = null;
    public $callBack = null;
    
    public $upload_file;
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

    function __construct($array = null) {
        $this->_parent = Base::Instance();
        if (!$this->_parent->api_link) {
            return;
        }
        if (is_array($array)) {
            foreach ($array as $key => $val) {
                $this->$key = $val;
            }
        } elseif (is_string($array)) {
            $this->hash_id = $array;
            $this->getVideo();
        }

        if (($this->id !== null)) {
            $this->_isNew = false;
        }
    }

    function save() {
        if ($this->_isNew) {
            return $this->insert();
        } else {
            return $this->update();
        }
    }

    function getVideo() {
        $uri = $uri = $this->_parent->api_link . parent::REQUEST_VIDEO . $this->hash_id . '.json' . $this->_parent->_authStr();        
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

    function addsubtitle() {
        $uri = $this->_parent->api_link . parent::REQUEST_VIDEO . $this->hash_id . '/' . parent::REQUEST_LIST_SUBTITLE.$this->_parent->_authStr(); 
        $client = new GuzzleHttp\Client();
        $qmerySize[] = array('name'=>'name','contents'=>$this->name);
        $qmerySize[] = array('name'=>'file','contents'=>fopen($this->file, 'r'),'Content-type'=>'multipart/form-data');
        //var_dump($qmerySize);die;
        $request = $client->post($uri, array(
            "multipart"=>$qmerySize
        ));
        $response = json_decode($request->getBody());
        if($request->getStatusCode() != 201)
        {
            return false;
        }
        foreach ($response as $k => $v) {
            $this->$k = $v;
        }
        return $this;
    }


    function deletesubtitle() {
        $uri = $this->_parent->api_link . parent::REQUEST_VIDEO . $this->hash_id . '/' . parent::REQUEST_LIST_SUBTITLE.$this->_parent->_authStr(); 
        $client = new GuzzleHttp\Client();
        $qmerySize[] = array('name'=>'name','contents'=>$this->name);

        $qmerySize['name'] = $this->name;
        $request = $client->delete($uri, array(
            "json"=>$qmerySize
        ));
        $response = json_decode($request->getBody());
        if($request->getStatusCode() != 200)
        {
            return false;
        }
        // foreach ($response as $k => $v) {
        //     $this->$k = $v;
        // }
        return $this;
    }





    function addthumbnail() {
        $uri = $this->_parent->api_link . parent::REQUEST_VIDEO . $this->hash_id . '/' . parent::REQUEST_LIST_THUMBNAIL.$this->_parent->_authStr(); 
        $client = new GuzzleHttp\Client();
        $qmerySize[] = array('name'=>'default','contents'=>$this->default);
        $qmerySize[] = array('name'=>'file','contents'=>fopen($this->file, 'r'),'Content-type'=>'multipart/form-data');
        $request = $client->post($uri, array(
            "multipart"=>$qmerySize
        ));
        $response = json_decode($request->getBody());
        if($request->getStatusCode() != 201)
        {
            return false;
        }
        foreach ($response as $k => $v) {
            $this->$k = $v;
        }
        return $this;
    }

    function deletethumbnail() {
        $uri = $this->_parent->api_link . parent::REQUEST_VIDEO . $this->hash_id . '/' . parent::REQUEST_LIST_THUMBNAIL.$this->_parent->_authStr(); 
        $client = new GuzzleHttp\Client();

        $qmerySize['index'] = $this->index;
        $request = $client->delete($uri, array(
            "json"=>$qmerySize
        ));
        $response = json_decode($request->getBody());
        if($request->getStatusCode() != 200)
        {
            return false;
        }
        // foreach ($response as $k => $v) {
        //     $this->$k = $v;
        // }
        return $this;
    }

    function setthumbnail() {
        $uri = $this->_parent->api_link . parent::REQUEST_VIDEO . $this->hash_id . '/' . parent::REQUEST_LIST_THUMBNAIL.$this->_parent->_authStr(); 
        $client = new GuzzleHttp\Client();

        $qmerySize['index'] = $this->index;
        $request = $client->put($uri, array(
            "json"=>$qmerySize
        ));
        $response = json_decode($request->getBody());
        if($request->getStatusCode() != 200)
        {
            return false;
        }
        // foreach ($response as $k => $v) {
        //     $this->$k = $v;
        // }
        return $this;
    }







    function delete() {
        $client = new GuzzleHttp\Client();
        $uri = $uri = $this->_parent->api_link . parent::REQUEST_VIDEO . $this->hash_id . '.json' . $this->_parent->_authStr();
        $request = $client->delete($uri, array(), array (
            //'api_token' => str_replace('@', '', $_POST['firstname'])
        ));
        $response = $request->getBody();

        echo $response;

    }

     function insert() {

        $uri =  $this->_parent->api_link . parent::REQUEST_LIST_VIDEO . $this->_parent->_authStrUpload();
        $client = new GuzzleHttp\Client();
        if($this->video) {
            $qmerySize[] = array('name'=>'group_id','contents'=>$this->group_id);
            $qmerySize[] = array('name'=>'title','contents'=>$this->title);
            $qmerySize[] = array('name'=>'description','contents'=>$this->description);
            if($this->logoUrl)
            {
                $qmerySize[] = array('name'=>'logo_url','contents'=>$this->logoUrl);
                $qmerySize[] = array('name'=>'logo_size','contents'=>$this->logoSize);
                $qmerySize[] = array('name'=>'logo_position','contents'=>$this->logoPosition);
            }
            $qmerySize[] = array('name'=>'callback_url','contents'=>$this->callBack);
            $qmerySize[] = array('name'=>'video','contents'=>fopen($this->video, 'r'),'Content-type'=>'multipart/form-data');
            //var_dump($qmerySize);die;
            $request = $client->post($uri, array(
                "multipart"=>$qmerySize
            ));
            $response = json_decode($request->getBody());
            if($request->getStatusCode() != 201)
            {
                return false;
            }   
            $headers = $request->getHeaders();
            return $response;
        } else {
            $qmerySize['group_id'] = $this->group_id;
            $qmerySize['title'] = $this->title;
            $qmerySize['description'] = $this->description;
            if($this->logoUrl)
            {
                $qmerySize['logo_url'] = $this->logoUrl;
                $qmerySize['logo_size'] = $this->logoSize;
                $qmerySize['logo_position'] = $this->logoPosition;
            }
            $qmerySize['callback_url'] = $this->callBack;
            $qmerySize['url'] = $this->url;
            $request = $client->post($uri, array(
                "json"=>$qmerySize
            ));
            $response = json_decode($request->getBody());
            if($request->getStatusCode() != 201)
            {
                return false;
            }   
            $headers = $request->getHeaders();
            return $response;



        }

        //return $this->__parseInsert($this->_parent->_createRequest($req));
    }

    public function update() {
        $uri = $uri = $this->_parent->api_link . parent::REQUEST_VIDEO . $this->hash_id . '.json' . $this->_parent->_authStr();

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

    private function __parseUpdate(\Httpful\Response $response) {
        $this->_parent->_error = false;
        if ($response->code != 200) {
            $this->_parent->_error = true;
            $this->_parent->_code = $response->code;
            $this->_parent->_message = $response->body;
            return false;
        }
        return true;
    }

    private function __parseDelete(\Httpful\Response $response) {
        $this->_parent->_error = false;
        if ($response->code != 200) {
            $this->_parent->_error = true;
            $this->_parent->_code = $response->code;
            $this->_parent->_message = $response->body;
            return false;
        }
        return true;
    }

    private function __parseInsert(\Httpful\Response $response) {
        $this->_parent->_error = false;
        if ($response->code != 201) {
            $this->_parent->_error = true;
            $this->_parent->_code = $response->code;
            $this->_parent->_message = $response->body;
            return false;
        }
        $uri = $response->headers->offsetGet('location') . $this->_parent->_authStr();
        $req = \Httpful\Request::get($uri);
        $newResponse = $this->_parent->_createRequest($req);

        /* @var $response Httpful\Response */
        if ($newResponse->code == 200) {
            if (empty($response->body)) {
                $this->_parent->_error = true;
                $this->_parent->_code = $newResponse->code;
                $this->_parent->_message = $newResponse->body;
                return false;
            }
            $rcv = $newResponse->body;
            foreach ($rcv as $k => $v) {
                $this->$k = $v;
            }
            array_push($this->_parent->videos, $this);
            return true;
        } else {
            $this->_parent->_error = true;
            $this->_parent->_code = $newResponse->code;
            $this->_parent->_message = $newResponse->body;
        }
    }

}
