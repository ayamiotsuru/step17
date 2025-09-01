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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('content');
            $table->timestamps();
            //foreignIdは他のテーブルのIDのときに使用されるデータ型（符号なしの大きな整数）
            //onDelete('cascade')はもし参照先のpostsのレコードが削除されたら、関連するこのテーブルのレコードも自動で削除
            //->constrained() を付けると Laravel は自動的に参照先のテーブルとカラムを推測、これがないとonDelete('cascade') を付けても、外部キー制約は作られない。
            //post_idという書き方はpostsテーブルのidを参照しているという書き方。自動的にsをつけて参照するので、テーブル名側は複数形で問題ない。
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
