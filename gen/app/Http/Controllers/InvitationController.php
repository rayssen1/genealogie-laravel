<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invitation;
use Illuminate\Support\Facades\Mail;

class InvitationController extends Controller
{
    public function sendInvitation(Request $request)
    {
        $request->validate([
            'invitee_email' => 'required|email',
            'person_id' => 'required|exists:people,id',
        ]);

        $invitation = Invitation::create([
            'inviter_id' => auth()->id(),
            'invitee_email' => $request->invitee_email,
            'person_id' => $request->person_id,
            'status' => 'pending',
        ]);

        Mail::to($request->invitee_email)->send(new \App\Mail\InvitationEmail($invitation));

        return redirect()->back()->with('success', 'Invitation envoyée.');
    }
}

