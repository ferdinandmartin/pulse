<?php
/**
* Get base path for API
*
* @category   Pulse
* @package    Pulse
* @author     Ferdinand Martin
* @since      File available since Release 1.0.0
*/
function basePath(){
    $formatedRequest = explode('/',$_SERVER['REQUEST_URI']);
    $formatedRequestFR = '/'.$formatedRequest[1];
    return sprintf(
      "%s://%s%s",
      isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
      $_SERVER['SERVER_NAME'],
      $formatedRequestFR
    );
}

/**
* Return Views path for API
*
* @category   Pulse
* @package    Pulse
* @author     Ferdinand Martin
* @since      File available since Release 1.0.0
*/
function viewsPath(){
    return $_SESSION['templates.path'];
}

/**
* Set Active Path for class="active" in Bootstrap
*
* @category   Pulse
* @package    Pulse
* @author     Ferdinand Martin
* @since      File available since Release 1.0.0
*/
function pathActive($route = '/'){
    $_SESSION['menu.name'] = $route;
}

/**
* Get Active Path for class="active" in Bootstrap
*
* @category   Pulse
* @package    Pulse
* @author     Ferdinand Martin
* @since      File available since Release 1.0.0
*/
function isActive(){
    return $_SESSION['menu.name'];
}

/**
* Returns Path for Name
*
* @category   Pulse
* @package    Pulse
* @author     Ferdinand Martin
* @since      File available since Release 1.0.0
*/
function path($name = 'home'){
    return $_SESSION['path.name'][$name];
}

/**
* Returns Path for Name
*
* @category   Pulse
* @package    Pulse
* @author     Ferdinand Martin
* @since      File available since Release 1.0.0
*/
function setPathName($pathName, $pathRoute){
    $_SESSION['path.name'][$pathName] = $pathRoute;
}

/**
* SET Url
*
* @category   Pulse
* @package    Pulse
* @author     Ferdinand Martin
* @since      File available since Release 1.0.0
*/
function setUri($pathName, $pathRoute){
    $_SESSION['link.name'][$pathName] = $pathRoute;
}

/**
* Returns URL for Name
*
* @category   Pulse
* @package    Pulse
* @author     Ferdinand Martin
* @since      File available since Release 1.0.0
*/
function uri($name = 'home'){
    return $_SESSION['link.name'][$name];
}

/**
* Assets Generator
*
* @category   Pulse
* @package    Pulse
* @author     Ferdinand Martin
* @since      File available since Release 1.0.0
*/
function asset($resource){
    
    if(substr($resource, -3)=='css') $asset=basePath().'/'.viewsPath().'/css/'.$resource;
    if(substr($resource, -3)=='.js') $asset=basePath().'/'.viewsPath().'/js/'.$resource;
    if(substr($resource, -3)=='peg') $asset=basePath().'/'.viewsPath().'/images/'.$resource;
    if(substr($resource, -3)=='png') $asset=basePath().'/'.viewsPath().'/images/'.$resource;
    if(substr($resource, -3)=='gif') $asset=basePath().'/'.viewsPath().'/images/'.$resource;
    if(substr($resource, -3)=='jpg') $asset=basePath().'/'.viewsPath().'/images/'.$resource;
    if(substr($resource, -3)=='svg') $asset=basePath().'/'.viewsPath().'/images/'.$resource;
    
    if(substr($resource, 0, 4)=='jque') $asset=basePath().'/'.viewsPath().'/resources/'.$resource;
    if(substr($resource, 0, 4)=='boot') $asset=basePath().'/'.viewsPath().'/resources/'.$resource;
    if(substr($resource, 0, 4)=='font') $asset=basePath().'/'.viewsPath().'/resources/'.$resource;
    
    if(empty($asset)) $asset = basePath().'/'.viewsPath().'/resources/'.$resource;
        
    return $asset;
}

/**
* Get BASE URL
*
* @category   Pulse
* @package    Pulse
* @author     Ferdinand Martin
* @since      File available since Release 1.0.0
*/
function url(){
  $formatedRequest = explode('/',$_SERVER['REQUEST_URI']);
  $formatedRequestFR = '/'.$formatedRequest[1];
  return sprintf(
    "%s://%s%s",
    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
    $_SERVER['SERVER_NAME'],
    $formatedRequestFR
  );
}

/**
* Security REST API AUTH
*
* @category   Pulse
* @package    Pulse
* @author     Ferdinand Martin
* @since      File available since Release 1.0.0
*/
function isAuth(){
    $restSalt = $_SESSION['rest.vars']['rest.salt'];
    $restID = $_SESSION['rest.vars']['rest.id'];
    if(stristr(base64_decode($_SERVER["HTTP_AUTHORIZATION"]), $restSalt) and 
       stristr(base64_decode($_SERVER["HTTP_AUTHORIZATION"]), $restID) and 
       md5($_SERVER["HTTP_AUTHORIZATION"])==$_SESSION['rest.pk'])
    {
      return true;
    } else {
      return false;
    }
}

/**
* Security DATA PRINT for API AUTH
*
* @category   Pulse
* @package    Pulse
* @author     Ferdinand Martin
* @since      File available since Release 1.0.0
*/
function printAuth(){
    return json_encode(array('PubicKey' => $_SESSION['rest.pu']));
}

/**
* Security ERROR PRINT for API AUTH
*
* @category   Pulse
* @package    Pulse
* @author     Ferdinand Martin
* @since      File available since Release 1.0.0
*/
function errorAuth(){
    return json_encode(array('status'=>'error','code'=>'401','message' => 'Authorization Required.','exception' => 'Missing public-key authorization header.'));
}

// @URIs External URL definition
setUri('documentationUrl','http://doc.pulseframework.com');
setUri('communityUrl','http://doc.pulseframework.com');
setUri('tutosUrl','http://doc.pulseframework.com');
