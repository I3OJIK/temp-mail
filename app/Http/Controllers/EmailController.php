<?php

namespace App\Http\Controllers;

use App\Services\EmailGenerator;
use App\Models\TempEmail;
use App\Services\EmailGeneratorService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class EmailController extends Controller
{
    public function __construct(
        private EmailGeneratorService $emailGenerator,
    ) 
    {}

    /**
     * Главная страница
     */
    public function index(): View
    {
        $recentEmails = TempEmail::latest()->limit(10)->get();
        return view('index', compact('recentEmails'));
    }

    /**
     * Создать новую почту и перейти в ее инбокс
     */
    public function create()
    {
        try {
            $tempEmail = $this->emailGenerator->create();

            Log::info('Создана новая почта', ['email' => $tempEmail->email]);

            return redirect()->route('email.show', urlencode($tempEmail->email))
                ->with('success', 'Новая почта создана!');

        } catch (\Exception $e) {
            Log::error('Ошибка создания почты', ['error' => $e->getMessage()]);

            return redirect()->route('home')->with('error', 'Ошибка создания почты');
        }
    }

     /**
     * Найти почту и перейти в ее инбокс
     */
    public function find(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        
        $tempEmail = TempEmail::where('email', $request->input('email'))->first();
        
        if (!$tempEmail) {
            return redirect()->route('home')
                ->with('error', "Почта не найдена: {$request->input('email')}")
                ->withInput();
        }
        
        // Переходим на страницу этой почты
        return redirect()->route('email.show', urlencode($tempEmail->email));
    }

    /**
     * Страница инбокса почты (здесь отслеживаем письма)
     */
    public function show($emailAddress)
    {
        $decodedEmail = urldecode($emailAddress);

        $tempEmail = TempEmail::where('email', $decodedEmail)
            ->with(['messages' => function($query) {
                $query->latest('received_at');
            }])
            ->first();
            
        if (!$tempEmail) {
            return redirect()->route('home')
                ->with('error', "Почта не найдена: {$decodedEmail}");
        }
        
        return view('inbox', compact('tempEmail'));
    }

     /**
     * Удалить почту
     */
    public function destroy($emailAddress)
    {
        $decodedEmail = urldecode($emailAddress);
        
        $tempEmail = TempEmail::where('email', $decodedEmail)->first();
        
        if (!$tempEmail) {
            return redirect()->route('home')->with('error', 'Почта не найдена');
        }
        
        $email = $tempEmail->email;
        $tempEmail->delete();
        
        Log::info('Почта удалена', ['email' => $email]);
        
        return redirect()->route('home')->with('success', "Почта удалена: {$email}");
    }
}