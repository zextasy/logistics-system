<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{

    public function submit(Request $request)
    {
        Notification::make()
            ->title('Success!')
            ->success()
            ->send();
        return redirect(route('home'));
    }


}
