<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'content',
        'read',
    ];

    protected $casts = [
        'content' => 'array',
        'read' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Create a notification for a user.
     *
     * @param int $userId
     * @param string $type
     * @param array $content
     * @return Notification
     */
    public static function createNotification($userId, $type, $content)
    {
        return self::create([
            'user_id' => $userId,
            'type' => $type,
            'content' => $content,
            'read' => false,
        ]);
    }
}
