<?php

    use Illuminate\Database\Seeder;

    class MenuTableSeeder extends Seeder {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run () {

            \App\Models\Menu::create([
                'label'  => 'Dashboard',
                'url'    => '#/dashboard',
                'icon'   => 'icon-speedometer',
                'roles'  => json_encode(['administrator', 'tenant', 'landlord', 'manager']),
                'status' => 1
            ]);

            \App\Models\Menu::create([
                'label'  => 'Properties',
                'url'    => '#/properties',
                'icon'   => 'icon-home',
                'roles'  => json_encode(['administrator', 'tenant', 'landlord', 'manager']),
                'status' => 1
            ]);

            \App\Models\Menu::create([
                'label'  => 'Tenants',
                'url'    => '#/tenants',
                'icon'   => 'icon-user',
                'roles'  => json_encode(['administrator', 'tenant', 'landlord', 'manager']),
                'status' => 1
            ]);

            \App\Models\Menu::create([
                'label'  => 'Documents',
                'url'    => '#/documents',
                'icon'   => 'icon-doc',
                'roles'  => json_encode(['administrator', 'tenant', 'landlord', 'manager']),
                'status' => 1
            ]);

            \App\Models\Menu::create([
                'label'  => 'Finances',
                'url'    => '#/finances',
                'icon'   => 'icon-credit-card',
                'roles'  => json_encode(['administrator', 'tenant', 'landlord', 'manager']),
                'status' => 1
            ]);

            \App\Models\Menu::create([
                'label'  => 'Messages',
                'url'    => '#/messages',
                'icon'   => 'icon-envelope',
                'roles'  => json_encode(['administrator', 'tenant', 'landlord', 'manager']),
                'status' => 1
            ]);

            \App\Models\Menu::create([
                'label'  => 'Planning',
                'url'    => '#/planning',
                'icon'   => 'icon-calendar',
                'roles'  => json_encode(['administrator', 'tenant', 'landlord', 'manager']),
                'status' => 1
            ]);
            
            \App\Models\Menu::create([
                'label'  => 'Association Settings',
                'url'    => '#/contract/association',
                'icon'   => 'icon-folder',
                'roles'  => json_encode(['administrator', 'tenant', 'landlord', 'manager']),
                'status' => 1
            ]);

            \App\Models\Menu::create([
                'label'  => 'Contract Template',
                'url'    => '#/contract/template',
                'icon'   => 'icon-folder',
                'roles'  => json_encode(['administrator', 'tenant', 'landlord', 'manager']),
                'status' => 1
            ]);

            \App\Models\Menu::create([
                'label'  => 'Settings',
                'url'    => '#/settings',
                'icon'   => 'icon-settings',
                'roles'  => json_encode(['administrator', 'tenant', 'landlord', 'manager']),
                'status' => 1
            ]);

            \App\Models\Menu::create([
                'label'  => 'Translations',
                'url'    => '#/translations',
                'icon'   => 'icon-book-open',
                'roles'  => json_encode(['administrator']),
                'status' => 1
            ]);

            \App\Models\Menu::create([
                'label'  => 'Emails',
                'url'    => '#/emails',
                'icon'   => 'icon-envelope-open',
                'roles'  => json_encode(['administrator']),
                'status' => 1
            ]);

            \App\Models\Menu::create([
                'label'  => 'Deposit Relays',
                'url'    => '#/deposit-relays',
                'icon'   => 'fa fa-money',
                'roles'  => json_encode(["administrator","depositrelay"]),
                'status' => 1
            ]);
        }
    }
