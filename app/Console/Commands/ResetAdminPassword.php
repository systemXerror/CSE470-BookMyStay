<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetAdminPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:reset-password {--email=admin@bookmystay.com} {--password=admin123}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset admin user password';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->option('email');
        $password = $this->option('password');

        $admin = User::where('email', $email)->first();

        if (!$admin) {
            $this->error("Admin user with email {$email} not found!");
            $this->info("Creating new admin user...");
            
            $admin = User::create([
                'name' => 'Admin User',
                'email' => $email,
                'password' => Hash::make($password),
                'is_admin' => true,
            ]);
            
            $this->info("Admin user created successfully!");
        } else {
            $admin->update([
                'password' => Hash::make($password),
                'is_admin' => true,
            ]);
            
            $this->info("Admin password reset successfully!");
        }

        $this->info("Admin Login Details:");
        $this->info("Email: {$email}");
        $this->info("Password: {$password}");
        $this->info("Admin Panel: http://localhost:8000/admin/dashboard");

        return Command::SUCCESS;
    }
}
