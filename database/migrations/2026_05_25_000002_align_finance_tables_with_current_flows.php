<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('wallets', function (Blueprint $table) {
            if (!Schema::hasColumn('wallets', 'name')) {
                $table->string('name')->nullable();
            }
            if (!Schema::hasColumn('wallets', 'bank_name')) {
                $table->string('bank_name')->nullable();
            }
            if (!Schema::hasColumn('wallets', 'type')) {
                $table->unsignedBigInteger('type')->nullable();
            }
            if (!Schema::hasColumn('wallets', 'expiry_date')) {
                $table->date('expiry_date')->nullable();
            }
            if (!Schema::hasColumn('wallets', 'notes')) {
                $table->text('notes')->nullable();
            }
            if (!Schema::hasColumn('wallets', 'acc_created_at')) {
                $table->date('acc_created_at')->nullable();
            }
        });

        Schema::table('transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('transactions', 'title')) {
                $table->string('title')->nullable();
            }
            if (!Schema::hasColumn('transactions', 'trxn_type')) {
                $table->unsignedBigInteger('trxn_type')->nullable();
            }
            if (!Schema::hasColumn('transactions', 'wallet_id')) {
                $table->foreignId('wallet_id')->nullable()->constrained('wallets')->nullOnDelete();
            }
            if (!Schema::hasColumn('transactions', 'status')) {
                $table->unsignedTinyInteger('status')->default(0);
            }
        });

        Schema::table('goals', function (Blueprint $table) {
            if (!Schema::hasColumn('goals', 'goal_category_id')) {
                $table->foreignId('goal_category_id')->nullable()->constrained('goal_category')->nullOnDelete();
            }
            if (!Schema::hasColumn('goals', 'description')) {
                $table->text('description')->nullable();
            }
        });
    }

    public function down(): void
    {
        // Intentionally left empty: this migration aligns older local schemas with
        // fields already used by the application and should not remove user data.
    }
};
