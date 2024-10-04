<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image as ImageFacade;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $guarded = [];

    public function imageable()
    {
        return $this->morphTo();
    }

    public function delete()
    {
        if (Storage::disk('public')->exists($this->link)) {
            Storage::disk('public')->delete($this->link);
        }
        return parent::delete();
    }

}
