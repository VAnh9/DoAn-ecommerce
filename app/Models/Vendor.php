<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    public function user() {
      return $this->belongsTo(User::class);
    }

    public function productReviews() {
      return $this->hasMany(ProductReview::class);
    }

    public function products() {
      return $this->hasMany(Product::class);
    }
}
