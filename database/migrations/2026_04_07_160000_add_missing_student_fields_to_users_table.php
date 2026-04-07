<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable()->after('email');
            }

            if (! Schema::hasColumn('users', 'parent_contact_number')) {
                $table->string('parent_contact_number')->nullable()->after('contact_number');
            }

            if (! Schema::hasColumn('users', 'gender')) {
                $table->string('gender', 20)->nullable()->after('parent_contact_number');
            }

            if (! Schema::hasColumn('users', 'college_name')) {
                $table->string('college_name')->nullable()->after('gender');
            }

            if (! Schema::hasColumn('users', 'payment_type')) {
                $table->string('payment_type')->nullable()->after('college_name');
            }

            if (! Schema::hasColumn('users', 'dummy_password')) {
                $table->string('dummy_password')->nullable()->after('password');
            }

            if (! Schema::hasColumn('users', 'amount')) {
                $table->decimal('amount', 10, 2)->nullable()->after('dummy_password');
            }

            if (! Schema::hasColumn('users', 'refer_code')) {
                $table->string('refer_code', 20)->nullable()->after('amount');
            }

            if (! Schema::hasColumn('users', 'profile_photo')) {
                $table->string('profile_photo')->nullable()->after('refer_code');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = [
                'address',
                'parent_contact_number',
                'gender',
                'college_name',
                'payment_type',
                'dummy_password',
                'amount',
                'refer_code',
                'profile_photo',
            ];

            $existingColumns = array_filter($columns, fn ($column) => Schema::hasColumn('users', $column));

            if ($existingColumns !== []) {
                $table->dropColumn($existingColumns);
            }
        });
    }
};
