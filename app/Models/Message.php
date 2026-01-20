<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int            $id             Уникальный идентификатор сообщения
 * @property int            $temp_email_id  Уникальный идентификатор email которому принадлежит сообщение
 * @property string         $from_email     Отправитель сообщения
 * @property string         $subject        Тема сообщения
 * @property string|null    $html_content   HTML сообщения
 * @property string|null    $text_content   Текст сообщения
 * @property Carbon         $received_at    Дата получения сообщения
 * @property Carbon|null    $created_at     Дата создания
 * @property Carbon|null    $updated_at     Дата обновления
 */
class Message extends Model
{
    protected $fillable = [
        'temp_email_id',
        'from_email',
        'subject',
        'html_content',
        'text_content',
        'received_at'
    ];

    protected $casts = [
        'received_at' => 'datetime'
    ];

    /**
     * К какой почте относится письмо
     */
    public function tempEmail(): BelongsTo
    {
        return $this->belongsTo(TempEmail::class);
    }
}
