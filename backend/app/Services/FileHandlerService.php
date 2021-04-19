<?php


namespace App\Services;


use App\Exceptions\UnableToSaveFile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileHandlerService
{
    /**
     * @var Storage
     */
    private $storage;

    /**
     * FileHandlerService constructor.
     * @param Storage $storage
     */

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * this method uploads a file and returns the hashName
     * @param UploadedFile $file
     * @param string $disk
     * @return string
     * @throws UnableToSaveFile
     */
    public function upload(UploadedFile $file, string $disk = "public"): string
    {
        $hashName = $file->hashName();
        if( ! $file->storeAs("/",$hashName,$disk) ) {
            throw new UnableToSaveFile;
        }
        return $hashName;
    }

    public function destroy()
    {

    }
}
