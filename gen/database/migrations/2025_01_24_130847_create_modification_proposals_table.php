<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modification_proposals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id'); // Fiche concernée
            $table->unsignedBigInteger('proposed_by'); // Utilisateur ayant proposé la modification
            $table->json('changes'); // Modifications proposées, stockées au format JSON
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending'); // État de la proposition
            $table->timestamps(); // created_at & updated_at

            // Clés étrangères
            $table->foreign('person_id')->references('id')->on('people')->onDelete('cascade');
            $table->foreign('proposed_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modification_proposals');
    }
};
