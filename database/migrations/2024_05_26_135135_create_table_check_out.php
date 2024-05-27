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
        Schema::connection('mysql')->create('check_out', function (Blueprint $table) {
            $table->id();
            $table->string('vCampo1_check_out', 30)->nullable();
            $table->string('vCampo2_check_out', 30)->nullable();
            $table->string('vCampo3_check_out', 30)->nullable();
            $table->string('vCampo4_check_out', 30)->nullable();
            $table->string('vCampo5_check_out', 30)->nullable();
            $table->string('vCampo6_check_out', 30)->nullable();
            $table->string('vCampo7_check_out', 30)->nullable();
            $table->string('vCampo8_check_out', 30)->nullable();
            $table->string('vCampo9_check_out', 30)->nullable();
            $table->string('vCampo10_check_out', 30)->nullable();
            $table->string('vCampo11_check_out', 30)->nullable();
            $table->string('vCampo12_check_out', 30)->nullable();
            $table->string('vCampo13_check_out', 30)->nullable();
            $table->string('vCampo14_check_out', 30)->nullable();
            $table->string('vCampo15_check_out', 30)->nullable();
            $table->string('vCampo16_check_out', 30)->nullable();
            $table->string('vCampo17_check_out', 30)->nullable();
            $table->string('vCampo18_check_out', 30)->nullable();
            $table->string('vCampo19_check_out', 30)->nullable();
            $table->string('vCampo20_check_out', 30)->nullable();
            $table->string('vCampo21_check_out', 30)->nullable();
            $table->string('vCampo22_check_out', 30)->nullable();
            $table->string('vCampo23_check_out', 30)->nullable();
            $table->string('vCampo24_check_out', 30)->nullable();
            $table->string('vCampo25_check_out', 30)->nullable();
            $table->string('vCampo26_check_out', 30)->nullable();
            $table->string('vCampo27_check_out', 30)->nullable();
            $table->string('vCampo28_check_out', 30)->nullable();
            $table->string('vCampo29_check_out', 30)->nullable();
            $table->string('vCampo30_check_out', 30)->nullable();
            $table->string('vCampo31_check_out', 30)->nullable();
            $table->string('vCampo32_check_out', 30)->nullable();
            $table->string('vCampo33_check_out', 30)->nullable();
            $table->string('vCampo34_check_out', 30)->nullable();
            $table->string('vCampo35_check_out', 30)->nullable();
            $table->string('vCampo36_check_out', 30)->nullable();
            $table->string('vCampo37_check_out', 30)->nullable();
            $table->string('vCampo38_check_out', 30)->nullable();
            $table->string('vCampo39_check_out', 30)->nullable();
            $table->string('vCampo40_check_out', 30)->nullable();
            $table->string('vCampo41_check_out', 30)->nullable();
            $table->string('vCampo42_check_out', 30)->nullable();
            $table->string('vCampo43_check_out', 30)->nullable();
            $table->string('vCampo44_check_out', 30)->nullable();
            $table->string('vCampo45_check_out', 30)->nullable();
            $table->string('vCampo46_check_out', 30)->nullable();
            $table->string('vCampo47_check_out', 30)->nullable();
            $table->string('vCampo48_check_out', 30)->nullable();
            $table->string('vCampo49_check_out', 30)->nullable();
            $table->string('vCampo50_check_out', 30)->nullable();
            $table->string('vCampo51_check_out', 30)->nullable();
            $table->string('vCampo52_check_out', 30)->nullable();
            $table->string('vCampo53_check_out', 30)->nullable();
            $table->string('vCampo54_check_out', 30)->nullable();
            $table->string('vCampo55_check_out', 30)->nullable();
            $table->string('vCampo56_check_out', 30)->nullable();
            $table->string('vCampo57_check_out', 30)->nullable();
            $table->string('vCampo58_check_out', 30)->nullable();
            $table->string('vCampo59_check_out', 30)->nullable();
            $table->string('vCampo60_check_out', 30)->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->boolean('b_status')->index()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('check_out');
    }
};
