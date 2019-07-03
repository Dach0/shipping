<?php

namespace App\Http\Controllers;

use App\Expence;
use Illuminate\Http\Request;

class ExpenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Expence::orderBy('expence_name')->orderBy('expence_amount', 'desc')->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Expence::create($this->validate($request, ['expence_name' => 'required', 'expence_amount' => 'required' ]));
        return (['Porukica' => 'Uspješno sačuvan trošak']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Expence  $expence
     * @return \Illuminate\Http\Response
     */
    public function show(Expence $expence)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expence  $expence
     * @return \Illuminate\Http\Response
     */
    public function edit(Expence $expence)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expence  $expence
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Expence::findOrFail($id)->update($this->validate($request, ['expence_name' => 'required', 'expence_amount' => 'required' ]));
        return (['Porukica' => 'Uspješno izmijenjen trošak']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expence  $expence
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expence = Expence::findOrFail($id);
        $expence->delete();
        return ['msg' => 'Obrisano, ćao pa pa'];
    }
}
