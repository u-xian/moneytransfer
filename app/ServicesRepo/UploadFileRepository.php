<?php
namespace App\ServicesRepo;

use App\ServicesRepo\Contracts\UploadFileRepositoryInterface;
use Illuminate\Container\Container as App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Customers;
use Carbon\Carbon;
use App\Customerfile;
use Response;

class UploadFileRepository implements UploadFileRepositoryInterface
{
	protected $upfile;

	public function __construct(App $upfile)
	{
	    $this->upfile = $upfile;
	}
    
    /**
     * List Uploaded files
     *
     * @return array
     */
	public function listFiles()
    {
        return ['files' => Customerfile::all()];
    }

    /**
     * Upload new File
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload($filename,$customerid)
    {
        $path = $filename->store('public');
        $file = [
            'name' => 'storage/'. str_replace('public/', '', $path),
            'type' => $filename->extension(),
            'size' => $filename->getClientSize(),
            'customer_id' => $customerid
        ];

        $fileresults = Customerfile::create($file);

        if($fileresults['id'] > 0) 
        {
        	$mess = ['status' => True,"message" =>"File uploaded successfully"];
        }
        else
        {
           $mess = ['status' => False,"message" =>"File failed to be uploaded"];
        }
       
        return $mess;
    }

    /**
     * Delete existing file from the server
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete()
    {
        
    }

}

?>