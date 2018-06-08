<?php
class Markup {
    private $url;
    private $layout;

    public function __construct($_url, $_layout){
        $this->url = $_url;
        $this->layout = $_layout;
    }

    public function get_layout() {
        print includeTemplate($this->url, $this->layout);
    }
}
