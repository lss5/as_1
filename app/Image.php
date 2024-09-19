<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image as ImageFacade;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $fillable = ['link'];

    // public function product()
    // {
    //     return $this->belongsTo('App\Product');
    // }

    public function users()
    {
        return $this->morphedByMany('App\User', 'imageable');
    }

    public function save(array $options = [])
    {
        $save = parent::save($options);

        // crop image
        // $imageFacade = ImageFacade::make(public_path('storage/'.$this->link))->fit(720, 600, function ($constraint) {
        //     $constraint->upsize();
        // });
        // $imageFacade->save();

        return $save;
    }

    public function delete()
    {
        if (Storage::disk('public')->exists($this->link)) {
            Storage::disk('public')->delete($this->link);
        }
        return parent::delete();
    }

}
