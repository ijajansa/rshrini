<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::table('chapters', function (Blueprint $table) {
            if (! Schema::hasColumn('chapters', 'link')) {
                $table->text('link')->nullable()->after('name');
            }

            if (! Schema::hasColumn('chapters', 'type')) {
                $table->integer('type')->nullable()->after('subject_id');
            }
        });

        if (Schema::hasColumn('chapters', 'format_id')) {
            DB::statement('ALTER TABLE `chapters` MODIFY `format_id` BIGINT UNSIGNED NULL');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('chapters', 'format_id')) {
            DB::statement('ALTER TABLE `chapters` MODIFY `format_id` BIGINT UNSIGNED NOT NULL');
        }

        Schema::table('chapters', function (Blueprint $table) {
            $columns = [];

            if (Schema::hasColumn('chapters', 'link')) {
                $columns[] = 'link';
            }

            if (Schema::hasColumn('chapters', 'type')) {
                $columns[] = 'type';
            }

            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
