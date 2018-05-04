<?php

    use Illuminate\Database\Seeder;

    class UsersTableSeeder extends Seeder {

        public function run () {

            \App\User::create([
                'name'              => 'Vasy Dragan',
                'email'             => 'vasy.dragan@gmail.com',
                'password'          => bcrypt('adm123'),
                'confirmed'         => 1,
                'admin'             => 1,
                'confirmation_code' => md5(microtime() . env('APP_KEY')),
            ]);

            \App\User::create([
                'name'              => 'Vasy Landlord',
                'email'             => 'vasy.dragan+landlord@gmail.com',
                'password'          => bcrypt('adm123'),
                'confirmed'         => 1,
                'admin'             => 1,
                'confirmation_code' => md5(microtime() . env('APP_KEY')),
            ]);

            \App\User::create([
                'name'              => 'Vasy Tenant',
                'email'             => 'vasy.dragan+tenant@gmail.com',
                'password'          => bcrypt('adm123'),
                'parent_id'         => 2,
                'confirmed'         => 1,
                'admin'             => 1,
                'confirmation_code' => md5(microtime() . env('APP_KEY')),
            ]);

            \App\User::create([
                'name'              => 'Razvan Admin',
                'email'             => 'razvan@rentomato.com',
                'password'          => bcrypt('adm123'),
                'confirmed'         => 1,
                'admin'             => 1,
                'confirmation_code' => md5(microtime() . env('APP_KEY')),
            ]);

            \App\User::create([
                'name'              => 'Razvan Landlord',
                'email'             => 'razvan+landlord@rentomato.com',
                'password'          => bcrypt('adm123'),
                'confirmed'         => 1,
                'admin'             => 1,
                'confirmation_code' => md5(microtime() . env('APP_KEY')),
            ]);

            \App\User::create([
                'name'              => 'Razvan Tenant',
                'email'             => 'razvan+tenant@rentomato.com',
                'password'          => bcrypt('adm123'),
                'confirmed'         => 1,
                'parent_id'         => 5,
                'admin'             => 1,
                'confirmation_code' => md5(microtime() . env('APP_KEY')),
            ]);

            \App\User::create([
                'name'              => 'Cos Admin',
                'email'             => 'cosinus84@gmail.com',
                'password'          => bcrypt('adm123'),
                'confirmed'         => 1,
                'admin'             => 1,
                'confirmation_code' => md5(microtime() . env('APP_KEY')),
            ]);

            \App\User::create([
                'name'              => 'Cos Landlord',
                'email'             => 'cosinus84+landlord@gmail.com',
                'password'          => bcrypt('adm123'),
                'confirmed'         => 1,
                'admin'             => 1,
                'confirmation_code' => md5(microtime() . env('APP_KEY')),
            ]);

            \App\User::create([
                'name'              => 'Cos Tenant',
                'email'             => 'cosinus84+tenant@gmail.com',
                'password'          => bcrypt('adm123'),
                'confirmed'         => 1,
                'admin'             => 1,
                'parent_id'         => 8,
                'confirmation_code' => md5(microtime() . env('APP_KEY')),
            ]);

            \App\User::create([
                'name'              => 'Dominik Admin',
                'email'             => 'dominik@rentomato.com',
                'password'          => bcrypt('adm123'),
                'confirmed'         => 1,
                'admin'             => 1,
                'confirmation_code' => md5(microtime() . env('APP_KEY')),
            ]);

            \App\User::create([
                'name'              => 'Dominik Landlord',
                'email'             => 'dominik+landlord@rentomato.com',
                'password'          => bcrypt('adm123'),
                'confirmed'         => 1,
                'admin'             => 1,
                'confirmation_code' => md5(microtime() . env('APP_KEY')),
            ]);

            \App\User::create([
                'name'              => 'Dominik Tenant',
                'email'             => 'dominik+tenant@rentomato.com',
                'password'          => bcrypt('adm123'),
                'confirmed'         => 1,
                'parent_id'         => 11,
                'admin'             => 1,
                'confirmation_code' => md5(microtime() . env('APP_KEY')),
            ]);

            \App\User::create([
                'name'              => 'Tom Admin',
                'email'             => 'tom@rentomato.com',
                'password'          => bcrypt('adm123'),
                'confirmed'         => 1,
                'admin'             => 1,
                'confirmation_code' => md5(microtime() . env('APP_KEY')),
            ]);

            \App\User::create([
                'name'              => 'Tom Landlord',
                'email'             => 'tom+landlord@rentomato.com',
                'password'          => bcrypt('adm123'),
                'confirmed'         => 1,
                'admin'             => 1,
                'confirmation_code' => md5(microtime() . env('APP_KEY')),
            ]);

            \App\User::create([
                'name'              => 'Tom Tenant',
                'email'             => 'tom+tenant@rentomato.com',
                'password'          => bcrypt('adm123'),
                'confirmed'         => 1,
                'parent_id'         => 14,
                'admin'             => 1,
                'confirmation_code' => md5(microtime() . env('APP_KEY')),
            ]);

            \App\User::create([
                'name'              => 'Sander Admin',
                'email'             => 'sander@rentomato.com',
                'password'          => bcrypt('adm123'),
                'confirmed'         => 1,
                'admin'             => 1,
                'confirmation_code' => md5(microtime() . env('APP_KEY')),
            ]);

            \App\User::create([
                'name'              => 'Sander Landlord',
                'email'             => 'sander+landlord@rentomato.com',
                'password'          => bcrypt('adm123'),
                'confirmed'         => 1,
                'admin'             => 1,
                'confirmation_code' => md5(microtime() . env('APP_KEY')),
            ]);

            \App\User::create([
                'name'              => 'Sander Tenant',
                'email'             => 'sander+tenant@rentomato.com',
                'password'          => bcrypt('adm123'),
                'confirmed'         => 1,
                'parent_id'         => 18,
                'admin'             => 1,
                'confirmation_code' => md5(microtime() . env('APP_KEY')),
            ]);

            \App\User::create([
                'name'              => 'Demo Manager',
                'email'             => 'info+manager@rentomato.com',
                'password'          => bcrypt('adm123'),
                'confirmed'         => 1,
                'admin'             => 1,
                'confirmation_code' => md5(microtime() . env('APP_KEY')),
            ]);
        }
    }
