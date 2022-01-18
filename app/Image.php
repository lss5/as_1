<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image as ImageFacade;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $fillable = ['link'];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function delete()
    {
        if (Storage::disk('public')->exists($this->link)) {
            Storage::disk('public')->delete($this->link);
        }
        return parent::delete();
    }

    public function storeImage()
    {
        // if (request()->has('delete_image')) {
        //     if (Storage::disk('public')->exists($this->image)) {
        //         Storage::disk('public')->delete($this->image);
        //     }
        //     $this->update([
        //         'image' => null,
        //     ]);
        // }
        // if (request()->hasFile('image')) {
        //     if (Storage::disk('public')->exists($this->image)) {
        //         Storage::disk('public')->delete($this->image);
        //     }
        //     $image = request()->file('image')->store('products', 'public');
        //     $this->update([
        //         'link' => $image,
        //         'link' => $image,
        //         'title' => $request
        //     ]);

        //     $image = ImageFacade::make(public_path('storage/'.$this->image))->fit(500, 500, function ($constraint) {
        //         $constraint->upsize();
        //     });
        //     $image->save();
        // }
    }
}
