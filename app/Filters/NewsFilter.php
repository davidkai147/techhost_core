<?php
namespace App\Filters;

class NewsFilter extends Filter
{
    /**
     * @param $title
     * @return \App\Builders\Builder
     */
    public function title($title)
    {
        return $this->query->whereLike('news_title', $title);
    }

    /**
     * Filter content by active
     *
     * @param integer $is_active
     * @return \App\Builders\Builder
     */
    public function is_active($is_active)
    {
        return $this->query->where('is_active', $is_active);
    }

    /**
     *
     * @param $category_id
     * @return \App\Builders\Builder
     */
    public function category_id($category_id)
    {
        return $this->query->where('news_category_id', $category_id);
    }

    /**
     * @param array $prefecture_ids
     * @return \App\Builders\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function prefectures($prefecture_ids)
    {
        return $this->query->whereHas('prefectures', function ($query) use ($prefecture_ids) {
            $query->whereIn('prefecture_id', $prefecture_ids);
        });
    }
}
