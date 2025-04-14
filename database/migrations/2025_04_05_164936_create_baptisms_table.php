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
        Schema::create('baptisms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('father_member_id')->constrained('members')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('mother_member_id')->constrained('members')->onDelete('cascade')->onUpdate('cascade');
            $table->string('baby_firstname');
            $table->string('baby_middlename');
            $table->string('baby_lastname');
            $table->date('dateOfBirth');
            $table->string('age')->nullable();
            $table->string('status')->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baptisms');
    }
};
