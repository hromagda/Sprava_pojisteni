<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Insurance;
use App\Models\InsuredPerson;
use App\Http\Requests\Insurance\StoreInsuranceRequest;
use App\Http\Requests\Insurance\UpdateInsuranceRequest;
use Carbon\Carbon;

class InsuranceController extends Controller
{

    public function index(Request $request)
    {
        $filter = $request->query('filter', 'all');
        $now = Carbon::now();

        $query = Insurance::with(['insuredPersons' => function ($query) use ($filter, $now) {
            switch ($filter) {
                case 'valid':
                    $query->wherePivot('valid_from', '<=', $now)
                        ->wherePivot('valid_to', '>=', $now)
                        ->wherePivot('status', 'active');  // Aktivní pojištění
                    break;
                case 'expired':
                    $query->wherePivot('valid_to', '<', $now)
                        ->wherePivot('status', 'active');  // Aktivní pojištění
                    break;
                case 'upcoming':
                    $query->wherePivot('valid_from', '>', $now)
                        ->wherePivot('status', 'active');  // Aktivní pojištění
                    break;
                case 'expiring_soon':
                    $query->wherePivot('valid_to', '>=', $now)
                        ->wherePivot('valid_to', '<=', $now->copy()->addDays(7))
                        ->wherePivot('status', 'active');  // Aktivní pojištění
                    break;
                case 'archived':
                    $query->wherePivot('status', 'archived');  // Archivovaná pojištění
                    break;
                default:
                    $query->wherePivot('status', '!=', 'archived');  // Výchozí chování – archivovaná se nezobrazují
                    break;
            }
        }]);

        // Načteme pojištění podle filtru
        $insurances = $query->paginate(10); // Získání pojištění podle aplikovaného filtru

        return view('insurances.index', compact('insurances', 'filter'));
    }


    public function store(StoreInsuranceRequest $request, $insuredPersonId)
    {
        // Validované data z requestu
        $validated = $request->validated();


        // Nalezení pojištěnce podle ID
        $insuredPerson = InsuredPerson::findOrFail($insuredPersonId);

        // Uložení pojištění do pivot tabulky
        $insuredPerson->insurances()->attach($validated['insurance_id'], [
            //'name' => $validated['name'],
            'amount' => $validated['amount'],
            'subject' => $validated['subject'],
            'valid_from' => $validated['valid_from'],
            'valid_to' => $validated['valid_to'],
            'note' => $validated['note'],
        ]);

        // Přesměrování na detail pojištěnce s úspěšnou zprávou
        return redirect()->route('insuredPersons.show', $insuredPersonId)->with('success', 'Pojištění přidáno!');
    }

    public function create($insuredPersonId)
    {
        $insuredPerson = InsuredPerson::findOrFail($insuredPersonId);
        $insurances = Insurance::all(); // Možnosti pojištění, která lze přidat

        return view('insurances.create', compact('insuredPerson', 'insurances'));
    }

    public function edit($insuredPersonId, $insuranceId)
    {
        $insuredPerson = InsuredPerson::findOrFail($insuredPersonId);
        $insurances = Insurance::all(); // Možnosti pojištění
        $assignedInsurance = $insuredPerson->insurances()->findOrFail($insuranceId); // Pojištění, které upravujete

        return view('insurances.create', compact('insuredPerson', 'insurances', 'assignedInsurance'));
    }

    public function update(UpdateInsuranceRequest $request, $insuredPersonId, $insuranceId)
    {
        $validated = $request->validated();

        $insuredPerson = InsuredPerson::findOrFail($insuredPersonId);
        $insurance = $insuredPerson->insurances()->findOrFail($insuranceId);

        $insurance->pivot->update([
            'amount' => $validated['amount'],
            'subject' => $validated['subject'],
            'valid_from' => $validated['valid_from'],
            'valid_to' => $validated['valid_to'],
            'note' => $validated['note'],
        ]);

        return redirect()->route('insuredPersons.show', $insuredPersonId)
            ->with('success', 'Pojištění bylo úspěšně aktualizováno.');
    }


    public function destroy($insuredPersonId, $insuranceId)
    {
        $insuredPerson = InsuredPerson::findOrFail($insuredPersonId);
        $insuredPerson->insurances()->detach($insuranceId);

        return redirect()->route('insuredPersons.show', $insuredPersonId)->with('success', 'Pojištění bylo odstraněno.');
    }

    // Archivace pojištění
    public function archive($insuredPersonId, $insuranceId)
    {
        $insuredPerson = InsuredPerson::findOrFail($insuredPersonId);
        $insurance = $insuredPerson->insurances()->findOrFail($insuranceId);

        $insuredPerson->insurances()->updateExistingPivot($insuranceId, [
            'status' => 'archived',
        ]);

        return redirect()->back()->with('success', 'Pojištění bylo archivováno.');
    }

    // Obnovení pojištění
    public function restore($insuredPersonId, $insuranceId)
    {
        $insuredPerson = InsuredPerson::findOrFail($insuredPersonId);
        $insurance = $insuredPerson->insurances()->findOrFail($insuranceId);

        $insuredPerson->insurances()->updateExistingPivot($insuranceId, [
            'status' => 'active',
        ]);

        return redirect()->back()->with('success', 'Pojištění bylo obnoveno.');
    }
}
