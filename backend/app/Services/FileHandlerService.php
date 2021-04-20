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
     * @param UploadedFile $file
     * @param string $path
     * @return string
     * @throws UnableToSaveFile
     */
    public function upload(UploadedFile $file, string $path): string
    {
        $hashName = $file->hashName();
        if( ! $file->store($path) ) {
            throw new UnableToSaveFile;
        }
        return $hashName;
    }

    public function destroy()
    {

    }
}
