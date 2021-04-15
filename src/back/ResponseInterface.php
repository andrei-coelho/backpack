<?php

namespace Back;

interface ResponseInterface {

    public function headers();
    public function send();

}