<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\AdminModel;
use Illuminate\Support\Str;


class CategoryModel extends AdminModel
{
    //===== __CONSTRUCT ======
    public function __construct()
    {
        $this->table               = 'category';
        $this->folderUpload        = 'category';
        $this->fieldSelectAccepted = ['id', 'name',];
        $this->crudNotAccepted     = ['_token',];
    }

    //===== LIST ITEMS ======
    public function listItems($params = null, $options = null)
    {
        $result = null;

        if ($options['task'] == 'admin_list_items') {

            $query = $this->select('id', 'name', 'display', 'is_home', 'created', 'created_by', 'modified', 'modified_by', 'status');

            if ($params['filter']['status'] != 'all') {
                $query->where('status', '=', $params['filter']['status']);
            }
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
            $result = $query->orderBy('id', 'desc')
                ->paginate($params['pagination']['totalItemsPerPage']);
        }
        if ($options['task'] == 'news-list-items') {
            $query = $this->select('id', 'name')
                ->where('status', '=', 'active')
                ->limit(8);
            $result = $query->get()->toArray();
        }
        if ($options['task'] == 'news-list-items-is-home') {
            $query = $this->select('id', 'name', 'display')
                ->where('status', '=', 'active')
                ->where('is_home', '=', 'yes');

            $result = $query->get()->toArray();
        }
        if ($options['task'] == 'admin-list-item-in-selectbox') {
            $query = $this->select('id', 'name',)
                ->orderBy('name', 'asc')
                ->where('status', '=', 'active');

            $result = $query->pluck('name', 'id')->toArray();
        }




        return $result;
    }

    //===== COUNT ITEMS ======
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

    //===== GET ITEM ======
    public function getItem($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'get-item') {
            $result = self::select('id', 'name',  'status')->where('id', $params['id'])->first();
        }
        if ($options['task'] == 'news-get-item') {
            $result = self::select('id', 'name',  'display')->where('id', $params['category_id'])->first();
            if ($result) {
                $result = $result->toArray();
            }
        }

        return $result;
    }

    //===== SAVE ITEM ======
    public function saveItem($params = null, $options = null)
    {

        if ($options['task'] == 'change-is-home') {
            $isHome = ($params['currentIsHome'] == 'yes') ? 'no' : 'yes';
            self::where('id', $params['id'])->update(['is_home' => $isHome]);
        }
        if ($options['task'] == 'change-status') {

            $status = ($params['currentStatus'] == 'active') ? 'inactive' : 'active';
            self::where('id', $params['id'])->update(['status' => $status]);
        }

        if ($options['task'] == 'change-display') {
            $display = $params['currentDisplay'];
            self::where('id', $params['id'])->update(['display' => $display]);
        }

        if ($options['task'] == 'add-item') {

            $params['created_by'] = 'hailan';
            $params['created']    = date('Y-m-d');
            self::insert($this->prepareParams($params));
        }
        if ($options['task'] == 'edit-item') {

            self::where('id', $params['id'])->update($this->prepareParams($params));
        }
    }

    //===== DELETE ITEM ======
    public function deleteItem($params = null, $options = null)
    {

        if ($options['task'] == 'delete-item') {

            $item = self::getItem($params, ['task' => 'get-thumb']);
            $this->deleteThumb($item['thumb']);
            self::where('id', $params['id'])->delete();
        }
    }
}
