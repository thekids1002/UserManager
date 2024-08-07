<?php

namespace App\Models;

use App\Traits\ObservantTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use ObservantTrait;
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $table = 'user';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'name',
        'group_id',
        'position_id',
        'started_date',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'started_date',
        'created_date',
        'updated_date',
        'deleted_date',
    ];

    protected $casts = [
        'started_date' => 'date',
        'created_date' => 'date',
        'updated_date' => 'date',
        'deleted_date' => 'date',
    ];

    public function group() {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function getPosition()
    {
        $positions = [
            0 => 'Director',
            1 => 'Group Leader',
            2 => 'Leader',
            3 => 'Member',
        ];
    
        return $positions[$this->position_id] ?? '';
    }
}
