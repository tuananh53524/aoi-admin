<?php

namespace App\Services;

use App\Models\Blog;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\DB;

class BlogService
{
    protected $blog, $imageHelper;

    public function __construct(Blog $blog, ImageHelper $imageHelper)
    {
        $this->blog = $blog;
        $this->imageHelper = $imageHelper;
    }

    /**
     * Lấy danh sách blog có phân trang
     */
    public function getAllBlogs(array $data, int $perPage = 10): LengthAwarePaginator
    {
        $blogs = $this->blog->filter($data)->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();
        return $blogs;
    }

    /**
     * Lấy chi tiết một blog
     */
    public function find(int $id): ?Blog
    {
        return $this->blog->find($id);
    }

    /**
     * Tạo blog mới
     */
    public function createBlog(array $data)
    {
        $blog = new Blog();
        $blog->title = $data['title'];
        $blog->slug = $data['slug'] ?? Str::slug($data['title']);
        $blog->description = $data['description'];
        $blog->meta_title = $data['meta_title'];
        $blog->meta_description = $data['meta_description'];
        $blog->category_id = $data['category_id'];
        $blog->content = $data['content'];
        $blog->tags = $data['tags'] ?? null;
        $blog->status = $data['status'] ?? 0;
        $blog->feature = $data['feature'] ?? 0;
        $blog->author_id = $data['author_id'];

        $base64Image = base64_encode(file_get_contents($data['thumbnail']));
        $thumbnailPath = $this->imageHelper->convertImage($base64Image,'blogs/thumbnails','1:1');
        $blog->thumbnail_url = $thumbnailPath;
        return $blog->save();
    }

    /**
     * Cập nhật blog
     */
    public function update(int $id, array $data): array
    {
        try {
            $blog = $this->find($id);
            
            if (!$blog) {
                return [
                    'success' => false,
                    'message' => 'Blog không tồn tại!'
                ];
            }

            DB::beginTransaction();

            $blog->title = $data['title'];
            $blog->slug = $data['slug'] ?? Str::slug($data['title']);
            $blog->description = $data['description'];
            $blog->meta_title = $data['meta_title'];
            $blog->meta_description = $data['meta_description'];
            $blog->category_id = $data['category_id'];
            $blog->content = $data['content'];
            $blog->tags = $data['tags'] ?? null;
            $blog->status = $data['status'] ?? 0;
            $blog->feature = $data['feature'] ?? 0;
            $blog->author_id = $data['author_id'];

            $base64Image = base64_encode(file_get_contents($data['thumbnail']));
            $thumbnailPath = $this->imageHelper->convertImage($base64Image,'blogs/thumbnails','1:1');
            $blog->thumbnail_url = $thumbnailPath;

            $blog->save();
            
            DB::commit();
            
            return [
                'success' => true,
                'message' => 'Blog đã được cập nhật thành công!'
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            
            return [
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Xóa blog
     */
    public function delete(int $id): bool
    {
        $blog = $this->find($id);
        
        if (!$blog) {
            return false;
        }

        return $blog->delete();
    }
}