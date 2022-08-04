<?php

use App\Modules\Users\Models\UserJsonAttributeKey;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('user_json_attribute_keys', function (Blueprint $table) {
            $table->string('key', 256);
            $table->string('description', 256);
            $table->json('validation_rules')->comment('Ref: Validator::make arguments')->default('{}');
            $table->json('validation_messages')->comment('Ref: Validator::make arguments')->default('{}');
            $table->json('validation_custom_attributes')->comment('Ref: Validator::make arguments')->default('{}');
            $table->json('sample_value');
            $table->primary('key');
            $table->index(['key']);

            $table->comment('possible values for user_json_attributes table');
        });

        Schema::create('user_json_attributes', function (Blueprint $table) {
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

        /**
         * Create System Keys
         */
        UserJsonAttributeKey::query()->create([
            'key' => 'system::portfolio::experiences',
            'description' => 'Data for user experiences',
            'validation_rules' => [
                '*' => 'required|array|present',
                '*.title' => 'required|string|max:128',
                '*.company' => 'required|string|max:128',
                '*.description' => 'required|string|max:6144',
                '*.start_date' => 'required|date',
                '*.end_date' => 'nullable|date'
            ],
            'validation_messages' => [],
            'validation_custom_attributes' => [
                '*' => 'Experiences',
                '*.title' => 'Title',
                '*.company' => 'Company',
                '*.description' => 'Description',
                '*.start_date' => 'Start Date',
                '*.end_date' => 'End Date'
            ],
            'sample_value' => [
                ['title' => 'Title 1', 'company' => 'Company 1', 'start_date' => date('Y-m-d'), 'end_date' => date('Y-m-d')],
                ['title' => 'Title 2', 'company' => 'Company 2', 'start_date' => date('Y-m-d'), 'end_date' => date('Y-m-d')],
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_json_attributes');
        Schema::dropIfExists('user_json_attribute_keys');
    }
};
