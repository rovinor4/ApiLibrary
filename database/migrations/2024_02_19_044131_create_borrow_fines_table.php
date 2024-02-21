<?php

use App\Models\BorrowBook;
use App\Models\Fine;
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
        Schema::create('borrow_fines', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(BorrowBook::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Fine::class)->constrained()->cascadeOnDelete();
            $table->string("note");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrow_fines');
    }
};
