<?php
// app/ServicesRepo/Contracts/UploadFileRepositoryInterface.php

namespace App\ServicesRepo\Contracts;

interface UploadFileRepositoryInterface
{
	public function listFiles();

    public function upload($filename,$customerid);

    public function delete();

}

?>