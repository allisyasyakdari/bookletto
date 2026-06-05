<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'payment_method')) {
                $table->string('payment_method')->default('cod')->after('status');
            }
            if (!Schema::hasColumn('orders', 'payment_status')) {
                $table->string('payment_status')->default('unpaid')->after('payment_method');
            }
            if (!Schema::hasColumn('orders', 'qris_reference')) {
                $table->string('qris_reference')->nullable()->after('payment_status');
            }
            if (!Schema::hasColumn('orders', 'discount_amount')) {
                $table->integer('discount_amount')->default(0)->after('shipping_cost');
            }
            if (!Schema::hasColumn('orders', 'promo_code')) {
                $table->string('promo_code')->nullable()->after('discount_amount');
            }
            if (!Schema::hasColumn('orders', 'province')) {
                $table->string('province')->nullable()->after('shipping_address');
            }
            if (!Schema::hasColumn('orders', 'city')) {
                $table->string('city')->nullable()->after('province');
            }
            if (!Schema::hasColumn('orders', 'district')) {
                $table->string('district')->nullable()->after('city');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(array_filter([
                Schema::hasColumn('orders', 'payment_method')  ? 'payment_method'  : null,
                Schema::hasColumn('orders', 'payment_status')  ? 'payment_status'  : null,
                Schema::hasColumn('orders', 'qris_reference')  ? 'qris_reference'  : null,
                Schema::hasColumn('orders', 'discount_amount') ? 'discount_amount' : null,
                Schema::hasColumn('orders', 'promo_code')      ? 'promo_code'      : null,
                Schema::hasColumn('orders', 'province')        ? 'province'        : null,
                Schema::hasColumn('orders', 'city')            ? 'city'            : null,
                Schema::hasColumn('orders', 'district')        ? 'district'        : null,
            ]));
        });
    }
};
