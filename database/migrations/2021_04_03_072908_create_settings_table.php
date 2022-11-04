<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('setting');
            $table->string('value');
            $table->enum('type', ['text', 'image','number','textarea','select'])->default('text');
            $table->timestamps();
        });
        Setting::create([
            'title' => 'عنوان سایت',
            'setting' => 'title',
            'value' => 'فاکتور ساز',
            'type' => "text"
        ]);

        Setting::create([
            'title' => 'لوگو',
            'setting' => 'logo',
            'value' => 'images/logo5.1.png',
            'type' => 'image'
        ]);
        Setting::create([
            'title' => 'درصد اجرا و نصب',
            'setting' => 'install|setup',
            'value' => '0',
            'type' => "number"
        ]);
        Setting::create([
            'title' => 'شماره موبایل',
            'setting' => 'mobile',
            'value' => '',
            'type' => "number"
        ]);

    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
