<?php

namespace App\Modules\Forms\Services;

use App\Modules\Forms\Models\DynamicForm;
use App\Modules\Users\Models\UserJsonAttributeKey;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DynamicForms
{

    public static function newInstance(): DynamicForms
    {
        return new self;
    }

    public function createForms(): void
    {
        DB::transaction(function () {
            // execute all portfolio* functions
            collect(get_class_methods(self::class))
                ->filter(fn($methodName) => Str::startsWith($methodName, 'portfolio'))
                ->each(function ($methodName) {
                    $this->{$methodName}();
                    echoln_console("Portfolio: $methodName ✅");
                });
        });
    }

    private function portfolioDetails(): void
    {
        DynamicForm::query()->updateOrCreate(
            [
                'form_identifier' => 'system::portfolio::details::2208'
            ],
            [
                'description' => 'Data for portfolio details',
                'dynamic_form_elements' => [
                    'Username' => [
                        'name' => 'external_id',
                        'type' => 'input', 'className' => 'form-control',
                        'wrapperClassName' => 'col-md-6',
                        'verbiage' => 'This will be your trenchdevs handle (eg. trenchdevs.org/myusername)',
                        'placeholder' => 'Username',
                    ],
                    'Template / Custom View' => [
                        'type' => 'select',
                        'dropdown_options' => [
                            ['value' => '', 'label' => 'Select Template'],
                            ['value' => 'themes.trenchdevs.pages.portfolio.basic', 'label' => 'Basic (StartBootstrap Template)'],
                            ['value' => 'themes.trenchdevs.pages.portfolio.console', 'label' => 'Console (Text Theme)'],
                        ],
                        'className' => 'form-control',
                        'wrapperClassName' => 'col-md-6',
                        'name' => 'template',
                        'value' => 'themes.trenchdevs.pages.portfolio.basic',
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
                    'external_id' => 'required|string|max:128',
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
                    'external_id' => 'Username',
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

        UserJsonAttributeKey::query()->updateOrCreate(
            ['key' => 'system::portfolio::details'],
            [
                'description' => 'Data for user details',
                'form_identifier' => 'system::portfolio::details::2208',
                'sample_value' => [
                    'external_id' => 'chris',
                    'template' => 'console',
                    'primary_phone_number' => '123-123-1234',
                    'github_url' => 'https://github.com/trenchdevs/trenchdevs',
                    'linkedin_url' => 'https://linkedin.com/trenchdevs',
                    'resume_url' => 'https://trenchdevs.org/',
                    'tagline' => 'About me',
                    'personal_interests' => 'About my interests',
                ],
            ]
        );
    }

    private function portfolioExperiences(): void
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
                    'Description' => ['type' => 'rich-text-editor', 'className' => 'form-control', 'wrapperClassName' => 'col-md-12', 'name' => '*.description'],
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

            ]
        );
        /**
         * Create System Keys
         */
        UserJsonAttributeKey::query()->updateOrCreate(
            ['key' => 'system::portfolio::experiences'],
            [
                'description' => 'Data for user experiences',
                'form_identifier' => 'system::portfolio::experiences::2208',
                'sample_value' => [
                    ['title' => 'Title 1', 'company' => 'Company 1', 'start_date' => date('Y-m-d'), 'end_date' => date('Y-m-d')],
                    ['title' => 'Title 2', 'company' => 'Company 2', 'start_date' => date('Y-m-d'), 'end_date' => date('Y-m-d')],
                ]
            ]
        );
    }

    private function portfolioDegrees(): void
    {
        DynamicForm::query()->updateOrCreate(
            [
                'form_identifier' => 'system::portfolio::degrees::2208',
            ],
            [
                'description' => 'Data for user experiences',
                'dynamic_form_elements' => [
                    'Educational Institution' => ['type' => 'input', 'className' => 'form-control', 'wrapperClassName' => 'col-md-6', 'name' => '*.educational_institution'],
                    'Degree' => ['type' => 'input', 'className' => 'form-control', 'wrapperClassName' => 'col-md-6', 'name' => '*.degree'],
                    'Start Date' => ['type' => 'date', 'className' => 'form-control', 'wrapperClassName' => 'col-md-6', 'name' => '*.start_date'],
                    'End Date' => ['type' => 'date', 'className' => 'form-control', 'wrapperClassName' => 'col-md-6', 'name' => '*.end_date'],
                    'Description' => ['type' => 'rich-text-editor', 'className' => 'form-control', 'wrapperClassName' => 'col-md-6', 'name' => '*.description'],
                ],
                'validation_rules' => [
                    '*' => 'required|array|present',
                    '*.educational_institution' => 'required|string|max:128',
                    '*.degree' => 'required|string|max:128',
                    '*.start_date' => 'required|date',
                    '*.end_date' => 'nullable|date',
                    '*.description' => 'required|string|max:6144',
                ],
                'validation_messages' => [],
                'validation_custom_attributes' => [
                    '*' => 'Degrees',
                    '*.educational_institution' => 'Educational Institution',
                    '*.degree' => 'Degree',
                    '*.start_date' => 'Start Date',
                    '*.end_date' => 'End Date',
                    '*.description' => 'Description',
                ],
            ]
        );
        /**
         * Create System Keys
         */
        UserJsonAttributeKey::query()->updateOrCreate(
            ['key' => 'system::portfolio::degrees'],
            [
                'description' => 'Data for user experiences',
                'form_identifier' => 'system::portfolio::degrees::2208',
                'sample_value' => []
            ]
        );
    }

    private function portfolioSkills(): void
    {
        DynamicForm::query()->updateOrCreate(
            [
                'form_identifier' => 'system::portfolio::skills::2208'
            ],
            [
                'description' => 'Data for portfolio details',
                'dynamic_form_elements' => [
                    'Tourist' => [
                        'name' => 'tourist',
                        'type' => 'rich-text-editor',
                        'className' => 'form-control',
                        'wrapperClassName' => 'col-md-12',
                        'verbiage' => 'Skills that you are a beginner at',
                    ],
                    'Conversationally Fluent' => [
                        'name' => 'conversationally_fluent',
                        'type' => 'rich-text-editor',
                        'className' => 'form-control',
                        'wrapperClassName' => 'col-md-12',
                        'verbiage' => 'Skills that you are comfortable talking about with other developers',
                    ],
                    'Fluent' => [
                        'name' => 'fluent',
                        'type' => 'rich-text-editor',
                        'className' => 'form-control',
                        'wrapperClassName' => 'col-md-12',
                        'verbiage' => 'Skills that you are an expert at',
                    ],
                ],
                'validation_rules' => [
                    'tourist' => 'nullable|string|max:6144',
                    'conversationally_fluent' => 'nullable|string|max:6144',
                    'fluent' => 'nullable|string|max:6144',
                ],
                'validation_messages' => [],
                'validation_custom_attributes' => [
                    'tourist' => 'Personal Interests',
                    'conversationally_fluent' => 'Personal Interests',
                    'fluent' => 'Personal Interests',
                ],
            ]
        );

        UserJsonAttributeKey::query()->updateOrCreate(
            ['key' => 'system::portfolio::skills'],
            [
                'description' => 'Data for user skills',
                'form_identifier' => 'system::portfolio::skills::2208',
                'sample_value' => [],
            ]
        );
    }

    private function portfolioCertifications(): void
    {
        DynamicForm::query()->updateOrCreate(
            [
                'form_identifier' => 'system::portfolio::certifications::2208',
            ],
            [
                'description' => 'Data for user experiences',
                'dynamic_form_elements' => [
                    'Title' => ['type' => 'input', 'className' => 'form-control', 'wrapperClassName' => 'col-md-6', 'name' => '*.title'],
                    'Issuer' => ['type' => 'input', 'className' => 'form-control', 'wrapperClassName' => 'col-md-6', 'name' => '*.issuer'],
                    'Certification URL' => ['type' => 'input', 'className' => 'form-control', 'wrapperClassName' => 'col-md-12', 'name' => '*.certification_url'],
                    'Issuance Date' => ['type' => 'date', 'className' => 'form-control', 'wrapperClassName' => 'col-md-6', 'name' => '*.issuance_date'],
                    'Expiration Date' => ['type' => 'date', 'className' => 'form-control', 'wrapperClassName' => 'col-md-6', 'name' => '*.expiration_date'],
                ],
                'validation_rules' => [
                    '*' => 'required|array|present',
                    '*.title' => 'required|string|max:128',
                    '*.issuer' => 'required|string|max:128',
                    '*.certification_url' => 'required|url',
                    '*.issuance_date' => 'nullable|date',
                    '*.expiration_date' => 'nullable|date',
                ],
                'validation_messages' => [],
                'validation_custom_attributes' => [
                    '*' => 'Certifications',
                    '*.title' => 'Title',
                    '*.issuer' => 'Issuer',
                    '*.certification_url' => 'Certification URL',
                    '*.issuance_date' => 'Issuance Date',
                    '*.expiration_date' => 'Expiration Date',
                ],
            ]
        );
        /**
         * Create System Keys
         */
        UserJsonAttributeKey::query()->updateOrCreate(
            ['key' => 'system::portfolio::certifications'],
            [
                'description' => 'Data for user Certifications',
                'form_identifier' => 'system::portfolio::certifications::2208',
                'sample_value' => []
            ]
        );
    }

}
