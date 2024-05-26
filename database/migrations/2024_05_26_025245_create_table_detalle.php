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
        Schema::connection('mysql')->create('detalle', function (Blueprint $table) {
            $table->id();
            $table->string('vCampo1_detalle', 30)->nullable();
            $table->string('vCampo2_detalle', 30)->nullable();
            $table->string('vCampo3_detalle', 30)->nullable();
            $table->string('vCampo4_detalle', 30)->nullable();
            $table->string('vCampo5_detalle', 30)->nullable();
            $table->string('vCampo6_detalle', 30)->nullable();
            $table->string('vCampo7_detalle', 30)->nullable();
            $table->string('vCampo8_detalle', 30)->nullable();
            $table->string('vCampo9_detalle', 30)->nullable();
            $table->string('vCampo10_detalle', 30)->nullable();
            $table->string('vCampo11_detalle', 30)->nullable();
            $table->string('vCampo12_detalle', 30)->nullable();
            $table->string('vCampo13_detalle', 30)->nullable();
            $table->string('vCampo14_detalle', 30)->nullable();
            $table->string('vCampo15_detalle', 30)->nullable();
            $table->string('vCampo16_detalle', 30)->nullable();
            $table->string('vCampo17_detalle', 30)->nullable();
            $table->string('vCampo18_detalle', 30)->nullable();
            $table->string('vCampo19_detalle', 30)->nullable();
            $table->string('vCampo20_detalle', 30)->nullable();
            $table->string('vCampo21_detalle', 30)->nullable();
            $table->string('vCampo22_detalle', 30)->nullable();
            $table->string('vCampo23_detalle', 30)->nullable();
            $table->string('vCampo24_detalle', 30)->nullable();
            $table->string('vCampo25_detalle', 30)->nullable();
            $table->string('vCampo26_detalle', 30)->nullable();
            $table->string('vCampo27_detalle', 30)->nullable();
            $table->string('vCampo28_detalle', 30)->nullable();
            $table->string('vCampo29_detalle', 30)->nullable();
            $table->string('vCampo30_detalle', 30)->nullable();
            $table->string('vCampo31_detalle', 30)->nullable();
            $table->string('vCampo32_detalle', 30)->nullable();
            $table->string('vCampo33_detalle', 30)->nullable();
            $table->string('vCampo34_detalle', 30)->nullable();
            $table->string('vCampo35_detalle', 30)->nullable();
            $table->string('vCampo36_detalle', 30)->nullable();
            $table->string('vCampo37_detalle', 30)->nullable();
            $table->string('vCampo38_detalle', 30)->nullable();
            $table->string('vCampo39_detalle', 30)->nullable();
            $table->string('vCampo40_detalle', 30)->nullable();
            $table->string('vCampo41_detalle', 30)->nullable();
            $table->string('vCampo42_detalle', 30)->nullable();
            $table->string('vCampo43_detalle', 30)->nullable();
            $table->string('vCampo44_detalle', 30)->nullable();
            $table->string('vCampo45_detalle', 30)->nullable();
            $table->string('vCampo46_detalle', 30)->nullable();
            $table->string('vCampo47_detalle', 30)->nullable();
            $table->string('vCampo48_detalle', 30)->nullable();
            $table->string('vCampo49_detalle', 30)->nullable();
            $table->string('vCampo50_detalle', 30)->nullable();
            $table->string('vCampo51_detalle', 30)->nullable();
            $table->string('vCampo52_detalle', 30)->nullable();
            $table->string('vCampo53_detalle', 30)->nullable();
            $table->string('vCampo54_detalle', 30)->nullable();
            $table->string('vCampo55_detalle', 30)->nullable();
            $table->string('vCampo56_detalle', 30)->nullable();
            $table->string('vCampo57_detalle', 30)->nullable();
            $table->string('vCampo58_detalle', 30)->nullable();
            $table->string('vCampo59_detalle', 30)->nullable();
            $table->string('vCampo60_detalle', 30)->nullable();
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
        Schema::dropIfExists('detalle');
    }
};
