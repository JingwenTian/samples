<?php 

function show_memory ( $byte ) {
	return $byte / (1024 * 1024) . "M\r\n";
}

function show_time( $time ) {
	return round($time, 4). "s\r\n";
}

