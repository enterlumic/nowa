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
        Schema::connection('mysql')->create('promociones', function (Blueprint $table) {
            $table->id();
            $table->string('vCampo1_promociones', 30)->nullable();
            $table->string('vCampo2_promociones', 30)->nullable();
            $table->string('vCampo3_promociones', 30)->nullable();
            $table->string('vCampo4_promociones', 30)->nullable();
            $table->string('vCampo5_promociones', 30)->nullable();
            $table->string('vCampo6_promociones', 30)->nullable();
            $table->string('vCampo7_promociones', 30)->nullable();
            $table->string('vCampo8_promociones', 30)->nullable();
            $table->string('vCampo9_promociones', 30)->nullable();
            $table->string('vCampo10_promociones', 30)->nullable();
            $table->string('vCampo11_promociones', 30)->nullable();
            $table->string('vCampo12_promociones', 30)->nullable();
            $table->string('vCampo13_promociones', 30)->nullable();
            $table->string('vCampo14_promociones', 30)->nullable();
            $table->string('vCampo15_promociones', 30)->nullable();
            $table->string('vCampo16_promociones', 30)->nullable();
            $table->string('vCampo17_promociones', 30)->nullable();
            $table->string('vCampo18_promociones', 30)->nullable();
            $table->string('vCampo19_promociones', 30)->nullable();
            $table->string('vCampo20_promociones', 30)->nullable();
            $table->string('vCampo21_promociones', 30)->nullable();
            $table->string('vCampo22_promociones', 30)->nullable();
            $table->string('vCampo23_promociones', 30)->nullable();
            $table->string('vCampo24_promociones', 30)->nullable();
            $table->string('vCampo25_promociones', 30)->nullable();
            $table->string('vCampo26_promociones', 30)->nullable();
            $table->string('vCampo27_promociones', 30)->nullable();
            $table->string('vCampo28_promociones', 30)->nullable();
            $table->string('vCampo29_promociones', 30)->nullable();
            $table->string('vCampo30_promociones', 30)->nullable();
            $table->string('vCampo31_promociones', 30)->nullable();
            $table->string('vCampo32_promociones', 30)->nullable();
            $table->string('vCampo33_promociones', 30)->nullable();
            $table->string('vCampo34_promociones', 30)->nullable();
            $table->string('vCampo35_promociones', 30)->nullable();
            $table->string('vCampo36_promociones', 30)->nullable();
            $table->string('vCampo37_promociones', 30)->nullable();
            $table->string('vCampo38_promociones', 30)->nullable();
            $table->string('vCampo39_promociones', 30)->nullable();
            $table->string('vCampo40_promociones', 30)->nullable();
            $table->string('vCampo41_promociones', 30)->nullable();
            $table->string('vCampo42_promociones', 30)->nullable();
            $table->string('vCampo43_promociones', 30)->nullable();
            $table->string('vCampo44_promociones', 30)->nullable();
            $table->string('vCampo45_promociones', 30)->nullable();
            $table->string('vCampo46_promociones', 30)->nullable();
            $table->string('vCampo47_promociones', 30)->nullable();
            $table->string('vCampo48_promociones', 30)->nullable();
            $table->string('vCampo49_promociones', 30)->nullable();
            $table->string('vCampo50_promociones', 30)->nullable();
            $table->string('vCampo51_promociones', 30)->nullable();
            $table->string('vCampo52_promociones', 30)->nullable();
            $table->string('vCampo53_promociones', 30)->nullable();
            $table->string('vCampo54_promociones', 30)->nullable();
            $table->string('vCampo55_promociones', 30)->nullable();
            $table->string('vCampo56_promociones', 30)->nullable();
            $table->string('vCampo57_promociones', 30)->nullable();
            $table->string('vCampo58_promociones', 30)->nullable();
            $table->string('vCampo59_promociones', 30)->nullable();
            $table->string('vCampo60_promociones', 30)->nullable();
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
        Schema::dropIfExists('promociones');
    }
};
