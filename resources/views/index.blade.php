{{-- resources/views/index.blade.php --}}
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Временная почта</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Заголовок -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">
                📧 Временная почта
            </h1>
            <p class="text-gray-600">Создайте временный email для регистрации на сайтах</p>
        </div>

        <!-- Сообщения -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                ✅ {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                ❌ {{ session('error') }}
            </div>
        @endif

        <!-- Создание новой почты -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Создать новую почту</h2>
            
                <a href="{{ route('email.create') }}" 
                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg">
                    🎲 Создать случайную почту
                </a>
        </div>

        <!-- Поиск старой почты -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Открыть старую почту</h2>
            
            <form action="{{ route('email.find') }}" method="POST">
                @csrf
                <div class="flex">
                    <input type="text" 
                           name="email"
                           value="{{ old('email') }}"
                           placeholder="fastfox1234@mailmail312.ru"
                           required
                           class="flex-grow border border-gray-300 rounded-l-lg p-3">
                    <button type="submit" 
                            class="bg-green-500 hover:bg-green-600 text-white font-bold px-6 rounded-r-lg">
                        🔍 Открыть
                    </button>
                </div>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </form>
        </div>

        <!-- Последние почты -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Недавно созданные</h2>
            
            @if($recentEmails->count() > 0)
                <div class="space-y-3">
                    @foreach($recentEmails as $email)
                        <a href="{{ route('email.show', urlencode($email->email)) }}"
                           class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                            <div class="flex justify-between items-center">
                                <div>
                                    <div class="font-mono font-semibold">{{ $email->email }}</div>
                                    <div class="text-sm text-gray-600 mt-1">
                                        {{ $email->created_at->format('d.m.Y') }} | 
                                        Писем: {{ $email->messages_count }}
                                    </div>
                                </div>
                                <div class="text-sm {{ $email->days_left > 30 ? 'text-green-600' : 'text-yellow-600' }}">
                                    {{ $email->days_left }} д.
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600 text-center py-4">Еще нет созданных почт</p>
            @endif
        </div>
    </div>
</body>
</html>