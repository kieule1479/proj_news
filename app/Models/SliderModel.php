<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\AdminModel;
use Illuminate\Support\Str;


class SliderModel extends AdminModel
{

    //======== __CONSTRUCT =========
    public function __construct()
    {
        $this->table               = 'slider';
        $this->folderUpload        = 'slider';
        $this->fieldSelectAccepted = ['id', 'name', 'description', 'link'];
        $this->crudNotAccepted     = ['_token', 'thumb_current'];
    }

    //======== LIST ITEMS  =========
    public function listItems($params = null, $options = null)
    {
        $result = null;

        if ($options['task'] == 'admin_list_items') {

            $query = $this->select('id', 'name', 'description', 'link', 'thumb', 'created', 'created_by', 'modified', 'modified_by', 'status');

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
            $query = $this->select('id', 'name', 'description', 'link', 'thumb')
                ->where('status', '=', 'active')
                ->limit(5);
            $result = $query->get()->toArray();
        }


        return $result;
    }

    //======== COUNT ITEMS =========
    public function countItems($params = null, $options = null)
    {

        $result = null;
        if ($options['task'] == 'admin_count_items_group_by_status') {

            $query = $this->groupBy('status')
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
            $result = self::select('id', 'name', 'description', 'status', 'link', 'thumb')->where('id', $params['id'])->first();
        }
        if ($options['task'] == 'get-thumb') {
            $result = self::select('id', 'thumb')->where('id', $params['id'])->first();
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
