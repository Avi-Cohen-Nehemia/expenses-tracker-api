<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\TransactionFactory;

class Transaction extends Model
{
    protected $fillable = ["amount", "category", "type", "user_id"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function newFactory()
    {
        return TransactionFactory::new();
    }
}
