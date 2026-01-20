<?php

namespace App\Services;

use App\Models\TempEmail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EmailGeneratorService
{
    protected string $domain = 'mailmail312.ru';

    // Слова для генерации имен
    protected array $adjectives = [
        'fast', 'quick', 'smart', 'clever', 'brave', 'happy',
        'cool', 'kind', 'lucky', 'proud', 'bold', 'wise',
        'calm', 'gentle', 'honest', 'loyal', 'noble', 'polite',
        'quiet', 'radiant', 'sincere', 'talented', 'unique', 'vibrant',
        'witty', 'young', 'zealous', 'active', 'bright', 'charming',
        'daring', 'eager', 'fierce', 'graceful', 'humble', 'jolly',
        'keen', 'merry', 'neat', 'optimistic', 'playful'
    ];
    
    protected array $nouns = [
        'fox', 'wolf', 'bear', 'lion', 'tiger', 'eagle',
        'hawk', 'owl', 'deer', 'panda', 'koala', 'seal',
        'raven', 'falcon', 'shark', 'dolphin', 'whale', 'octopus',
        'jaguar', 'leopard', 'cheetah', 'lynx', 'bobcat', 'coyote',
        'phoenix', 'griffin', 'dragon', 'unicorn', 'pegasus', 'sphinx',
        'panther', 'rhino', 'hippo', 'zebra', 'giraffe', 'elephant',
        'kangaroo', 'wallaby', 'platypus', 'wombat', 'lemur'
    ];

    /**
     * Создать новую временную почту
     * 
     * @return TempEmail
     */
    public function create(): TempEmail
    {
        $username = $this->generateUniqueUsername();
        $email = $username . '@' . $this->domain;

        // Создаем запись в базе
        return TempEmail::create([
            'email' => $email,
            'username' => $username,
            'expires_at' => Carbon::now()->addMonths(6) // 6 месяцев жизни
        ]);
    }

    /**
     * Сгенерировать уникальное имя пользователя
     * 
     * @return string
     */
    private function generateUniqueUsername(): string
    {
        do {
            $username = $this->generateUsername();
        } while ($this->usernameExists($username));

        return $username;
    }

    /**
     * Сгенерировать случайное имя
     * 
     * @return string
     */
    private function generateUsername(): string
    {
        $adjective = $this->adjectives[array_rand($this->adjectives)];
        $noun = $this->nouns[array_rand($this->nouns)];
        $numbers = rand(1000, 9999); // 4 случайные цифры
        $shortUuid = substr(str_replace('-', '', Str::uuid()), 0, 8); // 8 символов uuid

        return $adjective . $noun . $numbers . $shortUuid;
    }

    /**
     * Проверка на уникальность имени
     * 
     * @param string $username
     * 
     * @return bool
     */
    private function usernameExists(string $username): bool
    {
        $email = $username . '@' . $this->domain;
        return TempEmail::where('email', $email)->exists();
    }
}