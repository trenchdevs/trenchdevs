<?php

use App\Modules\Forms\Models\DynamicForm;
use App\Modules\Forms\Services\DynamicForms;
use App\Modules\Users\Models\UserJsonAttributeKey;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {


        Schema::create('dynamic_forms', function (Blueprint $table) {
            $table->string('form_identifier', 128);
            $table->string('description', 128);
            $table->json('validation_rules')->comment('Ref: Validator::make arguments');
            $table->json('validation_messages')->comment('Ref: Validator::make arguments');
            $table->json('validation_custom_attributes')->comment('Ref: Validator::make arguments');
            $table->json('dynamic_form_elements')->comment('Dynamic form elements for the front-end');
            $table->timestamps();

            $table->primary('form_identifier', 256);
            $table->index(['form_identifier']);
            $table->comment('Dynamic forms - first used by user_json_attribute_keys table');
        });

        Schema::create('user_json_attribute_keys', function (Blueprint $table) {
            $table->string('key', 256);
            $table->string('description', 256);
            $table->string('form_identifier', 128)->index()->nullable();
            $table->json('sample_value')->nullable();
            $table->primary('key');
            $table->index(['key']);

            $table->foreign('form_identifier')->on('dynamic_forms')->references('form_identifier');
            $table->comment('possible values for user_json_attributes table');
        });

        Schema::create('user_json_attributes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('key', 256);
            $table->jsonb('value');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('key')->references('key')->on('user_json_attribute_keys');

            $table->index(['user_id', 'key']);
            $table->index('user_id');
            $table->index(['key']);

            $table->unique(['user_id', 'key']);

            $table->index('created_at');
            $table->index('updated_at');

            $table->comment('Any non-relational values for a user');
        });

        // DynamicForms::newInstance()->createForms();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('user_json_attributes');
        Schema::dropIfExists('user_json_attribute_keys');
        Schema::dropIfExists('dynamic_forms');
    }
};
