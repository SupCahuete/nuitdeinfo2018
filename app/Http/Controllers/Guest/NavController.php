<?php

  namespace App\Http\Controllers\Guest;

  use App\Models\Symptom;
  use Illuminate\Http\Request;

  class NavController extends Controller
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
//      return 'Le sang de ses morts';
      return view('guest.nav.index');
    }
  }
