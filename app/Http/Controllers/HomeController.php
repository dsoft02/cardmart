<?php

namespace App\Http\Controllers;

use App\Models\ExamType;
use App\Models\Faq;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        $examTypes = ExamType::where('is_active', true)->get();

        $faqs = Faq::where('is_active', true)->get();

        return view('home', compact('examTypes', 'faqs'));
    }
}
