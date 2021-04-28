<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use HasFactory,NodeTrait;

    protected $fillable = [
        "name",
        "parent_id"
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        '_lft',
        '_rgt'
    ];
    
    /**
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class,'category_product');
    }
}
