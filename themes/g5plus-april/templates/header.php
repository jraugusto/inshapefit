<?php
/**
 * The template for displaying header
 */
$header_enable = g5Theme()->options()->get_header_enable();
if ($header_enable !== 'on') return;
g5Theme()->helper()->getTemplate('header/desktop');
g5Theme()->helper()->getTemplate('header/mobile');


