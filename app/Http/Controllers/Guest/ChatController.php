<?php

namespace App\Http\Controllers\Guest;

use Illuminate\Http\Request;

class ChatController extends Controller
{
  /**
   * Constructor.
   *
   * @return void
   */
  public function __construct()
  {
    //
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('guest.chat.index');
  }

  /**
   * Display the specified resource.
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function go(Request $request)
  {
    $locale='fr_FR.UTF-8';
    setlocale(LC_ALL,$locale);
    putenv('LC_ALL='.$locale);



    if ($text = $request->text) {
      $prefix = str_contains($text, '_') ? '' : 'recherchez_';
      $text = str_replace(' ', '_', $text);

      $output = shell_exec(
        "php -r \"echo shell_exec('python3 /media/psf/Home/www/info/storage/app/chat/chatbot.py -d {$prefix}{$text}');\" 2>&1"
      );
    }
    else {
      $output = "<p>Eh ! Je sais lire...</p>";
    }

    return response($output);
  }
}
