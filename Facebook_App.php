<?php
  // By Jatin :)
  class Facebook_App {
	  protected $app = ""; 
	  protected $appkey = "";
	  protected $state;
	  protected $xCurrentURL = "https://www.facebook.com/connect/login_success.html";
	  protected $sessionID;
	  protected static $keys = array('state', 'code', 'access_token', 'user_id');
	  public static $DOMAIN_MAP = array(
                   'api'         => 'https://api.facebook.com/',
                   'api_video'   => 'https://api-video.facebook.com/',
                   'api_read'    => 'https://api-read.facebook.com/',
                   'graph'       => 'https://graph.facebook.com/',
                   'graph_video' => 'https://graph-video.facebook.com/',
                   'www'         => 'https://www.facebook.com/',);
	  const VERSION = '3.2.3';
	  protected function xToken() {
         if($this->state === null) {
			 $this->state = md5(uniqid(mt_rand(), true));
			 $this->setData('state', $this->state);
         }
	  }
	  public function xLogin($params=array()) {
		  $this->xToken();
         $currentUrl = $this->xCurrentURL;
         $scopeParams = isset($params['scope']) ? $params['scope'] : null;
		        if($scopeParams && is_array($scopeParams)){
                  $params['scope'] = implode(',', $scopeParams);
               } return $this->getUrl('www','dialog/oauth',array_merge(array(
          'client_id' => $this->app,
          'redirect_uri' => $this->xCurrentURL, // possibly overwritten
          'state' => $this->state,
          'sdk' => 'php-sdk-'.self::VERSION),
        $params));
      }
	  protected function setData($key, $value) {
             if(!in_array($key, self::$keys)) {
                return;
             } $session_var_name = $this->SessionVar($key);
			    $_SESSION[$session_var_name] = $value;
      }
	  protected function SessionVar($key) {
               $parts = array('fb', $this->app, $key);
                          if ($this->sessionID) {
                          array_unshift($parts, $this->sessionID);
               } return implode('_', $parts);
	  }
	  protected function getUrl($name, $path='', $params=array()) {
               $url = self::$DOMAIN_MAP[$name];
               if ($path) {
                  if($path[0] === '/') {
                     $path = substr($path, 1);
                  } $url .= $path; }
                  if ($params) {
                  $url .= '?' . http_build_query($params, null, '&');
                  } return $url;
     }
}
?>
