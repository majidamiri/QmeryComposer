<?php

/**
 * This is the base class for contacting to
 * Qmery api platform
 *
 * @author Majid <info$majidoffline.com>
 *
 * The followings are the available columns in table 'tbl_videos':
 * @property string $api_link
 * @property string $token
 * @property string $username
 * @property string $password
 * @property integer $page
 * @property integer $per_page
 * @property string $sort
 * @property string $sort_dir
 * 
 * */

namespace Base;
use GuzzleHttp;


class Base {

    const METHOD_TOKEN = 1;
    const METHOD_USERPASS = 2;
    
    const REQUEST_LIST = 'groups.json';
    const REQUEST_CATEGORY = 'groups/';

    const REQUEST_LIST_VIDEO = 'videos.json';
    const REQUEST_VIDEO = 'videos/';

    const REQUEST_LIST_SUBTITLE = 'subtitle.json';
    const REQUEST_LIST_THUMBNAIL = 'thumbnail.json';
    const REQUEST_LIST_PLAYLISTS = 'playlists.json';
    /**
     *
     * @var array $_config 
     */
//    public $token = null;
    public $_config = array(
        'api_link' => 'http://api.qmery.com/v1/',
//        'api_link' => 'http://localhost/v1/',
        'token' => null,
        'upload_token' => null,
        'username' => null,
        'password' => null,
        'method' => self::METHOD_TOKEN,
        'page' => 1,
        'per_page' => 100,
        'sort' => 'id',
        'sort_dir' => 'desc'
    );
    public $_error = false;
    public $_code = null;
    public $_message = null;
    private $_options = array('page', 'per_page', 'sort', 'sort_dir');
    public $categories = array();
    public $videos = array();


    function __get($name) {
        if (key_exists($name, $this->_config))
            return $this->_config[$name];
        return false;
    }

    function __set($name, $value) {
        if (key_exists($name, $this->_config)) {
            $this->_config[$name] = $value;
            return $value;
        }
        return false;
    }


    function getCategories() {
        $client = new GuzzleHttp\Client();
        $uri = $this->api_link . self::REQUEST_LIST . $this->_authStr() . $this->_addOptions();
        $request = $client->get($uri, array(), array (
            //'api_token' => str_replace('@', '', $_POST['firstname'])
        ));
        $response = $request->getBody();
        if($request->getStatusCode() != 200)
        {
            return false;
        }

        $counter = 0;
        foreach (json_decode($response) as $value) 
            $array[] = $value;


        foreach ($array as $body) {
            $this->categories[$counter] = $body;
            $counter++;
        }
        return $this->categories;
    }

    function getVideos() {


        $client = new GuzzleHttp\Client();
        $uri = $this->api_link . self::REQUEST_LIST_VIDEO . $this->_authStr() . $this->_addOptions();
        $request = $client->get($uri, array(), array (
            //'api_token' => str_replace('@', '', $_POST['firstname'])
        ));
        $response = $request->getBody();
        $return = array();

        $counter = 0;
        foreach (json_decode($response) as $value) 
            $array[] = $value;


        foreach ($array as $body) {
            $this->videos[$counter] = $body;
            $counter++;
        }
        return $this->videos;

    }
    


    public function __construct($array = null) {
        if (!is_array($array)) {
            return;
        }
        foreach ($array as $key => $val) {
            $this->$key = $val;
        }
    }

    public function _authStr() {
        return ( $this->method == self::METHOD_TOKEN ) ?
                '?api_token=' . $this->token :
                '?username=' . $this->username . '&password=' . $this->password;
    }
    public function _authStrUpload() {
        return '?api_token=' . $this->token ;
    }

    public function _addOptions() {
        foreach ($this->_options as $opt) {
            if (($this->$opt))
                $ret[$opt] = $this->$opt;
        }
        $ret = '&' . http_build_query($ret);
        return $ret;
    }

    public function _createRequest(\Httpful\Request $req) {
        return $req->send();
    }
    
    public static function Instance($array = null)
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new Base($array);
        }
        return $inst;
    }
}
