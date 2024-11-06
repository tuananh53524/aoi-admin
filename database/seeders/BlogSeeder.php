<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = DB::table('categories')->pluck('id')->toArray();
        $users = DB::table('users')->pluck('id')->toArray();
        
        $blogs = [];
        
        for ($i = 1; $i <= 15; $i++) {
            $title = "Blog bài viết số " . $i;
            $blogs[] = [
                'category_id' => $categories[array_rand($categories)],
                'title' => $title,
                'slug' => Str::slug($title),
                'thumbnail_url' => 'images/blog/blog-' . $i . '.jpg',
                'meta_title' => $title . ' - Meta Title',
                'meta_description' => 'Mô tả meta cho ' . $title,
                'description' => 'Đây là mô tả ngắn cho ' . $title . '. Giới thiệu sơ lược về nội dung bài viết.',
                'content' => 'Nội dung chi tiết cho ' . $title . '. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'author_id' => $users[array_rand($users)],
                'tags' => 'tag1, tag2, tag3',
                'status' => rand(0, 1),
                'feature' => rand(0, 1),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }
        
        DB::table('blogs')->insert($blogs);
    }
}
