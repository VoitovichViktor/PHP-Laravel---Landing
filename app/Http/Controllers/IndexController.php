<?php

namespace App\Http\Controllers;

use App\Mail\QuestionMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Page;
use App\People;
use App\Portfolio;
use App\Service;
use Illuminate\Support\Facades\Mail;

class IndexController extends Controller
{
    public function execute (Request $request) {

        if($request->isMethod('POST')) {

            $this->validate($request, [
                'name' => 'required|max:255',
                'email' => 'required|email',
                'text' => 'required',
            ]);

            $data = $request->all();
            $result = Mail::to('bloknot.a6@gmail.com')->send(new QuestionMail($data['name'], $data['email'], $data['text']));

            if($result) {
                return redirect()->route('home')->with('status', 'Email is send');
            }
        }


        $pages = Page::all(); // get all
        $portfolios = Portfolio::get(['name', 'filter', 'images']); // get column
        $services = Service::where('id', '<', 20)->get(); //get row where id < 20
        $peoples = People::take(3)->get();

        $tags = DB::table('portfolios')->distinct()->pluck('filter');

        $menu = [];

        foreach($pages as $page) {
            $item = ['title' => $page->name, 'alias' => $page->alias];
            $menu[] = $item;
        }

        $item = ['title' => 'Services', 'alias' => 'service'];
        array_push($menu, $item);
        $item = ['title' => 'Portfolio', 'alias' => 'Portfolio'];
        array_push($menu, $item);
        $item = ['title' => 'Team', 'alias' => 'team'];
        array_push($menu, $item);
        $item = ['title' => 'Contact', 'alias' => 'contact'];
        array_push($menu, $item);

        return view('site.index', [
            'menu' => $menu,
            'pages' => $pages,
            'services' => $services,
            'portfolios' => $portfolios,
            'peoples' => $peoples,
            'tags' => $tags,
        ]);
    }
}
