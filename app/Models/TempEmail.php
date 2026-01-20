<?php

namespace App\Models;

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
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
