<?php

namespace App\Models\Stories;

use Illuminate\Database\Eloquent\Model;

class StoryResponse extends Model
{
    protected $table = 'story_responses';

    protected $fillable = [
        'story_id',
        'email',
        'contact_number',
        'response_text',
        'hash',
        'meta_json',
    ];

    public static function getValidationRules(): array
    {
        return [
            'email' => 'email|max:255|required_without:contact_number',
            'contact_number' => 'string|max:32|required_without:email',
            'response_text' => 'required|string|max:500',
        ];
    }

    public static function getCustomValidationMessages(): array
    {
        return [
            'response_text.required' => 'The inquiry field is required.',
            'response_text.max' => 'Please provide an inquiry of only 500 characters.',
        ];
    }
}
