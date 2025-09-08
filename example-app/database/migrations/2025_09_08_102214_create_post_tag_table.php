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
        Schema::create('post_tag', function (Blueprint $table) {
            //->constrained() を付けると Laravel は自動的に参照先のテーブルとカラムを推測、これがないとonDelete('cascade') を付けても、外部キー制約は作られない。
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            // この2つのカラムの組み合わせを、テーブルの主キー（Primary Key）として扱う
            // 1,1という組み合わせは1回のみ、2回目は1,1で登録できなくする→「同じ投稿に同じタグを2回つける」ことは意味がないので防止
            $table->primary(['post_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_tag');
    }
};
