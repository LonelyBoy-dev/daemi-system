<?php

namespace RachidLaasri\LaravelInstaller\Helpers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EnvironmentManager
{
    /**
     * @var string
     */
    private $envPath;

    /**
     * @var string
     */
    private $envExamplePath;

    /**
     * Set the .env and .env.example paths.
     */
    public function __construct()
    {
        $this->envPath = base_path('.env');
        $this->envExamplePath = base_path('.env.example');
    }

    /**
     * Get the content of the .env file.
     *
     * @return string
     */
    public function getEnvContent()
    {
        if (! file_exists($this->envPath)) {
            if (file_exists($this->envExamplePath)) {
                copy($this->envExamplePath, $this->envPath);
            } else {
                touch($this->envPath);
            }
        }

        return file_get_contents($this->envPath);
    }

    /**
     * Get the the .env file path.
     *
     * @return string
     */
    public function getEnvPath()
    {
        return $this->envPath;
    }

    /**
     * Get the the .env.example file path.
     *
     * @return string
     */
    public function getEnvExamplePath()
    {
        return $this->envExamplePath;
    }

    /**
     * Save the edited content to the .env file.
     *
     * @param Request $input
     * @return string
     */
    public function saveFileClassic(Request $input)
    {
        $message = trans('installer_messages.environment.success');

        try {
            file_put_contents($this->envPath, $input->get('envConfig'));
        } catch (Exception $e) {
            $message = trans('installer_messages.environment.errors');
        }

        return $message;
    }

    /**
     * Save the form content to the .env file.
     *
     * @param Request $request
     * @return string
     */
    public function saveFileWizard(Request $request)
    {
        $results = trans('installer_messages.environment.success');

        $envFileData =
            'APP_NAME=FactorSaz\'' . "'\n" .
            'APP_ENV=' . 'local' . "\n" .
            'APP_KEY=' . 'base64:' . base64_encode(Str::random(32)) . "\n" .
            'APP_DEBUG=' . 'false' . "\n\n" .
            'APP_URL=' . url('/') . "\n\n" .
            'LOG_CHANNEL=' . 'stack' . "\n" .
            'LOG_LEVEL=' . 'debug' . "\n\n" .
            'DB_CONNECTION=' . $request->database_connection . "\n" .
            'DB_HOST=' . $request->database_hostname . "\n" .
            'DB_PORT=' . $request->database_port . "\n" .
            'DB_DATABASE=' . $request->database_name . "\n" .
            'DB_USERNAME=' . $request->database_username . "\n" .
            'DB_PASSWORD=' . $request->database_password . "\n\n" .
            'BROADCAST_DRIVER=' . 'log' . "\n" .
            'CACHE_DRIVER=' . 'file' . "\n" .
            'SESSION_DRIVER=' . 'file' . "\n" .
            'QUEUE_CONNECTION=' . 'sync' . "\n" .
            'SESSION_LIFETIME=' . '120' . "\n\n" .
            'MEMCACHED_HOST=' . '127.0.0.1' . "\n\n" .
            'REDIS_HOST=' . '127.0.0.1' . "\n" .
            'REDIS_PASSWORD=' . 'null' . "\n" .
            'REDIS_PORT=' . '6379' . "\n\n" .
            'MAIL_DRIVER=' . 'smtp' . "\n" .
            'MAIL_HOST=' . 'mailhog' . "\n" .
            'MAIL_PORT=' . '1025' . "\n" .
            'MAIL_USERNAME=' . '' . "\n" .
            'MAIL_PASSWORD=' . '' . "\n" .
            'MAIL_ENCRYPTION=' . 'null' . "\n" .
            'MAIL_FROM_ADDRESS=' . '' . "\n" .
            'MAIL_FROM_NAME=' . '"${APP_NAME}"' . "\n\n" .
            'AWS_ACCESS_KEY_ID=' . '' . "\n" .
            'AWS_SECRET_ACCESS_KEY=' . '' . "\n" .
            'AWS_DEFAULT_REGION=' . 'us-east-1' . "\n" .
            'AWS_BUCKET=' . '' . "\n\n" .
            'PUSHER_APP_ID=' . '' . "\n" .
            'PUSHER_APP_KEY=' . '' . "\n" .
            'PUSHER_APP_SECRET=' . '' . "\n" .
            'PUSHER_APP_CLUSTER=' . '' . "\n\n" .
            'MIX_PUSHER_APP_KEY=' . '"${PUSHER_APP_KEY}"' . "\n" .
            'MIX_PUSHER_APP_CLUSTER=' . '"${PUSHER_APP_CLUSTER}"' . "\n\n";

        try {
            file_put_contents($this->envPath, $envFileData);
        } catch (Exception $e) {
            $results = trans('installer_messages.environment.errors');
        }

        return $results;
    }
}
