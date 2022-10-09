<?php

use App\Modules\Sites\Enums\SiteIdentifier;
use App\Modules\Sites\Models\Site;
use App\Modules\Sites\Models\SiteConfigKey;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        SiteConfigKey::query()->upsert([
            ['key_name' => 'dashboard_module_enabled', 'module' => 'dashboard', 'description' => 'Module is enabled'],
            ['key_name' => 'portfolio_module_enabled', 'module' => 'portfolio', 'description' => 'Module is enabled'],
            ['key_name' => 'users_module_enabled', 'module' => 'users', 'description' => 'Module is enabled'],
            ['key_name' => 'photos_module_enabled', 'module' => 'photos', 'description' => 'Module is enabled'],
            ['key_name' => 'announcement_module_enabled', 'module' => 'announcements', 'description' => 'Module is enabled'],
            ['key_name' => 'blogs_module_enabled', 'module' => 'blogs', 'description' => 'Module is enabled'],
            ['key_name' => 'projects_module_enabled', 'module' => 'projects', 'description' => 'Module is enabled'],
        ], ['key_name'], ['description', 'module']);

        $site = Site::findByIdentifier(SiteIdentifier::TRENCHDEVS->value);
        $site->setConfig('dashboard_module_enabled', '1', 'Migration enabled the module');
        $site->setConfig('portfolio_module_enabled', '1', 'Migration enabled the module');
        $site->setConfig('users_module_enabled', '1', 'Migration enabled the module');
        $site->setConfig('photos_module_enabled', '1', 'Migration enabled the module');
        $site->setConfig('announcement_module_enabled', '1', 'Migration enabled the module');
        $site->setConfig('blogs_module_enabled', '1', 'Migration enabled the module');
        $site->setConfig('projects_module_enabled', '1', 'Migration enabled the module');
    }
};
