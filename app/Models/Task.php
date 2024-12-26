<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category',
        'deadline',
        'completed',
        'notification_minutes', // Tambahkan kolom pengaturan notifikasi
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category', 'name');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

