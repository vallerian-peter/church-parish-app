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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('member_id')->nullable(); // fixed typo
            $table->string('firstname');
            $table->string('lastname');
            $table->string('sex');
            $table->date('dateOfBirth');
            $table->string('age')->nullable();
            $table->string('ambassador')->nullable();
            $table->string('phone')->unique();
            $table->string('street');
            $table->boolean('is_guest')->nullable(); // fixed method
            $table->foreignId('group_id')->nullable()->constrained('groups')->onDelete('cascade')->onUpdate('cascade'); // fixed foreign key
            $table->string('status')->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
