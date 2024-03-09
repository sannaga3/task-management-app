<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title', 20)->comment('タイトル');
            $table->string('content', 50)->nullable()->comment('内容');
            $table->date('begin')->default(Carbon::now())->comment('開始日');
            $table->date('end')->nullable()->comment('終了日');
            $table->tinyInteger('status')->default(0)->comment('ステータス');
            $table->boolean('published')->default(true)->comment('公開/非公開');
            $table->text('remarks', 50)->nullable()->comment('備考');
            $table->foreignId('user_id')->comment('ユーザーID')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};