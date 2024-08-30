<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pkt\StarterKit\Traits\HasCreatedUpdatedBy;

class Komparteman extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $table = 'ms_kompartemen';
    protected $primaryKey = 'ms_komparteman_id';
    protected $guarded = ['ms_komparteman_id', 'ms_komparteman_uuid'];
    
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
        return ['ms_komparteman_uuid'];
    }

    public function departeman(){
        return $this->hasMany(Departeman::class);
    }
}
