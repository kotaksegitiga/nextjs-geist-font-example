<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersekotRequestsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('persekot_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // requester
            $table->string('nama');
            $table->date('tanggal');
            $table->string('jabatan');
            $table->string('departemen');
            $table->string('kantor');
            // Table for usage details: 5 rows with date, purpose, amount
            $table->json('usage_details'); // store array of {tanggal, tujuan, jumlah}
            $table->decimal('total', 15, 2);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('approval_note')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persekot_requests');
    }
}
