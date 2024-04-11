<?php
if(!defined($config['define'])) { die; }
$title['default'] = 'Historial de '.($_GET['tab'] == 'posts' || !$_GET['tab'] ? 'posts' : 'fotos');