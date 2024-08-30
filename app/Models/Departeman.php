<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pkt\StarterKit\Traits\HasCreatedUpdatedBy;

class Departeman extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $table = 'ms_departemen';
    protected $primaryKey = 'ms_departeman_id';
    protected $guarded = ['ms_departeman_id', 'ms_departeman_uuid'];
    
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
        return ['ms_departeman_uuid'];
    }

    public function komparteman(){
        return $this->belongsTo(Komparteman::class);
    }
}
