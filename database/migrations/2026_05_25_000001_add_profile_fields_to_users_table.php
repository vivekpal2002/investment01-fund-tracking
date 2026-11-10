<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone', 30)->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'dob')) {
                $table->date('dob')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('users', 'gender')) {
                $table->string('gender', 20)->nullable()->after('dob');
            }
            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable()->after('gender');
            }
            if (!Schema::hasColumn('users', 'income')) {
                $table->decimal('income', 15, 2)->nullable()->after('address');
            }
            if (!Schema::hasColumn('users', 'goal')) {
                $table->decimal('goal', 15, 2)->nullable()->after('income');
            }
            if (!Schema::hasColumn('users', 'strategy')) {
                $table->string('strategy', 50)->nullable()->after('goal');
            }
            if (!Schema::hasColumn('users', 'risk')) {
                $table->string('risk', 20)->nullable()->after('strategy');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = ['phone', 'dob', 'gender', 'address', 'income', 'goal', 'strategy', 'risk'];

            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
