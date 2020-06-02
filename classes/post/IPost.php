<?php

interface IPost {
	public function getPID() : int;
	public function getCreatorUID() : int;
	public function getContent() : string;
	public function getCreatedAt() : string;
}

?>
