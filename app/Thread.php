<?php

namespace App;

use Cmgmyr\Messenger\Models\Thread as ParentThread;

class Thread extends ParentThread
{
    protected $fillable = ['subject', 'parent_id', 'type'];

    // public static $types = [
    //     'support' => 'Support',
    // ];

    public function listing()
    {
        return $this->belongsTo('App\Listing', 'parent_id');
    }

    public function messages()
    {
        return parent::messages()->orderBy('created_at', 'desc');
    }

}
