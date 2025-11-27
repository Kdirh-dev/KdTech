<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('repairs', function (Blueprint $table) {
            $table->id();
            $table->string('repair_number')->unique();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->string('device_type');
            $table->string('device_brand');
            $table->string('device_model');
            $table->text('issue_description');
            $table->decimal('estimated_cost', 10, 2)->nullable();
            $table->decimal('final_cost', 10, 2)->nullable();
            $table->enum('status', ['pending', 'diagnosis', 'repairing', 'repaired', 'ready', 'delivered', 'cancelled'])->default('pending');
            $table->text('technician_notes')->nullable();
            $table->date('estimated_completion')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('repairs');
    }
};
