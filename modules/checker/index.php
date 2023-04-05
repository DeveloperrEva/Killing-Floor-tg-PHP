<?php 

require_once 'simple_html_dom.php';

echo file_get_html('https://www.gametracker.com/components/html0/?host=185.97.254.214:7744')->plaintext;