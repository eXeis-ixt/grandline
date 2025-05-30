<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('crew_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role');
            $table->bigInteger('bounty');
            $table->foreignId('crew_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('crew_members');
    }
}; 