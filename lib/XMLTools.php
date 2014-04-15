<?php
  /**
  *
  * This class requires a valid XMLURL
  *
  */
  class XMLTools {

    public function __construct($config = array()){
      $this->config = array_merge($this->config, $config);
    }


    /**
    * Validate Config
    * Get Data Sources
    * Setup
    *
    * @return boolean $allgood
    */
    public function init() {
     if(empty($this->config['XMLURL'])){
        echo "<div class='alert alert-danger'> no xml url provided!</div>";
        return false;
      }
      $this->retrievePosts();
     return true;
    }


    public $config = array(
      'XMLURL' => null
    );


    public $data = array(
      'post' => null
    );


    /**
    *
    *
    * @return
    */
    public function retrievePosts() {
      $post = $this->retrieveXML($this->config['XMLURL']);
      $this->data['post'] = $post;
     debugSrc($this->data['post']);
    }





    /**
    * Cleans up a flattened array
    * replaces '@', and 'post/' with ''
    * replaces 'merchandise/' with 'merch/'
    * @param array
    * @return array
    */
    public function removeAts($array = array()) {
      foreach (array_keys($array) as $key) {
          $newKey = str_replace('@', '', $key);
          $array[$newKey] = $array[$key];
          unset($array[$key]);
      }
      return $array;
    }



    /**
    * Go get XML, parse it, return nested array
    *
    * @param string $url
    * @return array $postDataArray
    */
    public function retrieveXML($url) {
      //$page = $this->curlURL($url);
      $obj = simplexml_load_file($url);
      $objArray = $this->toArray($obj);
       debugSrc($objArray);
     return $objArray;

    }


    /**
   * Returns this XML structure as a array.
   *
   * @param SimpleXMLElement|DOMDocument|DOMNode $obj SimpleXMLElement, DOMDocument or DOMNode instance
   * @return array Array representation of the XML structure.
   * @throws XmlException
   */
    public static function toArray($obj) {
      if ($obj instanceof DOMNode) {
        $obj = simplexml_import_dom($obj);
      }
      if (!($obj instanceof SimpleXMLElement)) {
        throw new XmlException(__d('cake_dev', 'The input is not instance of SimpleXMLElement, DOMDocument or DOMNode.'));
      }
      $result = array();
      $namespaces = array_merge(array('' => ''), $obj->getNamespaces(true));
      self::_toArray($obj, $result, '', array_keys($namespaces));

      return self::makeNonNested($result);
    }


   /**
   * Recursive method to toArray
   *
   * @param SimpleXMLElement $xml SimpleXMLElement object
   * @param array $parentData Parent array with data
   * @param string $ns Namespace of current child
   * @param array $namespaces List of namespaces in XML
   * @return void
   */
    protected static function _toArray($xml, &$parentData, $ns, $namespaces) {
      $data = array();

      foreach ($namespaces as $namespace) {
        foreach ($xml->attributes($namespace, true) as $key => $value) {
          if (!empty($namespace)) {
            $key = $namespace . ':' . $key;
          }
          $data['@' . $key] = (string)$value;
        }
        foreach ($xml->children($namespace, true) as $child) {
          self::_toArray($child, $data, $namespace, $namespaces);
        }
      }
      $asString = trim((string)$xml);
      if (empty($data)) {
        $data = $asString;
      } elseif (strlen($asString) > 0) {
        $data['@'] = $asString;
      }
      if (!empty($ns)) {
        $ns .= ':';
      }
      $name = $ns . $xml->getName();
      if (isset($parentData[$name])) {
        if (!is_array($parentData[$name]) || !isset($parentData[$name][0])) {
          $parentData[$name] = array($parentData[$name]);
        }
        $parentData[$name][] = $data;
      } else {
        $parentData[$name] = $data;
      }
    }


    /**
    * Recursive method to flatten an array to paths/paths/paths
    *
    * @return $array
    */
    public function makeNonNestedRecursive(array &$out, $key, array $in){
        foreach($in as $k=>$v){
          if(is_array($v)){
              self::makeNonNestedRecursive($out, $key . $k . '/', $v);
          }else{
                $out[$key . $k] = $v;
          }
        }
    }
    public function makeNonNested(array $in){
        $out = array();
         self::makeNonNestedRecursive($out, '', $in);

        return $out;
    }



    /**
    * Find anything about a post from the API XML
    *
    * @return string of what you wanted to know about a post, or empty string
    */
    public function post($whatYouWant, $onFail = "") {
      $whatYouWant = 'rss/channel/item/'.$whatYouWant;
      $whatYouWantStripped = str_replace(' ', '', $whatYouWant);
      foreach (array_keys($this->data) as $post) {
        if (!empty($this->data[$post][$whatYouWant])) {
           return $this->data[$post][$whatYouWant];
        }
        if (!empty($this->data[$post][$whatYouWantStripped])) {
          return $this->data[$post][$whatYouWantStripped];
        }
      }
      if ($onFail) {
        return  $onFail;
      }
      return;
    }





    /**
    *title - string
    *link - url
    *comments -url
    *description html a href
    *@return string $optionTags HTML set of <option> tags
    */
   public function fillPosts(){
      $html = "";
      for ($i = 0; $i < 18; $i++) {
          $title = $this->post("$i/title", false);
          if (empty($title)) {
            echo" empty title ";// tried to get more than actually exist... return what we've got
            return $html;
          }
            $link = $this->post("$i/link");
            $title = $this->post("$i/title");
            $category = "demo"; //guessCategory($title);
            $description = $this->post("$i/description");
            $comments = $this->post("$i/comments");
          $html .= sprintf(
            '<div class="post" data-category="%s">'
            .'<section class="title row"><a href="%s"><h1 class="postTitle">%s</h1></a></section>'
            .'<section class="info row"><a class="comments" href="%s">Comments</a></section>'
            .'</div>',


            $category,
            $link,
            $title,
            $comments
          );
      }
      return $html;
    }


  }//end class


?>