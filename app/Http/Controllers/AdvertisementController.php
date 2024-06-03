<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdvertisementController extends Controller
{

    public function index()
    {
        return view('advertisements.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('advertisements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $advertisements = $request->validate([
            'title' => ['required', 'min:5', 'max:255'],
            'description' => ['required', 'min:15'],
            'image' => ['image']
        ]);

        Advertisement::create([
            'title' => $advertisements['title'],
            'description' => $advertisements['description'],
            'image' => $this->image($request),
            'author_id' => Auth::id()
        ]);

        return redirect()->route('home.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Advertisement $advertisement)
    {
        return view('advertisements.show', compact('advertisement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Advertisement $advertisement)
    {
        return view('advertisements.edit', compact('advertisement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Advertisement $advertisement)
    {
        $request->validate([
            'title' => ['required', 'min:5', 'max:255'],
            'description' => ['required', 'min:15'],
            'image' => ['image']
        ]);

        $advertisement->title = $request->input('title');
        $advertisement->description = $request->input('description');


        if ($request->hasFile('image')) {
            if ($advertisement->image !== 'noAd.jpg') {
                Storage::delete('public/img/advertisements/' . $advertisement->image);
            }

            $advertisement->image = $this->image($request);
        }

        $advertisement->save();

        return redirect()->route('home.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advertisement $advertisement)
    {
        $advertisement->delete();
        if ($advertisement->image !== 'noAd.jpg') {
            Storage::delete('public/img/advertisements/' . $advertisement->image);
        }
        return redirect()->route('home.index');
    }

    public function image(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image')->getClientOriginalName();
            $ext = $request->file('image')->getClientOriginalExtension();
            $image = pathinfo($file, PATHINFO_FILENAME) . '_' . time() . '.' . $ext;

            $request->file('image')->storeAs('public/img/advertisements', $image);
        } else {
            $image = 'noAd.jpg';
        }

        return $image;
    }
}
