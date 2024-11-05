<?php

namespace App\Services;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use App\Helpers\ImageHelper;

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
    public function getAllBlogs(int $perPage = 10): LengthAwarePaginator
    {
        return $this->blog->latest()->paginate($perPage);
    }

    /**
     * Lấy tất cả blog không phân trang
     */
    public function getAllWithoutPagination(): Collection
    {
        return $this->blog->latest()->get();
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
    public function update(int $id, array $data): bool
    {
        $blog = $this->find($id);
        
        if (!$blog) {
            return false;
        }

        return $blog->update([
            'title' => $data['title'],
            'content' => $data['content'],
            'slug' => Str::slug($data['title']),
            'status' => $data['status'] ?? $blog->status,
            // Thêm các trường khác nếu cần
        ]);
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

    /**
     * Tìm kiếm blog
     */
    public function search(string $keyword, int $perPage = 10): LengthAwarePaginator
    {
        return $this->blog
            ->where('title', 'LIKE', "%{$keyword}%")
            ->orWhere('content', 'LIKE', "%{$keyword}%")
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Lấy các bài viết theo trạng thái
     */
    public function getByStatus(string $status, int $perPage = 10): LengthAwarePaginator
    {
        return $this->blog
            ->where('status', $status)
            ->latest()
            ->paginate($perPage);
    }
}