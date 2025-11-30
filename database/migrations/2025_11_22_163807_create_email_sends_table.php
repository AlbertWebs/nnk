<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('email_sends', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('groups')->onDelete('cascade');
            $table->string('subject');
            $table->text('body');
            $table->foreignId('sent_by')->nullable()->constrained('users')->onDelete('set null');
            $table->integer('total_recipients')->default(0);
            $table->integer('sent_count')->default(0);
            $table->integer('failed_count')->default(0);
            $table->enum('status', ['pending', 'sending', 'completed', 'failed'])->default('pending');
            $table->text('errors')->nullable(); // JSON string of errors
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
        
        Schema::create('email_recipients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('email_send_id')->constrained('email_sends')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('recipient_email');
            $table->string('recipient_name')->nullable();
            $table->enum('status', ['pending', 'sent', 'failed'])->default('pending');
            $table->text('error_message')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
            
            $table->index(['email_send_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_recipients');
        Schema::dropIfExists('email_sends');
    }
};
