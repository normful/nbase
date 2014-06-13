<?php

if ( $_POST['payload'] ) {
  shell_exec( 'cd /home/project/cpsc304 && git pull');
}

?>Github post receive page
