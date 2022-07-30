<?php


namespace App\Modules\SuperAdmin\Services;


use App\Modules\Users\Models\User;
use Illuminate\Support\Facades\Auth;

class CommandHandlerHelper
{
    /**
     * command => feather icon data
     */
    const AVAILABLE_COMMANDS = [
        'git_status' => [
            'command' => 'git_status',
            'icon' => 'github',
            'label' => '1. git status',
            'btn-class' => 'btn-success',
        ],
        'git_pull' => [
            'command' => 'git_pull',
            'icon' => 'github',
            'label' => '2. git pull',
            'btn-class' => 'btn-orange'
        ],
        'git_status2' => [
            'command' => 'git_status',
            'icon' => 'github',
            'label' => '3. git status',
            'btn-class' => 'btn-success',
        ],
        'migrate' => [
            'command' => 'php artisan migrate',
            'icon' => 'database',
            'label' => '4. php artisan migrate',
            'btn-class' => 'btn-orange'
        ],
        'composer_install' => [
            'command' => 'composer install',
            'icon' => 'terminal',
            'label' => '5. composer install',
            'btn-class' => 'btn-warning',
        ],
        'composer_update' => [
            'command' => 'composer update',
            'label' => '6. composer update',
            'icon' => 'terminal',
            'btn-class' => 'btn-danger'
        ],
    ];

    /**
     * @param string $command
     * @return array
     */
    public function execute(string $command): array
    {

        $result = [];

        /** @var User $user */
        $user = Auth::user();

        if (!$user->isSuperAdmin()) {
            abort(403, 'Forbidden.');
        }

        switch ($command) {
            // can be a classes later on if needed, for now this suffices
            case 'git_pull':
                exec('cd .. && git pull 2>&1', $output);
                return $output;
            case 'composer_install':
                exec('cd .. && composer install 2>&1', $output);
                return $output;
            case 'composer_update':
                exec('cd .. && composer update 2>&1', $output);
                return $output;
            case 'migrate':
                exec('cd .. && php artisan migrate --force 2>&1', $output);
                return $output;
            case 'git_status':
            case 'git_status2':
                exec('cd .. && git status 2>&1', $output);
                return $output;
            default:
                abort(403, 'Forbidden..');
        }

        return $result;
    }

}
