<?php

$section = $this->menuSection('XKCD');
$section->setIcon('img/openclipart/scissors.png');

$section->add('Show Random')
        ->setIcon('img/xkcd/shuffle.png')
        ->setUrl('xkcd/show/random');
