<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Checkout;

class Camp extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'price'
    ];

    public function getIsRegisteredAttribute() {
        if(!Auth::check()) {
            return false;
        }

        return Checkout::where('camp_id', $this->id)->where('user_id', Auth::id())->exists();
    }
}
