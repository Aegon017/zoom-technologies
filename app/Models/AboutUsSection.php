<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUsSection extends Model
{
    protected $fillable = ['image', 'image_alt', 'video_url', 'title', 'heading', 'content'];
}
