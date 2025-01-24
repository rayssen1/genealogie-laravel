<?php
namespace App\Http\Controllers;

use App\Models\ModificationProposal;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModificationProposalController extends Controller
{
    public function store(Request $request, $person_id)
    {
        $request->validate([
            'changes' => 'required|array',
        ]);

        ModificationProposal::create([
            'person_id' => $person_id,
            'proposed_by' => Auth::id(),
            'changes' => json_encode($request->changes),
        ]);

        return back()->with('success', 'Proposition soumise avec succès !');
    }

    public function review($proposal_id, $decision)
    {
        $proposal = ModificationProposal::findOrFail($proposal_id);

        if (!in_array($decision, ['accepted', 'rejected'])) {
            return back()->with('error', 'Décision invalide.');
        }

        $proposal->status = $decision;
        $proposal->save();

        return back()->with('success', 'Proposition ' . ($decision == 'accepted' ? 'acceptée' : 'rejetée') . ' avec succès !');
    }
}
