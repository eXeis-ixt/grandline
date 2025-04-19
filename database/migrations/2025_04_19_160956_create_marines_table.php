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
        Schema::create('marines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('rank', [
                'Fleet Admiral',
                'Admiral',
                'Vice Admiral',
                'Rear Admiral',
                'Commodore',
                'Captain',
                'Commander',
                'Lieutenant Commander',
                'Lieutenant',
                'Warrant Officer',
                'Sergeant Major',
                'Sergeant',
                'Corporal',
                'Seaman First Class',
                'Seaman Apprentice',
                'Seaman Recruit'
            ]);
            $table->bigInteger('bounty')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('sea_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('active'); // active, retired, deceased
            $table->string('division')->nullable(); // e.g., G-1, G-2, etc.
            $table->string('specialty')->nullable(); // e.g., Swordsman, Devil Fruit user, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marines');
    }
};
