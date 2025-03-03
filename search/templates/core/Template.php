<?php

class Template {
    protected $path, $data;

    public function __construct($path, $data = array()) {
        $this->path = $path;
        $this->data = $data;
    }

    public function render() {
        if(file_exists($this->path)){
            extract($this->data);

            ob_start();

            include $this->path;
            $buffer = ob_get_contents();
            @ob_end_clean();

            return $buffer;
        } else {
            return "<div>Template not found</div>";
        }
    }       
}