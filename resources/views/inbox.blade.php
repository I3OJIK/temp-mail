{{-- resources/views/inbox.blade.php --}}
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Почта: {{ $tempEmail->email }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Шапка с адресом почты -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 mb-2">
                        📭 {{ $tempEmail->email }}
                    </h1>
                    <div class="text-gray-600">
                        Создана: {{ $tempEmail->created_at->format('d.m.Y H:i') }} | 
                        Осталось: 
                        <span class="font-semibold {{ $tempEmail->days_left > 30 ? 'text-green-600' : ($tempEmail->days_left > 7 ? 'text-yellow-600' : 'text-red-600') }}">
                            {{ $tempEmail->days_left }} дней
                        </span>
                    </div>
                </div>
                <div class="mt-4 md:mt-0 flex flex-wrap gap-3">
                    <a href="{{ route('home') }}" 
                       class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg">
                        ← На главную
                    </a>
                    <button onclick="copyToClipboard('{{ $tempEmail->email }}')"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                        📋 Копировать адрес
                    </button>
                    <form action="{{ route('email.destroy', urlencode($tempEmail->email)) }}" 
                          method="POST" 
                          onsubmit="return confirm('Удалить почту {{ $tempEmail->email }}? Все письма будут удалены.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                            🗑️ Удалить почту
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Сообщение если почта создана только что -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    ✅ {{ session('success') }}
                    <p class="text-sm mt-1">Используйте этот адрес для регистрации на сайтах</p>
                </div>
            @endif
        </div>

        <!-- Письма -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b bg-gray-50">
                <h2 class="text-xl font-semibold">
                    📨 Письма 
                    <span class="text-gray-600">({{ $tempEmail->messages_count }})</span>
                </h2>
            </div>
            
            @if($tempEmail->messages_count > 0)
                <div class="divide-y">
                    @foreach($tempEmail->messages as $message)
                    <div class="p-6 hover:bg-gray-50">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex-grow">
                                <div class="font-semibold text-gray-800">
                                    От: {{ $message->from_email }}
                                </div>
                                <div class="text-gray-800 font-medium mt-2 text-lg">
                                    {{ $message->subject }}
                                </div>
                            </div>
                            <div class="text-gray-500 text-sm whitespace-nowrap ml-4">
                                {{ $message->received_at->format('d.m.Y H:i') }}
                            </div>
                        </div>
                        
                        <div class="mt-4 text-gray-700 bg-gray-50 p-4 rounded-lg whitespace-pre-wrap">
                            {{ $message->clean_content }}
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-gray-300 text-6xl mb-4">📭</div>
                    <p class="text-gray-600 text-lg">Писем пока нет</p>
                    <p class="text-gray-500 text-sm mt-2">
                        Используйте адрес ниже для регистрации на сайтах
                    </p>
                    <div class="mt-6">
                        <div class="bg-gray-100 p-3 rounded-lg inline-block">
                            <code class="font-mono">{{ $tempEmail->email }}</code>
                        </div>
                        <div class="mt-4">
                            <button onclick="copyToClipboard('{{ $tempEmail->email }}')"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                                📋 Скопировать адрес
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Инструкция -->
        <div class="mt-6 text-sm text-gray-600">
            <p>💡 <strong>Как использовать:</strong></p>
            <ol class="list-decimal pl-5 mt-2 space-y-1">
                <li>Скопируйте адрес почты выше</li>
                <li>Вставьте его при регистрации на любом сайте</li>
                <li>Подтверждающее письмо придет сюда</li>
                <li>Через 6 месяцев почта и все письма автоматически удалятся</li>
            </ol>
        </div>
    </div>

    <script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text)
            .then(() => alert('Адрес скопирован:\n' + text))
            .catch(err => alert('Не удалось скопировать'));
    }
    </script>
</body>
</html>