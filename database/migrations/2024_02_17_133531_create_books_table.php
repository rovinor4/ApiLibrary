<?php

use App\Models\Bookshelf;
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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string("ISBN")->unique();
            $table->string("title");
            $table->json("authors");
            $table->longText("description");
            $table->string("publish");
            $table->date("published");
            $table->year("year_publish");
            $table->string("cover");
            $table->integer("total_page")->default(1);
            $table->integer("stock")->default(1);
            $table->json("preview")->nullable();
            $table->string("language");
            $table->json("genres")->nullable();
            $table->foreignIdFor(Bookshelf::class)->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
