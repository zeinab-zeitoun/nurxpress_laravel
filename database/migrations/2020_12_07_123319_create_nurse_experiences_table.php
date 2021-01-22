<?php

use App\Models\NurseProfile;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNurseExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nurse_experiences', function (Blueprint $table) {
            $table->id();
            $table->string('position');
            $table->string('employmentType');
            $table->string('company');
            $table->string('startYear')->nullable();
            $table->string('endYear')->nullable();
            $table->foreignId('nurse_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nurse_experiences');
    }
}
