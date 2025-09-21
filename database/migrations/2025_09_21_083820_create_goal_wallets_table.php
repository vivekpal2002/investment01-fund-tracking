<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('goal_wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('goal_id')->constrained('goals')->onDelete('cascade');
            $table->foreignId('wallet_id')->constrained('wallets')->onDelete('cascade');
            $table->decimal('amount', 12, 2)->default(0);
            $table->timestamps();

            $table->unique(['goal_id', 'wallet_id']); // prevent duplicate wallet-goal entries
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goal_wallets');
    }
};
