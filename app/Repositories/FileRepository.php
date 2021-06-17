<?php

namespace App\Repositories;

use App\Models\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request as HttpRequest;

class FileRepository extends Repository
{
    /**
     *  Finds file by id
     *
     *  @param int $id
     *
     *  @return File|bool
     */
    public static function find(int $id)
    {
        return self::findIn(File::class, $id);
    }

    /**
     *  Persists file
     *
     *  @param HttpRequest $httpRequest
     *  @param string $path
     *
     *  @return File|bool
     */
    public static function insert(HttpRequest $httpRequest, string $path)
    {
        $file = new File;
        $file->office_id = Auth::user()->office_id;

        self::save($file, $httpRequest, $path);

        if ($file->save()) {
            return $file;
        }

        return false;
    }

    /**
     *  Updates file
     *
     *  @param File $file
     *  @param HttpRequest $httpRequest
     *
     *  @return bool
     */
    public static function update(File $file, HttpRequest $httpRequest, string $path)
    {
        self::save($file, $httpRequest, $path);

        return $file->save();
    }

    /**
     *  Downloads file
     *
     *  @param File $file
     *
     *  @return mixed
     */
    public static function download(File $file)
    {
        return Storage::download($file->path, $file->name);
    }

    /**
     *  Sets and persist file
     *
     *  @param File $file
     *  @param HttpRequest $httpRequest
     *  @param string $path
     *
     *  @return void
     */
    private static function save(File &$file, HttpRequest $httpRequest, string $path)
    {
        if ($httpRequest->hasFile('file')) {

            $oldPath = $file->path;

            $uploadedFile = $httpRequest->file('file');
            $extension = $uploadedFile->getClientOriginalExtension();
            $name = $uploadedFile->getClientOriginalName();
            self::setPath($path, $name);

            Storage::disk(config('system.file_storage'))->put(
                $path, file_get_contents($uploadedFile->getRealPath())
            );

            $file->name = $name;
            $file->extension = $extension;
            $file->path = $path;

            if ($oldPath) {
                Storage::disk(config('system.file_storage'))->delete($path);
            }

        }
    }

    /**
     *  Set file path
     *
     *  @param string $path
     *  @param string $name
     *
     *  @return void
     */
    private static function setPath(string &$path, string $name)
    {
        $path = str_replace('<office_id>', Auth::user()->office_id, $path);
        $path = str_replace('<file_name>', time()."_".$name, $path);
    }
}
