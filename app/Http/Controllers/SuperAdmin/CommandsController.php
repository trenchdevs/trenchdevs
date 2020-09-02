<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Helpers\SuperAdmin\CommandHandlerHelper;
use App\Http\Controllers\AuthWebController;
use App\Models\SuperAdmin\SuperAdminAccessLogs;
use App\Models\SuperAdmin\SuperAdminWhitelistedIp;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class CommandsController extends AuthWebController
{

    /**
     * @throws Throwable
     */
    public function middlewareOnConstructorCalled(): void
    {
        parent::middlewareOnConstructorCalled();

        $ip = \request()->ip();

        try {

            if (!$this->user->isSuperAdmin()) {
                throw new Exception("Forbidden: ERR: CC_01. Please contact admin if you require elevated access");
            }

            if (!SuperAdminWhitelistedIp::isWhitelisted($this->user->id, $ip)) {
                throw new Exception("Forbidden: ERR: CC_02. Please contact admin if you require elevated access");
            }

        } catch (Exception $exception) {
            $errorMessage = $exception->getMessage();
            SuperAdminAccessLogs::log($this->user->id, $ip, 'access_error', $exception->getMessage());
            abort(403, $errorMessage);
        }

    }

    private function indexView(array $data = [])
    {
        return view('superadmin.index', array_merge(
            $data,
            ['commands' => CommandHandlerHelper::AVAILABLE_COMMANDS],
        ));
    }

    public function index(Request $request)
    {
        SuperAdminAccessLogs::log($this->user->id, $request->ip(), 'get_commands', 'User is viewing commands');

        return $this->indexView();
    }

    public function command(Request $request, CommandHandlerHelper $commandHandler)
    {

        try {

            $this->validate($request, [
                'command' => 'required',
            ]);


            $command = $request->get('command');

            $log = SuperAdminAccessLogs::log($this->user->id, $request->ip(), 'execute_command', "User is executing {$command} command");

            if (!in_array($command, array_keys(CommandHandlerHelper::AVAILABLE_COMMANDS))) {
                throw new Exception("Command invalid");
            }

            $results = $commandHandler->execute($command);

            $log->saveMeta(implode(PHP_EOL, $results));

            return $this->indexView([
                'lines' => $results,
            ]);

        } catch (Throwable $exception) {
            abort(403, $exception->getMessage());
        }

        abort(403, "Invalid Action");
    }

}
