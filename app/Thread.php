<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cmgmyr\Messenger\Models\Thread as ParentThread;

class Thread extends ParentThread
{
    protected $fillable = ['subject', 'parent_id', 'type'];

    public static $types = [
        'person' => 'Person', // User to User (parent_id empty)
        'product' => 'Product', // User to User seller (parent_id = Product)
        'support' => 'Support', // User to Support (parent_id = Product or Empty, participant = Admin)
        'plaint' => 'Plaint', // User to Support (parent_id = Product or Empty, participant = Admin)
    ];

    public function product()
    {
        return $this->belongsTo('App\Product', 'parent_id');
    }

    public function messages()
    {
        return parent::messages()->orderBy('created_at', 'desc');
    }

}
