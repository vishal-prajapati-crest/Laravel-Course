<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employers', function (Blueprint $table) {
            $table->id();

            $table->string('company_name');
            $table->foreignIdFor(\App\Models\User::class)
                ->nullable()->constrained(); //link user with the emloyer also its nullable because its not neccesary that every user is employer


            $table->timestamps();
        });

        //create a foreign key in the job table that will add the foreign key as emloyer_id in the table
        Schema::table('jobs', function (Blueprint $table){
            $table->foreignIdFor(\App\Models\Employer::class)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //before drop table need to drop froeign key in jobs table
        Schema::table('jobs', function (Blueprint $table){
            $table->dropForeignIdFor(\App\Models\Employer::class);
        });

        Schema::dropIfExists('employers');
    }
};
