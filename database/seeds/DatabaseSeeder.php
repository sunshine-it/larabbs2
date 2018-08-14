<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 注册用户数据填充
        $this->call(UsersTableSeeder::class);
        // 注册用户话题数据填充
		$this->call(TopicsTableSeeder::class);
    }
}
