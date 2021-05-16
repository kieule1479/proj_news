<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\AdminModel;
use Illuminate\Support\Str;


class ArticleModel extends AdminModel
{
    //======== __CONSTRUCT =========
    public function __construct()
    {
        $this->table               = 'article as a';
        $this->folderUpload        = 'article';
        $this->fieldSelectAccepted = ['name', 'content'];
        $this->crudNotAccepted     = ['_token', 'thumb_current'];
    }

    //======== LIST ITEMS =========
    public function listItems($params = null, $options = null)
    {
        $result = null;

        if ($options['task'] == 'admin_list_items') {

            $query = $this->select('a.id', 'a.category_id', 'a.name', 'a.content', 'a.status', 'a.thumb', 'a.type', 'c.name as category_name')->leftJoin('category as c', 'a.category_id', '=', 'c.id');

            if ($params['filter']['status'] != 'all') {
                $query->where('a.status', '=', $params['filter']['status']);
            }
            if ($params['search']['value'] != '') {
                if ($params['search']['field'] == 'all') {

                    $query->where(function ($query) use ($params) {
                        foreach ($this->fieldSelectAccepted as $column) {
                            $query->orWhere('a.' . $column, 'LIKE', "%{$params['search']['value']}%");
                        }
                    });
                } else if (in_array($params['search']['field'], $this->fieldSelectAccepted)) {
                    $query->where('a.' . $params['search']['field'], 'LIKE', "%{$params['search']['value']}%");
                }
            }
            $result = $query->orderBy('a.id', 'desc')
                ->paginate($params['pagination']['totalItemsPerPage']);
        }
        if ($options['task'] == 'news-list-items') {
            $query = $this->select('id', 'name', 'description', 'link', 'thumb')
                ->where('status', '=', 'active')
                ->limit(5);
            $result = $query->get()->toArray();
        }
        if ($options['task'] == 'news-list-items-is-featured') {
            $query = $this->select('a.id', 'a.name', 'a.content', 'a.created', 'a.category_id', 'c.name as category_name', 'a.thumb')
                ->leftJoin('category as c', 'a.category_id', '=', 'c.id')
                ->where('a.status', '=', 'active')
                ->where('a.type', 'feature')
                ->orderBy('a.id', 'desc')
                ->take(3);
            $result = $query->get()->toArray();
        }

        if ($options['task'] == 'news-list-items-latest') {

            $query = $this->select('a.id', 'a.name', 'a.created', 'a.category_id', 'c.name as category_name', 'a.thumb')
                ->leftJoin('category as c', 'a.category_id', '=', 'c.id')
                ->where('a.status', '=', 'active')
                ->orderBy('id', 'desc')
                ->take(4);
            $result = $query->get()->toArray();
        }
        if ($options['task'] == 'news-list-items-in-category') {

            $query = $this->select('id', 'name', 'content', 'created', 'thumb')

                ->where('status', '=', 'active')
                ->where('category_id', '=', $params['category_id'])
                ->take(4);

            $result = $query->get()->toArray();
        }

        if ($options['task'] == 'news-list-items-related-in-category') {
            $query = $this->select('id', 'name', 'content', 'thumb', 'created')
                ->where('status', '=', 'active')
                ->where('a.id', '!=', $params['article_id'])
                ->where('category_id', '=', $params['category_id'])
                ->take(4);
            $result = $query->get()->toArray();
        }


        return $result;
    }

    //======== COUNT ITEMS =========
    public function countItems($params = null, $options = null)
    {

        $result = null;
        if ($options['task'] == 'admin_count_items_group_by_status') {


            $query = $this::groupBy('status')
                ->select(DB::raw('count(id) as count, status'));


            if ($params['search']['value'] != '') {
                if ($params['search']['field'] == 'all') {

                    $query->where(function ($query) use ($params) {
                        foreach ($this->fieldSelectAccepted as $column) {
                            $query->orWhere($column, 'LIKE', "%{$params['search']['value']}%");
                        }
                    });
                } else if (in_array($params['search']['field'], $this->fieldSelectAccepted)) {
                    $query->where($params['search']['field'], 'LIKE', "%{$params['search']['value']}%");
                }
            }
        }
        $result = $query->get()->toArray();



        return $result;
    }

    //======== SAVE ITEM =========
    public function saveItem($params = null, $options = null)
    {

        if ($options['task'] == 'change-status') {

            $status = ($params['currentStatus'] == 'active') ? 'inactive' : 'active';
            self::where('id', $params['id'])->update(['status' => $status]);
        }
        if ($options['task'] == 'change-type') {
            self::where('id', $params['id'])->update(['type' => $params['currentType']]);
        }

        if ($options['task'] == 'add-item') {

            $params['created_by'] = 'hailan';
            $params['created']    = date('Y-m-d');
            $params['thumb']      = $this->uploadThumb($params['thumb']);

            self::insert($this->prepareParams($params));
        }
        if ($options['task'] == 'edit-item') {
            if (!empty($params['thumb'])) {
                $this->deleteThumb($params['thumb_current']);
                $params['thumb'] = $this->uploadThumb($params['thumb']);
            }

            $params['modified_by'] = 'hailan';
            $params['modified']    = date('Y-m-d');
            self::where('id', $params['id'])->update($this->prepareParams($params));
        }
    }

    //======== GET ITEM =========
    public function getItem($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'get-item') {
            $result = self::select('id', 'name', 'content', 'status', 'thumb', 'category_id')->where('id', $params['id'])->first();
        }
        if ($options['task'] == 'get-thumb') {
            $result = self::select('id', 'thumb')->where('id', $params['id'])->first();
        }
        if ($options['task'] == 'news-get-item') {

            $result = self::select('a.id', 'a.name', 'content', 'a.category_id', 'c.name as category_name', 'a.thumb', 'a.created', 'c.display')
                ->leftJoin('category as c', 'a.category_id', '=', 'c.id')
                ->where('a.id', '=', $params['article_id'])
                ->where('a.status', '=', 'active')->first();

            if ($result) $result = $result->toArray();
        }
        return $result;
    }

    //======== DELETE ITEM =========
    public function deleteItem($params = null, $options = null)
    {

        if ($options['task'] == 'delete-item') {

            $item = self::getItem($params, ['task' => 'get-thumb']);
            $this->deleteThumb($item['thumb']);
            self::where('id', $params['id'])->delete();
        }
    }
}
