<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		// \App\Models\User::factory(10)->create();
		$this->call(CampaignsTableSeeder::class);
		// $this->call(UsersTableSeeder::class);
		// $this->call(RolesTableSeeder::class);
		// $this->call(RoleUserTableSeeder::class);
		// $this->call(PermissionsTableSeeder::class);
		// $this->call(PermissionRoleTableSeeder::class);
	}
}
