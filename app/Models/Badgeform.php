<?php

namespace App\Models;

use App\Models\User;
use App\Models\Tambahidentitum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pkt\StarterKit\Traits\InteractsWithMedia;
use Pkt\StarterKit\Traits\HasCreatedUpdatedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Badgeform extends Model 

{
    use HasFactory, HasUuids, SoftDeletes;
    use InteractsWithMedia;
   
    protected $table = 'tr_badgeforms';
    protected $primaryKey = 'tr_badgeform_id';
    protected $guarded = ['tr_badgeform_id', 'tr_badgeform_uuid'];

    
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // ...
    ];

    /**
     * Get the columns that should receive a unique identifier.
     *
     * @return array<int, string>
     */
    public function uniqueIds(): array
    {
        return ['tr_badgeform_uuid'];
    }

    public function identities()
    {
        return $this->hasMany(Tambahidentitum::class, 'tr_badgeform_id');
    }

    public function kompartemen()
    {
        return $this->belongsTo(Komparteman::class, 'ms_komparteman_id');
    }

    public function departemen()
    {
        return $this->belongsTo(Departeman::class, 'ms_departeman_id');
    }

}
