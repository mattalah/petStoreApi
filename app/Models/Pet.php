<?php

namespace App\Models;

use App\Enum\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'status',
        'category_id',
    ];

    protected $casts = [

        'status' => ['available', 'pending', 'sold']
    ];

    /**
     * Get the category that related to the pet.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the tags of the pet.
     */
    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class);
    }
}
