<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Notifications\Notifiable;

class Company extends Model
{
use HasFactory, SoftDeletes, HasUuids, Notifiable;

   protected $fillable = [
        'name',
        'email',
        'logo',
        'website_link',
    ];
}
