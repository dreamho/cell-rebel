<?php namespace Ranking\Models;

use Illuminate\Database\Eloquent\Model;
use Ranking\User;

class SocialAccount extends Model
{
    protected $primaryKey = null;
    protected $fillable = ['user_id', 'provider_user_id', 'provider'];

    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
