<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Files extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'file_name', 'file_path', 'file_size', 'file_mime','file_extension', 'status',
    ];


    public static function deleteImage($value){

        $existing_logo_file_obj = Files::find($value);
        if(!empty($existing_logo_file_obj)){
            // delete the file from folder
            @unlink(asset('/storage'.$existing_logo_file_obj->file_path));
            Storage::delete($existing_logo_file_obj->file_path);
            // delete the row from database
            $existing_logo_file_obj->delete();
        }
        return true;
    }

    public static function getImagePath($id){
        $files = Files::find($id);
        if(!empty($files)){
            $path = asset('/storage'.$files->file_path);

            return $path;
        }

        return "";
    }
}
