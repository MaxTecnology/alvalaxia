<?php

class Lead {

    private $file_path;

    public function __construct($file_path) {
        $this->file_path = $file_path;
    }

    function save($name, $phone,$insta = "") {
        $linha = "$name,$phone,$insta\n";
        return file_put_contents($this->file_path, $linha, FILE_APPEND);
    }
}