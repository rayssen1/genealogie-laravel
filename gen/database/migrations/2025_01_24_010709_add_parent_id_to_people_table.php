<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParentIdToPeopleTable extends Migration
{
    public function up()
    {
        // Check if the column already exists before adding it
        if (!Schema::hasColumn('people', 'parent_id')) {
            Schema::table('people', function (Blueprint $table) {
                $table->unsignedBigInteger('parent_id')->nullable()->after('created_by');

                // Add foreign key constraint
                $table->foreign('parent_id')->references('id')->on('people')->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        // Drop the foreign key and the column if the migration is rolled back
        Schema::table('people', function (Blueprint $table) {
            if (Schema::hasColumn('people', 'parent_id')) {
                $table->dropForeign(['parent_id']);
                $table->dropColumn('parent_id');
            }
        });
    }
}
