<?php

namespace App\Models;

use App\Observers\GroupObserver;
use App\Traits\ObservantTrait;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Group extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'group';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'note',
        'group_leader_id',
        'group_floor_number',
        'deleted_date',
    ];


    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'created_date',
        'updated_date',
        'deleted_date',
    ];

    protected $casts = [
        'created_date' => 'date',
        'updated_date' => 'date',
        'deleted_date' => 'date',
    ];

    public function leader()
    {
        return $this->belongsTo(User::class, 'group_leader_id');
    }
}
