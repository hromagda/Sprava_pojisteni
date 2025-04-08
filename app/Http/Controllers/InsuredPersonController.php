<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InsuredPerson;
use App\Models\Insurance;
use Illuminate\Support\Facades\Redirect;
// use Illuminate\Support\Facades\Auth;
use App\Http\Requests\InsuredPerson\StoreRequest;
use App\Http\Requests\InsuredPerson\UpdateRequest;
use Carbon\Carbon;


class InsuredPersonController extends Controller
{
    /**
     * Zobrazí seznam pojištěnců.
     */
    public function index()
    {
        $insuredPersons = InsuredPerson::all(); // Získáme všechny pojištěnce
        return view('insuredPersons.index', compact('insuredPersons')); // Předáme data do pohledu
    }

    /**
     * Zobrazí formulář pro přidání nového pojištěnce.
     */
    public function create()
    {
        return view('insuredPersons.create'); // Prázdný formulář pro nového pojištěnce
    }

    /**
     * Uloží nového pojištěnce.
     */
    public function store(StoreRequest $request)
    {
        InsuredPerson::create($request->validated());

        return redirect()->route('insuredPersons.index')->with('success', 'Pojištěnec byl úspěšně přidán!');
    }

    /**
     * Zobrazí detail pojištěnce (údaje+tabulka pojištění).
     */
    public function show($id)
    {
        $insuredPerson = InsuredPerson::findOrFail($id);

        // Načteme pojištění spojené s pojištěncem
        $assignedInsurances = $insuredPerson->insurances()
            ->withPivot('amount', 'subject', 'valid_from', 'valid_to')
            ->get()
            ->map(function ($insurance) {
                $insurance->pivot->valid_from = \Carbon\Carbon::parse($insurance->pivot->valid_from);
                $insurance->pivot->valid_to = \Carbon\Carbon::parse($insurance->pivot->valid_to);
                return $insurance;
            });

        // Načteme všechny možné typy pojištění (pro výběr nebo přidávání)
        $insurances = \App\Models\Insurance::all();

        return view('insuredPersons.show', compact('insuredPerson', 'assignedInsurances', 'insurances'));
    }

    /**
     * Zobrazí formulář pro úpravu pojištěnce (předvyplněný formulář).
     */
    public function edit($id)
    {
        $insuredPerson = InsuredPerson::findOrFail($id); // Načteme pojištěnce pro úpravu
        return view('insuredPersons.edit', compact('insuredPerson')); // Předání do pohledu
    }

    /**
     * Uloží změny údajů pojištěnce.
     */
    public function update(UpdateRequest $request, $id)
    {
        $insuredPerson = InsuredPerson::findOrFail($id);
        $insuredPerson->update($request->validated());

        return redirect()->route('insuredPersons.show', $insuredPerson->id)->with('success', 'Pojištěnec byl úspěšně aktualizován!');
    }

    /**
     * Smaže pojištěnce.
     */
    public function destroy($id)
    {
        $insuredPerson = InsuredPerson::findOrFail($id);
        $insuredPerson->delete();

        return redirect()->route('insuredPersons.index')->with('success', 'Pojištěnec byl úspěšně smazán!');
    }
}
