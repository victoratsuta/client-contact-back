<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientContacts extends Model
{
    use SoftDeletes;

    protected $fillable = ['address', 'post_code', 'client_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {

        return $this->belongsTo(Client::class);

    }
}
