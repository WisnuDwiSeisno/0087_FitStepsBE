<?php 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('challenge_id')->nullable()->constrained()->onDelete('set null');
            $table->string('file_path');
            $table->text('caption')->nullable();
            $table->timestamps(); }); }
    public function down(): void
    {
        Schema::dropIfExists('photos'); }
};