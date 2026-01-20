<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int            $id             Уникальный идентификатор email
 * @property string         $email          Уникальный email
 * @property string         $username       Имя почты (часть до @)
 * @property Carbon    $expires_at     Дата истечения срока жизни email
 * @property Carbon|null    $created_at     Дата создания
 * @property Carbon|null    $updated_at     Дата обновления
 */
class TempEmail extends Model
{
    protected $fillable = [
        'email',
        'username',
        'expires_at'
    ];

    /**
     * Письма этой почты
     * 
     * @return HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Сколько дней осталось до удаления (новый метод)
     * 
     * @return int
     */
    public function getDaysLeftAttribute(): int
    {
        return Carbon::now()->diffInDays($this->expires_at, false);
    }
}
