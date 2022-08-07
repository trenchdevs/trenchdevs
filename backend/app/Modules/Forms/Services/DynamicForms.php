<?php

namespace App\Modules\Forms\Services;

use App\Modules\Forms\Models\DynamicForm;

class DynamicForms
{

    public static function newInstance(): DynamicForms
    {
        return new self;
    }

    public function create2208Forms(): void
    {
        DynamicForm::query()->updateOrCreate(
            [
                'form_identifier' => 'system::portfolio::experiences::2208',
            ],
            [
                'description' => 'Data for user experiences',
                'dynamic_form_elements' => [
                    'Title' => ['type' => 'input', 'className' => 'form-control', 'wrapperClassName' => 'col-md-6', 'name' => '*.title'],
                    'Company' => ['type' => 'input', 'className' => 'form-control', 'wrapperClassName' => 'col-md-6', 'name' => '*.company'],
                    'Description' => ['type' => 'textarea', 'className' => 'form-control', 'wrapperClassName' => 'col-md-12', 'name' => '*.description'],
                    'Start Date' => ['type' => 'date', 'className' => 'form-control', 'wrapperClassName' => 'col-md-6', 'name' => '*.start_date'],
                    'End Date' => ['type' => 'date', 'className' => 'form-control', 'wrapperClassName' => 'col-md-6', 'name' => '*.end_date'],
                ],
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

            ]);

        DynamicForm::query()->updateOrCreate(
            [
                'form_identifier' => 'system::portfolio::details::2208'
            ],
            [
                'description' => 'Data for portfolio details',
                'dynamic_form_elements' => [
                    'Username' => [
                        'name' => 'username',
                        'type' => 'input','className' => 'form-control',
                        'wrapperClassName' => 'col-md-6',
                        'verbiage' => 'This will be your trenchdevs handle (eg. trenchdevs.org/myusername)',
                        'placeholder' => 'Username',
                    ],
                    'Template / Custom View' => [
                        'type' => 'select',
                        'dropdown_options' => [
                            ['value' => 'portfolio.custom.basic', 'label' => 'Basic (StartBootstrap Template)'],
                            ['value' => 'portfolio.custom.console', 'label' => 'Console (Text Theme)'],
                        ],
                        'className' => 'form-control',
                        'wrapperClassName' => 'col-md-6',
                        'name' => 'template',
                        'value' => 'portfolio.custom.basic',
                    ],

                    'Primary Phone Number' => ['type' => 'input', 'className' => 'form-control', 'wrapperClassName' => 'col-md-6', 'name' => 'primary_phone_number', 'placeholder' => '123-123-..'],
                    'GitHub URL' => ['type' => 'input', 'className' => 'form-control', 'wrapperClassName' => 'col-md-6', 'name' => 'github_url', 'placeholder' => 'https://github.com/<<handle>>'],
                    'LinkedIn URL' => ['type' => 'input', 'className' => 'form-control', 'wrapperClassName' => 'col-md-6', 'name' => 'linkedin_url', 'placeholder' => 'https://linkedin.com/<<handle>>'],
                    'Resume URL' => ['type' => 'input', 'className' => 'form-control', 'wrapperClassName' => 'col-md-6', 'name' => 'resume_url', 'placeholder' => 'https://myresume.com'],

                    'Tagline' => [
                        'type' => 'textarea',
                        'className' => 'form-control',
                        'wrapperClassName' => 'col-md-12',
                        'name' => 'tagline',
                        'verbiage' => 'Shown below your name on your portfolio',
                    ],

                    'Personal Interests' => [
                        'type' => 'textarea',
                        'className' => 'form-control',
                        'wrapperClassName' => 'col-md-12',
                        'name' => 'personal_interests',
                        'verbiage' => 'Shown as a section on portfolio'
                    ],
                ],
                'validation_rules' => [
                    'username' => 'required|string|max:128',
                    'template' => 'required|string|max:128',
                    'primary_phone_number' => 'required|string|max:16',
                    'github_url' => 'required|url',
                    'linkedin_url' => 'required|url',
                    'resume_url' => 'nullable|url',
                    'tagline' => 'nullable|string|max:6144',
                    'personal_interests' => 'nullable|string|max:6144',
                ],
                'validation_messages' => [],
                'validation_custom_attributes' => [
                    'username' => 'Username',
                    'template' => 'Template',
                    'primary_phone_number' => 'Primary Phone Number',
                    'github_url' => 'Github URL',
                    'linkedin_url' => 'LinkedIn URL',
                    'resume_url' => 'Resume URL',
                    'tagline' => 'Tagline',
                    'personal_interests' => 'Personal Interests',
                ],
            ]
        );
    }
}
