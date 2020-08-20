<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 'description', 'category_parent_id', 'featured_image', 'icon', 'slug'
    ];




}
