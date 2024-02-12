<?php

use App\Models\User;
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
        Schema::create('events', function (Blueprint $table) {
            $table->id(); //bigint 20 unsigned
            $table->foreignIdFor(User::class); //bigint 20 unsigned
            $table->string('name');  //varchar 255
            $table->text('description')->nullable(); //text

            $table->dateTime('start_time');
            $table->dateTime('end_time');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
