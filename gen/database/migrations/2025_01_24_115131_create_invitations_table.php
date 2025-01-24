<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inviter_id')->constrained('users')->onDelete('cascade'); // L'utilisateur qui invite
            $table->foreignId('person_id')->constrained('people')->onDelete('cascade'); // La fiche associée
            $table->string('invitee_email'); // L'email de l'invité
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending'); // Statut de l'invitation
            $table->timestamps(); // Colonnes created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invitations');
    }
}
