<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dispute extends Model
{
    protected $fillable = [
        'user_id','transaction_id','subject',
        'dispute','dispute_solved'
     ];

    public function transaction()
    {
        return $this->belongsTo('App\Transaction');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
