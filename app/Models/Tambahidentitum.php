<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pkt\StarterKit\Traits\HasCreatedUpdatedBy;
use Pkt\StarterKit\Traits\InteractsWithMedia;




class Tambahidentitum extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    use InteractsWithMedia;

    protected $table = 'tr_tambahidentitas';
    protected $primaryKey = 'tr_tambahidentitum_id';
    protected $guarded = ['tr_tambahidentitum_id', 'tr_tambahidentitum_uuid'];
    
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
        return ['tr_tambahidentitum_uuid'];
    }
     public function badge()
     {
        return $this->belongsTo(Badgeform::class, 'tr_badgeform_id');
    }
}
