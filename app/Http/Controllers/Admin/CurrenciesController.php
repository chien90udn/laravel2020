<?php

namespace App\Http\Controllers\Admin;

use App\Models\Currency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CurrenciesRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class CurrenciesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function __construct()
    {
        parent::__construct();
        // $this->middleware('auth');

    }
    public function index(): View
    {
        return view('admin.currencies.index', [
            'currencies' => Currency::latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request): View
    {
        return view('admin.currencies.create');
    }

     /**
     * Store a newly created resource in storage.
     */
    public function store(CurrenciesRequest $request): RedirectResponse
    {
        Currency::create([
            'name'      => $request->name,
            'long_name'     => $request->long_name,
            'status'    => $request->status,
        ]);
        return redirect()->route('admin.currencies.index')->withSuccess(__('admin.currencies.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  obj  $currencie
     * @return \Illuminate\Http\Response
     */
    public function show(Currency $currency): View
    {
        return view('admin.currencies.show', [
            'currency' => $currency
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  obj  $currencie
     * @return \Illuminate\Http\Response
     */
    public function edit(Currency $currency): View
    {
        return view('admin.currencies.edit', [
            'currency' => $currency
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  obj  $currencie
     * @return \Illuminate\Http\Response
     */
    public function update(CurrenciesRequest $request, Currency $currency): RedirectResponse
    {
//        if ($request->filled('password')) {
//            $request->merge([
//                'password' => Hash::make($request->input('password'))
//            ]);
//        }
//        $currency->update(array_filter($request->only(['name', 'email', 'password', 'status'])));
        $currency->update(['name'=>$request->name, 'long_name'=>$request->long_name, 'status'=>$request->status]);
        return redirect()->route('admin.currencies.edit', $currency)->withSuccess(__('admin.currencies.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  obj  $currencie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Currency $currency)
    {
        $currency->delete();
        return redirect()->route('admin.currency.index')->withSuccess(__('admin.currencies.deleted'));
    }
}
